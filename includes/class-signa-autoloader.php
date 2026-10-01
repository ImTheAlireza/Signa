<?php
/**
 * Automatic Class & Interface Loader for Signa OTP
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Autoloader {

	/**
	 * Explicit class-to-relative-path map for fast O(1) lookup
	 *
	 * @var array<string, string>
	 */
	private static $class_map = array(
		'Signa_Plugin'              => 'includes/class-signa-plugin.php',
		'Signa_Activator'           => 'includes/core/class-signa-activator.php',
		'Signa_Helper'              => 'includes/core/class-signa-helper.php',
		'Signa_Security'            => 'includes/core/class-signa-security.php',
		'Signa_Logger'              => 'includes/core/class-signa-logger.php',
		'Signa_Auth'                => 'includes/services/class-signa-auth.php',
		'Signa_Frontend'            => 'includes/services/class-signa-frontend.php',
		'Signa_WooCommerce'         => 'includes/services/class-signa-woocommerce.php',
		'Signa_Elementor'           => 'includes/integrations/elementor/class-signa-elementor.php',
		'Signa_Gateway_Interface'   => 'includes/gateways/interface-signa-gateway.php',
		'Signa_Abstract_Gateway'    => 'includes/gateways/abstract-signa-gateway.php',
		'Signa_Gateway_Manager'     => 'includes/gateways/class-signa-gateway-manager.php',
		'Signa_Gateway_Sandbox'     => 'includes/gateways/class-signa-gateway-sandbox.php',
		'Signa_Gateway_Smsir'       => 'includes/gateways/class-signa-gateway-smsir.php',
		'Signa_Gateway_Kavenegar'   => 'includes/gateways/class-signa-gateway-kavenegar.php',
		'Signa_Gateway_Melipayamak' => 'includes/gateways/class-signa-gateway-melipayamak.php',
		'Signa_Gateway_Farazsms'    => 'includes/gateways/class-signa-gateway-farazsms.php',
		'Signa_Gateway_Ippanel'     => 'includes/gateways/class-signa-gateway-ippanel.php',
		'Signa_Gateway_Bale'        => 'includes/gateways/class-signa-gateway-bale.php',
		'Signa_Gateway_Email'       => 'includes/gateways/class-signa-gateway-email.php',
		'Signa_Admin'               => 'includes/admin/class-signa-admin.php',
	);

	/**
	 * Register SPL autoloader
	 */
	public static function register() {
		spl_autoload_register( array( __CLASS__, 'autoload' ) );
	}

	/**
	 * Autoload callback
	 *
	 * @param string $class_name Requested class name.
	 */
	public static function autoload( $class_name ) {
		if ( strpos( $class_name, 'Signa_' ) !== 0 ) {
			return;
		}

		if ( isset( self::$class_map[ $class_name ] ) ) {
			$file = SIGNA_OTP_PATH . self::$class_map[ $class_name ];
			if ( file_exists( $file ) ) {
				require_once $file;
				return;
			}
		}

		// Dynamic fallback for future classes following WordPress naming conventions
		$slug = strtolower( str_replace( '_', '-', $class_name ) );
		$dirs = array( 'core/', 'services/', 'gateways/', 'admin/', '' );

		foreach ( $dirs as $dir ) {
			$candidate = SIGNA_OTP_PATH . 'includes/' . $dir . 'class-' . $slug . '.php';
			if ( file_exists( $candidate ) ) {
				require_once $candidate;
				return;
			}
		}
	}
}
