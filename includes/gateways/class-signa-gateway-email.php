<?php
/**
 * Email OTP Gateway (WordPress wp_mail)
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Gateway_Email extends Signa_Abstract_Gateway {

	/**
	 * Get gateway ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'email';
	}

	/**
	 * Get gateway title
	 *
	 * @return string
	 */
	public function get_title() {
		return 'ایمیل (wp_mail)';
	}

	/**
	 * Send OTP via Email
	 *
	 * @param string $recipient Email address.
	 * @param string $code      OTP code.
	 * @return true|WP_Error
	 */
	public function send( $recipient, $code ) {
		if ( ! is_email( $recipient ) ) {
			return new WP_Error( 'email_invalid_recipient', 'آدرس ایمیل وارد شده معتبر نیست.' );
		}

		$site_name      = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
		$expiry_seconds = absint( Signa_Helper::get_option( 'otp_expiry', 120 ) );
		$primary_color  = Signa_Helper::get_option( 'primary_color', '#2563eb' );

		$raw_subject = Signa_Helper::get_option( 'email_subject', 'کد تایید ورود به {site_name}' );
		$subject     = str_replace(
			array( '{site_name}', '{code}', '{expiry}' ),
			array( $site_name, $code, $expiry_seconds ),
			$raw_subject
		);

		$heading   = Signa_Helper::get_option( 'email_heading', 'کد یکبارمصرف ورود به حساب کاربری' );
		$raw_body  = Signa_Helper::get_option( 'email_body_text', 'برای ورود به حساب کاربری خود در {site_name}، کد تایید زیر را در فرم ورود وارد نمایید:' );
		$body_text = str_replace(
			array( '{site_name}', '{code}', '{expiry}' ),
			array( $site_name, $code, $expiry_seconds ),
			$raw_body
		);

		ob_start();
		include SIGNA_OTP_PATH . 'templates/email-otp.php';
		$html_message = ob_get_clean();

		$headers   = array( 'Content-Type: text/html; charset=UTF-8' );
		$from_name = trim( (string) Signa_Helper::get_option( 'email_from_name', $site_name ) );
		$from_addr = trim( (string) Signa_Helper::get_option( 'email_from_address', get_bloginfo( 'admin_email' ) ) );

		if ( ! empty( $from_name ) && is_email( $from_addr ) ) {
			$headers[] = sprintf( 'From: %s <%s>', $from_name, $from_addr );
		}

		$sent = wp_mail( $recipient, $subject, $html_message, $headers );

		if ( ! $sent ) {
			return new WP_Error( 'email_send_failed', 'خطا در ارسال ایمیل توسط تابع wp_mail وردپرس. لطفاً تنظیمات SMTP سرور را بررسی کنید.' );
		}

		return true;
	}
}
