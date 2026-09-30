<?php
/**
 * Gateway Manager & Multi-Channel Dispatcher
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Gateway_Manager {

	/**
	 * Get all available SMS gateways
	 *
	 * @return array<string, Signa_Gateway_Interface>
	 */
	public static function get_sms_gateways() {
		$gateways = array(
			'sandbox'     => new Signa_Gateway_Sandbox(),
			'smsir'       => new Signa_Gateway_Smsir(),
			'kavenegar'   => new Signa_Gateway_Kavenegar(),
			'melipayamak' => new Signa_Gateway_Melipayamak(),
			'farazsms'    => new Signa_Gateway_Farazsms(),
			'ippanel'     => new Signa_Gateway_Ippanel(),
		);

		return apply_filters( 'signa_otp_sms_gateways', $gateways );
	}

	/**
	 * Get active SMS gateway instance
	 *
	 * @return Signa_Gateway_Interface
	 */
	public static function get_active_sms_gateway() {
		$gateways  = self::get_sms_gateways();
		$active_id = Signa_Helper::get_option( 'active_sms_gateway', 'sandbox' );

		if ( isset( $gateways[ $active_id ] ) ) {
			return $gateways[ $active_id ];
		}

		return $gateways['sandbox'];
	}

	/**
	 * Dispatch OTP code to recipient and log result
	 *
	 * @param string $recipient       Normalized phone or email.
	 * @param string $identifier_type 'phone' or 'email'.
	 * @param string $forced_channel  Optional forced channel ('sms', 'bale', 'email') for admin testing.
	 * @return array|WP_Error { code: string, channel: string, gateway: string, log_id: int }
	 */
	public static function dispatch_otp( $recipient, $identifier_type = 'phone', $forced_channel = '' ) {
		$length   = absint( Signa_Helper::get_option( 'otp_length', 5 ) );
		$code     = Signa_Helper::generate_otp_code( $length );
		$otp_hash = wp_hash_password( $code );

		$channel_used = 'sms';
		$gateway_used = 'sandbox';
		$response_msg = 'ارسال موفق';
		$send_result  = true;

		if ( 'email' === $identifier_type || 'email' === $forced_channel ) {
			$email_gw     = new Signa_Gateway_Email();
			$channel_used = 'email';
			$gateway_used = $email_gw->get_id();
			$send_result  = $email_gw->send( $recipient, $code );
			if ( ! is_wp_error( $send_result ) ) {
				$response_msg = 'ارسال موفق به ایمیل';
			}
		} else {
			$delivery_strategy = ! empty( $forced_channel )
				? $forced_channel
				: Signa_Helper::get_option( 'mobile_delivery_channel', 'sms' );

			$sms_gw  = self::get_active_sms_gateway();
			$bale_gw = new Signa_Gateway_Bale();

			switch ( $delivery_strategy ) {
				case 'bale':
					$channel_used = 'bale';
					$gateway_used = 'bale';
					$send_result  = $bale_gw->send( $recipient, $code );
					if ( ! is_wp_error( $send_result ) ) {
						$response_msg = 'ارسال موفق از طریق پیام‌رسان بله';
					}
					break;

				case 'bale_fallback_sms':
					$bale_res = $bale_gw->send( $recipient, $code );
					if ( ! is_wp_error( $bale_res ) ) {
						$channel_used = 'bale';
						$gateway_used = 'bale';
						$send_result  = true;
						$response_msg = 'ارسال موفق از طریق پیام‌رسان بله';
					} else {
						$channel_used = 'sms';
						$gateway_used = $sms_gw->get_id();
						$send_result  = $sms_gw->send( $recipient, $code );
						if ( ! is_wp_error( $send_result ) ) {
							$response_msg = sprintf( 'ارسال از طریق پیامک (%s) پس از عدم موفقیت بله (%s)', $sms_gw->get_title(), $bale_res->get_error_message() );
						}
					}
					break;

				case 'sms_fallback_bale':
					$sms_res = $sms_gw->send( $recipient, $code );
					if ( ! is_wp_error( $sms_res ) ) {
						$channel_used = 'sms';
						$gateway_used = $sms_gw->get_id();
						$send_result  = true;
						$response_msg = 'ارسال موفق از طریق ' . $sms_gw->get_title();
					} else {
						$channel_used = 'bale';
						$gateway_used = 'bale';
						$send_result  = $bale_gw->send( $recipient, $code );
						if ( ! is_wp_error( $send_result ) ) {
							$response_msg = 'ارسال از طریق بله پس از خطای پیامک: ' . $sms_res->get_error_message();
						}
					}
					break;

				case 'both':
					$sms_res  = $sms_gw->send( $recipient, $code );
					$bale_res = $bale_gw->send( $recipient, $code );
					if ( ! is_wp_error( $sms_res ) || ! is_wp_error( $bale_res ) ) {
						$channel_used = 'sms+bale';
						$gateway_used = $sms_gw->get_id() . '+bale';
						$send_result  = true;
						$response_msg = 'ارسال همزمان پیامک و بله';
					} else {
						$channel_used = 'sms+bale';
						$gateway_used = $sms_gw->get_id() . '+bale';
						$send_result  = $sms_res;
					}
					break;

				case 'sms':
				default:
					$channel_used = 'sms';
					$gateway_used = $sms_gw->get_id();
					$send_result  = $sms_gw->send( $recipient, $code );
					if ( ! is_wp_error( $send_result ) ) {
						$response_msg = 'ارسال موفق از طریق ' . $sms_gw->get_title();
					}
					break;
			}
		}

		$is_error = is_wp_error( $send_result );
		if ( $is_error ) {
			$response_msg = $send_result->get_error_message();
		}

		$log_id = Signa_Logger::insert(
			array(
				'recipient'        => $recipient,
				'channel'          => $channel_used,
				'gateway'          => $gateway_used,
				'otp_code'         => $code,
				'otp_hash'         => $otp_hash,
				'status'           => $is_error ? 'failed' : 'sent',
				'response_message' => $response_msg,
			)
		);

		if ( $is_error ) {
			return $send_result;
		}

		do_action( 'signa_otp_sent', $recipient, $code, $channel_used, $gateway_used, $log_id );

		return array(
			'code'     => $code,
			'channel'  => $channel_used,
			'gateway'  => $gateway_used,
			'log_id'   => $log_id,
			'response' => $response_msg,
		);
	}
}
