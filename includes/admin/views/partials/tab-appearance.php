<?php
/**
 * Admin Settings Partial: tab-appearance.php
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<section class="signa-panel" id="signa-tab-appearance_studio">
					<div class="signa-studio-layout">
						<!-- Studio Controls (Right Column) -->
						<div class="signa-studio-controls">
							<div class="signa-card">
								<div class="signa-card-head">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-purple">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
										</span>
										<div>
											<h2>پالت‌های رنگی و تم‌های آماده (Presets)</h2>
											<p>با یک کلیک استایل کلی فرم را تغییر دهید یا رنگ‌ها را سفارشی کنید</p>
										</div>
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
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-blue">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
										</span>
										<div>
											<h2>متن‌ها و برچسب‌های فرم</h2>
											<p>عنوان‌ها و متن دکمه‌ها را متناسب با لحن برند خود تغییر دهید</p>
										</div>
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
									<span style="display:inline-flex;align-items:center;gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> پیش‌نمایش زنده فرم</span>
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
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
													<path d="m9 12 2 2 4-4"></path>
												</svg>
											</div>
											<h3 id="signa-prev-title" style="margin:0 0 6px 0;font-size:18px;color:inherit;"><?php echo esc_html( $settings['form_title'] ); ?></h3>
											<p id="signa-prev-subtitle" style="margin:0;font-size:12.5px;opacity:0.75;"><?php echo esc_html( $settings['form_subtitle'] ); ?></p>
										</div>

										<!-- Preview Step 1 -->
										<div id="signa-prev-step-1">
											<label style="display:block;font-size:12.5px;font-weight:600;margin-bottom:6px;color:inherit;">شماره موبایل یا ایمیل</label>
											<input type="text" class="signa-prev-input" placeholder="شماره موبایل (0912...) یا ایمیل" dir="rtl" readonly />
											<button type="button" id="signa-prev-btn-1" style="width:100%;height:44px;border:none;border-radius:10px;background:<?php echo esc_attr( $settings['primary_color'] ); ?>;color:#fff;font-weight:700;font-size:14px;cursor:default;">
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
