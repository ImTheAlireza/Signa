<?php
/**
 * Admin Settings Partial: tab-auth-flow.php (v2.5.0 Creative Visual Flow Badges, Human Copy & Progressive Disclosure)
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Crisp SVG Icons & Official Bale Messenger Emblem
$svg_phone = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>';
$svg_email = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>';
$svg_sms   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8"/><path d="M8 13h5"/></svg>';
// Recognizable Bale Messenger Logo (Speech Bubble + Signature Check Wing)
$svg_bale  = '<svg viewBox="0 0 24 24" fill="none"><path d="M12 3C6.8 3 2.8 6.6 2.8 11.2c0 2.3 1 4.4 2.7 5.9-.2 1.2-.9 2.7-1.5 3.5-.2.3 0 .6.4.6 1.7-.1 3.6-.8 4.8-1.5.9.2 1.8.4 2.8.4 5.2 0 9.2-3.6 9.2-8.2S17.2 3 12 3z" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M8.5 11.6L11.1 14.2L16.5 8.6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$svg_arrow = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>';
$svg_check = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
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
										<h2>۱. کاربران با چه چیزی وارد شوند؟</h2>
										<p>انتخاب ورودی فرم ورود و عضویت</p>
									</div>
								</div>
							</div>

							<div class="signa-choice-grid signa-cols-1">
								<label class="signa-choice-card <?php echo 'phone_and_email' === $settings['login_mode'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[login_mode]" value="phone_and_email" <?php checked( $settings['login_mode'], 'phone_and_email' ); ?> />
									<div class="signa-choice-card-top">
										<div class="signa-flow-icons" title="شماره موبایل یا ایمیل">
											<span class="signa-flow-node is-phone"><?php echo $svg_phone; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>موبایل</span></span>
											<span class="signa-flow-sep">+</span>
											<span class="signa-flow-node is-email"><?php echo $svg_email; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>ایمیل</span></span>
										</div>
										<div class="signa-choice-top-left">
											<span class="signa-choice-tag is-green">تشخیص خودکار</span>
											<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									</div>
									<div class="signa-choice-body">
										<strong>موبایل یا ایمیل (هر دو)</strong>
										<small>کاربر هر کدام را بنویسد، سیستم خودش تشخیص می‌دهد</small>
									</div>
								</label>

								<label class="signa-choice-card <?php echo 'phone_only' === $settings['login_mode'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[login_mode]" value="phone_only" <?php checked( $settings['login_mode'], 'phone_only' ); ?> />
									<div class="signa-choice-card-top">
										<div class="signa-flow-icons" title="فقط شماره موبایل">
											<span class="signa-flow-node is-phone"><?php echo $svg_phone; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>شماره موبایل</span></span>
										</div>
										<div class="signa-choice-top-left">
											<span class="signa-choice-tag is-blue">محبوب فروشگاهی</span>
											<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									</div>
									<div class="signa-choice-body">
										<strong>فقط شماره موبایل</strong>
										<small>بهترین گزینه برای فروشگاه‌ها و سایت‌های ایرانی</small>
									</div>
								</label>

								<label class="signa-choice-card <?php echo 'email_only' === $settings['login_mode'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[login_mode]" value="email_only" <?php checked( $settings['login_mode'], 'email_only' ); ?> />
									<div class="signa-choice-card-top">
										<div class="signa-flow-icons" title="فقط آدرس ایمیل">
											<span class="signa-flow-node is-email"><?php echo $svg_email; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>آدرس ایمیل</span></span>
										</div>
										<div class="signa-choice-top-left">
											<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									</div>
									<div class="signa-choice-body">
										<strong>فقط آدرس ایمیل</strong>
										<small>کد تایید فقط به ایمیل کاربر فرستاده می‌شود</small>
									</div>
								</label>
							</div>
						</div>

						<!-- Top-Left Box (Col 7): 2. Mobile Delivery Strategy with Visual [SMS Icon <- Bale Logo] -->
						<div class="signa-card signa-col-7" id="signa-mobile-strategy-card" style="<?php echo 'email_only' === $settings['login_mode'] ? 'opacity:0.55;' : ''; ?>">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-green">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
									</span>
									<div>
										<h2>۲. کد تایید چطور به موبایل برسد؟</h2>
										<p>ترکیب پیامک و پیام‌رسان بله برای کاهش هزینه و جلوگیری از قطعی</p>
									</div>
								</div>
							</div>

							<div class="signa-choice-grid signa-cols-2">
								<!-- 1. SMS -> Fallback Bale (Visual: [SMS Icon] <- [Bale Logo]) -->
								<label class="signa-choice-card <?php echo 'sms_fallback_bale' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="sms_fallback_bale" <?php checked( $settings['mobile_delivery_channel'], 'sms_fallback_bale' ); ?> />
									<div class="signa-choice-card-top">
										<div class="signa-flow-icons" title="اول پیامک، بعد پیام‌رسان بله">
											<span class="signa-flow-node is-sms-brand"><?php echo $svg_sms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>پیامک</span></span>
											<span class="signa-flow-sep"><?php echo $svg_arrow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											<span class="signa-flow-node is-bale-brand"><?php echo $svg_bale; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>بله</span></span>
										</div>
										<div class="signa-choice-top-left">
											<span class="signa-choice-tag is-amber">ضد قطعی</span>
											<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									</div>
									<div class="signa-choice-body">
										<strong>اول پیامک، بعد بله</strong>
										<small>اگر پیامک به خطا خورد، خودکار در بله می‌فرستد</small>
									</div>
								</label>

								<!-- 2. Bale -> Fallback SMS (Visual: [Bale Logo] <- [SMS Icon]) -->
								<label class="signa-choice-card <?php echo 'bale_fallback_sms' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="bale_fallback_sms" <?php checked( $settings['mobile_delivery_channel'], 'bale_fallback_sms' ); ?> />
									<div class="signa-choice-card-top">
										<div class="signa-flow-icons" title="اول پیام‌رسان بله، بعد پیامک">
											<span class="signa-flow-node is-bale-brand"><?php echo $svg_bale; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>بله</span></span>
											<span class="signa-flow-sep"><?php echo $svg_arrow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											<span class="signa-flow-node is-sms-brand"><?php echo $svg_sms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>پیامک</span></span>
										</div>
										<div class="signa-choice-top-left">
											<span class="signa-choice-tag is-green">کاهش هزینه</span>
											<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									</div>
									<div class="signa-choice-body">
										<strong>اول بله، بعد پیامک</strong>
										<small>اگر کاربر بله نداشت، فوری پیامک می‌شود</small>
									</div>
								</label>

								<!-- 3. SMS Only -->
								<label class="signa-choice-card <?php echo 'sms' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="sms" <?php checked( $settings['mobile_delivery_channel'], 'sms' ); ?> />
									<div class="signa-choice-card-top">
										<div class="signa-flow-icons" title="فقط پیامک">
											<span class="signa-flow-node is-sms-brand"><?php echo $svg_sms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>پیامک</span></span>
										</div>
										<div class="signa-choice-top-left">
											<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									</div>
									<div class="signa-choice-body">
										<strong>فقط پیامک</strong>
										<small>ارسال مستقیم از پنل پیامک و پشتیبان‌ها</small>
									</div>
								</label>

								<!-- 4. Bale Only -->
								<label class="signa-choice-card <?php echo 'bale' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="bale" <?php checked( $settings['mobile_delivery_channel'], 'bale' ); ?> />
									<div class="signa-choice-card-top">
										<div class="signa-flow-icons" title="فقط پیام‌رسان بله">
											<span class="signa-flow-node is-bale-brand"><?php echo $svg_bale; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>پیام‌رسان بله</span></span>
										</div>
										<div class="signa-choice-top-left">
											<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									</div>
									<div class="signa-choice-body">
										<strong>فقط پیام‌رسان بله</strong>
										<small>ارسال کد فقط به حساب کاربری بله</small>
									</div>
								</label>

								<!-- 5. Simultaneous SMS + Bale (Full Width Span 2) -->
								<label class="signa-choice-card signa-span-2 <?php echo 'both' === $settings['mobile_delivery_channel'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[mobile_delivery_channel]" value="both" <?php checked( $settings['mobile_delivery_channel'], 'both' ); ?> />
									<div class="signa-choice-card-top">
										<div class="signa-flow-icons" title="ارسال همزمان در پیامک و بله">
											<span class="signa-flow-node is-sms-brand"><?php echo $svg_sms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>پیامک</span></span>
											<span class="signa-flow-sep">+</span>
											<span class="signa-flow-node is-bale-brand"><?php echo $svg_bale; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>پیام‌رسان بله</span></span>
										</div>
										<div class="signa-choice-top-left">
											<span class="signa-choice-tag is-purple">تحویل فوری در هر دو</span>
											<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
									</div>
									<div class="signa-choice-body">
										<strong>پیامک و بله به صورت همزمان</strong>
										<small>کد تایید در یک لحظه هم پیامک می‌شود و هم در پیام‌رسان بله ارسال می‌گردد تا کاربر هر کدام را زودتر دید وارد شود</small>
									</div>
								</label>
							</div>
						</div>
					</div>

					<!-- BOTTOM BENTO ROW: OTP Code Timing & Registration (Col 6) + Redirect & Password Options (Col 6) -->
					<div class="signa-bento-row" style="margin-top:20px;">
						<!-- Left Box: Code Settings & New User Signup -->
						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-purple">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
									</span>
									<div>
										<h2>تنظیمات کد و عضویت کاربران جدید</h2>
										<p>تعداد ارقام کد، زمان اعتبار و اطلاعات دریافتی هنگام ثبت‌نام</p>
									</div>
								</div>
							</div>

							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="otp_length">تعداد ارقام کد</label>
									<select name="signa[otp_length]" id="otp_length">
										<?php for ( $i = 4; $i <= 6; $i++ ) : ?>
											<option value="<?php echo esc_attr( (string) $i ); ?>" <?php selected( $settings['otp_length'], $i ); ?>>
												<?php echo esc_html( (string) $i ); ?> رقمی <?php echo 5 === $i ? '(پیشنهادی)' : ''; ?>
											</option>
										<?php endfor; ?>
									</select>
								</div>

								<div class="signa-field">
									<label for="otp_expiry">اعتبار کد (ثانیه)</label>
									<input type="number" name="signa[otp_expiry]" id="otp_expiry" value="<?php echo esc_attr( (string) $settings['otp_expiry'] ); ?>" min="30" max="600" />
								</div>

								<div class="signa-field">
									<label for="resend_cooldown">فاصله ارسال مجدد (ثانیه)</label>
									<input type="number" name="signa[resend_cooldown]" id="resend_cooldown" value="<?php echo esc_attr( (string) $settings['resend_cooldown'] ); ?>" min="20" max="300" />
								</div>
							</div>

							<div class="signa-switch-row" style="margin-top:16px;">
								<div class="signa-switch-text">
									<strong>عضویت خودکار کاربران جدید</strong>
									<p>اگر شماره یا ایمیل کاربر در سایت نبود، همان لحظه حسابش ساخته شود.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[auto_register]" id="auto_register" value="1" <?php checked( $settings['auto_register'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>

							<div id="signa-auto-register-fields" style="margin-top:16px; <?php echo empty( $settings['auto_register'] ) ? 'display:none;' : ''; ?>">
								<div class="signa-fields-grid signa-cols-3">
									<div class="signa-field">
										<label for="default_user_role">نقش کاربر جدید</label>
										<select name="signa[default_user_role]" id="default_user_role">
											<option value="customer" <?php selected( $settings['default_user_role'], 'customer' ); ?>>مشتری ووکامرس</option>
											<option value="subscriber" <?php selected( $settings['default_user_role'], 'subscriber' ); ?>>مشترک وردپرس</option>
										</select>
									</div>

									<div class="signa-field">
										<label for="require_name_on_register">دریافت نام در ثبت‌نام</label>
										<select name="signa[require_name_on_register]" id="require_name_on_register">
											<option value="disabled" <?php selected( $settings['require_name_on_register'], 'disabled' ); ?>>نپرس (سریع‌ترین ورود)</option>
											<option value="optional" <?php selected( $settings['require_name_on_register'], 'optional' ); ?>>اختیاری بپرس</option>
											<option value="required" <?php selected( $settings['require_name_on_register'], 'required' ); ?>>اجباری باشد</option>
										</select>
									</div>

									<div class="signa-field">
										<label for="require_email_on_register">دریافت ایمیل از کاربر موبایل</label>
										<select name="signa[require_email_on_register]" id="require_email_on_register">
											<option value="disabled" <?php selected( $settings['require_email_on_register'], 'disabled' ); ?>>نپرس</option>
											<option value="optional" <?php selected( $settings['require_email_on_register'], 'optional' ); ?>>اختیاری بپرس</option>
											<option value="required" <?php selected( $settings['require_email_on_register'], 'required' ); ?>>اجباری باشد</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<!-- Right Box: Redirect Cards, Password Option & Terms -->
						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-amber">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
									</span>
									<div>
										<h2>پس از ورود، کاربر به کجا برود؟</h2>
										<p>مسیر انتقال کاربر بعد از ورود و گزینه‌های کمکی فرم</p>
									</div>
								</div>
							</div>

							<!-- Visual Redirect Behavior Cards instead of a dry select -->
							<div class="signa-choice-grid signa-cols-2">
								<label class="signa-choice-card <?php echo 'auto' === $settings['redirect_behavior'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[redirect_behavior]" value="auto" <?php checked( $settings['redirect_behavior'], 'auto' ); ?> />
									<div class="signa-choice-card-top">
										<span class="signa-flow-node is-phone">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
											<span>هوشمند</span>
										</span>
										<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>همان صفحه فعلی</strong>
										<small>برگشت به صفحه‌ای که کاربر در آن بود</small>
									</div>
								</label>

								<label class="signa-choice-card <?php echo 'my_account' === $settings['redirect_behavior'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[redirect_behavior]" value="my_account" <?php checked( $settings['redirect_behavior'], 'my_account' ); ?> />
									<div class="signa-choice-card-top">
										<span class="signa-flow-node is-sms">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
											<span>پنل کاربری</span>
										</span>
										<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>حساب کاربری من</strong>
										<small>انتقال به پنل کاربری ووکامرس یا وردپرس</small>
									</div>
								</label>

								<label class="signa-choice-card <?php echo 'home' === $settings['redirect_behavior'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[redirect_behavior]" value="home" <?php checked( $settings['redirect_behavior'], 'home' ); ?> />
									<div class="signa-choice-card-top">
										<span class="signa-flow-node is-bale">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
											<span>صفحه اول</span>
										</span>
										<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>صفحه اصلی سایت</strong>
										<small>انتقال به صفحه اول وب‌سایت</small>
									</div>
								</label>

								<label class="signa-choice-card <?php echo 'custom' === $settings['redirect_behavior'] ? 'selected' : ''; ?>">
									<input type="radio" name="signa[redirect_behavior]" value="custom" <?php checked( $settings['redirect_behavior'], 'custom' ); ?> />
									<div class="signa-choice-card-top">
										<span class="signa-flow-node is-email">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
											<span>لینک دلخواه</span>
										</span>
										<span class="signa-choice-check"><?php echo $svg_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>
									<div class="signa-choice-body">
										<strong>آدرس دلخواه شما</strong>
										<small>انتقال به یک لینک مشخص (مثلاً داشبورد)</small>
									</div>
								</label>
							</div>

							<!-- Progressive disclosure: only show Custom Redirect URL when 'custom' is selected -->
							<div class="signa-field" id="signa-custom-redirect-wrap" style="margin-top:14px; <?php echo 'custom' === $settings['redirect_behavior'] ? '' : 'display:none;'; ?>">
								<label for="custom_redirect_url">آدرس لینک مقصد دلخواه</label>
								<input type="url" name="signa[custom_redirect_url]" id="custom_redirect_url" value="<?php echo esc_attr( $settings['custom_redirect_url'] ); ?>" dir="ltr" placeholder="https://yoursite.com/dashboard" />
							</div>

							<div style="display:flex;flex-direction:column;gap:12px;margin-top:16px;">
								<div class="signa-switch-row">
									<div class="signa-switch-text">
										<strong>امکان ورود با رمز عبور ثابت</strong>
										<p>زیر دکمه دریافت کد، لینک «ورود با رمز عبور» هم نمایش داده شود.</p>
									</div>
									<label class="signa-switch">
										<input type="checkbox" name="signa[allow_password_login]" value="1" <?php checked( $settings['allow_password_login'], 1 ); ?> />
										<span class="signa-slider"></span>
									</label>
								</div>

								<div class="signa-switch-row">
									<div class="signa-switch-text">
										<strong>نمایش جمله پذیرش قوانین سایت</strong>
										<p>نمایش متن قوانین و مقررات در پایین فرم ورود.</p>
									</div>
									<label class="signa-switch">
										<input type="checkbox" name="signa[show_terms_checkbox]" id="show_terms_checkbox" value="1" <?php checked( $settings['show_terms_checkbox'], 1 ); ?> />
										<span class="signa-slider"></span>
									</label>
								</div>
							</div>

							<!-- Progressive disclosure: only show Terms fields when switch is enabled -->
							<div class="signa-fields-grid signa-cols-2" id="signa-terms-fields-wrap" style="margin-top:14px; <?php echo ! empty( $settings['show_terms_checkbox'] ) ? '' : 'display:none;'; ?>">
								<div class="signa-field">
									<label for="terms_text">متن پذیرش قوانین</label>
									<input type="text" name="signa[terms_text]" id="terms_text" value="<?php echo esc_attr( $settings['terms_text'] ); ?>" />
								</div>
								<div class="signa-field">
									<label for="terms_url">لینک برگه قوانین (اختیاری)</label>
									<input type="url" name="signa[terms_url]" id="terms_url" value="<?php echo esc_attr( $settings['terms_url'] ); ?>" dir="ltr" placeholder="https://example.com/terms" />
								</div>
							</div>
						</div>
					</div>
				</section>
