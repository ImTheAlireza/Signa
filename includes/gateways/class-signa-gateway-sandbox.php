<?php
/**
 * Sandbox / Test Gateway (For local testing without SMS credits)
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Gateway_Sandbox implements Signa_Gateway_Interface {

	/**
	 * Get gateway ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'sandbox';
	}

	/**
	 * Get gateway title
	 *
	 * @return string
	 */
	public function get_title() {
		return 'حالت تست / آزمایشی (ثبت در لاگ)';
	}

	/**
	 * Simulate sending OTP
	 *
	 * @param string $recipient Recipient phone.
	 * @param string $code      OTP code.
	 * @return true|WP_Error
	 */
	public function send( $recipient, $code ) {
		return true;
	}
}
