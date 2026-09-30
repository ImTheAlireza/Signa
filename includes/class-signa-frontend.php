<?php
/**
 * Frontend Shortcodes, Assets, Global Modal & wp-login Integration
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Frontend {

	/**
	 * Singleton instance
	 *
	 * @var Signa_Frontend|null
	 */
	private static $instance = null;

	/**
	 * Get instance
	 *
	 * @return Signa_Frontend
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
		add_shortcode( 'signa_otp_login', array( $this, 'shortcode_login_form' ) );
		add_shortcode( 'signa_otp_button', array( $this, 'shortcode_modal_button' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'wp_footer', array( $this, 'render_global_modal' ) );

		if ( Signa_Helper::get_option( 'wp_login_integration', 0 ) ) {
			add_action( 'login_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'login_form', array( $this, 'render_wp_login_section' ) );
		}
	}

	/**
	 * Enqueue frontend CSS and JS
	 */
	public function enqueue_assets() {
		wp_enqueue_style(
			'signa-otp-frontend',
			SIGNA_OTP_URL . 'assets/css/frontend.css',
			array(),
			SIGNA_OTP_VERSION
		);

		wp_enqueue_script(
			'signa-otp-frontend',
			SIGNA_OTP_URL . 'assets/js/frontend.js',
			array( 'jquery' ),
			SIGNA_OTP_VERSION,
			true
		);

		wp_localize_script(
			'signa-otp-frontend',
			'signaOtpParams',
			array(
				'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
				'nonce'     => wp_create_nonce( 'signa_otp_nonce' ),
				'otpLength' => absint( Signa_Helper::get_option( 'otp_length', 5 ) ),
				'i18n'      => array(
					'networkError' => 'خطا در برقراری ارتباط با سرور. لطفاً اتصال اینترنت خود را بررسی کنید.',
					'sending'      => 'در حال ارسال...',
					'verifying'    => 'در حال بررسی...',
				),
			)
		);
	}

	/**
	 * Render login form template (can be overridden in theme/signa/login-form.php)
	 *
	 * @param array $args Template arguments.
	 * @return string
	 */
	public static function get_login_form_html( $args = array() ) {
		$defaults = array(
			'title'    => Signa_Helper::get_option( 'form_title', 'ورود / ثبت‌نام' ),
			'subtitle' => Signa_Helper::get_option( 'form_subtitle', 'برای ادامه، شماره موبایل یا ایمیل خود را وارد کنید.' ),
			'redirect' => '',
			'context'  => 'shortcode',
		);
		$args     = wp_parse_args( $args, $defaults );

		ob_start();
		$theme_template = locate_template( 'signa/login-form.php' );
		if ( $theme_template ) {
			include $theme_template;
		} else {
			include SIGNA_OTP_PATH . 'templates/login-form.php';
		}
		return ob_get_clean();
	}

	/**
	 * Shortcode: [signa_otp_login]
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function shortcode_login_form( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'           => '',
				'subtitle'        => '',
				'redirect'        => '',
				'show_if_logged'  => 'no',
			),
			$atts,
			'signa_otp_login'
		);

		if ( is_user_logged_in() && 'yes' !== $atts['show_if_logged'] ) {
			$user         = wp_get_current_user();
			$account_link = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : admin_url( 'profile.php' );
			$logout_link  = wp_logout_url( home_url( '/' ) );

			return sprintf(
				'<div class="signa-otp-wrapper" dir="rtl"><div class="signa-otp-card signa-logged-in-box"><p>سلام <strong>%s</strong>، شما وارد حساب کاربری خود شده‌اید.</p><div class="signa-logged-actions"><a href="%s" class="signa-btn signa-btn-primary">حساب کاربری</a><a href="%s" class="signa-btn signa-btn-outline">خروج</a></div></div></div>',
				esc_html( $user->display_name ),
				esc_url( $account_link ),
				esc_url( $logout_link )
			);
		}

		return self::get_login_form_html(
			array(
				'title'    => $atts['title'],
				'subtitle' => $atts['subtitle'],
				'redirect' => $atts['redirect'],
				'context'  => 'shortcode',
			)
		);
	}

	/**
	 * Shortcode: [signa_otp_button text="ورود / ثبت‌نام"]
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function shortcode_modal_button( $atts ) {
		$atts = shortcode_atts(
			array(
				'text'           => 'ورود / ثبت‌نام',
				'logged_in_text' => 'حساب کاربری',
				'class'          => '',
			),
			$atts,
			'signa_otp_button'
		);

		$primary_color = Signa_Helper::get_option( 'primary_color', '#2563eb' );

		if ( is_user_logged_in() ) {
			$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : admin_url( 'profile.php' );
			return sprintf(
				'<a href="%s" class="signa-trigger-btn %s" style="--signa-primary:%s;">%s</a>',
				esc_url( $account_url ),
				esc_attr( $atts['class'] ),
				esc_attr( $primary_color ),
				esc_html( $atts['logged_in_text'] )
			);
		}

		return sprintf(
			'<button type="button" class="signa-trigger-btn signa-open-modal %s" style="--signa-primary:%s;">%s</button>',
			esc_attr( $atts['class'] ),
			esc_attr( $primary_color ),
			esc_html( $atts['text'] )
		);
	}

	/**
	 * Render global modal popup in footer for guests
	 */
	public function render_global_modal() {
		if ( is_user_logged_in() || ! Signa_Helper::get_option( 'enable_global_modal', 1 ) ) {
			return;
		}
		?>
		<div id="signa-otp-modal" class="signa-modal-overlay" aria-hidden="true" style="display:none;">
			<div class="signa-modal-dialog" role="dialog" aria-modal="true">
				<button type="button" class="signa-modal-close" aria-label="بستن">&times;</button>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo self::get_login_form_html( array( 'context' => 'modal' ) );
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render link to modal or inline OTP on wp-login.php
	 */
	public function render_wp_login_section() {
		echo '<div style="margin:16px 0;text-align:center;">';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo self::get_login_form_html( array( 'context' => 'wp-login' ) );
		echo '</div>';
	}
}
