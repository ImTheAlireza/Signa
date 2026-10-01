<?php
/**
 * Admin Settings Partial: tab-dashboard.php (Vector Icons + Bento Grid)
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$active_backups = Signa_Gateway_Manager::get_backup_sms_gateways();
$backup_names   = array();
foreach ( $active_backups as $bgw ) {
	$backup_names[] = $bgw->get_id();
}
$captcha_labels = array(
	'none'         => 'غیرفعال',
	'arcaptcha'    => 'آرکپچا (Arcaptcha)',
	'math'         => 'کپچای ریاضی داخلی',
	'recaptcha_v3' => 'Google reCAPTCHA v3',
	'turnstile'    => 'Cloudflare Turnstile',
);
$active_captcha_label = isset( $captcha_labels[ $settings['captcha_type'] ] ) ? $captcha_labels[ $settings['captcha_type'] ] : 'غیرفعال';
?>
				<section class="signa-panel active" id="signa-tab-dashboard">
					<!-- Quick Configuration & Jump Bar -->
					<div class="signa-quick-setup-grid">
						<div class="signa-quick-item">
							<div class="signa-quick-head">
								<span class="signa-pill <?php echo 'sandbox' === $settings['active_sms_gateway'] ? 'is-warn' : 'is-ok'; ?>">
									<?php echo 'sandbox' === $settings['active_sms_gateway'] ? 'حالت تست (Sandbox)' : 'درگاه عملیاتی فعال'; ?>
								</span>
								<button type="button" class="signa-jump-tab" data-target-tab="sms_gateways">تنظیم درگاه &larr;</button>
							</div>
							<strong>سامانه پیامک: <?php echo esc_html( $active_gw_title ); ?></strong>
							<small><?php echo empty( $backup_names ) ? 'بدون درگاه پشتیبان (Failover)' : sprintf( '%d درگاه پشتیبان فعال (%s)', count( $backup_names ), implode( '، ', $backup_names ) ); ?></small>
						</div>

						<div class="signa-quick-item">
							<div class="signa-quick-head">
								<span class="signa-pill is-info">کانال ارسال</span>
								<button type="button" class="signa-jump-tab" data-target-tab="auth_flow">تغییر سناریو &larr;</button>
							</div>
							<strong>استراتژی: <?php echo esc_html( $settings['mobile_delivery_channel'] ); ?></strong>
							<small>ثبت‌نام خودکار: <?php echo ! empty( $settings['auto_register'] ) ? 'فعال' : 'غیرفعال'; ?> | کد <?php echo esc_html( (string) $settings['otp_length'] ); ?> رقمی</small>
						</div>

						<div class="signa-quick-item">
							<div class="signa-quick-head">
								<span class="signa-pill <?php echo 'none' === $settings['captcha_type'] ? 'is-muted' : 'is-ok'; ?>">
									<?php echo 'none' === $settings['captcha_type'] ? 'بدون کپچا' : 'محافظت فعال'; ?>
								</span>
								<button type="button" class="signa-jump-tab" data-target-tab="security_firewall">تنظیمات امنیت &larr;</button>
							</div>
							<strong>کپچا: <?php echo esc_html( $active_captcha_label ); ?></strong>
							<small>سقف مجاز: <?php echo esc_html( (string) $settings['max_requests_per_hour'] ); ?> بار در ساعت برای هر شماره</small>
						</div>

						<div class="signa-quick-item">
							<div class="signa-quick-head">
								<span class="signa-pill is-ok">المنتور و شورت‌کد</span>
								<button type="button" class="signa-jump-tab" data-target-tab="woocommerce">مشاهده ابزارها &larr;</button>
							</div>
							<strong>یکپارچگی قالب و صفحه‌ساز</strong>
							<small>۲ ویجت بومی المنتور + شورت‌کد + مودال سراسری</small>
						</div>
					</div>

					<!-- KPI Summary Cards with SVG Vector Icons -->
					<div class="signa-kpi-grid">
						<div class="signa-kpi-card">
							<div class="signa-kpi-icon is-blue">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
							</div>
							<div class="signa-kpi-info">
								<span>کل کدهای ارسال‌شده</span>
								<strong><?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?></strong>
								<small><?php echo esc_html( number_format_i18n( $stats['today'] ) ); ?> ارسال در امروز</small>
							</div>
						</div>

						<div class="signa-kpi-card">
							<div class="signa-kpi-icon is-green">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
							</div>
							<div class="signa-kpi-info">
								<span>ورودهای موفق (Verified)</span>
								<strong><?php echo esc_html( number_format_i18n( $stats['verified'] ) ); ?></strong>
								<small>نرخ تبدیل: %<?php echo esc_html( (string) $stats['conversion_rate'] ); ?></small>
							</div>
						</div>

						<div class="signa-kpi-card">
							<div class="signa-kpi-icon is-purple">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
							</div>
							<div class="signa-kpi-info">
								<span>کاربران ثبت‌نامی با OTP</span>
								<strong><?php echo esc_html( number_format_i18n( $stats['otp_users'] ) ); ?></strong>
								<small>ثبت‌نام خودکار یکپارچه</small>
							</div>
						</div>

						<div class="signa-kpi-card">
							<div class="signa-kpi-icon is-red">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
							</div>
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
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-blue">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
									</span>
									<div>
										<h2>نمودار ارسال کد در ۷ روز گذشته</h2>
										<p>مقایسه تعداد کل درخواست‌ها و ورودهای موفق روزانه</p>
									</div>
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
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-green">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
									</span>
									<div>
										<h2>وضعیت سلامت سیستم</h2>
										<p>پیش‌نیازها و یکپارچگی‌ها</p>
									</div>
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
									<span>ویجت‌های صفحه‌ساز المنتور</span>
									<span class="signa-pill <?php echo $elementor_active ? 'is-ok' : 'is-muted'; ?>"><?php echo $elementor_active ? 'فعال (۲ ویجت)' : 'المنتور نصب نیست'; ?></span>
								</li>
								<li>
									<span>درگاه‌های پیامک پشتیبان (Failover)</span>
									<span class="signa-pill <?php echo empty( $backup_names ) ? 'is-muted' : 'is-ok'; ?>">
										<?php echo empty( $backup_names ) ? 'غیرفعال' : esc_html( implode( ' ← ', $backup_names ) ); ?>
									</span>
								</li>
							</ul>
						</div>
					</div>

					<!-- Recent Logs Feed -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div class="signa-card-head-title">
								<span class="signa-card-icon is-purple">
									<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
								</span>
								<div>
									<h2>آخرین کدهای ارسال‌شده</h2>
									<p>۶ درخواست اخیر ثبت‌شده در سیستم (مفید برای مشاهده سریع کد در حالت تست)</p>
								</div>
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
