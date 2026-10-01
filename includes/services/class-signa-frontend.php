<?php
/**
 * Frontend Shortcodes, Assets, Global Modal & Full wp-login.php Replacement
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
			add_action( 'login_init', array( $this, 'intercept_wp_login_page' ), 1 );
		}
	}

	/**
	 * Enqueue frontend CSS and JS
	 */
	public function enqueue_assets() {
		wp_enqueue_style(
			'signa-vazirmatn-font',
			'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css',
			array(),
			'33.003'
		);

		wp_enqueue_style(
			'signa-otp-frontend',
			SIGNA_OTP_URL . 'assets/css/frontend.css',
			array( 'signa-vazirmatn-font' ),
			SIGNA_OTP_VERSION
		);

		$custom_css = trim( (string) Signa_Helper::get_option( 'custom_css', '' ) );
		if ( ! empty( $custom_css ) ) {
			wp_add_inline_style( 'signa-otp-frontend', wp_strip_all_tags( $custom_css ) );
		}

		$captcha_type = Signa_Helper::get_option( 'captcha_type', 'none' );
		$site_key     = trim( (string) Signa_Helper::get_option( 'captcha_site_key', '' ) );

		if ( 'arcaptcha' === $captcha_type && ! empty( $site_key ) ) {
			wp_enqueue_script( 'signa-arcaptcha', 'https://widget.arcaptcha.ir/1/api.js', array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		} elseif ( 'turnstile' === $captcha_type && ! empty( $site_key ) ) {
			wp_enqueue_script( 'signa-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		} elseif ( 'recaptcha_v3' === $captcha_type && ! empty( $site_key ) ) {
			wp_enqueue_script( 'signa-recaptcha', 'https://www.google.com/recaptcha/api.js?render=' . rawurlencode( $site_key ), array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		}

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
				'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
				'nonce'          => wp_create_nonce( 'signa_otp_nonce' ),
				'otpLength'      => absint( Signa_Helper::get_option( 'otp_length', 5 ) ),
				'captchaType'    => $captcha_type,
				'captchaSiteKey' => $site_key,
				'i18n'           => array(
					'networkError' => 'خطا در برقراری ارتباط با سرور. لطفاً اتصال اینترنت خود را بررسی کنید.',
					'sending'      => 'در حال ارسال...',
					'verifying'    => 'در حال بررسی...',
				),
			)
		);
	}

	/**
	 * Completely replace default wp-login.php form when wp_login_integration is active
	 */
	public function intercept_wp_login_page() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$action = isset( $_REQUEST['action'] ) ? sanitize_key( wp_unslash( $_REQUEST['action'] ) ) : 'login';

		$passthrough_actions = array( 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'postpass', 'confirmaction', 'confirm_admin_email' );
		if ( in_array( $action, $passthrough_actions, true ) || isset( $_REQUEST['interim-login'] ) ) {
			return;
		}

		if ( is_user_logged_in() ) {
			$redirect_to = isset( $_REQUEST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ) : admin_url();
			wp_safe_redirect( $redirect_to );
			exit;
		}

		$redirect_to = isset( $_REQUEST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ) : '';
		// phpcs:enable

		$this->enqueue_assets();

		status_header( 200 );
		nocache_headers();
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?> dir="rtl">
		<head>
			<meta charset="<?php bloginfo( 'charset' ); ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title><?php echo esc_html( get_bloginfo( 'name' ) . ' — ورود / ثبت‌نام' ); ?></title>
			<?php wp_print_styles( array( 'signa-vazirmatn-font', 'signa-otp-frontend' ) ); ?>
			<style>
				body.signa-standalone-login {
					margin: 0;
					padding: 24px 16px;
					min-height: 100vh;
					display: flex;
					flex-direction: column;
					align-items: center;
					justify-content: center;
					background: radial-gradient(circle at top right, #eef2ff 0%, #f8fafc 55%, #f1f5f9 100%);
					font-family: 'Vazirmatn', Tahoma, sans-serif;
					direction: rtl;
					box-sizing: border-box;
				}
				.signa-standalone-login .signa-otp-wrapper {
					width: 100%;
					margin: 0 auto;
				}
				.signa-back-to-site {
					margin-top: 20px;
					text-align: center;
				}
				.signa-back-to-site a {
					color: #64748b;
					text-decoration: none;
					font-size: 13px;
					font-weight: 500;
					transition: color 0.15s ease;
				}
				.signa-back-to-site a:hover {
					color: #0f172a;
				}
			</style>
		</head>
		<body class="signa-standalone-login">
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo self::get_login_form_html(
				array(
					'redirect' => $redirect_to,
					'context'  => 'wp-login',
				)
			);
			?>
			<div class="signa-back-to-site">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">&rarr; بازگشت به <?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
			</div>
			<?php wp_print_scripts( array( 'jquery', 'signa-arcaptcha', 'signa-turnstile', 'signa-recaptcha', 'signa-otp-frontend' ) ); ?>
		</body>
		</html>
		<?php
		exit;
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
				'title'          => '',
				'subtitle'       => '',
				'redirect'       => '',
				'show_if_logged' => 'no',
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
}
