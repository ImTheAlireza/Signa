<?php
/**
 * Plugin Name:       Signa - ورود و ثبت‌نام با کد یکبارمصرف (OTP)
 * Plugin URI:        https://github.com/ImTheAlireza/Signa
 * Description:       پلاگین جامع ورود و ثبت‌نام یکپارچه با کد یکبارمصرف (OTP) از طریق پیامک (SMS.ir، فراز اس‌ام‌اس، ملی‌پیامک، کاوه‌نگار، آی‌پی‌پنل)، پیام‌رسان بله و ایمیل همراه با یکپارچگی کامل ووکامرس.
 * Version:           2.2.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Signa Team
 * Text Domain:       signa-otp
 * Domain Path:       /languages
 * License:           GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SIGNA_OTP_VERSION', '2.2.0' );
define( 'SIGNA_OTP_FILE', __FILE__ );
define( 'SIGNA_OTP_PATH', plugin_dir_path( __FILE__ ) );
define( 'SIGNA_OTP_URL', plugin_dir_url( __FILE__ ) );
define( 'SIGNA_OTP_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Main Signa_OTP Class
 */
final class Signa_OTP {

	/**
	 * Singleton instance
	 *
	 * @var Signa_OTP|null
	 */
	private static $instance = null;

	/**
	 * Get singleton instance
	 *
	 * @return Signa_OTP
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
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required files
	 */
	private function includes() {
		require_once SIGNA_OTP_PATH . 'includes/class-signa-helper.php';
		require_once SIGNA_OTP_PATH . 'includes/class-signa-activator.php';
		require_once SIGNA_OTP_PATH . 'includes/class-signa-logger.php';
		require_once SIGNA_OTP_PATH . 'includes/class-signa-security.php';

		// Gateways
		require_once SIGNA_OTP_PATH . 'includes/gateways/interface-signa-gateway.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-sandbox.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-smsir.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-kavenegar.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-melipayamak.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-farazsms.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-ippanel.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-bale.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-email.php';
		require_once SIGNA_OTP_PATH . 'includes/gateways/class-signa-gateway-manager.php';

		// Core & Integrations
		require_once SIGNA_OTP_PATH . 'includes/class-signa-auth.php';
		require_once SIGNA_OTP_PATH . 'includes/class-signa-frontend.php';
		require_once SIGNA_OTP_PATH . 'includes/class-signa-woocommerce.php';

		if ( is_admin() ) {
			require_once SIGNA_OTP_PATH . 'includes/admin/class-signa-admin.php';
		}
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		register_activation_hook( SIGNA_OTP_FILE, array( 'Signa_Activator', 'activate' ) );

		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );
		add_filter( 'plugin_action_links_' . SIGNA_OTP_BASENAME, array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Initialize components when plugins are loaded
	 */
	public function on_plugins_loaded() {
		Signa_Activator::maybe_upgrade();

		Signa_Auth::instance();
		Signa_Frontend::instance();
		Signa_WooCommerce::instance();

		if ( is_admin() ) {
			Signa_Admin::instance();
		}
	}

	/**
	 * Add quick links to plugins page
	 *
	 * @param array $links Existing links.
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=signa-otp' ) ) . '" style="font-weight:600;color:#2563eb;">تنظیمات</a>';
		$logs_link     = '<a href="' . esc_url( admin_url( 'admin.php?page=signa-otp-logs' ) ) . '">لاگ پیامک‌ها</a>';
		array_unshift( $links, $settings_link, $logs_link );
		return $links;
	}
}

/**
 * Return main instance of Signa_OTP
 *
 * @return Signa_OTP
 */
function signa_otp() {
	return Signa_OTP::instance();
}

signa_otp();
