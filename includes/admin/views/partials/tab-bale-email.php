<?php
/**
 * Admin Settings Partial: tab-bale-email.php (Side-by-Side Bento Grid + Vector Icons)
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<section class="signa-panel" id="signa-tab-bale_email">
					<div class="signa-bento-row">
						<!-- Box 1: Bale Messenger (Safir OTP + Bot API) -->
						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-green">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/><polyline points="9 11 12 14 16 10"/></svg>
									</span>
									<div>
										<h2>درگاه پیام‌رسان بله (Bale OTP)</h2>
										<p>اتصال به وب‌سرویس رسمی «سفیر بله» یا بازوی ربات بله</p>
									</div>
								</div>
								<span class="signa-pill is-ok">تعرفه اقتصادی</span>
							</div>

							<div class="signa-field">
								<label for="bale_mode">حالت اتصال به پیام‌رسان بله</label>
								<select name="signa[bale_mode]" id="bale_mode">
									<option value="safir" <?php selected( $settings['bale_mode'], 'safir' ); ?>>وب‌سرویس رسمی سفیر بله (Safir OTP API — ارسال به شماره موبایل)</option>
									<option value="bot" <?php selected( $settings['bale_mode'], 'bot' ); ?>>ربات بله (Bale Bot API — ارسال با Chat ID)</option>
								</select>
							</div>

							<div class="signa-fields-grid signa-cols-2" style="margin-top:14px;">
								<div class="signa-field">
									<label for="bale_client_id">شناسه کاربری سفیر (Client ID)</label>
									<input type="text" name="signa[bale_client_id]" id="bale_client_id" value="<?php echo esc_attr( $settings['bale_client_id'] ); ?>" dir="ltr" placeholder="Client ID" />
								</div>
								<div class="signa-field">
									<label for="bale_client_secret">رمز عبور سفیر (Client Secret)</label>
									<input type="password" name="signa[bale_client_secret]" id="bale_client_secret" value="<?php echo esc_attr( $settings['bale_client_secret'] ); ?>" dir="ltr" placeholder="Client Secret" />
								</div>
							</div>

							<div class="signa-field" style="margin-top:14px;">
								<label for="bale_bot_token">توکن ربات بله (در حالت Bot API)</label>
								<input type="text" name="signa[bale_bot_token]" id="bale_bot_token" value="<?php echo esc_attr( $settings['bale_bot_token'] ); ?>" dir="ltr" placeholder="123456789:ABCDEF..." />
							</div>

							<div class="signa-field" style="margin-top:14px;">
								<label for="bale_message_template">قالب پیام ربات بله (متغیرها: <code>{code}</code>، <code>{site_name}</code>، <code>{expiry}</code>)</label>
								<textarea name="signa[bale_message_template]" id="bale_message_template" rows="3"><?php echo esc_textarea( $settings['bale_message_template'] ); ?></textarea>
							</div>
						</div>

						<!-- Box 2: Email OTP Configuration -->
						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-blue">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
									</span>
									<div>
										<h2>پیکربندی ایمیل (Email OTP)</h2>
										<p>تنظیمات قالب HTML ریسپانسیو ایمیل‌های کد تایید</p>
									</div>
								</div>
								<span class="signa-pill is-info">wp_mail</span>
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

							<div class="signa-info-note">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
								<span>قالب گرافیکی ایمیل به صورت خودکار رنگ برند انتخابی شما در «استودیو طراحی ظاهر» را به خود می‌گیرد.</span>
							</div>
						</div>
					</div>
				</section>
