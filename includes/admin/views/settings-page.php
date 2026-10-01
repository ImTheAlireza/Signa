<?php
/**
 * Signa OTP v2.4.1 - Enterprise SaaS Admin Dashboard Layout Shell (Vector Icons + Bento Grid)
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
					<span class="signa-dark-icon">🌙</span>
				</button>

				<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp-logs' ) ); ?>" class="signa-btn-secondary">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
					<span>لاگ کدها (<?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?>)</span>
				</a>

				<button type="submit" id="signa-ajax-save-btn" class="signa-btn-save">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
					<span class="signa-save-label">ذخیره تغییرات</span>
					<span id="signa-unsaved-dot" class="signa-unsaved-dot" style="display:none;" title="تغییرات ذخیره نشده"></span>
					<kbd class="signa-kbd">Ctrl+S</kbd>
				</button>
			</div>
		</header>

		<!-- APP BODY (ORGANIZED SIDEBAR + MAIN PANEL) -->
		<div class="signa-app-body">
			<!-- CATEGORIZED VERTICAL SIDEBAR WITH VECTOR ICONS -->
			<aside class="signa-sidebar">
				<nav class="signa-nav">
					<div class="signa-sidebar-group-title">مانیتورینگ و گزارش</div>
					<button type="button" class="signa-nav-item active" data-tab="dashboard">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
						<span class="signa-nav-label">پیشخوان و آمار</span>
					</button>

					<div class="signa-sidebar-group-title">احراز هویت و درگاه‌ها</div>
					<button type="button" class="signa-nav-item" data-tab="auth_flow">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/></svg>
						<span class="signa-nav-label">سناریوی ورود و عضویت</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="sms_gateways">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
						<span class="signa-nav-label">درگاه‌های پیامک و پشتیبان</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="bale_email">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 10h.01"/><path d="M12 10h.01"/><path d="M16 10h.01"/></svg>
						<span class="signa-nav-label">پیام‌رسان بله و ایمیل</span>
					</button>

					<div class="signa-sidebar-group-title">ظاهر و یکپارچگی</div>
					<button type="button" class="signa-nav-item" data-tab="appearance_studio">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
						<span class="signa-nav-label">استودیو طراحی ظاهر</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="woocommerce">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
						<span class="signa-nav-label">ووکامرس، المنتور و شورت‌کد</span>
					</button>

					<div class="signa-sidebar-group-title">امنیت و ابزارها</div>
					<button type="button" class="signa-nav-item" data-tab="security_firewall">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><rect x="9" y="9" width="6" height="6" rx="1"/></svg>
						<span class="signa-nav-label">امنیت، فایروال و کپچا</span>
						<?php if ( count( $active_lockouts ) > 0 ) : ?>
							<span class="signa-nav-counter"><?php echo esc_html( (string) count( $active_lockouts ) ); ?></span>
						<?php endif; ?>
					</button>

					<button type="button" class="signa-nav-item" data-tab="tools_backup">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
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
