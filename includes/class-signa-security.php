<?php
/**
 * Security, Rate Limiting & OTP Verification Engine
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Security {

	/**
	 * Check if a recipient or IP can request a new OTP
	 *
	 * @param string $recipient Normalized phone or email.
	 * @return true|WP_Error
	 */
	public static function can_request_otp( $recipient ) {
		global $wpdb;

		$ip             = Signa_Helper::get_client_ip();
		$lockout_status = self::check_lockout( $recipient, $ip );
		if ( is_wp_error( $lockout_status ) ) {
			return $lockout_status;
		}

		// 1. Check resend cooldown
		$remaining_cooldown = self::get_resend_remaining( $recipient );
		if ( $remaining_cooldown > 0 ) {
			return new WP_Error(
				'signa_cooldown',
				sprintf( 'لطفاً %d ثانیه دیگر برای درخواست مجدد کد صبر کنید.', $remaining_cooldown ),
				array( 'remaining' => $remaining_cooldown )
			);
		}

		$table        = Signa_Logger::table_name();
		$one_hour_ago = gmdate( 'Y-m-d H:i:s', strtotime( current_time( 'mysql' ) ) - HOUR_IN_SECONDS );

		// 2. Check hourly limit per recipient
		$max_recipient = max( 1, absint( Signa_Helper::get_option( 'max_requests_per_hour', 5 ) ) );
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$recipient_count = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$table} WHERE recipient = %s AND created_at >= %s",
				$recipient,
				$one_hour_ago
			)
		);

		if ( $recipient_count >= $max_recipient ) {
			return new WP_Error(
				'signa_rate_limit_recipient',
				'تعداد درخواست‌های کد برای این شماره/ایمیل بیش از حد مجاز در یک ساعت گذشته است. لطفاً کمی بعد تلاش کنید.'
			);
		}

		// 3. Check hourly limit per IP
		$max_ip = max( 2, absint( Signa_Helper::get_option( 'max_ip_requests_per_hour', 15 ) ) );
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$ip_count = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$table} WHERE ip_address = %s AND created_at >= %s",
				$ip,
				$one_hour_ago
			)
		);

		if ( $ip_count >= $max_ip ) {
			return new WP_Error(
				'signa_rate_limit_ip',
				'تعداد درخواست‌های ارسالی از آی‌پی شما بیش از حد مجاز است. لطفاً یک ساعت دیگر تلاش کنید.'
			);
		}

		return true;
	}

	/**
	 * Calculate remaining seconds before a new OTP can be requested
	 *
	 * @param string $recipient Normalized phone or email.
	 * @return int Remaining seconds (0 if allowed now).
	 */
	public static function get_resend_remaining( $recipient ) {
		$latest = Signa_Logger::get_latest_record( $recipient );
		if ( ! $latest || 'failed' === $latest->status ) {
			return 0;
		}

		$cooldown = absint( Signa_Helper::get_option( 'resend_cooldown', 60 ) );
		$created  = strtotime( $latest->created_at );
		$now      = strtotime( current_time( 'mysql' ) );
		$elapsed  = $now - $created;

		if ( $elapsed < $cooldown ) {
			return max( 0, $cooldown - $elapsed );
		}

		return 0;
	}

	/**
	 * Check if recipient or IP is temporarily locked out due to brute-force attempts
	 *
	 * @param string $recipient Recipient.
	 * @param string $ip        IP address.
	 * @return true|WP_Error
	 */
	public static function check_lockout( $recipient, $ip = '' ) {
		if ( empty( $ip ) ) {
			$ip = Signa_Helper::get_client_ip();
		}

		$recipient_lock = get_transient( 'signa_lock_' . md5( $recipient ) );
		$ip_lock        = get_transient( 'signa_lock_ip_' . md5( $ip ) );

		if ( $recipient_lock || $ip_lock ) {
			return new WP_Error(
				'signa_locked_out',
				'به دلیل تلاش‌های ناموفق متعدد، دسترسی شما به صورت موقت مسدود شده است. لطفاً ۱۵ دقیقه دیگر تلاش کنید.'
			);
		}

		return true;
	}

	/**
	 * Lock out a recipient and IP temporarily
	 *
	 * @param string $recipient Recipient.
	 */
	public static function trigger_lockout( $recipient ) {
		$duration = max( 60, absint( Signa_Helper::get_option( 'lockout_duration', 900 ) ) );
		$ip       = Signa_Helper::get_client_ip();

		set_transient( 'signa_lock_' . md5( $recipient ), 1, $duration );
		set_transient( 'signa_lock_ip_' . md5( $ip ), 1, $duration );
	}

	/**
	 * Verify submitted OTP code for a recipient
	 *
	 * @param string $recipient Normalized phone or email.
	 * @param string $code      Submitted OTP code.
	 * @return true|WP_Error
	 */
	public static function verify_otp( $recipient, $code ) {
		$code = Signa_Helper::convert_digits( $code );
		$code = preg_replace( '/[^0-9]/', '', $code );

		if ( empty( $code ) ) {
			return new WP_Error( 'signa_empty_code', 'لطفاً کد تایید را وارد کنید.' );
		}

		$lockout = self::check_lockout( $recipient );
		if ( is_wp_error( $lockout ) ) {
			return $lockout;
		}

		$record = Signa_Logger::get_latest_record( $recipient );
		if ( ! $record ) {
			return new WP_Error( 'signa_no_otp', 'کد فعالی برای این شماره/ایمیل یافت نشد. لطفاً مجدداً درخواست کد دهید.' );
		}

		if ( 'verified' === $record->status ) {
			return new WP_Error( 'signa_already_used', 'این کد قبلاً استفاده شده است. لطفاً کد جدید دریافت کنید.' );
		}

		if ( 'sent' !== $record->status ) {
			return new WP_Error( 'signa_invalid_state', 'کد تایید منقضی یا نامعتبر شده است. لطفاً مجدداً درخواست کد دهید.' );
		}

		$now        = strtotime( current_time( 'mysql' ) );
		$expires_at = strtotime( $record->expires_at );

		if ( $now > $expires_at ) {
			Signa_Logger::update( $record->id, array( 'status' => 'expired' ) );
			return new WP_Error( 'signa_expired_code', 'مهلت استفاده از این کد به پایان رسیده است. لطفاً کد جدید دریافت کنید.' );
		}

		$max_attempts = max( 1, absint( Signa_Helper::get_option( 'max_verify_attempts', 5 ) ) );
		if ( (int) $record->attempts >= $max_attempts ) {
			Signa_Logger::update( $record->id, array( 'status' => 'expired' ) );
			self::trigger_lockout( $recipient );
			return new WP_Error( 'signa_max_attempts', 'تعداد تلاش‌های مجاز برای این کد به پایان رسید. لطفاً کمی بعد کد جدید دریافت کنید.' );
		}

		$is_valid = wp_check_password( $code, $record->otp_hash );

		if ( ! $is_valid ) {
			$new_attempts = (int) $record->attempts + 1;
			$update_data  = array( 'attempts' => $new_attempts );

			if ( $new_attempts >= $max_attempts ) {
				$update_data['status'] = 'expired';
				self::trigger_lockout( $recipient );
			}

			Signa_Logger::update( $record->id, $update_data );

			$remaining_tries = max( 0, $max_attempts - $new_attempts );
			if ( 0 === $remaining_tries ) {
				return new WP_Error( 'signa_max_attempts', 'کد وارد شده اشتباه است. به دلیل تلاش بیش از حد، کد باطل شد.' );
			}

			return new WP_Error(
				'signa_wrong_code',
				sprintf( 'کد وارد شده صحیح نیست. (%d تلاش باقی‌مانده)', $remaining_tries )
			);
		}

		// Valid OTP! Mark record as verified
		Signa_Logger::update(
			$record->id,
			array(
				'status'      => 'verified',
				'verified_at' => current_time( 'mysql' ),
				'otp_code'    => '****', // Clear plain code once verified for extra security
			)
		);

		return true;
	}
}
