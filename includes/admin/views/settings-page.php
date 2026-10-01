<?php
/**
 * Signa OTP v2.4 - Enterprise SaaS Admin Dashboard Layout Shell
 *
 * Each tab panel is modularized under includes/admin/views/partials/tab-*.php
 *
 * @package Signa_OTP
 * @var array $settings
 * @var array $sms_gateways
 * @var array $stats
 * @var array $chart_data
 * @var array $recent_logs
 * @var array $active_lockouts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$active_gw_obj    = isset( $sms_gateways[ $settings['active_sms_gateway'] ] ) ? $sms_gateways[ $settings['active_sms_gateway'] ] : reset( $sms_gateways );
$active_gw_title  = $active_gw_obj ? $active_gw_obj->get_title() : 'نامشخص';
$wc_active        = class_exists( 'WooCommerce' );
$elementor_active = did_action( 'elementor/loaded' ) || class_exists( '\Elementor\Plugin' );
$curl_active      = function_exists( 'curl_version' );
$openssl_active   = extension_loaded( 'openssl' );
$partials_dir     = SIGNA_OTP_PATH . 'includes/admin/views/partials/';
?>
<div class="signa-app-shell" id="signa-app-shell" dir="rtl">
	<!-- Floating Toast Notification -->
	<div id="signa-toast" class="signa-toast" style="display:none;">
		<span class="signa-toast-icon"></span>
		<span class="signa-toast-text"></span>
	</div>

	<form id="signa-settings-form" method="post" action="">
		<?php wp_nonce_field( 'signa_save_settings_action', 'signa_settings_nonce' ); ?>
		<input type="hidden" name="signa_save_settings" value="1" />

		<!-- STICKY TOPBAR -->
		<header class="signa-topbar">
			<div class="signa-topbar-brand">
				<div class="signa-brand-logo">
					<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
						<path d="m9 12 2 2 4-4"></path>
					</svg>
				</div>
				<div>
					<div class="signa-brand-title-row">
						<h1>Signa OTP</h1>
						<span class="signa-badge-ver">v<?php echo esc_html( SIGNA_OTP_VERSION ); ?> Pro</span>
					</div>
					<p>سیستم جامع احراز هویت، ورود پیامکی، بله، ایمیل و المنتور</p>
				</div>
			</div>

			<div class="signa-topbar-actions">
				<div class="signa-gateway-status-pill" title="درگاه پیامک فعال فعلی">
					<span class="signa-status-dot <?php echo 'sandbox' === $settings['active_sms_gateway'] ? 'is-warning' : 'is-online'; ?>"></span>
					<span>درگاه فعال: <strong id="signa-topbar-gw-name"><?php echo esc_html( $active_gw_title ); ?></strong></span>
				</div>

				<button type="button" id="signa-theme-toggle" class="signa-icon-btn" title="تغییر حالت روشن / تاریک (Dark Mode)">
					<span class="dashicons dashicons-Saved signa-dark-icon">🌙</span>
				</button>

				<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp-logs' ) ); ?>" class="signa-btn-secondary">
					<span class="dashicons dashicons-list-view"></span>
					لاگ کدها (<?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?>)
				</a>

				<button type="submit" id="signa-ajax-save-btn" class="signa-btn-save">
					<span class="dashicons dashicons-yes-alt"></span>
					<span class="signa-save-label">ذخیره تغییرات</span>
					<span id="signa-unsaved-dot" class="signa-unsaved-dot" style="display:none;" title="تغییرات ذخیره نشده"></span>
					<kbd class="signa-kbd">Ctrl+S</kbd>
				</button>
			</div>
		</header>

		<!-- APP BODY (ORGANIZED SIDEBAR + MAIN PANEL) -->
		<div class="signa-app-body">
			<!-- CATEGORIZED VERTICAL SIDEBAR -->
			<aside class="signa-sidebar">
				<nav class="signa-nav">
					<div class="signa-sidebar-group-title">مانیتورینگ و گزارش</div>
					<button type="button" class="signa-nav-item active" data-tab="dashboard">
						<span class="dashicons dashicons-chart-bar"></span>
						<span class="signa-nav-label">پیشخوان و آمار</span>
					</button>

					<div class="signa-sidebar-group-title">احراز هویت و درگاه‌ها</div>
					<button type="button" class="signa-nav-item" data-tab="auth_flow">
						<span class="dashicons dashicons-admin-users"></span>
						<span class="signa-nav-label">سناریوی ورود و عضویت</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="sms_gateways">
						<span class="dashicons dashicons-smartphone"></span>
						<span class="signa-nav-label">درگاه‌های پیامک و پشتیبان</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="bale_email">
						<span class="dashicons dashicons-format-chat"></span>
						<span class="signa-nav-label">پیام‌رسان بله و ایمیل</span>
					</button>

					<div class="signa-sidebar-group-title">ظاهر و یکپارچگی</div>
					<button type="button" class="signa-nav-item" data-tab="appearance_studio">
						<span class="dashicons dashicons-art"></span>
						<span class="signa-nav-label">استودیو طراحی ظاهر</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="woocommerce">
						<span class="dashicons dashicons-cart"></span>
						<span class="signa-nav-label">ووکامرس، المنتور و شورت‌کد</span>
					</button>

					<div class="signa-sidebar-group-title">امنیت و ابزارها</div>
					<button type="button" class="signa-nav-item" data-tab="security_firewall">
						<span class="dashicons dashicons-shield-alt"></span>
						<span class="signa-nav-label">امنیت، فایروال و کپچا</span>
						<?php if ( count( $active_lockouts ) > 0 ) : ?>
							<span class="signa-nav-counter"><?php echo esc_html( (string) count( $active_lockouts ) ); ?></span>
						<?php endif; ?>
					</button>

					<button type="button" class="signa-nav-item" data-tab="tools_backup">
						<span class="dashicons dashicons-admin-tools"></span>
						<span class="signa-nav-label">تست زنده و پشتیبان‌گیری</span>
					</button>
				</nav>

				<div class="signa-sidebar-footer">
					<p>Signa OTP v<?php echo esc_html( SIGNA_OTP_VERSION ); ?></p>
					<small>معماری ماژولار + ویجت المنتور</small>
				</div>
			</aside>

			<!-- MAIN CONTENT PANELS (Modular Partials) -->
			<main class="signa-main">
				<?php
				require $partials_dir . 'tab-dashboard.php';
				require $partials_dir . 'tab-auth-flow.php';
				require $partials_dir . 'tab-sms-gateways.php';
				require $partials_dir . 'tab-bale-email.php';
				require $partials_dir . 'tab-appearance.php';
				require $partials_dir . 'tab-woocommerce.php';
				require $partials_dir . 'tab-security.php';
				require $partials_dir . 'tab-tools.php';
				?>
			</main>
		</div>
	</form>
</div>
