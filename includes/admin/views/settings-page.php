<?php
/**
 * Signa OTP v2.0 - Enterprise SaaS Admin Dashboard View
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

$active_gw_obj   = isset( $sms_gateways[ $settings['active_sms_gateway'] ] ) ? $sms_gateways[ $settings['active_sms_gateway'] ] : reset( $sms_gateways );
$active_gw_title = $active_gw_obj ? $active_gw_obj->get_title() : 'نامشخص';
$wc_active       = class_exists( 'WooCommerce' );
$curl_active     = function_exists( 'curl_version' );
$openssl_active  = extension_loaded( 'openssl' );
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

		<!-- TOPBAR -->
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
					<p>سیستم جامع احراز هویت، ورود پیامکی، بله و ایمیل وردپرس</p>
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
					<kbd class="signa-kbd">Ctrl+S</kbd>
				</button>
			</div>
		</header>

		<!-- APP BODY (SIDEBAR + MAIN PANEL) -->
		<div class="signa-app-body">
			<!-- VERTICAL SIDEBAR -->
			<aside class="signa-sidebar">
				<nav class="signa-nav">
					<button type="button" class="signa-nav-item active" data-tab="dashboard">
						<span class="dashicons dashicons-chart-area"></span>
						<div class="signa-nav-text">
							<strong>پیشخوان و آمار</strong>
							<small>گزارش ۷ روزه و وضعیت</small>
						</div>
					</button>

					<button type="button" class="signa-nav-item" data-tab="auth_flow">
						<span class="dashicons dashicons-admin-users"></span>
						<div class="signa-nav-text">
							<strong>سناریوی ورود و عضویت</strong>
							<small>فیلدهای ثبت‌نام و ریدایرکت</small>
						</div>
					</button>

					<button type="button" class="signa-nav-item" data-tab="sms_gateways">
						<span class="dashicons dashicons-smartphone"></span>
						<div class="signa-nav-text">
							<strong>درگاه‌های پیامک و پشتیبان</strong>
							<small>۵ درگاه ایرانی + Failover</small>
						</div>
					</button>

					<button type="button" class="signa-nav-item" data-tab="bale_email">
						<span class="dashicons dashicons-format-chat"></span>
						<div class="signa-nav-text">
							<strong>پیام‌رسان بله و ایمیل</strong>
							<small>سفیر بله، ربات و قالب ایمیل</small>
						</div>
					</button>

					<button type="button" class="signa-nav-item" data-tab="appearance_studio">
						<span class="dashicons dashicons-art"></span>
						<div class="signa-nav-text">
							<strong>استودیو طراحی ظاهر</strong>
							<small>پیش‌نمایش زنده و تم‌ها</small>
						</div>
					</button>

					<button type="button" class="signa-nav-item" data-tab="woocommerce">
						<span class="dashicons dashicons-cart"></span>
						<div class="signa-nav-text">
							<strong>ووکامرس و شورت‌کدها</strong>
							<small>My Account، تسویه‌حساب و مودال</small>
						</div>
					</button>

					<button type="button" class="signa-nav-item" data-tab="security_firewall">
						<span class="dashicons dashicons-shield-alt"></span>
						<div class="signa-nav-text">
							<strong>امنیت، فایروال و کپچا</strong>
							<small>Rate Limit، لیست سیاه و قفل‌ها</small>
						</div>
						<?php if ( count( $active_lockouts ) > 0 ) : ?>
							<span class="signa-nav-counter"><?php echo esc_html( (string) count( $active_lockouts ) ); ?></span>
						<?php endif; ?>
					</button>

					<button type="button" class="signa-nav-item" data-tab="tools_backup">
						<span class="dashicons dashicons-admin-tools"></span>
						<div class="signa-nav-text">
							<strong>تست زنده و پشتیبان‌گیری</strong>
							<small>آزمایش ارسال و خروجی JSON</small>
						</div>
					</button>
				</nav>

				<div class="signa-sidebar-footer">
					<p>طراحی‌شده برای وردپرس فارسی</p>
					<small>پشتیبانی از WebOTP و خطوط خدماتی</small>
				</div>
			</aside>

			<!-- MAIN CONTENT PANELS -->
			<main class="signa-main">

				<!-- ==========================================
				     PANEL 1: DASHBOARD & ANALYTICS
				     ========================================== -->
				<section class="signa-panel active" id="signa-tab-dashboard">
					<div class="signa-kpi-grid">
						<div class="signa-kpi-card">
							<div class="signa-kpi-icon is-blue"><span class="dashicons dashicons-email-alt"></span></div>
							<div class="signa-kpi-info">
								<span>کل کدهای ارسال‌شده</span>
								<strong><?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?></strong>
								<small><?php echo esc_html( number_format_i18n( $stats['today'] ) ); ?> ارسال در امروز</small>
							</div>
						</div>

						<div class="signa-kpi-card">
							<div class="signa-kpi-icon is-green"><span class="dashicons dashicons-yes-alt"></span></div>
							<div class="signa-kpi-info">
								<span>ورودهای موفق (Verified)</span>
								<strong><?php echo esc_html( number_format_i18n( $stats['verified'] ) ); ?></strong>
								<small>نرخ تبدیل: %<?php echo esc_html( (string) $stats['conversion_rate'] ); ?></small>
							</div>
						</div>

						<div class="signa-kpi-card">
							<div class="signa-kpi-icon is-purple"><span class="dashicons dashicons-groups"></span></div>
							<div class="signa-kpi-info">
								<span>کاربران ثبت‌نامی با OTP</span>
								<strong><?php echo esc_html( number_format_i18n( $stats['otp_users'] ) ); ?></strong>
								<small>ثبت‌نام خودکار یکپارچه</small>
							</div>
						</div>

						<div class="signa-kpi-card">
							<div class="signa-kpi-icon is-red"><span class="dashicons dashicons-warning"></span></div>
							<div class="signa-kpi-info">
								<span>ارسال‌های ناموفق / خطا</span>
								<strong><?php echo esc_html( number_format_i18n( $stats['failed'] ) ); ?></strong>
								<small><?php echo esc_html( (string) count( $active_lockouts ) ); ?> مسدودی امنیتی فعال</small>
							</div>
						</div>
					</div>

					<div class="signa-bento-row">
						<!-- 7-Day Visual Bar Chart -->
						<div class="signa-card signa-col-8">
							<div class="signa-card-head">
								<div>
									<h2>نمودار ارسال کد در ۷ روز گذشته</h2>
									<p>مقایسه تعداد کل درخواست‌ها و ورودهای موفق روزانه</p>
								</div>
								<div class="signa-chart-legend">
									<span><i style="background:#3b82f6;"></i> کل ارسالی</span>
									<span><i style="background:#10b981;"></i> تایید شده</span>
								</div>
							</div>
							<div class="signa-bar-chart">
								<?php foreach ( $chart_data as $day ) : ?>
									<div class="signa-bar-col">
										<div class="signa-bar-track" title="<?php echo esc_attr( sprintf( '%s: %d ارسال (%d موفق)', $day['label'], $day['total'], $day['verified'] ) ); ?>">
											<div class="signa-bar-fill-total" style="height:<?php echo esc_attr( (string) $day['height_pct'] ); ?>%;">
												<span class="signa-bar-num"><?php echo esc_html( (string) $day['total'] ); ?></span>
											</div>
										</div>
										<span class="signa-bar-label"><?php echo esc_html( $day['label'] ); ?></span>
									</div>
								<?php endforeach; ?>
							</div>
						</div>

						<!-- System Health Check -->
						<div class="signa-card signa-col-4">
							<div class="signa-card-head">
								<div>
									<h2>وضعیت سلامت سیستم</h2>
									<p>بررسی پیش‌نیازهای سرور و یکپارچگی</p>
								</div>
							</div>
							<ul class="signa-health-list">
								<li>
									<span>ماژول cURL و ارتباط وب‌سرویس</span>
									<span class="signa-pill <?php echo $curl_active ? 'is-ok' : 'is-err'; ?>"><?php echo $curl_active ? 'فعال' : 'غیرفعال'; ?></span>
								</li>
								<li>
									<span>ماژول رمزنگاری OpenSSL</span>
									<span class="signa-pill <?php echo $openssl_active ? 'is-ok' : 'is-err'; ?>"><?php echo $openssl_active ? 'فعال' : 'غیرفعال'; ?></span>
								</li>
								<li>
									<span>افزونه فروشگاه‌ساز ووکامرس</span>
									<span class="signa-pill <?php echo $wc_active ? 'is-ok' : 'is-warn'; ?>"><?php echo $wc_active ? 'نصب و فعال' : 'نصب نیست'; ?></span>
								</li>
								<li>
									<span>درگاه پیامک اصلی</span>
									<span class="signa-pill <?php echo 'sandbox' === $settings['active_sms_gateway'] ? 'is-warn' : 'is-ok'; ?>">
										<?php echo esc_html( $settings['active_sms_gateway'] ); ?>
									</span>
								</li>
								<li>
									<span>درگاه پیامک پشتیبان (Failover)</span>
									<span class="signa-pill <?php echo 'none' === $settings['backup_sms_gateway'] ? 'is-muted' : 'is-ok'; ?>">
										<?php echo 'none' === $settings['backup_sms_gateway'] ? 'غیرفعال' : esc_html( $settings['backup_sms_gateway'] ); ?>
									</span>
								</li>
							</ul>
						</div>
					</div>

					<!-- Recent Logs Feed -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>آخرین کدهای ارسال‌شده</h2>
								<p>۶ درخواست اخیر ثبت‌شده در سیستم (مفید برای مشاهده سریع کد در حالت تست)</p>
							</div>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp-logs' ) ); ?>" class="signa-btn-secondary">مشاهده تمام لاگ‌ها</a>
						</div>
						<table class="signa-modern-table">
							<thead>
								<tr>
									<th>گیرنده</th>
									<th>کانال / درگاه</th>
									<th>کد OTP</th>
									<th>وضعیت</th>
									<th>پاسخ سرور</th>
									<th>زمان</th>
								</tr>
							</thead>
							<tbody>
								<?php if ( empty( $recent_logs ) ) : ?>
									<tr><td colspan="6" style="text-align:center;padding:24px;">هنوز هیچ کد یکبارمصرفی ارسال نشده است.</td></tr>
								<?php else : ?>
									<?php foreach ( $recent_logs as $rlog ) : ?>
										<tr>
											<td><strong dir="ltr"><?php echo esc_html( $rlog->recipient ); ?></strong></td>
											<td><span class="signa-pill is-muted"><?php echo esc_html( $rlog->channel . ' / ' . $rlog->gateway ); ?></span></td>
											<td><code class="signa-otp-code-pill" dir="ltr"><?php echo esc_html( $rlog->otp_code ); ?></code></td>
											<td>
												<?php if ( 'verified' === $rlog->status ) : ?>
													<span class="signa-pill is-ok">تایید شده</span>
												<?php elseif ( 'failed' === $rlog->status ) : ?>
													<span class="signa-pill is-err">خطا</span>
												<?php elseif ( 'sent' === $rlog->status ) : ?>
													<span class="signa-pill is-info">ارسال شده</span>
												<?php else : ?>
													<span class="signa-pill is-muted">منقضی</span>
												<?php endif; ?>
											</td>
											<td><?php echo esc_html( $rlog->response_message ); ?></td>
											<td dir="ltr"><?php echo esc_html( $rlog->created_at ); ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</section>

				<!-- ==========================================
				     PANEL 2: AUTH FLOW & REGISTRATION
				     ========================================== -->
				<section class="signa-panel" id="signa-tab-auth_flow">
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>روش شناسایی و کانال ارسال کد</h2>
								<p>نحوه دریافت اطلاعات از کاربر و مسیردهی هوشمند ارسال کد تایید را مشخص کنید</p>
							</div>
						</div>

						<label class="signa-section-label">۱. نوع شناسه قابل قبول در فیلد ورود</label>
						<div class="signa-choice-grid signa-cols-3">
							<label class="signa-choice-card <?php echo 'phone_and_email' === $settings['login_mode'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[login_mode]" value="phone_and_email" <?php checked( $settings['login_mode'], 'phone_and_email' ); ?> />
								<span class="dashicons dashicons-id-alt"></span>
								<strong>موبایل و ایمیل (هوشمند)</strong>
								<small>تشخیص خودکار شماره موبایل یا آدرس ایمیل در یک فیلد</small>
							</label>

							<label class="signa-choice-card <?php echo 'phone_only' === $settings['login_mode'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[login_mode]" value="phone_only" <?php checked( $settings['login_mode'], 'phone_only' ); ?> />
								<span class="dashicons dashicons-smartphone"></span>
								<strong>فقط شماره موبایل</strong>
								<small>مختص سایت‌های ایرانی با احراز هویت پیامکی/بله</small>
							</label>

							<label class="signa-choice-card <?php echo 'email_only' === $settings['login_mode'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[login_mode]" value="email_only" <?php checked( $settings['login_mode'], 'email_only' ); ?> />
								<span class="dashicons dashicons-email"></span>
								<strong>فقط آدرس ایمیل</strong>
								<small>ارسال کد یکبارمصرف فقط از طریق ایمیل وردپرس</small>
							</label>
						</div>

						<label class="signa-section-label" style="margin-top:22px;">۲. استراتژی ارسال کد به شماره‌های موبایل</label>
						<div class="signa-choice-grid signa-cols-3">
							<label class="signa-choice-card <?php echo 'sms' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="sms" <?php checked( $settings['mobile_delivery_channel'], 'sms' ); ?> />
								<span class="dashicons dashicons-testimonial"></span>
								<strong>فقط پیامک (SMS)</strong>
								<small>ارسال مستقیم از طریق درگاه پیامک فعال (و پشتیبان)</small>
							</label>

							<label class="signa-choice-card <?php echo 'bale_fallback_sms' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="bale_fallback_sms" <?php checked( $settings['mobile_delivery_channel'], 'bale_fallback_sms' ); ?> />
								<span class="dashicons dashicons-superhero"></span>
								<strong>هوشمند: اول بله ← سپس پیامک</strong>
								<small>کاهش شدید هزینه! اگر کاربر بله نداشت خودکار پیامک می‌شود</small>
							</label>

							<label class="signa-choice-card <?php echo 'sms_fallback_bale' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="sms_fallback_bale" <?php checked( $settings['mobile_delivery_channel'], 'sms_fallback_bale' ); ?> />
								<span class="dashicons dashicons-randomize"></span>
								<strong>هوشمند: اول پیامک ← سپس بله</strong>
								<small>در صورت اختلال درگاه پیامک، از طریق بله ارسال می‌شود</small>
							</label>

							<label class="signa-choice-card <?php echo 'bale' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="bale" <?php checked( $settings['mobile_delivery_channel'], 'bale' ); ?> />
								<span class="dashicons dashicons-format-chat"></span>
								<strong>فقط پیام‌رسان بله</strong>
								<small>ارسال صرفاً از طریق سرویس سفیر یا ربات بله</small>
							</label>

							<label class="signa-choice-card <?php echo 'both' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="both" <?php checked( $settings['mobile_delivery_channel'], 'both' ); ?> />
								<span class="dashicons dashicons-megaphone"></span>
								<strong>ارسال همزمان (پیامک + بله)</strong>
								<small>ارسال همزمان کد در هر دو کانال برای اطمینان حداکثری</small>
							</label>
						</div>
					</div>

					<!-- OTP Timing & Code Parameters -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>تنظیمات کد تایید و زمان‌بندی</h2>
								<p>تعداد ارقام کد، مهلت انقضا و تایمر شمارش معکوس</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-3">
							<div class="signa-field">
								<label for="otp_length">تعداد ارقام کد (۴ تا ۸ رقم)</label>
								<input type="number" name="signa[otp_length]" id="otp_length" value="<?php echo esc_attr( (string) $settings['otp_length'] ); ?>" min="4" max="8" />
								<small>استاندارد پیشنهادی: ۵ رقم</small>
							</div>
							<div class="signa-field">
								<label for="otp_expiry">زمان انقضای کد (ثانیه)</label>
								<input type="number" name="signa[otp_expiry]" id="otp_expiry" value="<?php echo esc_attr( (string) $settings['otp_expiry'] ); ?>" min="30" max="900" />
								<small>پیش‌فرض: ۱۲۰ ثانیه (۲ دقیقه)</small>
							</div>
							<div class="signa-field">
								<label for="resend_cooldown">تایمر ارسال مجدد (ثانیه)</label>
								<input type="number" name="signa[resend_cooldown]" id="resend_cooldown" value="<?php echo esc_attr( (string) $settings['resend_cooldown'] ); ?>" min="15" max="600" />
								<small>فاصله زمانی بین دو درخواست متوالی</small>
							</div>
						</div>
					</div>

					<!-- Registration & Profile Completion Fields -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>ثبت‌نام کاربران جدید و فیلدهای تکمیلی</h2>
								<p>مدیریت عضویت خودکار و اطلاعات دریافتی از کاربرانی که برای اولین بار وارد می‌شوند</p>
							</div>
						</div>

						<div class="signa-switch-row">
							<div>
								<strong>ثبت‌نام خودکار کاربران جدید (Unified Auto-Register)</strong>
								<p>اگر شماره موبایل یا ایمیل در دیتابیس نبود، پس از تایید کد حساب کاربری ساخته شود.</p>
							</div>
							<label class="signa-switch">
								<input type="checkbox" name="signa[auto_register]" value="1" <?php checked( $settings['auto_register'], 1 ); ?> />
								<span class="signa-slider"></span>
							</label>
						</div>

						<div class="signa-fields-grid signa-cols-2" style="margin-top:16px;">
							<div class="signa-field">
								<label for="require_name_on_register">دریافت «نام و نام خانوادگی» از کاربران جدید</label>
								<select name="signa[require_name_on_register]" id="require_name_on_register">
									<option value="disabled" <?php selected( $settings['require_name_on_register'], 'disabled' ); ?>>غیرفعال (عدم نمایش فیلد نام)</option>
									<option value="optional" <?php selected( $settings['require_name_on_register'], 'optional' ); ?>>نمایش به صورت اختیاری در مرحله تایید کد</option>
									<option value="required" <?php selected( $settings['require_name_on_register'], 'required' ); ?>>اجباری برای تکمیل ثبت‌نام کاربران جدید</option>
								</select>
							</div>

							<div class="signa-field">
								<label for="require_email_on_register">دریافت «آدرس ایمیل» از کاربران جدید موبایلی</label>
								<select name="signa[require_email_on_register]" id="require_email_on_register">
									<option value="disabled" <?php selected( $settings['require_email_on_register'], 'disabled' ); ?>>غیرفعال (عدم نمایش فیلد ایمیل)</option>
									<option value="optional" <?php selected( $settings['require_email_on_register'], 'optional' ); ?>>نمایش به صورت اختیاری</option>
									<option value="required" <?php selected( $settings['require_email_on_register'], 'required' ); ?>>اجباری برای کاربران جدید</option>
								</select>
							</div>

							<div class="signa-field">
								<label for="default_user_role">نقش کاربری پیش‌فرض کاربران جدید</label>
								<select name="signa[default_user_role]" id="default_user_role">
									<option value="customer" <?php selected( $settings['default_user_role'], 'customer' ); ?>>مشتری ووکامرس (Customer)</option>
									<option value="subscriber" <?php selected( $settings['default_user_role'], 'subscriber' ); ?>>مشترک وردپرس (Subscriber)</option>
								</select>
							</div>

							<div class="signa-field">
								<label for="username_prefix">پیشوند نام کاربری (Username Prefix)</label>
								<input type="text" name="signa[username_prefix]" id="username_prefix" value="<?php echo esc_attr( $settings['username_prefix'] ); ?>" dir="ltr" />
							</div>
						</div>

						<div class="signa-switch-row" style="margin-top:16px;">
							<div>
								<strong>امکان ورود با رمز عبور ثابت (Password Fallback)</strong>
								<p>نمایش دکمه «ورود با رمز عبور ثابت» زیر فرم برای کاربرانی که ترجیح می‌دهند با رمز وارد شوند.</p>
							</div>
							<label class="signa-switch">
								<input type="checkbox" name="signa[allow_password_login]" value="1" <?php checked( $settings['allow_password_login'], 1 ); ?> />
								<span class="signa-slider"></span>
							</label>
						</div>

						<div class="signa-switch-row">
							<div>
								<strong>نمایش متن قوانین و مقررات در فرم ورود</strong>
								<p>نمایش جمله پذیرش قوانین و حریم خصوصی بالای دکمه دریافت کد.</p>
							</div>
							<label class="signa-switch">
								<input type="checkbox" name="signa[show_terms_checkbox]" value="1" <?php checked( $settings['show_terms_checkbox'], 1 ); ?> />
								<span class="signa-slider"></span>
							</label>
						</div>

						<div class="signa-fields-grid signa-cols-2" style="margin-top:12px;">
							<div class="signa-field">
								<label for="terms_text">متن قوانین و مقررات</label>
								<input type="text" name="signa[terms_text]" id="terms_text" value="<?php echo esc_attr( $settings['terms_text'] ); ?>" />
							</div>
							<div class="signa-field">
								<label for="terms_url">لینک صفحه قوانین (اختیاری)</label>
								<input type="url" name="signa[terms_url]" id="terms_url" value="<?php echo esc_attr( $settings['terms_url'] ); ?>" dir="ltr" placeholder="https://example.com/terms" />
							</div>
						</div>
					</div>

					<!-- Smart Redirects -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>ریدایرکت هوشمند پس از ورود</h2>
								<p>تعیین مقصد هدایت کاربران و مدیران پس از احراز هویت موفق</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-3">
							<div class="signa-field">
								<label for="redirect_behavior">رفتار پیش‌فرض ریدایرکت</label>
								<select name="signa[redirect_behavior]" id="redirect_behavior">
									<option value="auto" <?php selected( $settings['redirect_behavior'], 'auto' ); ?>>خودکار (حساب کاربری ووکامرس / صفحه اصلی)</option>
									<option value="referer" <?php selected( $settings['redirect_behavior'], 'referer' ); ?>>بازگشت به صفحه قبلی کاربر (Referer)</option>
									<option value="custom" <?php selected( $settings['redirect_behavior'], 'custom' ); ?>>هدایت به آدرس سفارشی زیر</option>
								</select>
							</div>
							<div class="signa-field">
								<label for="redirect_url">آدرس ریدایرکت سفارشی کاربران</label>
								<input type="url" name="signa[redirect_url]" id="redirect_url" value="<?php echo esc_attr( $settings['redirect_url'] ); ?>" dir="ltr" placeholder="https://example.com/my-account" />
							</div>
							<div class="signa-field">
								<label for="admin_redirect_url">آدرس ریدایرکت ویژه مدیران (Admins)</label>
								<input type="url" name="signa[admin_redirect_url]" id="admin_redirect_url" value="<?php echo esc_attr( $settings['admin_redirect_url'] ); ?>" dir="ltr" placeholder="<?php echo esc_attr( admin_url() ); ?>" />
							</div>
						</div>
					</div>
				</section>

				<!-- ==========================================
				     PANEL 3: SMS GATEWAYS & FAILOVER
				     ========================================== -->
				<section class="signa-panel" id="signa-tab-sms_gateways">
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>درگاه پیامک اصلی و پشتیبان خودکار (Failover)</h2>
								<p>درگاه اصلی را انتخاب کنید و در صورت تمایل یک درگاه دوم به عنوان پشتیبان زمان قطعی تعیین نمایید</p>
							</div>
						</div>

						<div class="signa-fields-grid signa-cols-2">
							<div class="signa-field">
								<label for="active_sms_gateway">درگاه پیامک اصلی (Primary SMS Gateway)</label>
								<select name="signa[active_sms_gateway]" id="active_sms_gateway">
									<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
										<option value="<?php echo esc_attr( $gw_id ); ?>" <?php selected( $settings['active_sms_gateway'], $gw_id ); ?>>
											<?php echo esc_html( $gw_obj->get_title() ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="signa-field">
								<label for="backup_sms_gateway">درگاه پیامک پشتیبان خودکار (Failover Gateway)</label>
								<select name="signa[backup_sms_gateway]" id="backup_sms_gateway">
									<option value="none" <?php selected( $settings['backup_sms_gateway'], 'none' ); ?>>غیرفعال (بدون درگاه پشتیبان)</option>
									<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
										<?php if ( 'sandbox' !== $gw_id ) : ?>
											<option value="<?php echo esc_attr( $gw_id ); ?>" <?php selected( $settings['backup_sms_gateway'], $gw_id ); ?>>
												<?php echo esc_html( $gw_obj->get_title() ); ?>
											</option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
								<small>در صورت خطا یا اتمام شارژ درگاه اصلی، کد بلافاصله از این درگاه ارسال می‌شود.</small>
							</div>
						</div>

						<!-- Gateway Switcher Pills to Inspect/Edit Any Gateway -->
						<div class="signa-gw-tabs-bar">
							<span>مشاهده و ویرایش تنظیمات درگاه:</span>
							<div class="signa-gw-pills">
								<button type="button" class="signa-gw-pill" data-gw="sandbox">🧪 حالت تست (Sandbox)</button>
								<button type="button" class="signa-gw-pill" data-gw="smsir">💬 SMS.ir</button>
								<button type="button" class="signa-gw-pill" data-gw="kavenegar">📨 کاوه‌نگار</button>
								<button type="button" class="signa-gw-pill" data-gw="melipayamak">📱 ملی‌پیامک</button>
								<button type="button" class="signa-gw-pill" data-gw="farazsms">🚀 فراز اس‌ام‌اس</button>
								<button type="button" class="signa-gw-pill" data-gw="ippanel">🌐 آی‌پی‌پنل (IPPanel)</button>
							</div>
						</div>

						<!-- 1. Sandbox Box -->
						<div class="signa-gateway-box" data-gateway="sandbox">
							<div class="signa-gw-box-head">
								<h3>🧪 حالت تست / آزمایشی (Sandbox)</h3>
								<span class="signa-pill is-warn">مخصوص توسعه و تست لوکال</span>
							</div>
							<p class="description">در این حالت هیچ پیامکی به بیرون ارسال نمی‌شود، اما کد تولیدشده در جدول لاگ ثبت می‌شود تا بدون نیاز به پنل پیامک، کل فرآیند را روی لوکال تست کنید.</p>
							<div class="signa-switch-row" style="margin-top:14px;">
								<div>
									<strong>نمایش کد OTP در کادر پیام بالای فرم ورود</strong>
									<p>هنگام درخواست کد، خودِ کد آزمایشی در پیغام سبز بالای فرم به کاربر نمایش داده شود (در سایت عملیاتی خاموش کنید).</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[show_debug_code_in_toast]" value="1" <?php checked( $settings['show_debug_code_in_toast'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>
						</div>

						<!-- 2. SMS.ir Box -->
						<div class="signa-gateway-box" data-gateway="smsir">
							<div class="signa-gw-box-head">
								<h3>💬 پیکربندی درگاه SMS.ir (نسخه جدید REST v1)</h3>
								<span class="signa-pill is-info">api.sms.ir/v1/send/verify</span>
							</div>
							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="smsir_api_key">کلید وب‌سرویس (API Key)</label>
									<input type="text" name="signa[smsir_api_key]" id="smsir_api_key" value="<?php echo esc_attr( $settings['smsir_api_key'] ); ?>" dir="ltr" placeholder="کلید دریافتی از پنل app.sms.ir" />
								</div>
								<div class="signa-field">
									<label for="smsir_template_id">شناسه قالب (Template ID)</label>
									<input type="text" name="signa[smsir_template_id]" id="smsir_template_id" value="<?php echo esc_attr( $settings['smsir_template_id'] ); ?>" dir="ltr" placeholder="100000" />
								</div>
								<div class="signa-field">
									<label for="smsir_param_name">نام متغیر کد در قالب</label>
									<input type="text" name="signa[smsir_param_name]" id="smsir_param_name" value="<?php echo esc_attr( $settings['smsir_param_name'] ); ?>" dir="ltr" placeholder="CODE" />
								</div>
							</div>
						</div>

						<!-- 3. Kavenegar Box -->
						<div class="signa-gateway-box" data-gateway="kavenegar">
							<div class="signa-gw-box-head">
								<h3>📨 پیکربندی درگاه کاوه‌نگار (Kavenegar)</h3>
								<span class="signa-pill is-info">verify/lookup.json</span>
							</div>
							<div class="signa-fields-grid signa-cols-2">
								<div class="signa-field">
									<label for="kavenegar_api_key">کلید API (API Key)</label>
									<input type="text" name="signa[kavenegar_api_key]" id="kavenegar_api_key" value="<?php echo esc_attr( $settings['kavenegar_api_key'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="kavenegar_template">نام الگوی اعتبارسنجی (Template)</label>
									<input type="text" name="signa[kavenegar_template]" id="kavenegar_template" value="<?php echo esc_attr( $settings['kavenegar_template'] ); ?>" dir="ltr" placeholder="verify-login" />
									<small>الگو باید در پنل کاوه‌نگار شامل متغیر <code>%token</code> باشد.</small>
								</div>
							</div>
						</div>

						<!-- 4. Melipayamak Box -->
						<div class="signa-gateway-box" data-gateway="melipayamak">
							<div class="signa-gw-box-head">
								<h3>📱 پیکربندی درگاه ملی‌پیامک (Melipayamak)</h3>
								<span class="signa-pill is-info">BaseServiceNumber</span>
							</div>
							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="melipayamak_username">نام کاربری پنل</label>
									<input type="text" name="signa[melipayamak_username]" id="melipayamak_username" value="<?php echo esc_attr( $settings['melipayamak_username'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="melipayamak_password">رمز عبور یا API Key</label>
									<input type="password" name="signa[melipayamak_password]" id="melipayamak_password" value="<?php echo esc_attr( $settings['melipayamak_password'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="melipayamak_body_id">کد متن خدماتی (bodyId)</label>
									<input type="text" name="signa[melipayamak_body_id]" id="melipayamak_body_id" value="<?php echo esc_attr( $settings['melipayamak_body_id'] ); ?>" dir="ltr" placeholder="12345" />
								</div>
							</div>
						</div>

						<!-- 5. FarazSMS Box -->
						<div class="signa-gateway-box" data-gateway="farazsms">
							<div class="signa-gw-box-head">
								<h3>🚀 پیکربندی درگاه فراز اس‌ام‌اس (FarazSMS)</h3>
								<span class="signa-pill is-info">ارسال پترن خدماتی</span>
							</div>
							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="farazsms_auth_type">روش احراز هویت</label>
									<select name="signa[farazsms_auth_type]" id="farazsms_auth_type">
										<option value="apikey" <?php selected( $settings['farazsms_auth_type'], 'apikey' ); ?>>کلید دسترسی (API Key)</option>
										<option value="userpass" <?php selected( $settings['farazsms_auth_type'], 'userpass' ); ?>>نام کاربری و رمز عبور</option>
									</select>
								</div>
								<div class="signa-field">
									<label for="farazsms_api_key">کلید دسترسی (API Key)</label>
									<input type="text" name="signa[farazsms_api_key]" id="farazsms_api_key" value="<?php echo esc_attr( $settings['farazsms_api_key'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="farazsms_from_number">شماره خط فرستنده</label>
									<input type="text" name="signa[farazsms_from_number]" id="farazsms_from_number" value="<?php echo esc_attr( $settings['farazsms_from_number'] ); ?>" dir="ltr" placeholder="+983000505" />
								</div>
								<div class="signa-field">
									<label for="farazsms_pattern_code">کد پترن (Pattern Code)</label>
									<input type="text" name="signa[farazsms_pattern_code]" id="farazsms_pattern_code" value="<?php echo esc_attr( $settings['farazsms_pattern_code'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="farazsms_param_name">نام متغیر درون پترن</label>
									<input type="text" name="signa[farazsms_param_name]" id="farazsms_param_name" value="<?php echo esc_attr( $settings['farazsms_param_name'] ); ?>" dir="ltr" placeholder="verification-code" />
								</div>
								<div class="signa-field">
									<label for="farazsms_username">نام کاربری و رمز (در حالت سنتی)</label>
									<div style="display:flex;gap:6px;">
										<input type="text" name="signa[farazsms_username]" id="farazsms_username" value="<?php echo esc_attr( $settings['farazsms_username'] ); ?>" dir="ltr" placeholder="Username" />
										<input type="password" name="signa[farazsms_password]" id="farazsms_password" value="<?php echo esc_attr( $settings['farazsms_password'] ); ?>" dir="ltr" placeholder="Password" />
									</div>
								</div>
							</div>
						</div>

						<!-- 6. IPPanel Box -->
						<div class="signa-gateway-box" data-gateway="ippanel">
							<div class="signa-gw-box-head">
								<h3>🌐 پیکربندی درگاه آی‌پی‌پنل (IPPanel Edge / REST)</h3>
								<span class="signa-pill is-info">edge.ippanel.com</span>
							</div>
							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="ippanel_auth_type">نسخه وب‌سرویس IPPanel</label>
									<select name="signa[ippanel_auth_type]" id="ippanel_auth_type">
										<option value="edge" <?php selected( $settings['ippanel_auth_type'], 'edge' ); ?>>وب‌سرویس جدید Edge (پیشنهادی)</option>
										<option value="apikey" <?php selected( $settings['ippanel_auth_type'], 'apikey' ); ?>>وب‌سرویس REST با کلید API</option>
										<option value="userpass" <?php selected( $settings['ippanel_auth_type'], 'userpass' ); ?>>نام کاربری و رمز عبور</option>
									</select>
								</div>
								<div class="signa-field">
									<label for="ippanel_api_key">کلید API / توکن Authorization</label>
									<input type="text" name="signa[ippanel_api_key]" id="ippanel_api_key" value="<?php echo esc_attr( $settings['ippanel_api_key'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="ippanel_from_number">شماره خط فرستنده</label>
									<input type="text" name="signa[ippanel_from_number]" id="ippanel_from_number" value="<?php echo esc_attr( $settings['ippanel_from_number'] ); ?>" dir="ltr" placeholder="+983000505" />
								</div>
								<div class="signa-field">
									<label for="ippanel_pattern_code">کد پترن (Pattern Code)</label>
									<input type="text" name="signa[ippanel_pattern_code]" id="ippanel_pattern_code" value="<?php echo esc_attr( $settings['ippanel_pattern_code'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="ippanel_param_name">نام متغیر درون پترن</label>
									<input type="text" name="signa[ippanel_param_name]" id="ippanel_param_name" value="<?php echo esc_attr( $settings['ippanel_param_name'] ); ?>" dir="ltr" placeholder="code" />
								</div>
								<div class="signa-field">
									<label>نام کاربری و رمز (در حالت کلاسیک)</label>
									<div style="display:flex;gap:6px;">
										<input type="text" name="signa[ippanel_username]" value="<?php echo esc_attr( $settings['ippanel_username'] ); ?>" dir="ltr" placeholder="Username" />
										<input type="password" name="signa[ippanel_password]" value="<?php echo esc_attr( $settings['ippanel_password'] ); ?>" dir="ltr" placeholder="Password" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<!-- ==========================================
				     PANEL 4: BALE MESSENGER & EMAIL
				     ========================================== -->
				<section class="signa-panel" id="signa-tab-bale_email">
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>پیکربندی پیام‌رسان بله (Bale OTP)</h2>
								<p>اتصال به وب‌سرویس رسمی «سفیر بله» برای ارسال مستقیم کد تایید به شماره موبایل یا استفاده از ربات بله</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-3">
							<div class="signa-field">
								<label for="bale_mode">حالت اتصال به بله</label>
								<select name="signa[bale_mode]" id="bale_mode">
									<option value="safir" <?php selected( $settings['bale_mode'], 'safir' ); ?>>وب‌سرویس رسمی سفیر بله (Safir OTP API)</option>
									<option value="bot" <?php selected( $settings['bale_mode'], 'bot' ); ?>>ربات بله (Bale Bot API)</option>
								</select>
							</div>
							<div class="signa-field">
								<label for="bale_client_id">شناسه کاربری سفیر (Client ID)</label>
								<input type="text" name="signa[bale_client_id]" id="bale_client_id" value="<?php echo esc_attr( $settings['bale_client_id'] ); ?>" dir="ltr" />
							</div>
							<div class="signa-field">
								<label for="bale_client_secret">رمز عبور سفیر (Client Secret)</label>
								<input type="password" name="signa[bale_client_secret]" id="bale_client_secret" value="<?php echo esc_attr( $settings['bale_client_secret'] ); ?>" dir="ltr" />
							</div>
						</div>

						<div class="signa-fields-grid signa-cols-2" style="margin-top:14px;">
							<div class="signa-field">
								<label for="bale_bot_token">توکن ربات بله (در حالت Bot API)</label>
								<input type="text" name="signa[bale_bot_token]" id="bale_bot_token" value="<?php echo esc_attr( $settings['bale_bot_token'] ); ?>" dir="ltr" />
							</div>
							<div class="signa-field">
								<label for="bale_message_template">قالب پیام ربات بله</label>
								<textarea name="signa[bale_message_template]" id="bale_message_template" rows="2"><?php echo esc_textarea( $settings['bale_message_template'] ); ?></textarea>
							</div>
						</div>
					</div>

					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>پیکربندی ایمیل (Email OTP)</h2>
								<p>تنظیمات قالب HTML ایمیل‌های کد یکبارمصرف ارسالی توسط وردپرس</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-2">
							<div class="signa-field">
								<label for="email_from_name">نام فرستنده ایمیل</label>
								<input type="text" name="signa[email_from_name]" id="email_from_name" value="<?php echo esc_attr( $settings['email_from_name'] ); ?>" />
							</div>
							<div class="signa-field">
								<label for="email_from_address">آدرس ایمیل فرستنده</label>
								<input type="email" name="signa[email_from_address]" id="email_from_address" value="<?php echo esc_attr( $settings['email_from_address'] ); ?>" dir="ltr" />
							</div>
							<div class="signa-field">
								<label for="email_subject">موضوع ایمیل (Subject)</label>
								<input type="text" name="signa[email_subject]" id="email_subject" value="<?php echo esc_attr( $settings['email_subject'] ); ?>" />
							</div>
							<div class="signa-field">
								<label for="email_heading">تیتر هدر داخل ایمیل</label>
								<input type="text" name="signa[email_heading]" id="email_heading" value="<?php echo esc_attr( $settings['email_heading'] ); ?>" />
							</div>
						</div>
						<div class="signa-field" style="margin-top:14px;">
							<label for="email_body_text">متن توضیحات ایمیل (متغیرها: <code>{site_name}</code>، <code>{code}</code>، <code>{expiry}</code>)</label>
							<textarea name="signa[email_body_text]" id="email_body_text" rows="3"><?php echo esc_textarea( $settings['email_body_text'] ); ?></textarea>
						</div>
					</div>
				</section>

				<!-- ==========================================
				     PANEL 5: APPEARANCE STUDIO & LIVE PREVIEW
				     ========================================== -->
				<section class="signa-panel" id="signa-tab-appearance_studio">
					<div class="signa-studio-layout">
						<!-- Studio Controls (Right Column) -->
						<div class="signa-studio-controls">
							<div class="signa-card">
								<div class="signa-card-head">
									<div>
										<h2>پالت‌های رنگی و تم‌های آماده (Presets)</h2>
										<p>با یک کلیک استایل کلی فرم را تغییر دهید یا رنگ‌ها را سفارشی کنید</p>
									</div>
								</div>

								<div class="signa-preset-grid">
									<button type="button" class="signa-preset-btn" data-primary="#2563eb" data-bg="#ffffff" data-text="#111827" data-radius="16">
										<span class="signa-swatch" style="background:#2563eb;"></span>
										آبی مدرن (پیش‌فرض)
									</button>
									<button type="button" class="signa-preset-btn" data-primary="#ef4444" data-bg="#ffffff" data-text="#111827" data-radius="12">
										<span class="signa-swatch" style="background:#ef4444;"></span>
										قرمز فروشگاهی
									</button>
									<button type="button" class="signa-preset-btn" data-primary="#10b981" data-bg="#ffffff" data-text="#0f172a" data-radius="20">
										<span class="signa-swatch" style="background:#10b981;"></span>
										سبز زمردی
									</button>
									<button type="button" class="signa-preset-btn" data-primary="#6366f1" data-bg="#1e293b" data-text="#f8fafc" data-radius="18">
										<span class="signa-swatch" style="background:#1e293b;border:2px solid #6366f1;"></span>
										تیره لوکس (Dark)
									</button>
								</div>

								<div class="signa-fields-grid signa-cols-3" style="margin-top:18px;">
									<div class="signa-field">
										<label for="primary_color">رنگ اصلی برند و دکمه</label>
										<div class="signa-color-input-wrap">
											<input type="color" name="signa[primary_color]" id="primary_color" value="<?php echo esc_attr( $settings['primary_color'] ); ?>" />
											<span id="primary_color_hex"><?php echo esc_html( $settings['primary_color'] ); ?></span>
										</div>
									</div>
									<div class="signa-field">
										<label for="card_bg_color">رنگ پس‌زمینه کارت</label>
										<div class="signa-color-input-wrap">
											<input type="color" name="signa[card_bg_color]" id="card_bg_color" value="<?php echo esc_attr( $settings['card_bg_color'] ); ?>" />
											<span id="card_bg_color_hex"><?php echo esc_html( $settings['card_bg_color'] ); ?></span>
										</div>
									</div>
									<div class="signa-field">
										<label for="text_color">رنگ متون اصلی</label>
										<div class="signa-color-input-wrap">
											<input type="color" name="signa[text_color]" id="text_color" value="<?php echo esc_attr( $settings['text_color'] ); ?>" />
											<span id="text_color_hex"><?php echo esc_html( $settings['text_color'] ); ?></span>
										</div>
									</div>
								</div>

								<div class="signa-fields-grid signa-cols-3" style="margin-top:16px;">
									<div class="signa-field">
										<label for="border_radius">گردی گوشه‌ها: <strong id="radius_val_label"><?php echo esc_html( (string) $settings['border_radius'] ); ?>px</strong></label>
										<input type="range" name="signa[border_radius]" id="border_radius" min="0" max="28" value="<?php echo esc_attr( (string) $settings['border_radius'] ); ?>" />
									</div>
									<div class="signa-field">
										<label for="digit_box_style">استایل باکس ارقام کد</label>
										<select name="signa[digit_box_style]" id="digit_box_style">
											<option value="box" <?php selected( $settings['digit_box_style'], 'box' ); ?>>مربعی مدرن (Box)</option>
											<option value="underline" <?php selected( $settings['digit_box_style'], 'underline' ); ?>>خط تیره پایین (Underline)</option>
											<option value="pill" <?php selected( $settings['digit_box_style'], 'pill' ); ?>>کپسولی گرد (Pill)</option>
										</select>
									</div>
									<div class="signa-field">
										<label for="form_max_width">حداکثر عرض کارت (px)</label>
										<input type="number" name="signa[form_max_width]" id="form_max_width" min="320" max="640" value="<?php echo esc_attr( (string) $settings['form_max_width'] ); ?>" />
									</div>
								</div>

								<div class="signa-field" style="margin-top:16px;">
									<label for="logo_url">تصویر لوگوی بالای فرم (اختیاری)</label>
									<div style="display:flex;gap:8px;">
										<input type="url" name="signa[logo_url]" id="logo_url" value="<?php echo esc_attr( $settings['logo_url'] ); ?>" dir="ltr" placeholder="https://example.com/logo.png" style="flex:1;" />
										<button type="button" id="signa_upload_logo_btn" class="signa-btn-secondary">انتخاب از رسانه</button>
									</div>
								</div>
							</div>

							<div class="signa-card" style="margin-top:20px;">
								<div class="signa-card-head">
									<div>
										<h2>متن‌ها و برچسب‌های فرم</h2>
										<p>عنوان‌ها و متن دکمه‌ها را متناسب با لحن برند خود تغییر دهید</p>
									</div>
								</div>
								<div class="signa-fields-grid signa-cols-2">
									<div class="signa-field">
										<label for="form_title">عنوان اصلی فرم</label>
										<input type="text" name="signa[form_title]" id="form_title" value="<?php echo esc_attr( $settings['form_title'] ); ?>" />
									</div>
									<div class="signa-field">
										<label for="button_text">متن دکمه مرحله اول</label>
										<input type="text" name="signa[button_text]" id="button_text" value="<?php echo esc_attr( $settings['button_text'] ); ?>" />
									</div>
									<div class="signa-field">
										<label for="form_subtitle">زیرعنوان (توضیح کوتاه)</label>
										<input type="text" name="signa[form_subtitle]" id="form_subtitle" value="<?php echo esc_attr( $settings['form_subtitle'] ); ?>" />
									</div>
									<div class="signa-field">
										<label for="verify_button_text">متن دکمه تایید کد</label>
										<input type="text" name="signa[verify_button_text]" id="verify_button_text" value="<?php echo esc_attr( $settings['verify_button_text'] ); ?>" />
									</div>
								</div>
								<div class="signa-field" style="margin-top:14px;">
									<label for="custom_css">کدهای CSS سفارشی (Custom CSS)</label>
									<textarea name="signa[custom_css]" id="custom_css" rows="3" dir="ltr" placeholder=".signa-otp-card { ... }"><?php echo esc_textarea( $settings['custom_css'] ); ?></textarea>
								</div>
							</div>
						</div>

						<!-- Interactive Live Preview Stage (Left Sticky Column) -->
						<div class="signa-studio-preview-col">
							<div class="signa-preview-box">
								<div class="signa-preview-toolbar">
									<span>👁️ پیش‌نمایش زنده فرم</span>
									<div class="signa-preview-step-btns">
										<button type="button" class="signa-prev-step-btn active" data-step="1">مرحله ۱: شماره</button>
										<button type="button" class="signa-prev-step-btn" data-step="2">مرحله ۲: کد تایید</button>
									</div>
								</div>

								<div class="signa-preview-canvas">
									<div id="signa-live-preview-card" class="signa-prev-card" style="background:<?php echo esc_attr( $settings['card_bg_color'] ); ?>;color:<?php echo esc_attr( $settings['text_color'] ); ?>;border-radius:<?php echo esc_attr( (string) $settings['border_radius'] ); ?>px;">
										<div style="text-align:center;margin-bottom:20px;">
											<div id="signa-prev-logo-wrap" style="<?php echo empty( $settings['logo_url'] ) ? 'display:none;' : ''; ?>margin-bottom:12px;">
												<img id="signa-prev-logo-img" src="<?php echo esc_url( $settings['logo_url'] ); ?>" alt="Logo" style="max-height:48px;" />
											</div>
											<div id="signa-prev-badge-icon" style="<?php echo ! empty( $settings['logo_url'] ) ? 'display:none;' : 'display:inline-flex;'; ?>width:48px;height:48px;border-radius:12px;align-items:center;justify-content:center;background:rgba(37,99,235,0.12);color:<?php echo esc_attr( $settings['primary_color'] ); ?>;margin-bottom:10px;">
												<span class="dashicons dashicons-smartphone" style="font-size:24px;width:24px;height:24px;"></span>
											</div>
											<h3 id="signa-prev-title" style="margin:0 0 6px 0;font-size:18px;color:inherit;"><?php echo esc_html( $settings['form_title'] ); ?></h3>
											<p id="signa-prev-subtitle" style="margin:0;font-size:12.5px;opacity:0.75;"><?php echo esc_html( $settings['form_subtitle'] ); ?></p>
										</div>

										<!-- Preview Step 1 -->
										<div id="signa-prev-step-1">
											<label style="display:block;font-size:12.5px;font-weight:600;margin-bottom:6px;">شماره موبایل یا ایمیل</label>
											<input type="text" value="09123456789" dir="ltr" readonly style="width:100%;height:44px;padding:0 12px;border:1.5px solid #d1d5db;border-radius:10px;margin-bottom:16px;text-align:left;background:#f9fafb;color:#111827;" />
											<button type="button" id="signa-prev-btn-1" style="width:100%;height:44px;border:none;border-radius:10px;background:<?php echo esc_attr( $settings['primary_color'] ); ?>;color:#fff;font-weight:600;font-size:14px;cursor:default;">
												<?php echo esc_html( $settings['button_text'] ); ?>
											</button>
										</div>

										<!-- Preview Step 2 -->
										<div id="signa-prev-step-2" style="display:none;">
											<div style="display:flex;justify-content:space-between;background:rgba(156,163,175,0.15);padding:8px 12px;border-radius:8px;margin-bottom:14px;font-size:12px;">
												<strong dir="ltr">0912***6789</strong>
												<span style="color:<?php echo esc_attr( $settings['primary_color'] ); ?>;font-weight:600;">ویرایش</span>
											</div>
											<div id="signa-prev-digits" style="display:flex;justify-content:center;gap:6px;margin-bottom:16px;" dir="ltr">
												<span class="signa-prev-digit">5</span>
												<span class="signa-prev-digit">8</span>
												<span class="signa-prev-digit">2</span>
												<span class="signa-prev-digit">9</span>
												<span class="signa-prev-digit">1</span>
											</div>
											<button type="button" id="signa-prev-btn-2" style="width:100%;height:44px;border:none;border-radius:10px;background:<?php echo esc_attr( $settings['primary_color'] ); ?>;color:#fff;font-weight:600;font-size:14px;cursor:default;">
												<?php echo esc_html( $settings['verify_button_text'] ); ?>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<!-- ==========================================
				     PANEL 6: WOOCOMMERCE & SHORTCODES
				     ========================================== -->
				<section class="signa-panel" id="signa-tab-woocommerce">
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>یکپارچگی با ووکامرس و وردپرس</h2>
								<p>جایگزینی خودکار فرم‌های پیش‌فرض با سیستم ورود یکبارمصرف</p>
							</div>
						</div>

						<div class="signa-switch-row">
							<div>
								<strong>جایگزینی فرم حساب کاربری ووکامرس (My Account)</strong>
								<p>فرم ورود و عضویت پیش‌فرض ووکامرس در برگه حساب کاربری با فرم OTP جایگزین شود.</p>
							</div>
							<label class="signa-switch">
								<input type="checkbox" name="signa[wc_replace_myaccount]" value="1" <?php checked( $settings['wc_replace_myaccount'], 1 ); ?> />
								<span class="signa-slider"></span>
							</label>
						</div>

						<div class="signa-switch-row">
							<div>
								<strong>نوار ورود سریع در صفحه تسویه‌حساب ووکامرس (Checkout)</strong>
								<p>نمایش باکس بازشونده ورود با کد یکبارمصرف بالای صفحه تسویه‌حساب برای مشتریان مهمان.</p>
							</div>
							<label class="signa-switch">
								<input type="checkbox" name="signa[wc_checkout_otp_box]" value="1" <?php checked( $settings['wc_checkout_otp_box'], 1 ); ?> />
								<span class="signa-slider"></span>
							</label>
						</div>

						<div class="signa-switch-row">
							<div>
								<strong>مودال پاپ‌آپ سراسری (Global Popup Modal)</strong>
								<p>قرارگیری خودکار پنجره پاپ‌آپ ورود در فوتر سایت برای باز شدن با شورت‌کد دکمه یا کلاس CSS.</p>
							</div>
							<label class="signa-switch">
								<input type="checkbox" name="signa[enable_global_modal]" value="1" <?php checked( $settings['enable_global_modal'], 1 ); ?> />
								<span class="signa-slider"></span>
							</label>
						</div>

						<div class="signa-switch-row">
							<div>
								<strong>افزودن به صفحه ورود پیش‌فرض وردپرس (wp-login.php)</strong>
								<p>نمایش فرم ورود با کد یکبارمصرف در صفحه <code>wp-login.php</code> وردپرس.</p>
							</div>
							<label class="signa-switch">
								<input type="checkbox" name="signa[wp_login_integration]" value="1" <?php checked( $settings['wp_login_integration'], 1 ); ?> />
								<span class="signa-slider"></span>
							</label>
						</div>
					</div>

					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>شورت‌کدها و کلاس‌های آماده (کلیک برای کپی)</h2>
								<p>از این شورت‌کدها در برگه‌ها، هدر قالب یا المنتور استفاده کنید</p>
							</div>
						</div>
						<div class="signa-copy-cards-grid">
							<div class="signa-copy-card">
								<strong>فرم کامل ورود و ثبت‌نام در برگه</strong>
								<code dir="ltr">[signa_otp_login]</code>
								<button type="button" class="signa-copy-btn" data-copy="[signa_otp_login]">کپی شورت‌کد</button>
							</div>

							<div class="signa-copy-card">
								<strong>دکمه بازکننده مودال پاپ‌آپ (مناسب هدر)</strong>
								<code dir="ltr">[signa_otp_button text="ورود / عضویت"]</code>
								<button type="button" class="signa-copy-btn" data-copy='[signa_otp_button text="ورود / عضویت"]'>کپی شورت‌کد</button>
							</div>

							<div class="signa-copy-card">
								<strong>کلاس CSS بازکننده پاپ‌آپ روی هر دکمه دلخواه</strong>
								<code dir="ltr">signa-open-modal</code>
								<button type="button" class="signa-copy-btn" data-copy="signa-open-modal">کپی کلاس</button>
							</div>
						</div>
					</div>
				</section>

				<!-- ==========================================
				     PANEL 7: SECURITY, FIREWALL & CAPTCHA
				     ========================================== -->
				<section class="signa-panel" id="signa-tab-security_firewall">
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>محدودیت نرخ ارسال (Rate Limiting) و محافظت Brute-Force</h2>
								<p>جلوگیری از اسپم پیامکی و سوختن شارژ پنل با محدودسازی هوشمند درخواست‌ها</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-4">
							<div class="signa-field">
								<label for="max_requests_per_hour">سقف درخواست هر شماره (در ساعت)</label>
								<input type="number" name="signa[max_requests_per_hour]" id="max_requests_per_hour" value="<?php echo esc_attr( (string) $settings['max_requests_per_hour'] ); ?>" min="1" max="50" />
							</div>
							<div class="signa-field">
								<label for="max_ip_requests_per_hour">سقف درخواست هر IP (در ساعت)</label>
								<input type="number" name="signa[max_ip_requests_per_hour]" id="max_ip_requests_per_hour" value="<?php echo esc_attr( (string) $settings['max_ip_requests_per_hour'] ); ?>" min="2" max="200" />
							</div>
							<div class="signa-field">
								<label for="max_verify_attempts">حداکثر تلاش اشتباه کد</label>
								<input type="number" name="signa[max_verify_attempts]" id="max_verify_attempts" value="<?php echo esc_attr( (string) $settings['max_verify_attempts'] ); ?>" min="2" max="15" />
							</div>
							<div class="signa-field">
								<label for="lockout_duration">مدت زمان مسدودی موقت (ثانیه)</label>
								<input type="number" name="signa[lockout_duration]" id="lockout_duration" value="<?php echo esc_attr( (string) $settings['lockout_duration'] ); ?>" min="60" max="86400" />
							</div>
						</div>
					</div>

					<!-- Captcha Protection -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>سپر امنیتی کپچا (Captcha Anti-Bot)</h2>
								<p>محافظت از فرم درخواست پیامک در برابر ربات‌های خودکار</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-3">
							<div class="signa-field">
								<label for="captcha_type">نوع کپچای امنیتی</label>
								<select name="signa[captcha_type]" id="captcha_type">
									<option value="none" <?php selected( $settings['captcha_type'], 'none' ); ?>>غیرفعال (بدون کپچا)</option>
									<option value="math" <?php selected( $settings['captcha_type'], 'math' ); ?>>کپچای ریاضی هوشمند داخلی (بدون نیاز به کلید)</option>
									<option value="recaptcha_v3" <?php selected( $settings['captcha_type'], 'recaptcha_v3' ); ?>>Google reCAPTCHA v3</option>
									<option value="turnstile" <?php selected( $settings['captcha_type'], 'turnstile' ); ?>>Cloudflare Turnstile</option>
								</select>
							</div>
							<div class="signa-field">
								<label for="captcha_site_key">کلید سایت (Site Key - برای گوگل/کلودفلر)</label>
								<input type="text" name="signa[captcha_site_key]" id="captcha_site_key" value="<?php echo esc_attr( $settings['captcha_site_key'] ); ?>" dir="ltr" />
							</div>
							<div class="signa-field">
								<label for="captcha_secret_key">کلید مخفی (Secret Key - برای گوگل/کلودفلر)</label>
								<input type="password" name="signa[captcha_secret_key]" id="captcha_secret_key" value="<?php echo esc_attr( $settings['captcha_secret_key'] ); ?>" dir="ltr" />
							</div>
						</div>
					</div>

					<!-- Firewall Blacklist & Whitelist -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>دیوار آتش: لیست سیاه و سفید (Blacklist / Whitelist)</h2>
								<p>در هر خط یک مورد وارد کنید (از <code>*</code> برای الگو مثل <code>0919000*</code> می‌توانید استفاده کنید)</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-3">
							<div class="signa-field">
								<label for="blocked_phones">شماره‌ها / پیش‌شماره‌های مسدود (Blacklist)</label>
								<textarea name="signa[blocked_phones]" id="blocked_phones" rows="4" dir="ltr" placeholder="09120000000&#10;0939111*"><?php echo esc_textarea( $settings['blocked_phones'] ); ?></textarea>
							</div>
							<div class="signa-field">
								<label for="blocked_ips">آدرس‌های IP مسدود (IP Blacklist)</label>
								<textarea name="signa[blocked_ips]" id="blocked_ips" rows="4" dir="ltr" placeholder="192.168.1.50&#10;185.10.*"><?php echo esc_textarea( $settings['blocked_ips'] ); ?></textarea>
							</div>
							<div class="signa-field">
								<label for="whitelisted_identifiers">لیست سفید معاف از محدودیت (Whitelist)</label>
								<textarea name="signa[whitelisted_identifiers]" id="whitelisted_identifiers" rows="4" dir="ltr" placeholder="09121234567&#10;127.0.0.1"><?php echo esc_textarea( $settings['whitelisted_identifiers'] ); ?></textarea>
							</div>
						</div>
					</div>

					<!-- Active Lockouts Table -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>قفل‌های امنیتی فعال (Active Lockouts)</h2>
								<p>شماره‌ها و IPهایی که به علت وارد کردن کد اشتباه بیش از حد، موقتاً قفل شده‌اند</p>
							</div>
						</div>
						<table class="signa-modern-table">
							<thead>
								<tr>
									<th>شناسه / شماره</th>
									<th>آدرس IP</th>
									<th>زمان قفل شدن</th>
									<th>زمان باقی‌مانده</th>
									<th>عملیات</th>
								</tr>
							</thead>
							<tbody>
								<?php if ( empty( $active_lockouts ) ) : ?>
									<tr><td colspan="5" style="text-align:center;padding:20px;color:#10b981;">✅ در حال حاضر هیچ شماره یا آی‌پی مسدود شده‌ای وجود ندارد.</td></tr>
								<?php else : ?>
									<?php foreach ( $active_lockouts as $lock_key => $lock_info ) : ?>
										<tr>
											<td><strong dir="ltr"><?php echo esc_html( $lock_info['target'] ); ?></strong></td>
											<td><code dir="ltr"><?php echo esc_html( $lock_info['ip'] ); ?></code></td>
											<td dir="ltr"><?php echo esc_html( $lock_info['locked_at'] ); ?></td>
											<td><?php echo esc_html( (string) ceil( $lock_info['remaining_sec'] / 60 ) ); ?> دقیقه</td>
											<td>
												<button type="button" class="signa-btn-secondary signa-unlock-btn" data-target="<?php echo esc_attr( $lock_key ); ?>">
													رفع مسدودی آنی (Unlock)
												</button>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</section>

				<!-- ==========================================
				     PANEL 8: LIVE TESTER, TOOLS & BACKUP
				     ========================================== -->
				<section class="signa-panel" id="signa-tab-tools_backup">
					<!-- Live Gateway Tester -->
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>آزمایشگاه تست زنده ارسال کد (Live Gateway Tester)</h2>
								<p>ارسال آنی کد آزمایشی برای اطمینان از صحت تنظیمات هر درگاه، پیام‌رسان بله و ایمیل</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-3">
							<div class="signa-field">
								<label for="signa_test_recipient">شماره موبایل یا ایمیل گیرنده تست</label>
								<input type="text" id="signa_test_recipient" dir="ltr" placeholder="09123456789 یا email@example.com" />
							</div>
							<div class="signa-field">
								<label for="signa_test_channel">کانال ارسال تست</label>
								<select id="signa_test_channel">
									<option value="sms">پیامک (درگاه انتخابی)</option>
									<option value="bale">پیام‌رسان بله (Bale)</option>
									<option value="email">ایمیل (wp_mail)</option>
								</select>
							</div>
							<div class="signa-field">
								<label for="signa_test_gateway_id">درگاه پیامک مشخص (اختیاری)</label>
								<select id="signa_test_gateway_id">
									<option value="">استفاده از درگاه اصلی فعال</option>
									<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
										<option value="<?php echo esc_attr( $gw_id ); ?>"><?php echo esc_html( $gw_obj->get_title() ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div style="margin-top:14px;">
							<button type="button" id="signa_run_test_btn" class="signa-btn-save">
								<span class="dashicons dashicons-controls-play"></span>
								ارسال کد آزمایشی همین الان
							</button>
						</div>
						<div id="signa_test_result" style="display:none;margin-top:14px;padding:14px 18px;border-radius:10px;"></div>
					</div>

					<!-- Export / Import / Reset Settings -->
					<div class="signa-bento-row" style="margin-top:20px;">
						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div>
									<h2>برون‌ریزی و درون‌ریزی تنظیمات (JSON Backup)</h2>
									<p>انتقال سریع تنظیمات بین سایت تستی و سایت اصلی</p>
								</div>
							</div>
							<div class="signa-field">
								<label>کد پشتیبان تنظیمات فعلی (Export JSON)</label>
								<textarea id="signa_export_json_box" rows="3" dir="ltr" readonly><?php echo esc_textarea( wp_json_encode( $settings ) ); ?></textarea>
								<button type="button" class="signa-btn-secondary signa-copy-btn" data-copy="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>" style="margin-top:8px;">
									کپی JSON تنظیمات
								</button>
							</div>
							<div class="signa-field" style="margin-top:16px;">
								<label for="signa_import_json_box">درون‌ریزی تنظیمات (Import JSON)</label>
								<textarea id="signa_import_json_box" rows="3" dir="ltr" placeholder='{"login_mode":"phone_and_email", ...}'></textarea>
								<button type="button" id="signa_import_settings_btn" class="signa-btn-secondary" style="margin-top:8px;">
									درون‌ریزی و جایگزینی تنظیمات
								</button>
							</div>
						</div>

						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div>
									<h2>نگهداری دیتابیس و بازنشانی</h2>
									<p>مدیریت طول عمر لاگ‌ها و بازگشت به تنظیمات کارخانه</p>
								</div>
							</div>
							<div class="signa-field">
								<label for="log_retention_days">مدت زمان نگهداری خودکار لاگ‌ها (روز)</label>
								<input type="number" name="signa[log_retention_days]" id="log_retention_days" value="<?php echo esc_attr( (string) $settings['log_retention_days'] ); ?>" min="1" max="365" />
							</div>
							<div class="signa-switch-row" style="margin-top:14px;">
								<div>
									<strong>پاکسازی کامل هنگام حذف افزونه</strong>
									<p>حذف جدول لاگ‌ها و تنظیمات از دیتابیس در صورت پاک کردن افزونه.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[delete_data_on_uninstall]" value="1" <?php checked( $settings['delete_data_on_uninstall'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>
							<div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(156,163,175,0.2);">
								<button type="button" id="signa_reset_defaults_btn" class="signa-btn-danger">
									بازنشانی تمام تنظیمات به حالت پیش‌فرض کارخانه
								</button>
							</div>
						</div>
					</div>
				</section>

			</main>
		</div>
	</form>
</div>
