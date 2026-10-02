<?php
/**
 * Admin Controller, AJAX Settings Saver, Live Tester, Firewall Manager & CSV Exporter (v2.0)
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

		// AJAX Endpoints
		add_action( 'wp_ajax_signa_admin_save_settings', array( $this, 'ajax_save_settings' ) );
		add_action( 'wp_ajax_signa_admin_test_gateway', array( $this, 'ajax_test_gateway' ) );
		add_action( 'wp_ajax_signa_admin_unlock_target', array( $this, 'ajax_unlock_target' ) );
		add_action( 'wp_ajax_signa_admin_import_settings', array( $this, 'ajax_import_settings' ) );
		add_action( 'wp_ajax_signa_admin_reset_settings', array( $this, 'ajax_reset_settings' ) );
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
			'داشبورد و تنظیمات',
			'داشبورد و تنظیمات',
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
	 * Enqueue Admin CSS, Fonts, Media Uploader & JS on Signa pages
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( strpos( $hook, 'signa-otp' ) === false ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_style(
			'signa-vazirmatn-font',
			'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css',
			array(),
			'33.003'
		);

		$css_ver = SIGNA_OTP_VERSION . '.' . ( file_exists( SIGNA_OTP_PATH . 'assets/css/admin.css' ) ? filemtime( SIGNA_OTP_PATH . 'assets/css/admin.css' ) : '1' );
		$js_ver  = SIGNA_OTP_VERSION . '.' . ( file_exists( SIGNA_OTP_PATH . 'assets/js/admin.js' ) ? filemtime( SIGNA_OTP_PATH . 'assets/js/admin.js' ) : '1' );

		wp_enqueue_style(
			'signa-otp-admin-v265',
			SIGNA_OTP_URL . 'assets/css/admin.css',
			array(),
			$css_ver
		);

		wp_enqueue_script(
			'signa-otp-admin-v265',
			SIGNA_OTP_URL . 'assets/js/admin.js',
			array( 'jquery' ),
			$js_ver,
			true
		);

		wp_localize_script(
			'signa-otp-admin-v265',
			'signaAdminParams',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'signa_admin_nonce' ),
				'settings' => Signa_Helper::get_settings(),
			)
		);
	}

	/**
	 * Sanitize settings array
	 *
	 * @param array $raw Raw input settings array.
	 * @return array
	 */
	private function sanitize_settings_payload( $raw ) {
		$defaults = Signa_Helper::default_settings();
		$clean    = array();

		$checkbox_keys = array(
			'auto_register',
			'allow_password_login',
			'enable_passkey',
			'passkey_prompt_after_otp',
			'passkey_wc_myaccount',
			'show_terms_checkbox',
			'send_welcome_message',
			'show_debug_code_in_toast',
			'wc_replace_myaccount',
			'wc_checkout_otp_box',
			'wp_login_integration',
			'enable_global_modal',
			'trust_proxy_headers',
			'delete_data_on_uninstall',
		);

		$int_keys = array(
			'otp_length',
			'otp_expiry',
			'resend_cooldown',
			'border_radius',
			'form_max_width',
			'max_requests_per_hour',
			'max_ip_requests_per_hour',
			'max_verify_attempts',
			'lockout_duration',
			'log_retention_days',
		);

		$textarea_keys = array(
			'bale_message_template',
			'email_body_text',
			'welcome_message_text',
			'custom_css',
			'blocked_phones',
			'blocked_ips',
			'whitelisted_identifiers',
		);

		$url_keys = array(
			'redirect_url',
			'custom_redirect_url',
			'admin_redirect_url',
			'terms_url',
			'logo_url',
		);

		foreach ( $defaults as $key => $default_val ) {
			if ( in_array( $key, $checkbox_keys, true ) ) {
				$clean[ $key ] = ! empty( $raw[ $key ] ) ? 1 : 0;
			} elseif ( in_array( $key, $int_keys, true ) ) {
				$val           = isset( $raw[ $key ] ) ? absint( Signa_Helper::convert_digits( $raw[ $key ] ) ) : $default_val;
				$clean[ $key ] = ( 'border_radius' === $key ) ? min( 32, $val ) : ( $val > 0 ? $val : $default_val );
			} elseif ( in_array( $key, $textarea_keys, true ) ) {
				$clean[ $key ] = isset( $raw[ $key ] ) ? sanitize_textarea_field( $raw[ $key ] ) : $default_val;
			} elseif ( in_array( $key, $url_keys, true ) ) {
				$clean[ $key ] = isset( $raw[ $key ] ) ? esc_url_raw( trim( $raw[ $key ] ) ) : '';
			} else {
				$clean[ $key ] = isset( $raw[ $key ] ) ? sanitize_text_field( $raw[ $key ] ) : $default_val;
			}
		}

		if ( ! empty( $clean['custom_redirect_url'] ) && empty( $clean['redirect_url'] ) ) {
			$clean['redirect_url'] = $clean['custom_redirect_url'];
		} elseif ( ! empty( $clean['redirect_url'] ) && empty( $clean['custom_redirect_url'] ) ) {
			$clean['custom_redirect_url'] = $clean['redirect_url'];
		}

		$clean['otp_length']     = max( 4, min( 8, $clean['otp_length'] ) );
		$clean['form_max_width'] = max( 320, min( 640, $clean['form_max_width'] ) );

		return $clean;
	}

	/**
	 * Handle form submissions (Fallback POST Save, Clear Logs, Export CSV)
	 */
	public function handle_actions() {
		if ( wp_doing_ajax() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// 1. Classic Form POST Save Settings
		if ( isset( $_POST['signa_save_settings'] ) && check_admin_referer( 'signa_save_settings_action', 'signa_settings_nonce' ) ) {
			$raw   = isset( $_POST['signa'] ) && is_array( $_POST['signa'] ) ? wp_unslash( $_POST['signa'] ) : array();
			$clean = $this->sanitize_settings_payload( $raw );

			Signa_Helper::save_settings( $clean );
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

		// 3. Export CSV Logs
		if ( isset( $_GET['signa_export_logs_csv'] ) && check_admin_referer( 'signa_export_csv_action', 'nonce' ) ) {
			$logs_data = Signa_Logger::get_logs( array( 'per_page' => 2000, 'paged' => 1 ) );
			header( 'Content-Type: text/csv; charset=utf-8' );
			header( 'Content-Disposition: attachment; filename=signa-otp-logs-' . gmdate( 'Y-m-d' ) . '.csv' );

			$out = fopen( 'php://output', 'w' );
			// UTF-8 BOM for Excel Persian support
			fwrite( $out, "\xEF\xBB\xBF" );
			fputcsv( $out, array( 'ID', 'Recipient', 'Channel', 'Gateway', 'OTP Code', 'Status', 'Attempts', 'IP Address', 'Response', 'Created At', 'Verified At' ) );

			foreach ( $logs_data['items'] as $row ) {
				fputcsv(
					$out,
					array(
						$row->id,
						$row->recipient,
						$row->channel,
						$row->gateway,
						$row->otp_code,
						$row->status,
						$row->attempts,
						$row->ip_address,
						$row->response_message,
						$row->created_at,
						$row->verified_at,
					)
				);
			}
			fclose( $out );
			exit;
		}
	}

	/**
	 * AJAX Handler: Live Save Settings without page reload
	 */
	public function ajax_save_settings() {
		$nonce_ok = false;
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'signa_admin_nonce' ) ) {
			$nonce_ok = true;
		} elseif ( isset( $_POST['signa_settings_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['signa_settings_nonce'] ) ), 'signa_save_settings_action' ) ) {
			$nonce_ok = true;
		}

		if ( ! $nonce_ok || ! current_user_can( 'manage_options' ) ) {
			if ( ob_get_length() ) {
				ob_clean();
			}
			wp_send_json_error( array( 'message' => 'نشست امنیتی منقضی شده است؛ لطفاً صفحه را رفرش کنید.' ) );
		}

		$raw   = isset( $_POST['signa'] ) && is_array( $_POST['signa'] ) ? wp_unslash( $_POST['signa'] ) : array();
		$clean = $this->sanitize_settings_payload( $raw );

		Signa_Helper::save_settings( $clean );
		delete_transient( 'signa_bale_safir_token' );

		if ( ob_get_length() ) {
			ob_clean();
		}

		wp_send_json_success(
			array(
				'message'  => 'تنظیمات با موفقیت ذخیره شد!',
				'settings' => $clean,
			)
		);
	}

	/**
	 * AJAX Handler: Test Gateway from Admin Panel
	 */
	public function ajax_test_gateway() {
		check_ajax_referer( 'signa_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'دسترسی غیرمجاز.' ) );
		}

		$recipient  = isset( $_POST['recipient'] ) ? sanitize_text_field( wp_unslash( $_POST['recipient'] ) ) : '';
		$channel    = isset( $_POST['channel'] ) ? sanitize_text_field( wp_unslash( $_POST['channel'] ) ) : 'sms';
		$gateway_id = isset( $_POST['gateway_id'] ) ? sanitize_text_field( wp_unslash( $_POST['gateway_id'] ) ) : '';

		if ( empty( $recipient ) ) {
			wp_send_json_error( array( 'message' => 'لطفاً شماره موبایل یا ایمیل تست را وارد کنید.' ) );
		}

		$parsed = Signa_Helper::parse_identifier( $recipient );
		if ( 'invalid' === $parsed['type'] ) {
			wp_send_json_error( array( 'message' => 'شماره موبایل یا آدرس ایمیل وارد شده معتبر نیست.' ) );
		}

		$result = Signa_Gateway_Manager::dispatch_otp( $parsed['normalized'], $parsed['type'], $channel, $gateway_id );
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
					'ارسال تست موفق! کد تولیدشده: %s | درگاه: %s | پاسخ: %s',
					$result['code'],
					$result['gateway'],
					$result['response']
				),
			)
		);
	}

	/**
	 * AJAX Handler: Unlock a locked-out phone or IP immediately
	 */
	public function ajax_unlock_target() {
		check_ajax_referer( 'signa_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'دسترسی غیرمجاز.' ) );
		}

		$target = isset( $_POST['target'] ) ? sanitize_text_field( wp_unslash( $_POST['target'] ) ) : '';
		if ( empty( $target ) ) {
			wp_send_json_error( array( 'message' => 'شناسه نامعتبر است.' ) );
		}

		Signa_Security::unlock_target( $target );
		wp_send_json_success( array( 'message' => 'رفع مسدودی با موفقیت انجام شد.' ) );
	}

	/**
	 * AJAX Handler: Import JSON Settings
	 */
	public function ajax_import_settings() {
		check_ajax_referer( 'signa_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'دسترسی غیرمجاز.' ) );
		}

		$json_raw = isset( $_POST['json_data'] ) ? wp_unslash( $_POST['json_data'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$decoded  = json_decode( $json_raw, true );

		if ( ! is_array( $decoded ) ) {
			wp_send_json_error( array( 'message' => 'فرمت فایل یا متن JSON معتبر نیست.' ) );
		}

		$clean = $this->sanitize_settings_payload( $decoded );
		Signa_Helper::save_settings( $clean );

		wp_send_json_success( array( 'message' => 'تنظیمات با موفقیت درون‌ریزی شد! در حال بارگذاری مجدد...' ) );
	}

	/**
	 * AJAX Handler: Reset Settings to Factory Defaults
	 */
	public function ajax_reset_settings() {
		check_ajax_referer( 'signa_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'دسترسی غیرمجاز.' ) );
		}

		Signa_Helper::save_settings( Signa_Helper::default_settings() );
		delete_transient( 'signa_bale_safir_token' );

		wp_send_json_success( array( 'message' => 'تمام تنظیمات به حالت پیش‌فرض بازنشانی شد!' ) );
	}

	/**
	 * Render Settings Page
	 */
	public function render_settings_page() {
		$settings        = Signa_Helper::get_settings();
		$sms_gateways    = Signa_Gateway_Manager::get_sms_gateways();
		$stats           = Signa_Logger::get_stats();
		$chart_data      = Signa_Logger::get_daily_chart_data( 7 );
		$recent_logs     = Signa_Logger::get_logs( array( 'per_page' => 6, 'paged' => 1 ) )['items'];
		$active_lockouts = Signa_Security::get_active_lockouts();

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
