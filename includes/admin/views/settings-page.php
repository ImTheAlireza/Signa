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

	<style>
		#signa-app-shell .signa-theme-linear-icon { display: inline-flex !important; align-items: center !important; justify-content: center !important; width: 20px !important; height: 20px !important; line-height: 0 !important; }
		#signa-app-shell .signa-icon-moon { display: block !important; width: 20px !important; height: 20px !important; flex-shrink: 0 !important; }
		#signa-app-shell .signa-icon-sun { display: none !important; width: 20px !important; height: 20px !important; flex-shrink: 0 !important; }
		#signa-app-shell.is-dark .signa-icon-moon { display: none !important; }
		#signa-app-shell.is-dark .signa-icon-sun { display: block !important; }
	</style>
	<form id="signa-settings-form" method="post" action="" novalidate="novalidate">
		<?php wp_nonce_field( 'signa_save_settings_action', 'signa_settings_nonce' ); ?>
		<input type="hidden" name="signa_save_settings" value="1" />

		<!-- STICKY TOPBAR -->
		<header class="signa-topbar">
			<div class="signa-topbar-brand">
				<div class="signa-brand-logo">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:24px;height:24px;flex-shrink:0;display:block;">
						<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
						<path d="m9 12 2 2 4-4"></path>
					</svg>
				</div>
				<div>
					<div class="signa-brand-title-row">
						<h1>Signa OTP</h1>
						<span class="signa-badge-ver">v<?php echo esc_html( SIGNA_OTP_VERSION ); ?> Pro</span>
					</div>
					<p>ورود و عضویت سریع با پیامک، بله و ایمیل</p>
				</div>
			</div>

			<div class="signa-topbar-actions">
				<div class="signa-gateway-status-pill" title="درگاه پیامک فعال فعلی">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;flex-shrink:0;display:block;opacity:0.8;"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
					<span class="signa-status-dot <?php echo 'sandbox' === $settings['active_sms_gateway'] ? 'is-warning' : 'is-online'; ?>"></span>
					<span>درگاه فعال: <strong id="signa-topbar-gw-name"><?php echo esc_html( $active_gw_title ); ?></strong></span>
				</div>

				<button type="button" id="signa-theme-toggle" class="signa-icon-btn" title="تغییر حالت روشن / تاریک (Dark Mode)" style="padding:0 !important;width:40px !important;height:40px !important;display:inline-flex !important;align-items:center !important;justify-content:center !important;">
					<span class="signa-theme-linear-icon">
						<svg class="signa-icon-moon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
						<svg class="signa-icon-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
					</span>
				</button>

				<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp-logs' ) ); ?>" class="signa-btn-secondary">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px;flex-shrink:0;display:block;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>
					<span>گزارش کدها (<?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?>)</span>
				</a>

				<button type="button" id="signa-ajax-save-btn" class="signa-btn-save signa-save-trigger-btn" onclick="return window.signaSaveSettingsNow ? window.signaSaveSettingsNow(event, this) : true;">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px;flex-shrink:0;display:block;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
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
					<div class="signa-sidebar-group-title">گزارش و وضعیت</div>
					<button type="button" class="signa-nav-item active" data-tab="dashboard">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
						<span class="signa-nav-label">پیشخوان</span>
					</button>

					<div class="signa-sidebar-group-title">مسیر ورود و ارسال</div>
					<button type="button" class="signa-nav-item" data-tab="auth_flow">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/></svg>
						<span class="signa-nav-label">روش و مسیر ورود</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="sms_gateways">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
						<span class="signa-nav-label">درگاه پیامک</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="bale_email">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 10h.01"/><path d="M12 10h.01"/><path d="M16 10h.01"/></svg>
						<span class="signa-nav-label">بله و ایمیل</span>
					</button>

					<div class="signa-sidebar-group-title">ظاهر و اتصال به قالب</div>
					<button type="button" class="signa-nav-item" data-tab="appearance_studio">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
						<span class="signa-nav-label">طراحی ظاهر فرم</span>
					</button>

					<button type="button" class="signa-nav-item" data-tab="woocommerce">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
						<span class="signa-nav-label">ووکامرس و المنتور</span>
					</button>

					<div class="signa-sidebar-group-title">امنیت و ابزارها</div>
					<button type="button" class="signa-nav-item" data-tab="security_firewall">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><rect x="9" y="9" width="6" height="6" rx="1"/></svg>
						<span class="signa-nav-label">امنیت و ضد اسپم</span>
						<?php if ( count( $active_lockouts ) > 0 ) : ?>
							<span class="signa-nav-counter"><?php echo esc_html( (string) count( $active_lockouts ) ); ?></span>
						<?php endif; ?>
					</button>

					<button type="button" class="signa-nav-item" data-tab="tools_backup">
						<svg class="signa-nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
						<span class="signa-nav-label">تست و پشتیبان‌گیری</span>
					</button>
				</nav>

				<div class="signa-sidebar-footer">
					<p>Signa OTP v<?php echo esc_html( SIGNA_OTP_VERSION ); ?></p>
					<small>سازگار با دیجیتز و ووکامرس</small>
				</div>
			</aside>

			<!-- MAIN CONTENT PANELS (Modular Partials) -->
			<main class="signa-main">
				<?php $is_just_saved = isset( $_GET['settings-updated'] ) && 'true' === $_GET['settings-updated']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div id="signa-inline-save-banner" style="<?php echo $is_just_saved ? 'display:flex;' : 'display:none;'; ?>align-items:center;justify-content:space-between;gap:12px;padding:14px 18px;margin-bottom:18px;border-radius:12px;background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.35);color:#059669;font-size:13.5px;font-weight:700;">
					<div style="display:flex;align-items:center;gap:10px;">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
						<span id="signa-inline-save-banner-text">تنظیمات با موفقیت ذخیره و اعمال شد!</span>
					</div>
					<button type="button" onclick="this.parentElement.style.display='none';" style="background:transparent;border:none;color:inherit;cursor:pointer;font-size:18px;line-height:1;padding:0 4px;">&times;</button>
				</div>

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

				<!-- Bottom Action Footer Bar -->
				<div class="signa-bottom-save-bar" style="margin-top:22px;padding:16px 22px;border-radius:14px;background:var(--s-bg-surface);border:1px solid var(--s-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
					<div style="display:flex;align-items:center;gap:10px;color:var(--s-text-muted);font-size:13px;">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;opacity:0.8;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						<span>پس از تغییر هر بخش، دکمه تایید و ذخیره تنظیمات را بزنید (یا کلید میانبر <code>Ctrl + S</code>).</span>
					</div>
					<button type="button" id="signa-ajax-save-btn-bottom" class="signa-btn-save signa-save-trigger-btn" onclick="return window.signaSaveSettingsNow ? window.signaSaveSettingsNow(event, this) : true;">
						<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px;flex-shrink:0;display:block;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
						<span class="signa-save-label">تایید و ذخیره تنظیمات</span>
					</button>
				</div>
			</main>
		</div>
	</form>

	<script>
	(function() {
		var isSaving = false;
		var ajaxEndpoint = <?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>;
		var adminNonce   = <?php echo wp_json_encode( wp_create_nonce( 'signa_admin_nonce' ) ); ?>;

		function parseJsonResilient(rawText) {
			if (!rawText || typeof rawText !== 'string') {
				return null;
			}
			var trimmed = rawText.trim();
			try {
				return JSON.parse(trimmed);
			} catch (e) {}
			var idx = trimmed.indexOf('{"success":');
			if (idx !== -1) {
				var lastBrace = trimmed.lastIndexOf('}');
				if (lastBrace > idx) {
					try {
						return JSON.parse(trimmed.substring(idx, lastBrace + 1));
					} catch (e2) {}
				}
			}
			return null;
		}

		function showFeedback(message, isError) {
			var toast = document.getElementById('signa-toast');
			if (toast) {
				toast.className = 'signa-toast' + (isError ? ' is-error' : '');
				var iconEl = toast.querySelector('.signa-toast-icon');
				var textEl = toast.querySelector('.signa-toast-text');
				if (iconEl) {
					iconEl.innerHTML = isError
						? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
						: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
				}
				if (textEl) {
					textEl.textContent = message;
				}
				toast.style.display = 'flex';
				setTimeout(function() {
					toast.style.display = 'none';
				}, 3800);
			}

			var banner = document.getElementById('signa-inline-save-banner');
			var bannerText = document.getElementById('signa-inline-save-banner-text');
			if (banner && bannerText) {
				bannerText.textContent = message;
				banner.style.background = isError ? 'rgba(239,68,68,0.12)' : 'rgba(16,185,129,0.12)';
				banner.style.borderColor = isError ? 'rgba(239,68,68,0.35)' : 'rgba(16,185,129,0.35)';
				banner.style.color = isError ? '#dc2626' : '#059669';
				banner.style.display = 'flex';
			}
		}

		function setButtonsState(saving, doneSuccess) {
			var btns = document.querySelectorAll('.signa-save-trigger-btn, #signa-ajax-save-btn');
			for (var i = 0; i < btns.length; i++) {
				btns[i].disabled = !!saving;
				var lbl = btns[i].querySelector('.signa-save-label');
				if (lbl) {
					if (saving) {
						lbl.textContent = 'در حال ذخیره...';
					} else if (doneSuccess) {
						lbl.textContent = 'ذخیره شد ✓';
					} else {
						lbl.textContent = btns[i].id === 'signa-ajax-save-btn-bottom' ? 'تایید و ذخیره تنظیمات' : 'ذخیره تغییرات';
					}
				}
				if (doneSuccess) {
					btns[i].classList.remove('has-unsaved');
				}
			}
			if (doneSuccess) {
				var dot = document.getElementById('signa-unsaved-dot');
				if (dot) {
					dot.style.display = 'none';
				}
				setTimeout(function() {
					setButtonsState(false, false);
				}, 1800);
			}
		}

		function fallbackClassicSubmit(form) {
			try {
				HTMLFormElement.prototype.submit.call(form);
			} catch (err) {
				form.submit();
			}
		}

		window.signaSaveSettingsNow = function(evt, btnEl) {
			if (evt) {
				if (typeof evt.preventDefault === 'function') {
					evt.preventDefault();
				}
				if (typeof evt.stopImmediatePropagation === 'function') {
					evt.stopImmediatePropagation();
				}
			}
			if (isSaving) {
				return false;
			}
			var form = document.getElementById('signa-settings-form');
			if (!form) {
				return false;
			}

			isSaving = true;
			setButtonsState(true, false);

			try {
				var fd = new FormData(form);
				fd.delete('signa_save_settings');
				fd.append('action', 'signa_admin_save_settings');
				fd.append('nonce', adminNonce);

				var xhr = new XMLHttpRequest();
				xhr.open('POST', ajaxEndpoint, true);
				xhr.timeout = 20000;

				xhr.onload = function() {
					isSaving = false;
					if (xhr.status >= 200 && xhr.status < 300) {
						var parsed = parseJsonResilient(xhr.responseText);
						if (parsed && parsed.success) {
							setButtonsState(false, true);
							var msg = (parsed.data && parsed.data.message) ? parsed.data.message : 'تنظیمات با موفقیت ذخیره شد!';
							showFeedback(msg, false);
							var expBox = document.getElementById('signa_export_json_box');
							if (expBox && parsed.data && parsed.data.settings) {
								expBox.value = JSON.stringify(parsed.data.settings);
							}
							return;
						}
					}
					// Automatic fallback to native POST submission if AJAX failed or returned error
					fallbackClassicSubmit(form);
				};

				xhr.onerror = function() {
					isSaving = false;
					fallbackClassicSubmit(form);
				};

				xhr.ontimeout = function() {
					isSaving = false;
					fallbackClassicSubmit(form);
				};

				xhr.send(fd);
			} catch (ex) {
				isSaving = false;
				fallbackClassicSubmit(form);
			}

			return false;
		};
	})();
	</script>
</div>
