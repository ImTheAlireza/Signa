<?php
/**
 * Admin Controller, Settings Saver & Live Gateway Test Handler
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Signa_Admin|null
	 */
	private static $instance = null;

	/**
	 * Get instance
	 *
	 * @return Signa_Admin
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
		add_action( 'admin_menu', array( $this, 'register_menus' ) );
		add_action( 'admin_init', array( $this, 'handle_actions' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'wp_ajax_signa_admin_test_gateway', array( $this, 'ajax_test_gateway' ) );
	}

	/**
	 * Register WordPress Admin Menus
	 */
	public function register_menus() {
		add_menu_page(
			'ورود پیامکی (Signa OTP)',
			'ورود پیامکی (Signa)',
			'manage_options',
			'signa-otp',
			array( $this, 'render_settings_page' ),
			'dashicons-smartphone',
			58
		);

		add_submenu_page(
			'signa-otp',
			'تنظیمات و درگاه‌ها',
			'تنظیمات و درگاه‌ها',
			'manage_options',
			'signa-otp',
			array( $this, 'render_settings_page' )
		);

		add_submenu_page(
			'signa-otp',
			'لاگ کدهای ارسالی',
			'لاگ کدهای ارسالی',
			'manage_options',
			'signa-otp-logs',
			array( $this, 'render_logs_page' )
		);
	}

	/**
	 * Enqueue Admin CSS & JS on Signa pages
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( strpos( $hook, 'signa-otp' ) === false ) {
			return;
		}

		wp_enqueue_style(
			'signa-otp-admin',
			SIGNA_OTP_URL . 'assets/css/admin.css',
			array(),
			SIGNA_OTP_VERSION
		);

		wp_enqueue_script(
			'signa-otp-admin',
			SIGNA_OTP_URL . 'assets/js/admin.js',
			array( 'jquery' ),
			SIGNA_OTP_VERSION,
			true
		);

		wp_localize_script(
			'signa-otp-admin',
			'signaAdminParams',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'signa_admin_nonce' ),
			)
		);
	}

	/**
	 * Handle form submissions (Save Settings & Clear Logs)
	 */
	public function handle_actions() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// 1. Save Settings
		if ( isset( $_POST['signa_save_settings'] ) && check_admin_referer( 'signa_save_settings_action', 'signa_settings_nonce' ) ) {
			$defaults = Signa_Helper::default_settings();
			$raw      = isset( $_POST['signa'] ) && is_array( $_POST['signa'] ) ? wp_unslash( $_POST['signa'] ) : array();
			$clean    = array();

			$checkbox_keys = array(
				'auto_register',
				'show_debug_code_in_toast',
				'wc_replace_myaccount',
				'wc_checkout_otp_box',
				'wp_login_integration',
				'enable_global_modal',
				'delete_data_on_uninstall',
			);

			$int_keys = array(
				'otp_length',
				'otp_expiry',
				'resend_cooldown',
				'max_requests_per_hour',
				'max_ip_requests_per_hour',
				'max_verify_attempts',
				'lockout_duration',
				'log_retention_days',
			);

			$textarea_keys = array(
				'bale_message_template',
				'email_body_text',
			);

			foreach ( $defaults as $key => $default_val ) {
				if ( in_array( $key, $checkbox_keys, true ) ) {
					$clean[ $key ] = isset( $raw[ $key ] ) ? 1 : 0;
				} elseif ( in_array( $key, $int_keys, true ) ) {
					$val           = isset( $raw[ $key ] ) ? absint( Signa_Helper::convert_digits( $raw[ $key ] ) ) : $default_val;
					$clean[ $key ] = $val > 0 ? $val : $default_val;
				} elseif ( in_array( $key, $textarea_keys, true ) ) {
					$clean[ $key ] = isset( $raw[ $key ] ) ? sanitize_textarea_field( $raw[ $key ] ) : $default_val;
				} elseif ( 'redirect_url' === $key ) {
					$clean[ $key ] = isset( $raw[ $key ] ) ? esc_url_raw( trim( $raw[ $key ] ) ) : '';
				} else {
					$clean[ $key ] = isset( $raw[ $key ] ) ? sanitize_text_field( $raw[ $key ] ) : $default_val;
				}
			}

			// Clamp OTP length between 4 and 8
			$clean['otp_length'] = max( 4, min( 8, $clean['otp_length'] ) );

			update_option( 'signa_otp_settings', $clean );
			delete_transient( 'signa_bale_safir_token' );

			wp_safe_redirect( add_query_arg( 'settings-updated', 'true', admin_url( 'admin.php?page=signa-otp' ) ) );
			exit;
		}

		// 2. Clear Logs
		if ( isset( $_POST['signa_clear_logs'] ) && check_admin_referer( 'signa_clear_logs_action', 'signa_logs_nonce' ) ) {
			$clear_type = isset( $_POST['clear_type'] ) ? sanitize_text_field( wp_unslash( $_POST['clear_type'] ) ) : 'old';
			Signa_Logger::clear_logs( 'all' === $clear_type );

			wp_safe_redirect( add_query_arg( 'logs-cleared', 'true', admin_url( 'admin.php?page=signa-otp-logs' ) ) );
			exit;
		}
	}

	/**
	 * AJAX Handler: Test Gateway from Admin Panel
	 */
	public function ajax_test_gateway() {
		check_ajax_referer( 'signa_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'دسترسی غیرمجاز.' ) );
		}

		$recipient = isset( $_POST['recipient'] ) ? sanitize_text_field( wp_unslash( $_POST['recipient'] ) ) : '';
		$channel   = isset( $_POST['channel'] ) ? sanitize_text_field( wp_unslash( $_POST['channel'] ) ) : 'sms';

		if ( empty( $recipient ) ) {
			wp_send_json_error( array( 'message' => 'لطفاً شماره موبایل یا ایمیل تست را وارد کنید.' ) );
		}

		$parsed = Signa_Helper::parse_identifier( $recipient );
		if ( 'invalid' === $parsed['type'] ) {
			wp_send_json_error( array( 'message' => 'شماره موبایل یا آدرس ایمیل وارد شده معتبر نیست.' ) );
		}

		$result = Signa_Gateway_Manager::dispatch_otp( $parsed['normalized'], $parsed['type'], $channel );
		if ( is_wp_error( $result ) ) {
			wp_send_json_error(
				array(
					'message' => 'خطا در ارسال تست: ' . $result->get_error_message(),
				)
			);
		}

		wp_send_json_success(
			array(
				'message' => sprintf(
					'ارسال تست با موفقیت انجام شد! (کد تولیدشده: %s | درگاه: %s | پاسخ: %s)',
					$result['code'],
					$result['gateway'],
					$result['response']
				),
			)
		);
	}

	/**
	 * Render Settings Page
	 */
	public function render_settings_page() {
		$settings     = Signa_Helper::get_settings();
		$sms_gateways = Signa_Gateway_Manager::get_sms_gateways();
		$stats        = Signa_Logger::get_stats();
		include SIGNA_OTP_PATH . 'includes/admin/views/settings-page.php';
	}

	/**
	 * Render Logs Page
	 */
	public function render_logs_page() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$paged   = isset( $_GET['paged'] ) ? max( 1, absint( $_GET['paged'] ) ) : 1;
		$search  = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
		$status  = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : '';
		$channel = isset( $_GET['channel'] ) ? sanitize_text_field( wp_unslash( $_GET['channel'] ) ) : '';
		// phpcs:enable

		$per_page  = 20;
		$logs_data = Signa_Logger::get_logs(
			array(
				'per_page' => $per_page,
				'paged'    => $paged,
				'search'   => $search,
				'status'   => $status,
				'channel'  => $channel,
			)
		);
		$stats     = Signa_Logger::get_stats();

		include SIGNA_OTP_PATH . 'includes/admin/views/logs-page.php';
	}
}
