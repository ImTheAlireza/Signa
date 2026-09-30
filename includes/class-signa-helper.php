<?php
/**
 * Helper utility functions for Signa OTP
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Helper {

	/**
	 * Default plugin settings
	 *
	 * @return array
	 */
	public static function default_settings() {
		return array(
			// General & OTP settings
			'login_mode'               => 'phone_and_email', // phone_only | phone_and_email | email_only
			'mobile_delivery_channel'  => 'sms',             // sms | bale | bale_fallback_sms | sms_fallback_bale | both
			'otp_length'               => 5,
			'otp_expiry'               => 120,               // seconds
			'resend_cooldown'          => 60,                // seconds
			'auto_register'            => 1,
			'default_user_role'        => 'customer',        // falls back to subscriber if WooCommerce not active
			'username_prefix'          => 'u_',
			'redirect_url'             => '',
			'show_debug_code_in_toast' => 0,                 // For local/sandbox testing convenience

			// Security & Rate Limiting
			'max_requests_per_hour'    => 5,
			'max_ip_requests_per_hour' => 15,
			'max_verify_attempts'      => 5,
			'lockout_duration'         => 900,               // 15 minutes in seconds

			// Active SMS Gateway
			'active_sms_gateway'       => 'sandbox',         // sandbox | smsir | kavenegar | melipayamak | farazsms | ippanel

			// SMS.ir Settings
			'smsir_api_key'            => '',
			'smsir_template_id'        => '',
			'smsir_param_name'         => 'CODE',

			// Kavenegar Settings
			'kavenegar_api_key'        => '',
			'kavenegar_template'       => '',

			// Melipayamak Settings
			'melipayamak_username'     => '',
			'melipayamak_password'     => '',
			'melipayamak_body_id'      => '',

			// FarazSMS Settings
			'farazsms_auth_type'       => 'apikey',          // apikey | userpass
			'farazsms_api_key'         => '',
			'farazsms_username'        => '',
			'farazsms_password'        => '',
			'farazsms_from_number'     => '+983000505',
			'farazsms_pattern_code'    => '',
			'farazsms_param_name'      => 'verification-code',

			// IPPanel Settings
			'ippanel_auth_type'        => 'edge',            // edge | apikey | userpass
			'ippanel_api_key'          => '',
			'ippanel_username'         => '',
			'ippanel_password'         => '',
			'ippanel_from_number'      => '+983000505',
			'ippanel_pattern_code'     => '',
			'ippanel_param_name'       => 'code',

			// Bale Messenger Settings
			'bale_mode'                => 'safir',           // safir | bot
			'bale_client_id'           => '',
			'bale_client_secret'       => '',
			'bale_bot_token'           => '',
			'bale_message_template'    => "کد تایید ورود شما به {site_name}:\n*{code}*\nاین کد تا {expiry} ثانیه معتبر است.",

			// Email Settings
			'email_subject'            => 'کد تایید ورود به {site_name}',
			'email_from_name'          => get_bloginfo( 'name' ),
			'email_from_address'       => get_bloginfo( 'admin_email' ),
			'email_heading'            => 'کد یکبارمصرف ورود به حساب کاربری',
			'email_body_text'          => 'برای ورود به حساب کاربری خود در {site_name}، کد تایید زیر را در فرم ورود وارد نمایید:',

			// WooCommerce & UI Settings
			'wc_replace_myaccount'     => 1,
			'wc_checkout_otp_box'      => 1,
			'wp_login_integration'     => 0,
			'enable_global_modal'      => 1,
			'primary_color'            => '#2563eb',
			'form_title'               => 'ورود / ثبت‌نام',
			'form_subtitle'            => 'برای ادامه، شماره موبایل یا ایمیل خود را وارد کنید.',
			'button_text'              => 'دریافت کد تایید',
			'verify_button_text'       => 'تایید و ورود به حساب',

			// Maintenance
			'log_retention_days'       => 30,
			'delete_data_on_uninstall' => 0,
		);
	}

	/**
	 * Get all settings merged with defaults
	 *
	 * @return array
	 */
	public static function get_settings() {
		$saved = get_option( 'signa_otp_settings', array() );
		if ( ! is_array( $saved ) ) {
			$saved = array();
		}
		return wp_parse_args( $saved, self::default_settings() );
	}

	/**
	 * Get a specific setting value
	 *
	 * @param string $key     Setting key.
	 * @param mixed  $default Fallback default.
	 * @return mixed
	 */
	public static function get_option( $key, $default = null ) {
		$settings = self::get_settings();
		if ( isset( $settings[ $key ] ) ) {
			return $settings[ $key ];
		}
		return $default;
	}

	/**
	 * Convert Persian and Arabic numerals to English numerals
	 *
	 * @param string $input Input string.
	 * @return string
	 */
	public static function convert_digits( $input ) {
		$persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
		$arabic  = array( '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
		$english = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );

		$input = str_replace( $persian, $english, (string) $input );
		$input = str_replace( $arabic, $english, $input );
		return trim( $input );
	}

	/**
	 * Normalize Iranian mobile number to standard 09XXXXXXXXX format
	 *
	 * @param string $phone Raw phone number.
	 * @return string Normalized phone or cleaned digits.
	 */
	public static function normalize_phone( $phone ) {
		$phone = self::convert_digits( $phone );
		$phone = preg_replace( '/[^0-9]/', '', $phone );

		if ( strpos( $phone, '0098' ) === 0 ) {
			$phone = '0' . substr( $phone, 4 );
		} elseif ( strpos( $phone, '98' ) === 0 && strlen( $phone ) === 12 ) {
			$phone = '0' . substr( $phone, 2 );
		} elseif ( strpos( $phone, '9' ) === 0 && strlen( $phone ) === 10 ) {
			$phone = '0' . $phone;
		}

		return $phone;
	}

	/**
	 * Format phone number to international format (989XXXXXXXXX or +989XXXXXXXXX)
	 *
	 * @param string $phone     Phone number.
	 * @param bool   $with_plus Whether to prepend '+'.
	 * @return string
	 */
	public static function to_international_phone( $phone, $with_plus = false ) {
		$normalized = self::normalize_phone( $phone );
		if ( strpos( $normalized, '0' ) === 0 ) {
			$intl = '98' . substr( $normalized, 1 );
		} else {
			$intl = $normalized;
		}
		return $with_plus ? '+' . $intl : $intl;
	}

	/**
	 * Validate Iranian mobile number
	 *
	 * @param string $phone Phone number.
	 * @return bool
	 */
	public static function is_valid_phone( $phone ) {
		$normalized = self::normalize_phone( $phone );
		return (bool) preg_match( '/^09[0-9]{9}$/', $normalized );
	}

	/**
	 * Detect whether input is 'phone', 'email', or 'invalid'
	 *
	 * @param string $input Raw user input.
	 * @return array { type: 'phone'|'email'|'invalid', normalized: string }
	 */
	public static function parse_identifier( $input ) {
		$converted = self::convert_digits( $input );

		if ( is_email( $converted ) ) {
			return array(
				'type'       => 'email',
				'normalized' => strtolower( sanitize_email( $converted ) ),
			);
		}

		$phone = self::normalize_phone( $converted );
		if ( self::is_valid_phone( $phone ) ) {
			return array(
				'type'       => 'phone',
				'normalized' => $phone,
			);
		}

		return array(
			'type'       => 'invalid',
			'normalized' => sanitize_text_field( $converted ),
		);
	}

	/**
	 * Mask phone or email for display
	 *
	 * @param string $identifier Phone or email.
	 * @return string
	 */
	public static function mask_identifier( $identifier ) {
		if ( is_email( $identifier ) ) {
			$parts  = explode( '@', $identifier );
			$name   = $parts[0];
			$domain = $parts[1];
			$masked = substr( $name, 0, min( 2, strlen( $name ) ) ) . '***';
			return $masked . '@' . $domain;
		}

		if ( strlen( $identifier ) === 11 ) {
			return substr( $identifier, 0, 4 ) . '***' . substr( $identifier, -4 );
		}

		return $identifier;
	}

	/**
	 * Get client IP address safely
	 *
	 * @return string
	 */
	public static function get_client_ip() {
		$keys = array(
			'HTTP_CF_CONNECTING_IP',
			'HTTP_X_REAL_IP',
			'HTTP_X_FORWARDED_FOR',
			'REMOTE_ADDR',
		);

		foreach ( $keys as $key ) {
			if ( ! empty( $_SERVER[ $key ] ) ) {
				$ip_list = explode( ',', sanitize_text_field( wp_unslash( $_SERVER[ $key ] ) ) );
				$ip      = trim( $ip_list[0] );
				if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
					return $ip;
				}
			}
		}

		return '127.0.0.1';
	}

	/**
	 * Generate numeric OTP code
	 *
	 * @param int $length Length between 4 and 8.
	 * @return string
	 */
	public static function generate_otp_code( $length = 5 ) {
		$length = max( 4, min( 8, absint( $length ) ) );
		$min    = (int) pow( 10, $length - 1 );
		$max    = (int) pow( 10, $length ) - 1;
		return (string) wp_rand( $min, $max );
	}
}
