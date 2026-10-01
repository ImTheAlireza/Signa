<?php
/**
 * Admin Settings Partial: tab-auth-flow.php (Visual Flow Badges [SMS <- Bale], Human Copy & Progressive Disclosure)
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Reusable crisp SVG icons for flow combinations
$svg_phone = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>';
$svg_email = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>';
$svg_sms   = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8"/><path d="M8 13h5"/></svg>';
// Bale Messenger stylized chat+check logo
$svg_bale  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/><polyline points="9 11.5 11.2 13.8 15.5 9.5"/></svg>';
$svg_arrow = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>';
?>
				<section class="signa-panel" id="signa-tab-auth_flow">
					<!-- TOP BENTO ROW: Identifier Type (Col 5) + Mobile Delivery Strategy (Col 7) -->
					<div class="signa-bento-row">
						<!-- Top-Right Box (Col 5): 1. Login Identifier Mode -->
						<div class="signa-card signa-col-5">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-blue">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
									</span>
									<div>
										<h2>کاربران با چه چیزی وارد شوند؟</h2>
										<p>انتخاب ورودی مجاز در فرم ورود سایت</p>
									</div>
								</div>
							</div>

							<div class="signa-choice-grid signa-cols-1">
								<label class="signa-choice-card <?php echo 'phone_and_email' === $settings['login_mode'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[login_mode]" value="phone_and_email" <?php checked( $settings['login_mode'], 'phone_and_email' ); ?> />
									<div class="signa-flow-icons" title="شماره موبایل + آدرس ایمیل">
										<span class="signa-flow-node is-phone"><?php echo $svg_phone; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										<span class="signa-flow-sep">+</span>
										<span class="signa-flow-node is-email"><?php echo $svg_email; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>موبایل و ایمیل <span class="signa-choice-tag is-green">تشخیص هوشمند</span></strong>
										<small>کاربر هر کدام را تایپ کند، خودش تشخیص می‌دهد</small>
									</div>
									<span class="signa-choice-check">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
									</span>
								</label>

								<label class="signa-choice-card <?php echo 'phone_only' === $settings['login_mode'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[login_mode]" value="phone_only" <?php checked( $settings['login_mode'], 'phone_only' ); ?> />
									<div class="signa-flow-icons" title="فقط شماره موبایل">
										<span class="signa-flow-node is-phone"><?php echo $svg_phone; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>فقط شماره موبایل</strong>
										<small>مناسب فروشگاه‌ها و سایت‌های ایرانی</small>
									</div>
									<span class="signa-choice-check">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
									</span>
								</label>

								<label class="signa-choice-card <?php echo 'email_only' === $settings['login_mode'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[login_mode]" value="email_only" <?php checked( $settings['login_mode'], 'email_only' ); ?> />
									<div class="signa-flow-icons" title="فقط ایمیل">
										<span class="signa-flow-node is-email"><?php echo $svg_email; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>فقط آدرس ایمیل</strong>
										<small>ارسال کد تایید فقط به ایمیل کاربر</small>
									</div>
									<span class="signa-choice-check">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
									</span>
								</label>
							</div>
						</div>

						<!-- Top-Left Box (Col 7): 2. Mobile Delivery Strategy with Visual [Icon -> Icon] Flow -->
						<div class="signa-card signa-col-7">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-green">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
									</span>
									<div>
										<h2>کد تایید چطور به موبایل برسد؟</h2>
										<p>ترکیب هوشمند پیامک و پیام‌رسان بله برای کاهش هزینه و تضمین تحویل</p>
									</div>
								</div>
							</div>

							<div class="signa-choice-grid signa-cols-2">
								<!-- 1. SMS Only -->
								<label class="signa-choice-card <?php echo 'sms' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="sms" <?php checked( $settings['mobile_delivery_channel'], 'sms' ); ?> />
									<div class="signa-flow-icons" title="ارسال با پیامک">
										<span class="signa-flow-node is-sms"><?php echo $svg_sms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>فقط پیامک (SMS)</strong>
										<small>ارسال مستقیم از درگاه پیامک و پشتیبان‌ها</small>
									</div>
									<span class="signa-choice-check">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
									</span>
								</label>

								<!-- 2. Bale Only -->
								<label class="signa-choice-card <?php echo 'bale' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="bale" <?php checked( $settings['mobile_delivery_channel'], 'bale' ); ?> />
									<div class="signa-flow-icons" title="ارسال در بله">
										<span class="signa-flow-node is-bale"><?php echo $svg_bale; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>فقط پیام‌رسان بله</strong>
										<small>ارسال کد صرفاً در اپلیکیشن بله کاربر</small>
									</div>
									<span class="signa-choice-check">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
									</span>
								</label>

								<!-- 3. Bale -> Fallback SMS (Visual: [Bale] -> [SMS]) -->
								<label class="signa-choice-card <?php echo 'bale_fallback_sms' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="bale_fallback_sms" <?php checked( $settings['mobile_delivery_channel'], 'bale_fallback_sms' ); ?> />
									<div class="signa-flow-icons" title="اول بله، اگر نشد پیامک">
										<span class="signa-flow-node is-bale"><?php echo $svg_bale; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										<span class="signa-flow-sep"><?php echo $svg_arrow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										<span class="signa-flow-node is-sms"><?php echo $svg_sms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>اول بله ← بعد پیامک <span class="signa-choice-tag is-green">بهصرفه</span></strong>
										<small>اگر کاربر بله نداشت، خودکار پیامک می‌شود</small>
									</div>
									<span class="signa-choice-check">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
									</span>
								</label>

								<!-- 4. SMS -> Fallback Bale (Visual: [SMS] -> [Bale]) -->
								<label class="signa-choice-card <?php echo 'sms_fallback_bale' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="sms_fallback_bale" <?php checked( $settings['mobile_delivery_channel'], 'sms_fallback_bale' ); ?> />
									<div class="signa-flow-icons" title="اول پیامک، اگر نشد بله">
										<span class="signa-flow-node is-sms"><?php echo $svg_sms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										<span class="signa-flow-sep"><?php echo $svg_arrow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										<span class="signa-flow-node is-bale"><?php echo $svg_bale; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>اول پیامک ← بعد بله <span class="signa-choice-tag is-amber">ضد قطعی</span></strong>
										<small>اگر پیامک به خطا خورد، در بله ارسال می‌شود</small>
									</div>
									<span class="signa-choice-check">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
									</span>
								</label>

								<!-- 5. Simultaneous SMS + Bale (Visual: [SMS] + [Bale]) -->
								<label class="signa-choice-card signa-span-2 <?php echo 'both' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="both" <?php checked( $settings['mobile_delivery_channel'], 'both' ); ?> />
									<div class="signa-flow-icons" title="ارسال همزمان پیامک و بله">
										<span class="signa-flow-node is-sms"><?php echo $svg_sms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										<span class="signa-flow-sep">+</span>
										<span class="signa-flow-node is-bale"><?php echo $svg_bale; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>ارسال همزمان در هر دو کانال (پیامک + بله) <span class="signa-choice-tag is-purple">تحویل فوری</span></strong>
										<small>کد همزمان هم پیامک می‌شود و هم در بله می‌آید تا کاربر هر کدام را زودتر دید وارد کند</small>
									</div>
									<span class="signa-choice-check">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
									</span>
								</label>
							</div>
						</div>
					</div>

					<!-- BOTTOM BENTO ROW: Registration & Profile (Col 7) + Timing & Smart Redirects (Col 5) -->
					<div class="signa-bento-row" style="margin-top:20px;">
						<!-- Box 1: Registration & Profile Completion -->
						<div class="signa-card signa-col-7">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-purple">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
									</span>
									<div>
										<h2>عضویت خودکار و اطلاعات کاربران جدید</h2>
										<p>با کاربرانی که اولین بار وارد می‌شوند چطور برخورد شود؟</p>
									</div>
								</div>
							</div>

							<div class="signa-switch-row">
								<div class="signa-switch-text">
									<strong>ساخت خودکار حساب برای کاربران جدید</strong>
									<p>اگر شماره یا ایمیل کاربر قبلاً ثبت نشده بود، بلافاصله بعد از تایید کد عضو سایت شود.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[auto_register]" value="1" <?php checked( $settings['auto_register'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>

							<div class="signa-fields-grid signa-cols-2" style="margin-top:16px;">
								<div class="signa-field">
									<label for="require_name_on_register">پرسیدن «نام و نام خانوادگی» در اولین ورود</label>
									<select name="signa[require_name_on_register]" id="require_name_on_register">
										<option value="disabled" <?php selected( $settings['require_name_on_register'], 'disabled' ); ?>>نپرس (فقط کد تایید را بگیرد)</option>
										<option value="optional" <?php selected( $settings['require_name_on_register'], 'optional' ); ?>>اختیاری بپرس</option>
										<option value="required" <?php selected( $settings['require_name_on_register'], 'required' ); ?>>الزامی باشد</option>
									</select>
								</div>

								<div class="signa-field">
									<label for="require_email_on_register">پرسیدن «ایمیل» از کاربران موبایلی جدید</label>
									<select name="signa[require_email_on_register]" id="require_email_on_register">
										<option value="disabled" <?php selected( $settings['require_email_on_register'], 'disabled' ); ?>>نپرس (غیرفعال)</option>
										<option value="optional" <?php selected( $settings['require_email_on_register'], 'optional' ); ?>>اختیاری بپرس</option>
										<option value="required" <?php selected( $settings['require_email_on_register'], 'required' ); ?>>الزامی باشد</option>
									</select>
								</div>

								<div class="signa-field">
									<label for="default_user_role">نقش کاربر جدید در سایت</label>
									<select name="signa[default_user_role]" id="default_user_role">
										<option value="customer" <?php selected( $settings['default_user_role'], 'customer' ); ?>>مشتری فروشگاه (Customer)</option>
										<option value="subscriber" <?php selected( $settings['default_user_role'], 'subscriber' ); ?>>مشترک عادی (Subscriber)</option>
									</select>
								</div>

								<div class="signa-field">
									<label for="username_prefix">فرمت نام کاربری در وردپرس</label>
									<select name="signa[username_prefix]" id="username_prefix">
										<option value="" <?php selected( $settings['username_prefix'], '' ); ?>>خودِ شماره موبایل (0912... — سازگار با دیجیتز)</option>
										<option value="u_" <?php selected( $settings['username_prefix'], 'u_' ); ?>>با پیشوند u_ (مثلاً u_0912...)</option>
										<option value="user_" <?php selected( $settings['username_prefix'], 'user_' ); ?>>با پیشوند user_ (مثلاً user_0912...)</option>
									</select>
								</div>
							</div>

							<div class="signa-switch-row" style="margin-top:16px;">
								<div class="signa-switch-text">
									<strong>دکمه «ورود با رمز عبور» هم زیر فرم باشد</strong>
									<p>برای کاربرانی که ترجیح می‌دهند به جای کد پیامکی با رمز ثابت وارد شوند.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[allow_password_login]" value="1" <?php checked( $settings['allow_password_login'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>

							<div class="signa-switch-row" style="margin-top:10px;">
								<div class="signa-switch-text">
									<strong>نمایش جمله پذیرش قوانین سایت زیر فیلد موبایل</strong>
									<p>نمایش متن کوتاه قوانین و لینک صفحه مقررات در فرم ورود.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[show_terms_checkbox]" id="show_terms_checkbox" value="1" <?php checked( $settings['show_terms_checkbox'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>

							<div id="signa-terms-fields-wrap" class="signa-fields-grid signa-cols-2" style="margin-top:12px;<?php echo empty( $settings['show_terms_checkbox'] ) ? 'display:none;' : ''; ?>">
								<div class="signa-field">
									<label for="terms_text">متن جمله قوانین</label>
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
										<h2>تنظیمات کد و مسیر بازگشت</h2>
										<p>تعداد ارقام کد تایید و صفحه‌ای که کاربر پس از ورود می‌بیند</p>
									</div>
								</div>
							</div>

							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="otp_length">تعداد ارقام</label>
									<input type="number" name="signa[otp_length]" id="otp_length" value="<?php echo esc_attr( (string) $settings['otp_length'] ); ?>" min="4" max="8" />
								</div>
								<div class="signa-field">
									<label for="otp_expiry">اعتبار کد (ثانیه)</label>
									<input type="number" name="signa[otp_expiry]" id="otp_expiry" value="<?php echo esc_attr( (string) $settings['otp_expiry'] ); ?>" min="30" max="900" />
								</div>
								<div class="signa-field">
									<label for="resend_cooldown">تایمر ارسال مجدد</label>
									<input type="number" name="signa[resend_cooldown]" id="resend_cooldown" value="<?php echo esc_attr( (string) $settings['resend_cooldown'] ); ?>" min="15" max="600" />
								</div>
							</div>

							<hr style="border:none;border-top:1px dashed var(--s-border-input);margin:20px 0;" />

							<div class="signa-field">
								<label for="redirect_behavior">پس از ورود، کاربر به کجا منتقل شود؟</label>
								<select name="signa[redirect_behavior]" id="redirect_behavior">
									<option value="auto" <?php selected( $settings['redirect_behavior'], 'auto' ); ?>>هوشمند (پنل کاربری ووکامرس / صفحه اصلی)</option>
									<option value="referer" <?php selected( $settings['redirect_behavior'], 'referer' ); ?>>برگردد به همان صفحه‌ای که بود</option>
									<option value="custom" <?php selected( $settings['redirect_behavior'], 'custom' ); ?>>برود به یک لینک دلخواه مشخص</option>
								</select>
							</div>

							<div id="signa-custom-redirect-wrap" class="signa-field" style="margin-top:14px;<?php echo 'custom' !== $settings['redirect_behavior'] && empty( $settings['redirect_url'] ) ? 'display:none;' : ''; ?>">
								<label for="redirect_url">لینک مقصد کاربران بعد از ورود</label>
								<input type="url" name="signa[redirect_url]" id="redirect_url" value="<?php echo esc_attr( $settings['redirect_url'] ); ?>" dir="ltr" placeholder="https://example.com/my-account" />
							</div>

							<div class="signa-field" style="margin-top:14px;">
								<label for="admin_redirect_url">مقصد اختصاصی مدیران سایت (اختیاری)</label>
								<input type="url" name="signa[admin_redirect_url]" id="admin_redirect_url" value="<?php echo esc_attr( $settings['admin_redirect_url'] ); ?>" dir="ltr" placeholder="<?php echo esc_attr( admin_url() ); ?>" />
							</div>

							<div class="signa-info-note" style="margin-top:auto;">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.2" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
								<span>کاربران قدیمی <strong>دیجیتز (Digits)</strong> و <strong>ووکامرس</strong> به‌صورت خودکار شناسایی می‌شوند.</span>
							</div>
						</div>
					</div>
				</section>
