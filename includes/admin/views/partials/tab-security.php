<?php
/**
 * Admin Settings Partial: tab-security.php
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
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

						<div class="signa-switch-row" style="margin-top:16px;">
							<div>
								<strong>اعتماد به هدرهای کلودفلر / پروکسی معکوس (Cloudflare / ArvanCloud Proxy IP)</strong>
								<p>در صورتی که سایت شما پشت Cloudflare یا ابرآروان است فعال کنید تا IP واقعی کاربر از هدر <code>CF-Connecting-IP</code> یا <code>X-Forwarded-For</code> خوانده شود. (در سرورهای مستقیم برای جلوگیری از جعل IP غیرفعال بگذارید).</p>
							</div>
							<label class="signa-switch">
								<input type="checkbox" name="signa[trust_proxy_headers]" value="1" <?php checked( ! empty( $settings['trust_proxy_headers'] ), true ); ?> />
								<span class="signa-slider"></span>
							</label>
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
									<option value="arcaptcha" <?php selected( $settings['captcha_type'], 'arcaptcha' ); ?>>آرکپچا - Arcaptcha.ir (کپچای بومی ایرانی)</option>
									<option value="math" <?php selected( $settings['captcha_type'], 'math' ); ?>>کپچای ریاضی هوشمند داخلی (بدون نیاز به کلید)</option>
									<option value="recaptcha_v3" <?php selected( $settings['captcha_type'], 'recaptcha_v3' ); ?>>Google reCAPTCHA v3</option>
									<option value="turnstile" <?php selected( $settings['captcha_type'], 'turnstile' ); ?>>Cloudflare Turnstile</option>
								</select>
							</div>
							<div class="signa-field">
								<label for="captcha_site_key">کلید سایت (Site Key - آرکپچا / گوگل / کلودفلر)</label>
								<input type="text" name="signa[captcha_site_key]" id="captcha_site_key" value="<?php echo esc_attr( $settings['captcha_site_key'] ); ?>" dir="ltr" />
							</div>
							<div class="signa-field">
								<label for="captcha_secret_key">کلید مخفی (Secret Key - آرکپچا / گوگل / کلودفلر)</label>
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
