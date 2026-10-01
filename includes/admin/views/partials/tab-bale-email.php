<?php
/**
 * Admin Settings Partial: tab-bale-email.php
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
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
