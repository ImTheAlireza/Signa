<?php
/**
 * Admin Settings Partial: tab-auth-flow.php (Bento Side-by-Side Layout + Vector Icons)
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<section class="signa-panel" id="signa-tab-auth_flow">
					<!-- TOP CARD: Login Identifier Mode & Delivery Strategy with Vector Icons -->
					<div class="signa-card">
						<div class="signa-card-head">
							<div class="signa-card-head-title">
								<span class="signa-card-icon is-blue">
									<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
								</span>
								<div>
									<h2>روش شناسایی کاربر و استراتژی کانال ارسال کد</h2>
									<p>نحوه دریافت اطلاعات از کاربر و مسیردهی هوشمند ارسال کد تایید را مشخص کنید</p>
								</div>
							</div>
						</div>

						<label class="signa-section-label">۱. نوع شناسه قابل قبول در فیلد ورود</label>
						<div class="signa-choice-grid signa-cols-3">
							<label class="signa-choice-card <?php echo 'phone_and_email' === $settings['login_mode'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[login_mode]" value="phone_and_email" <?php checked( $settings['login_mode'], 'phone_and_email' ); ?> />
								<span class="signa-choice-icon-svg">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
								</span>
								<strong>موبایل و ایمیل (هوشمند)</strong>
								<small>تشخیص خودکار شماره موبایل یا آدرس ایمیل در یک فیلد واحد</small>
							</label>

							<label class="signa-choice-card <?php echo 'phone_only' === $settings['login_mode'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[login_mode]" value="phone_only" <?php checked( $settings['login_mode'], 'phone_only' ); ?> />
								<span class="signa-choice-icon-svg">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
								</span>
								<strong>فقط شماره موبایل</strong>
								<small>مختص سایت‌های ایرانی با احراز هویت پیامکی / بله</small>
							</label>

							<label class="signa-choice-card <?php echo 'email_only' === $settings['login_mode'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[login_mode]" value="email_only" <?php checked( $settings['login_mode'], 'email_only' ); ?> />
								<span class="signa-choice-icon-svg">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
								</span>
								<strong>فقط آدرس ایمیل</strong>
								<small>ارسال کد یکبارمصرف فقط از طریق ایمیل وردپرس</small>
							</label>
						</div>

						<label class="signa-section-label" style="margin-top:22px;">۲. استراتژی ارسال کد به شماره‌های موبایل</label>
						<div class="signa-choice-grid signa-cols-3">
							<label class="signa-choice-card <?php echo 'sms' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="sms" <?php checked( $settings['mobile_delivery_channel'], 'sms' ); ?> />
								<span class="signa-choice-icon-svg">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
								</span>
								<strong>فقط پیامک (SMS)</strong>
								<small>ارسال مستقیم از طریق درگاه پیامک فعال (و پشتیبان‌ها)</small>
							</label>

							<label class="signa-choice-card <?php echo 'bale_fallback_sms' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="bale_fallback_sms" <?php checked( $settings['mobile_delivery_channel'], 'bale_fallback_sms' ); ?> />
								<span class="signa-choice-icon-svg">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
								</span>
								<strong>هوشمند: اول بله ← سپس پیامک</strong>
								<small>کاهش شدید هزینه! اگر کاربر بله نداشت خودکار پیامک می‌شود</small>
							</label>

							<label class="signa-choice-card <?php echo 'sms_fallback_bale' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="sms_fallback_bale" <?php checked( $settings['mobile_delivery_channel'], 'sms_fallback_bale' ); ?> />
								<span class="signa-choice-icon-svg">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/></svg>
								</span>
								<strong>هوشمند: اول پیامک ← سپس بله</strong>
								<small>در صورت اختلال درگاه پیامک، از طریق بله ارسال می‌شود</small>
							</label>

							<label class="signa-choice-card <?php echo 'bale' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="bale" <?php checked( $settings['mobile_delivery_channel'], 'bale' ); ?> />
								<span class="signa-choice-icon-svg">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
								</span>
								<strong>فقط پیام‌رسان بله</strong>
								<small>ارسال صرفاً از طریق سرویس سفیر یا ربات بله</small>
							</label>

							<label class="signa-choice-card <?php echo 'both' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
								<input type="radio" name="signa[mobile_delivery_channel]" value="both" <?php checked( $settings['mobile_delivery_channel'], 'both' ); ?> />
								<span class="signa-choice-icon-svg">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
								</span>
								<strong>ارسال همزمان (پیامک + بله)</strong>
								<small>ارسال همزمان کد در هر دو کانال برای اطمینان حداکثری</small>
							</label>
						</div>
					</div>

					<!-- SIDE-BY-SIDE BENTO ROW: Registration & Profile (Col 7) + Timing & Smart Redirects (Col 5) -->
					<div class="signa-bento-row" style="margin-top:20px;">
						<!-- Box 1: Registration & Profile Completion -->
						<div class="signa-card signa-col-7">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-purple">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
									</span>
									<div>
										<h2>ثبت‌نام کاربران جدید و فیلدهای تکمیلی</h2>
										<p>مدیریت عضویت خودکار و اطلاعات دریافتی از کاربران بار اول</p>
									</div>
								</div>
							</div>

							<div class="signa-switch-row">
								<div class="signa-switch-text">
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
								<div class="signa-switch-text">
									<strong>امکان ورود با رمز عبور ثابت (Password Fallback)</strong>
									<p>نمایش دکمه «ورود با رمز عبور ثابت» زیر فرم برای کاربران دارای رمز.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[allow_password_login]" value="1" <?php checked( $settings['allow_password_login'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>

							<div class="signa-switch-row" style="margin-top:10px;">
								<div class="signa-switch-text">
									<strong>نمایش متن پذیرش قوانین و مقررات در فرم ورود</strong>
									<p>نمایش جمله پذیرش قوانین بالای دکمه دریافت کد.</p>
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

						<!-- Box 2: OTP Timing & Smart Redirects -->
						<div class="signa-card signa-col-5">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-cyan">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
									</span>
									<div>
										<h2>زمان‌بندی کد و ریدایرکت هوشمند</h2>
										<p>ارقام کد، تایمر انقضا و مقصد هدایت کاربران</p>
									</div>
								</div>
							</div>

							<div class="signa-fields-grid signa-cols-2">
								<div class="signa-field">
									<label for="otp_length">تعداد ارقام کد (۴ تا ۸)</label>
									<input type="number" name="signa[otp_length]" id="otp_length" value="<?php echo esc_attr( (string) $settings['otp_length'] ); ?>" min="4" max="8" />
								</div>
								<div class="signa-field">
									<label for="otp_expiry">انقضای کد (ثانیه)</label>
									<input type="number" name="signa[otp_expiry]" id="otp_expiry" value="<?php echo esc_attr( (string) $settings['otp_expiry'] ); ?>" min="30" max="900" />
								</div>
							</div>

							<div class="signa-field" style="margin-top:14px;">
								<label for="resend_cooldown">تایمر شمارش معکوس ارسال مجدد (ثانیه)</label>
								<input type="number" name="signa[resend_cooldown]" id="resend_cooldown" value="<?php echo esc_attr( (string) $settings['resend_cooldown'] ); ?>" min="15" max="600" />
							</div>

							<hr style="border:none;border-top:1px dashed var(--s-border-input);margin:20px 0;" />

							<div class="signa-field">
								<label for="redirect_behavior">رفتار پیش‌فرض ریدایرکت پس از ورود</label>
								<select name="signa[redirect_behavior]" id="redirect_behavior">
									<option value="auto" <?php selected( $settings['redirect_behavior'], 'auto' ); ?>>خودکار (حساب کاربری ووکامرس / صفحه اصلی)</option>
									<option value="referer" <?php selected( $settings['redirect_behavior'], 'referer' ); ?>>بازگشت به صفحه قبلی کاربر (Referer)</option>
									<option value="custom" <?php selected( $settings['redirect_behavior'], 'custom' ); ?>>هدایت به آدرس سفارشی زیر</option>
								</select>
							</div>

							<div class="signa-field" style="margin-top:14px;">
								<label for="redirect_url">آدرس ریدایرکت سفارشی کاربران</label>
								<input type="url" name="signa[redirect_url]" id="redirect_url" value="<?php echo esc_attr( $settings['redirect_url'] ); ?>" dir="ltr" placeholder="https://example.com/my-account" />
							</div>

							<div class="signa-field" style="margin-top:14px;">
								<label for="admin_redirect_url">آدرس ریدایرکت ویژه مدیران (Admins)</label>
								<input type="url" name="signa[admin_redirect_url]" id="admin_redirect_url" value="<?php echo esc_attr( $settings['admin_redirect_url'] ); ?>" dir="ltr" placeholder="<?php echo esc_attr( admin_url() ); ?>" />
							</div>
						</div>
					</div>
				</section>
