<?php
/**
 * Authentication, Unified Login/Registration & AJAX Handlers
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Auth {

	/**
	 * Singleton instance
	 *
	 * @var Signa_Auth|null
	 */
	private static $instance = null;

	/**
	 * Get instance
	 *
	 * @return Signa_Auth
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'wp_ajax_nopriv_signa_request_otp', array( $this, 'ajax_request_otp' ) );
		add_action( 'wp_ajax_signa_request_otp', array( $this, 'ajax_request_otp' ) );

		add_action( 'wp_ajax_nopriv_signa_verify_otp', array( $this, 'ajax_verify_otp' ) );
		add_action( 'wp_ajax_signa_verify_otp', array( $this, 'ajax_verify_otp' ) );
	}

	/**
	 * Handle AJAX Request OTP
	 */
	public function ajax_request_otp() {
		check_ajax_referer( 'signa_otp_nonce', 'nonce' );

		$raw_identifier = isset( $_POST['identifier'] ) ? sanitize_text_field( wp_unslash( $_POST['identifier'] ) ) : '';
		if ( empty( $raw_identifier ) ) {
			wp_send_json_error( array( 'message' => 'لطفاً شماره موبایل یا ایمیل خود را وارد کنید.' ) );
		}

		$parsed     = Signa_Helper::parse_identifier( $raw_identifier );
		$type       = $parsed['type'];
		$identifier = $parsed['normalized'];
		$login_mode = Signa_Helper::get_option( 'login_mode', 'phone_and_email' );

		if ( 'invalid' === $type ) {
			if ( 'phone_only' === $login_mode ) {
				wp_send_json_error( array( 'message' => 'شماره موبایل وارد شده معتبر نیست. (مثال: 09123456789)' ) );
			} elseif ( 'email_only' === $login_mode ) {
				wp_send_json_error( array( 'message' => 'آدرس ایمیل وارد شده معتبر نیست.' ) );
			} else {
				wp_send_json_error( array( 'message' => 'لطفاً یک شماره موبایل معتبر (مثل 09123456789) یا آدرس ایمیل صحیح وارد کنید.' ) );
			}
		}

		if ( 'phone_only' === $login_mode && 'phone' !== $type ) {
			wp_send_json_error( array( 'message' => 'ورود فقط با شماره موبایل امکان‌پذیر است.' ) );
		}

		if ( 'email_only' === $login_mode && 'email' !== $type ) {
			wp_send_json_error( array( 'message' => 'ورود فقط با آدرس ایمیل امکان‌پذیر است.' ) );
		}

		// Check if user exists
		$existing_user = self::find_user( $identifier, $type );
		$auto_register = (bool) Signa_Helper::get_option( 'auto_register', 1 );

		if ( ! $existing_user && ! $auto_register ) {
			wp_send_json_error( array( 'message' => 'حساب کاربری با این مشخصات یافت نشد.' ) );
		}

		// Rate limit & cooldown check
		$can_request = Signa_Security::can_request_otp( $identifier );
		if ( is_wp_error( $can_request ) ) {
			$data = $can_request->get_error_data();
			wp_send_json_error(
				array(
					'message'   => $can_request->get_error_message(),
					'code'      => $can_request->get_error_code(),
					'remaining' => isset( $data['remaining'] ) ? (int) $data['remaining'] : 0,
				)
			);
		}

		// Dispatch OTP
		$dispatch = Signa_Gateway_Manager::dispatch_otp( $identifier, $type );
		if ( is_wp_error( $dispatch ) ) {
			wp_send_json_error(
				array(
					'message' => 'خطا در ارسال کد تایید: ' . $dispatch->get_error_message(),
				)
			);
		}

		$channel_labels = array(
			'sms'      => 'پیامک',
			'bale'     => 'پیام‌رسان بله',
			'sms+bale' => 'پیامک و پیام‌رسان بله',
			'email'    => 'ایمیل',
		);
		$channel_label  = isset( $channel_labels[ $dispatch['channel'] ] ) ? $channel_labels[ $dispatch['channel'] ] : 'پیامک';

		$response_data = array(
			'message'       => sprintf( 'کد تایید از طریق %s به %s ارسال شد.', $channel_label, Signa_Helper::mask_identifier( $identifier ) ),
			'identifier'    => $identifier,
			'masked'        => Signa_Helper::mask_identifier( $identifier ),
			'type'          => $type,
			'channel'       => $dispatch['channel'],
			'cooldown'      => absint( Signa_Helper::get_option( 'resend_cooldown', 60 ) ),
			'expiry'        => absint( Signa_Helper::get_option( 'otp_expiry', 120 ) ),
			'otp_length'    => absint( Signa_Helper::get_option( 'otp_length', 5 ) ),
			'is_new_user'   => empty( $existing_user ),
		);

		// If sandbox mode and debug toast is enabled, include debug_code
		if ( 'sandbox' === $dispatch['gateway'] && Signa_Helper::get_option( 'show_debug_code_in_toast', 0 ) ) {
			$response_data['debug_code'] = $dispatch['code'];
		}

		wp_send_json_success( $response_data );
	}

	/**
	 * Handle AJAX Verify OTP & Unified Login / Auto-Register
	 */
	public function ajax_verify_otp() {
		check_ajax_referer( 'signa_otp_nonce', 'nonce' );

		$raw_identifier = isset( $_POST['identifier'] ) ? sanitize_text_field( wp_unslash( $_POST['identifier'] ) ) : '';
		$raw_code       = isset( $_POST['code'] ) ? sanitize_text_field( wp_unslash( $_POST['code'] ) ) : '';
		$redirect_to    = isset( $_POST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ) : '';

		$parsed     = Signa_Helper::parse_identifier( $raw_identifier );
		$type       = $parsed['type'];
		$identifier = $parsed['normalized'];

		if ( 'invalid' === $type ) {
			wp_send_json_error( array( 'message' => 'شناسه کاربری نامعتبر است.' ) );
		}

		$verified = Signa_Security::verify_otp( $identifier, $raw_code );
		if ( is_wp_error( $verified ) ) {
			wp_send_json_error(
				array(
					'message' => $verified->get_error_message(),
					'code'    => $verified->get_error_code(),
				)
			);
		}

		// Find or create user
		$user        = self::find_user( $identifier, $type );
		$is_new_user = false;

		if ( ! $user ) {
			if ( ! Signa_Helper::get_option( 'auto_register', 1 ) ) {
				wp_send_json_error( array( 'message' => 'ثبت‌نام خودکار غیرفعال است.' ) );
			}

			$user = self::register_user( $identifier, $type );
			if ( is_wp_error( $user ) ) {
				wp_send_json_error( array( 'message' => $user->get_error_message() ) );
			}
			$is_new_user = true;
		} else {
			// Ensure phone meta is synced on existing user
			if ( 'phone' === $type ) {
				update_user_meta( $user->ID, 'signa_phone', $identifier );
				if ( ! get_user_meta( $user->ID, 'billing_phone', true ) ) {
					update_user_meta( $user->ID, 'billing_phone', $identifier );
				}
			}
		}

		// Log the user in
		wp_clear_auth_cookie();
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID, true, is_ssl() );
		do_action( 'wp_login', $user->user_login, $user );
		do_action( 'signa_otp_user_authenticated', $user, $identifier, $type, $is_new_user );

		// Determine redirect URL
		$final_redirect = self::resolve_redirect_url( $redirect_to, $user );

		wp_send_json_success(
			array(
				'message'     => $is_new_user ? 'ثبت‌نام و ورود شما با موفقیت انجام شد! در حال انتقال...' : 'ورود با موفقیت انجام شد! در حال انتقال...',
				'redirect_to' => $final_redirect,
				'user_id'     => $user->ID,
				'is_new_user' => $is_new_user,
			)
		);
	}

	/**
	 * Find existing WordPress user by normalized phone or email
	 *
	 * @param string $identifier Normalized phone or email.
	 * @param string $type       'phone' or 'email'.
	 * @return WP_User|false
	 */
	public static function find_user( $identifier, $type = 'phone' ) {
		if ( 'email' === $type ) {
			return get_user_by( 'email', $identifier );
		}

		// 1. Check by signa_phone meta
		$users = get_users(
			array(
				'meta_key'   => 'signa_phone',
				'meta_value' => $identifier,
				'number'     => 1,
			)
		);
		if ( ! empty( $users ) ) {
			return $users[0];
		}

		// 2. Check by WooCommerce billing_phone meta (both normalized 09... and +989...)
		$intl_plus = Signa_Helper::to_international_phone( $identifier, true );
		$intl_raw  = Signa_Helper::to_international_phone( $identifier, false );

		$wc_users = get_users(
			array(
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key'   => 'billing_phone',
						'value' => $identifier,
					),
					array(
						'key'   => 'billing_phone',
						'value' => $intl_plus,
					),
					array(
						'key'   => 'billing_phone',
						'value' => $intl_raw,
					),
					array(
						'key'   => 'digits_phone',
						'value' => $intl_plus,
					),
				),
				'number'     => 1,
			)
		);
		if ( ! empty( $wc_users ) ) {
			return $wc_users[0];
		}

		// 3. Check by user_login matching phone number directly
		$user_by_login = get_user_by( 'login', $identifier );
		if ( $user_by_login ) {
			return $user_by_login;
		}

		$prefix           = Signa_Helper::get_option( 'username_prefix', 'u_' );
		$prefixed_login   = get_user_by( 'login', $prefix . $identifier );
		if ( $prefixed_login ) {
			return $prefixed_login;
		}

		return false;
	}

	/**
	 * Automatically register a new user from verified phone or email
	 *
	 * @param string $identifier Normalized phone or email.
	 * @param string $type       'phone' or 'email'.
	 * @return WP_User|WP_Error
	 */
	public static function register_user( $identifier, $type = 'phone' ) {
		$prefix = sanitize_key( Signa_Helper::get_option( 'username_prefix', 'u_' ) );

		if ( 'email' === $type ) {
			$email_local = explode( '@', $identifier )[0];
			$base_login  = sanitize_user( $email_local, true );
			if ( empty( $base_login ) ) {
				$base_login = $prefix . wp_rand( 10000, 99999 );
			}
			$user_login = $base_login;
			$suffix     = 1;
			while ( username_exists( $user_login ) ) {
				$user_login = $base_login . '_' . $suffix;
				++$suffix;
			}
			$user_email = $identifier;
		} else {
			$user_login = $prefix . $identifier;
			if ( username_exists( $user_login ) ) {
				$user_login = $identifier . '_' . wp_rand( 100, 999 );
			}
			$user_email = '';
		}

		// Determine role
		$desired_role = Signa_Helper::get_option( 'default_user_role', 'customer' );
		if ( 'customer' === $desired_role && ! wp_roles()->is_role( 'customer' ) ) {
			$desired_role = get_option( 'default_role', 'subscriber' );
		}

		$userdata = array(
			'user_login'   => $user_login,
			'user_pass'    => wp_generate_password( 24, true, true ),
			'user_email'   => $user_email,
			'display_name' => 'phone' === $type ? $identifier : explode( '@', $identifier )[0],
			'role'         => $desired_role,
		);

		$user_id = wp_insert_user( $userdata );
		if ( is_wp_error( $user_id ) ) {
			return $user_id;
		}

		if ( 'phone' === $type ) {
			update_user_meta( $user_id, 'signa_phone', $identifier );
			update_user_meta( $user_id, 'billing_phone', $identifier );
		}

		update_user_meta( $user_id, 'signa_registered_via_otp', 1 );

		do_action( 'signa_otp_user_registered', $user_id, $identifier, $type );

		return get_user_by( 'id', $user_id );
	}

	/**
	 * Resolve redirect URL after login
	 *
	 * @param string  $requested_redirect Redirect passed from form.
	 * @param WP_User $user               Authenticated user.
	 * @return string
	 */
	private static function resolve_redirect_url( $requested_redirect, $user ) {
		$configured_redirect = trim( (string) Signa_Helper::get_option( 'redirect_url', '' ) );

		if ( ! empty( $requested_redirect ) ) {
			$redirect = wp_validate_redirect( $requested_redirect, home_url( '/' ) );
		} elseif ( ! empty( $configured_redirect ) ) {
			$redirect = esc_url_raw( $configured_redirect );
		} elseif ( function_exists( 'wc_get_page_permalink' ) ) {
			$redirect = wc_get_page_permalink( 'myaccount' );
		} else {
			$redirect = home_url( '/' );
		}

		return apply_filters( 'signa_otp_login_redirect', $redirect, $user );
	}
}
