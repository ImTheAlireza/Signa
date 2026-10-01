<?php
/**
 * Admin Settings Partial: tab-auth-flow.php
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
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
