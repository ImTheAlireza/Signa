<?php
/**
 * Admin Settings Partial: tab-appearance.php
 * Includes Category 1: Split-Screen Layout, Slide-Over Drawer Modal, Standalone Full-Page Canvas & Card Alignment
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form_layout    = isset( $settings['form_layout'] ) ? $settings['form_layout'] : 'card';
$card_position  = isset( $settings['card_position'] ) ? $settings['card_position'] : 'center';
$modal_style    = isset( $settings['modal_style'] ) ? $settings['modal_style'] : 'center';
$canvas_bg      = isset( $settings['canvas_bg_style'] ) ? $settings['canvas_bg_style'] : 'mesh_light';
$button_bg_mode = isset( $settings['button_bg_mode'] ) ? $settings['button_bg_mode'] : 'solid';
$card_shadow    = isset( $settings['card_shadow'] ) ? $settings['card_shadow'] : 'medium';
$card_border    = isset( $settings['card_border_style'] ) ? $settings['card_border_style'] : 'subtle';
$bg_pattern     = isset( $settings['bg_pattern'] ) ? $settings['bg_pattern'] : 'none';
$font_family    = isset( $settings['font_family'] ) ? $settings['font_family'] : 'vazirmatn';
$input_style    = isset( $settings['input_style'] ) ? $settings['input_style'] : 'filled';
$input_addon    = isset( $settings['input_addon_style'] ) ? $settings['input_addon_style'] : 'icon';
$is_split       = in_array( $form_layout, array( 'split_right', 'split_left' ), true );
$wp_pages       = get_pages( array( 'post_status' => 'publish' ) );
$svg_check_mark = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';

$split_features_raw  = isset( $settings['split_features'] ) ? $settings['split_features'] : '';
$split_features_list = array_filter( array_map( 'trim', explode( "\n", (string) $split_features_raw ) ) );
?>
				<section class="signa-panel" id="signa-tab-appearance_studio">
					<div class="signa-studio-layout">
						<!-- Studio Controls (Right Column) -->
						<div class="signa-studio-controls">

							<!-- CARD 1: Layout Skeleton (Single Card vs Split-Screen) & Card Position -->
							<div class="signa-card signa-accordion-card" style="margin-bottom:16px;">
								<div class="signa-card-head signa-accordion-trigger">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-blue">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/></svg>
										</span>
										<div>
											<h2>۱. چیدمان و اسکلت صفحه ورود (Layout &amp; Alignment)</h2>
											<p>انتخاب حالت کارت تکی یا لی‌اوت دوتایی (Split-Screen) به همراه موقعیت قرارگیری در صفحه</p>
										</div>
									</div>
									<div style="display:flex;align-items:center;gap:10px;">
										<span class="signa-pill is-info">پیش‌نمایش زنده</span>
										<span class="signa-accordion-chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></span>
									</div>
								</div>
								<div class="signa-accordion-body" style="display:none;">

								<label class="signa-section-label">الف) اسکلت و ساختار فرم ورود</label>
								<div class="signa-choice-grid signa-cols-3">
									<!-- 1. Classic Single Card -->
									<label class="signa-choice-card <?php echo 'card' === $form_layout ? 'selected' : ''; ?>">
										<input type="radio" name="signa[form_layout]" value="card" <?php checked( $form_layout, 'card' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش</span>
											<div class="signa-mv-card">
												<span class="signa-mv-line"></span>
												<span class="signa-mv-input"></span>
												<span class="signa-mv-btn"></span>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<div class="signa-flow-icons" title="کارت تکی کلاسیک">
												<span class="signa-flow-node is-phone">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="6" y="3" width="12" height="18" rx="2"/><line x1="9" y1="9" x2="15" y2="9"/><line x1="9" y1="13" x2="15" y2="13"/></svg>
												</span>
											</div>
											<div class="signa-choice-top-left">
												<span class="signa-choice-tag is-blue">مینیمال</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
										</div>
										<div class="signa-choice-body">
											<strong>کارت تکی کلاسیک</strong>
											<small>نمایش فرم ورود در یک کارت مستقل و جمع‌وجور</small>
										</div>
									</label>

									<!-- 2. Split-Screen: Form Right + Banner Left -->
									<label class="signa-choice-card <?php echo 'split_right' === $form_layout ? 'selected' : ''; ?>">
										<input type="radio" name="signa[form_layout]" value="split_right" <?php checked( $form_layout, 'split_right' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش</span>
											<div class="signa-mv-split">
												<div class="signa-mv-card">
													<span class="signa-mv-line"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
												<div class="signa-mv-banner">
													<span style="width:85%;"></span>
													<span style="width:65%;opacity:0.65;"></span>
													<span style="width:75%;background:#6ee7b7;"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<div class="signa-flow-icons" title="فرم راست + بنر چپ">
												<span class="signa-flow-node is-sms">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/><path d="M15 9h3"/><path d="M15 13h3"/><circle cx="7.5" cy="12" r="2"/></svg>
												</span>
											</div>
											<div class="signa-choice-top-left">
												<span class="signa-choice-tag is-green">محبوب فروشگاهی</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
										</div>
										<div class="signa-choice-body">
											<strong>دوتایی (فرم راست + بنر چپ)</strong>
											<small>فرم در سمت راست و بنر تصویری/برند در سمت چپ</small>
										</div>
									</label>

									<!-- 3. Split-Screen: Form Left + Banner Right -->
									<label class="signa-choice-card <?php echo 'split_left' === $form_layout ? 'selected' : ''; ?>">
										<input type="radio" name="signa[form_layout]" value="split_left" <?php checked( $form_layout, 'split_left' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش</span>
											<div class="signa-mv-split is-reverse">
												<div class="signa-mv-card">
													<span class="signa-mv-line"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
												<div class="signa-mv-banner">
													<span style="width:85%;"></span>
													<span style="width:65%;opacity:0.65;"></span>
													<span style="width:75%;background:#6ee7b7;"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<div class="signa-flow-icons" title="فرم چپ + بنر راست">
												<span class="signa-flow-node is-passkey">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/><path d="M6 9h3"/><path d="M6 13h3"/><circle cx="16.5" cy="12" r="2"/></svg>
												</span>
											</div>
											<div class="signa-choice-top-left">
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
										</div>
										<div class="signa-choice-body">
											<strong>دوتایی (فرم چپ + بنر راست)</strong>
											<small>بنر معرفی برند در سمت راست و فرم در سمت چپ</small>
										</div>
									</label>
								</div>

								<!-- Progressive Disclosure: Split-Screen Side Banner Configuration -->
								<div id="signa-split-banner-settings" style="margin-top:18px;padding:18px;border-radius:14px;background:var(--s-bg-subtle);border:1px solid var(--s-border-input);<?php echo $is_split ? '' : 'display:none;'; ?>">
									<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
										<strong style="font-size:13.5px;color:var(--s-text);">تنظیمات بنر کناری (Split-Screen Side Panel)</strong>
										<span class="signa-pill is-info">نمایش در دسکتاپ و تبلت</span>
									</div>

									<div class="signa-fields-grid signa-cols-2">
										<div class="signa-field">
											<label for="split_bg_color">رنگ پایه پس‌زمینه بنر کناری</label>
											<div class="signa-color-input-wrap">
												<input type="color" name="signa[split_bg_color]" id="split_bg_color" value="<?php echo esc_attr( $settings['split_bg_color'] ); ?>" />
												<span id="split_bg_color_hex"><?php echo esc_html( $settings['split_bg_color'] ); ?></span>
											</div>
										</div>
										<div class="signa-field">
											<label for="split_badge_text">متن بج بالای بنر (اختیاری)</label>
											<input type="text" name="signa[split_badge_text]" id="split_badge_text" value="<?php echo esc_attr( $settings['split_badge_text'] ); ?>" placeholder="احراز هویت سریع و امن" />
										</div>
									</div>

									<div class="signa-field" style="margin-top:12px;">
										<label for="split_image_url">تصویر کاور یا پس‌زمینه بنر کناری (اختیاری)</label>
										<div style="display:flex;gap:8px;">
											<input type="text" name="signa[split_image_url]" id="split_image_url" value="<?php echo esc_attr( $settings['split_image_url'] ); ?>" dir="ltr" placeholder="https://example.com/banner.jpg" style="flex:1;" />
											<button type="button" id="signa_upload_split_img_btn" class="signa-btn-secondary">انتخاب تصویر</button>
										</div>
									</div>

									<div class="signa-fields-grid signa-cols-2" style="margin-top:12px;">
										<div class="signa-field">
											<label for="split_title">تیتر اصلی بنر کناری</label>
											<input type="text" name="signa[split_title]" id="split_title" value="<?php echo esc_attr( $settings['split_title'] ); ?>" />
										</div>
										<div class="signa-field">
											<label for="split_subtitle">زیرعنوان بنر کناری</label>
											<input type="text" name="signa[split_subtitle]" id="split_subtitle" value="<?php echo esc_attr( $settings['split_subtitle'] ); ?>" />
										</div>
									</div>

									<div class="signa-field" style="margin-top:12px;">
										<label for="split_features">ویژگی‌های تیک‌دار پایین بنر (هر خط یک ویژگی)</label>
										<textarea name="signa[split_features]" id="split_features" rows="3"><?php echo esc_textarea( $settings['split_features'] ); ?></textarea>
									</div>
								</div>

								<!-- Card Horizontal Alignment / Position -->
								<label class="signa-section-label" style="margin-top:20px;">ب) موقعیت افقی قرارگیری کارت در صفحه (Card Alignment)</label>
								<div class="signa-choice-grid signa-cols-3">
									<label class="signa-choice-card <?php echo 'right' === $card_position ? 'selected' : ''; ?>">
										<input type="radio" name="signa[card_position]" value="right" <?php checked( $card_position, 'right' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش</span>
											<div class="signa-mv-pos-track is-right">
												<div class="signa-mv-card" style="width:42px;height:44px;">
													<span class="signa-mv-line"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<span class="signa-flow-node is-phone">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><rect x="13" y="6" width="6" height="12" rx="1" fill="currentColor" fill-opacity="0.25"/></svg>
											</span>
											<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
										<div class="signa-choice-body">
											<strong>شناور در سمت راست</strong>
											<small>مناسب وقتی تصویر پس‌زمینه در سمت چپ است</small>
										</div>
									</label>

									<label class="signa-choice-card <?php echo 'center' === $card_position ? 'selected' : ''; ?>">
										<input type="radio" name="signa[card_position]" value="center" <?php checked( $card_position, 'center' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش</span>
											<div class="signa-mv-pos-track is-center">
												<div class="signa-mv-card" style="width:42px;height:44px;">
													<span class="signa-mv-line"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<span class="signa-flow-node is-sms">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><rect x="8.5" y="6" width="7" height="12" rx="1" fill="currentColor" fill-opacity="0.25"/></svg>
											</span>
											<div class="signa-choice-top-left">
												<span class="signa-choice-tag is-green">پیش‌فرض</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
										</div>
										<div class="signa-choice-body">
											<strong>وسط‌چین (مرکز صفحه)</strong>
											<small>قرارگیری متوازن کارت در مرکز صفحه</small>
										</div>
									</label>

									<label class="signa-choice-card <?php echo 'left' === $card_position ? 'selected' : ''; ?>">
										<input type="radio" name="signa[card_position]" value="left" <?php checked( $card_position, 'left' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش</span>
											<div class="signa-mv-pos-track is-left">
												<div class="signa-mv-card" style="width:42px;height:44px;">
													<span class="signa-mv-line"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<span class="signa-flow-node is-passkey">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><rect x="5" y="6" width="6" height="12" rx="1" fill="currentColor" fill-opacity="0.25"/></svg>
											</span>
											<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
										<div class="signa-choice-body">
											<strong>شناور در سمت چپ</strong>
											<small>مناسب وقتی تصویر پس‌زمینه در سمت راست است</small>
										</div>
									</label>
								</div>
								</div>
							</div>

							<!-- CARD 2: Slide-Over Drawer Modal & Standalone Full-Page Canvas -->
							<div class="signa-card signa-accordion-card" style="margin-bottom:16px;">
								<div class="signa-card-head signa-accordion-trigger">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-green">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18"/></svg>
										</span>
										<div>
											<h2>۲. استایل پاپ‌آپ (Drawer / Modal) و قالب تمام‌صفحه اختصاصی</h2>
											<p>تنظیم نحوه باز شدن مودال ورود (با کلیک روی هر گزینه، انیمیشن آن در پیش‌نمایش زنده اجرا می‌شود)</p>
										</div>
									</div>
									<div style="display:flex;align-items:center;gap:10px;">
										<span class="signa-accordion-chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></span>
									</div>
								</div>
								<div class="signa-accordion-body" style="display:none;">

								<label class="signa-section-label">الف) نحوه باز شدن پنجره پاپ‌آپ سراسری (Global Modal &amp; Slide-Over Drawer)</label>
								<div class="signa-choice-grid signa-cols-2">
									<label class="signa-choice-card <?php echo 'center' === $modal_style ? 'selected' : ''; ?>">
										<input type="radio" name="signa[modal_style]" value="center" <?php checked( $modal_style, 'center' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش انیمیشن</span>
											<div class="signa-mv-screen">
												<div class="signa-mv-screen-bg"><i style="width:45%;"></i><i style="width:85%;"></i><i style="width:65%;"></i></div>
												<div class="signa-mv-modal-center">
													<span class="signa-mv-line"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<span class="signa-flow-node is-phone">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="3" width="20" height="18" rx="2"/><rect x="7" y="7" width="10" height="10" rx="1.5"/></svg>
											</span>
											<div class="signa-choice-top-left">
												<span class="signa-choice-tag is-blue">کلاسیک</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
										</div>
										<div class="signa-choice-body">
											<strong>پاپ‌آپ وسط صفحه (Center Modal)</strong>
											<small>باز شدن پنجره در مرکز تصویر با افکت تار شدن پس‌زمینه</small>
										</div>
									</label>

									<label class="signa-choice-card <?php echo 'drawer_left' === $modal_style ? 'selected' : ''; ?>">
										<input type="radio" name="signa[modal_style]" value="drawer_left" <?php checked( $modal_style, 'drawer_left' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش انیمیشن</span>
											<div class="signa-mv-screen">
												<div class="signa-mv-screen-bg"><i style="width:55%;"></i><i style="width:90%;"></i><i style="width:70%;"></i></div>
												<div class="signa-mv-drawer-left">
													<span class="signa-mv-line"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<span class="signa-flow-node is-sms">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="10" y1="3" x2="10" y2="21"/><path d="m15 10-3 2 3 2"/></svg>
											</span>
											<div class="signa-choice-top-left">
												<span class="signa-choice-tag is-green">مدرن</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
										</div>
										<div class="signa-choice-body">
											<strong>دراور کشویی از چپ (Slide-Over Left)</strong>
											<small>باز شدن پنل تمام‌قد به صورت کشویی از لبه چپ صفحه</small>
										</div>
									</label>

									<label class="signa-choice-card <?php echo 'drawer_right' === $modal_style ? 'selected' : ''; ?>">
										<input type="radio" name="signa[modal_style]" value="drawer_right" <?php checked( $modal_style, 'drawer_right' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش انیمیشن</span>
											<div class="signa-mv-screen">
												<div class="signa-mv-screen-bg"><i style="width:55%;"></i><i style="width:90%;"></i><i style="width:70%;"></i></div>
												<div class="signa-mv-drawer-right">
													<span class="signa-mv-line"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<span class="signa-flow-node is-passkey">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="14" y1="3" x2="14" y2="21"/><path d="m9 10 3 2-3 2"/></svg>
											</span>
											<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
										<div class="signa-choice-body">
											<strong>دراور کشویی از راست (Slide-Over Right)</strong>
											<small>باز شدن پنل تمام‌قد به صورت کشویی از لبه راست صفحه</small>
										</div>
									</label>

									<label class="signa-choice-card <?php echo 'bottom_sheet' === $modal_style ? 'selected' : ''; ?>">
										<input type="radio" name="signa[modal_style]" value="bottom_sheet" <?php checked( $modal_style, 'bottom_sheet' ); ?> />
										<div class="signa-mini-video">
											<span class="signa-mini-video-badge">پیشنمایش انیمیشن</span>
											<div class="signa-mv-screen">
												<div class="signa-mv-screen-bg"><i style="width:55%;"></i><i style="width:90%;"></i></div>
												<div class="signa-mv-bottom-sheet">
													<span style="width:18px;height:2.5px;border-radius:99px;background:#cbd5e1;margin:0 auto 2px auto;display:block;"></span>
													<span class="signa-mv-input"></span>
													<span class="signa-mv-btn"></span>
												</div>
											</div>
										</div>
										<div class="signa-choice-card-top">
											<span class="signa-flow-node is-email">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="14" x2="21" y2="14"/><line x1="10" y1="17" x2="14" y2="17"/></svg>
											</span>
											<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										</div>
										<div class="signa-choice-body">
											<strong>شیت کشویی از پایین (Bottom Sheet)</strong>
											<small>باز شدن از پایین صفحه به سبک اپلیکیشن‌های موبایل</small>
										</div>
									</label>
								</div>

								<div class="signa-switch-row" style="margin-top:14px;">
									<div class="signa-switch-text">
										<strong>حالت شیت کشویی پایین (Bottom Sheet) خودکار در موبایل</strong>
										<p>در صفحه‌نمایش موبایل، پاپ‌آپ همیشه از پایین صفحه باز شود تا تایپ کد با یک دست راحت باشد.</p>
									</div>
									<label class="signa-switch">
										<input type="checkbox" name="signa[modal_mobile_sheet]" value="1" <?php checked( ! empty( $settings['modal_mobile_sheet'] ), true ); ?> />
										<span class="signa-slider"></span>
									</label>
								</div>

								<!-- Standalone Full-Page Canvas Settings -->
								<div style="margin-top:20px;padding-top:18px;border-top:1px solid var(--s-border);">
									<label class="signa-section-label">ب) قالب تمام‌صفحه اختصاصی بدون هدر و فوتر قالب (Standalone Full-Page Canvas)</label>
									<div class="signa-fields-grid signa-cols-2">
										<div class="signa-field">
											<label for="standalone_page_id">برگه ورود تمام‌صفحه (حذف خودکار هدر و فوتر قالب)</label>
											<select name="signa[standalone_page_id]" id="standalone_page_id">
												<option value="0" <?php selected( (int) $settings['standalone_page_id'], 0 ); ?>>غیرفعال (فقط روی wp-login.php اعمال شود)</option>
												<?php if ( ! empty( $wp_pages ) ) : ?>
													<?php foreach ( $wp_pages as $p_obj ) : ?>
														<option value="<?php echo esc_attr( (string) $p_obj->ID ); ?>" <?php selected( (int) $settings['standalone_page_id'], (int) $p_obj->ID ); ?>>
															<?php echo esc_html( $p_obj->post_title . ' (ID: ' . $p_obj->ID . ')' ); ?>
														</option>
													<?php endforeach; ?>
												<?php endif; ?>
											</select>
											<small>برگه انتخابی بدون منو، هدر و فوتر قالب به صورت صفحه ورود تمام‌صفحه نمایش داده می‌شود.</small>
										</div>

										<div class="signa-field">
											<label for="canvas_bg_style">استایل پس‌زمینه محیط تمام‌صفحه</label>
											<select name="signa[canvas_bg_style]" id="canvas_bg_style">
												<option value="mesh_light" <?php selected( $canvas_bg, 'mesh_light' ); ?>>گرادینت نوری روشن (Mesh Light — پیش‌فرض)</option>
												<option value="mesh_dark" <?php selected( $canvas_bg, 'mesh_dark' ); ?>>کهکشانی تیره و لوکس (Dark Aurora)</option>
												<option value="brand_gradient" <?php selected( $canvas_bg, 'brand_gradient' ); ?>>گرادینت هماهنگ با رنگ اصلی برند</option>
												<option value="solid" <?php selected( $canvas_bg, 'solid' ); ?>>رنگ یکدست سفارشی</option>
												<option value="custom_image" <?php selected( $canvas_bg, 'custom_image' ); ?>>تصویر پس‌زمینه تمام‌صفحه (Custom Image)</option>
											</select>
										</div>
									</div>

									<div class="signa-fields-grid signa-cols-2" style="margin-top:12px;">
										<div class="signa-field" id="signa-canvas-color-wrap" style="<?php echo in_array( $canvas_bg, array( 'solid', 'mesh_light' ), true ) ? '' : 'display:none;'; ?>">
											<label for="canvas_bg_color">رنگ پس‌زمینه صفحه</label>
											<div class="signa-color-input-wrap">
												<input type="color" name="signa[canvas_bg_color]" id="canvas_bg_color" value="<?php echo esc_attr( $settings['canvas_bg_color'] ); ?>" />
												<span id="canvas_bg_color_hex"><?php echo esc_html( $settings['canvas_bg_color'] ); ?></span>
											</div>
										</div>

										<div class="signa-field" id="signa-canvas-image-wrap" style="<?php echo 'custom_image' === $canvas_bg ? '' : 'display:none;'; ?>grid-column:span 2;">
											<label for="canvas_bg_image">تصویر پس‌زمینه تمام‌صفحه</label>
											<div style="display:flex;gap:8px;">
												<input type="text" name="signa[canvas_bg_image]" id="canvas_bg_image" value="<?php echo esc_attr( $settings['canvas_bg_image'] ); ?>" dir="ltr" placeholder="https://example.com/fullpage-bg.jpg" style="flex:1;" />
												<button type="button" id="signa_upload_canvas_bg_btn" class="signa-btn-secondary">انتخاب از رسانه</button>
											</div>
										</div>
									</div>

									<div class="signa-switch-row" style="margin-top:12px;">
										<div class="signa-switch-text">
											<strong>نمایش دکمه شناور «بازگشت به صفحه اصلی سایت»</strong>
											<p>در صفحه ورود تمام‌صفحه، لینک بازگشت سریع به صفحه اول سایت نمایش داده شود.</p>
										</div>
										<label class="signa-switch">
											<input type="checkbox" name="signa[canvas_show_back_link]" value="1" <?php checked( ! empty( $settings['canvas_show_back_link'] ), true ); ?> />
											<span class="signa-slider"></span>
										</label>
									</div>
								</div>
								</div>
							</div>

							<!-- CARD 2.5 (CATEGORY 2): Glassmorphism, Shadows, Borders, Gradients & SVG Background Patterns -->
							<div class="signa-card signa-accordion-card" style="margin-bottom:16px;">
								<div class="signa-card-head signa-accordion-trigger">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-amber">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
										</span>
										<div>
											<h2>۳. استایل کارت، افکت شیشه‌ای (Glassmorphism) و سایه‌ها</h2>
											<p>شخصی‌سازی افکت شیشه‌ای مات، عمق سایه، کادر دور کارت، گرادینت دکمه و پترن گرافیکی پس‌زمینه</p>
										</div>
									</div>
									<div style="display:flex;align-items:center;gap:10px;">
										<span class="signa-pill is-ok">افکت‌های مدرن</span>
										<span class="signa-accordion-chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></span>
									</div>
								</div>
								<div class="signa-accordion-body" style="display:none;">

								<!-- 1. Glassmorphism Switch & Sliders -->
								<div class="signa-switch-row">
									<div class="signa-switch-text">
										<strong>افکت شیشه‌ای مات (Glassmorphism / Frosted Glass)</strong>
										<p>شفاف شدن پس‌زمینه کارت به همراه تار شدن نوری تصویر یا گرادینت پشت کارت (Backdrop Blur).</p>
									</div>
									<label class="signa-switch">
										<input type="checkbox" name="signa[glassmorphism]" id="glassmorphism" value="1" <?php checked( ! empty( $settings['glassmorphism'] ), true ); ?> />
										<span class="signa-slider"></span>
									</label>
								</div>

								<div id="signa-glassmorphism-controls" style="margin-top:12px;padding:16px;border-radius:12px;background:var(--s-bg-subtle);border:1px solid var(--s-border-input);<?php echo ! empty( $settings['glassmorphism'] ) ? '' : 'display:none;'; ?>">
									<div class="signa-fields-grid signa-cols-2">
										<div class="signa-field">
											<label for="card_bg_opacity">شفافیت پس‌زمینه کارت (Opacity): <strong id="opacity_val_label"><?php echo esc_html( (string) $settings['card_bg_opacity'] ); ?>%</strong></label>
											<input type="range" name="signa[card_bg_opacity]" id="card_bg_opacity" min="25" max="100" value="<?php echo esc_attr( (string) $settings['card_bg_opacity'] ); ?>" />
										</div>
										<div class="signa-field">
											<label for="backdrop_blur">شدت ماتی شیشه (Backdrop Blur): <strong id="blur_val_label"><?php echo esc_html( (string) $settings['backdrop_blur'] ); ?>px</strong></label>
											<input type="range" name="signa[backdrop_blur]" id="backdrop_blur" min="0" max="32" value="<?php echo esc_attr( (string) $settings['backdrop_blur'] ); ?>" />
										</div>
									</div>
								</div>

								<!-- 2. Card Shadow, Border Style & Inner Padding -->
								<div class="signa-fields-grid signa-cols-3" style="margin-top:18px;">
									<div class="signa-field">
										<label for="card_shadow">عمق سایه کارت (Elevation)</label>
										<select name="signa[card_shadow]" id="card_shadow">
											<option value="none" <?php selected( $card_shadow, 'none' ); ?>>بدون سایه (Flat)</option>
											<option value="soft" <?php selected( $card_shadow, 'soft' ); ?>>سایه ملایم و ظریف (Soft)</option>
											<option value="medium" <?php selected( $card_shadow, 'medium' ); ?>>سایه استاندارد مدرن (Medium)</option>
											<option value="deep" <?php selected( $card_shadow, 'deep' ); ?>>سایه عمیق و معلق (Deep 3D)</option>
											<option value="glow" <?php selected( $card_shadow, 'glow' ); ?>>هاله نوری همرنگ برند (Brand Glow)</option>
										</select>
									</div>

									<div class="signa-field">
										<label for="card_border_style">استایل کادر دور کارت</label>
										<select name="signa[card_border_style]" id="card_border_style">
											<option value="subtle" <?php selected( $card_border, 'subtle' ); ?>>کادر ظریف استاندارد (1px)</option>
											<option value="none" <?php selected( $card_border, 'none' ); ?>>بدون کادر (Borderless)</option>
											<option value="top_accent" <?php selected( $card_border, 'top_accent' ); ?>>نوار رنگی برجسته بالای کارت (Top Bar)</option>
											<option value="glow" <?php selected( $card_border, 'glow' ); ?>>کادر درخشان همرنگ برند (Glowing)</option>
										</select>
									</div>

									<div class="signa-field">
										<label for="card_padding">فاصله داخلی کارت (Padding): <strong id="padding_val_label"><?php echo esc_html( (string) $settings['card_padding'] ); ?>px</strong></label>
										<input type="range" name="signa[card_padding]" id="card_padding" min="20" max="48" value="<?php echo esc_attr( (string) $settings['card_padding'] ); ?>" />
									</div>
								</div>

								<!-- 3. Dual-Tone Button Gradient & Secondary Brand Color -->
								<div style="margin-top:20px;padding-top:18px;border-top:1px solid var(--s-border);">
									<label class="signa-section-label">استایل رنگ دکمه‌ها و هدر کارت (تک‌رنگ یا گرادینت دو رنگ)</label>
									<div class="signa-fields-grid signa-cols-2">
										<div class="signa-field">
											<label for="button_bg_mode">حالت رنگ دکمه اصلی</label>
											<select name="signa[button_bg_mode]" id="button_bg_mode">
												<option value="solid" <?php selected( $button_bg_mode, 'solid' ); ?>>تک‌رنگ یکدست کلاسیک (Solid Color)</option>
												<option value="gradient" <?php selected( $button_bg_mode, 'gradient' ); ?>>گرادینت دو رنگ مدرن (Linear Gradient 135°)</option>
											</select>
										</div>

										<div class="signa-field" id="signa-secondary-color-wrap" style="<?php echo 'gradient' === $button_bg_mode ? '' : 'opacity:0.65;'; ?>">
											<label for="secondary_color">رنگ دوم گرادینت دکمه و المان‌ها</label>
											<div class="signa-color-input-wrap">
												<input type="color" name="signa[secondary_color]" id="secondary_color" value="<?php echo esc_attr( $settings['secondary_color'] ); ?>" />
												<span id="secondary_color_hex"><?php echo esc_html( $settings['secondary_color'] ); ?></span>
											</div>
										</div>
									</div>
								</div>

								<!-- 4. SVG Background Patterns -->
								<div style="margin-top:20px;padding-top:18px;border-top:1px solid var(--s-border);">
									<label class="signa-section-label">پترن و بافت گرافیکی پس‌زمینه (SVG Background Pattern)</label>
									<div class="signa-choice-grid signa-cols-3">
										<label class="signa-choice-card <?php echo 'none' === $bg_pattern ? 'selected' : ''; ?>">
											<input type="radio" name="signa[bg_pattern]" value="none" <?php checked( $bg_pattern, 'none' ); ?> />
											<div class="signa-mini-video" style="height:56px;background:radial-gradient(circle at top right, #1e293b, #0f172a);">
												<span class="signa-mini-video-badge">پیشنمایش</span>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-phone">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
												</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
											<div class="signa-choice-body">
												<strong>ساده (بدون پترن)</strong>
												<small>پس‌زمینه صاف و یکدست بدون بافت</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'dots' === $bg_pattern ? 'selected' : ''; ?>">
											<input type="radio" name="signa[bg_pattern]" value="dots" <?php checked( $bg_pattern, 'dots' ); ?> />
											<div class="signa-mini-video" style="height:56px;background:radial-gradient(rgba(96,165,250,0.45) 1.5px, transparent 1.5px), #0f172a;background-size:12px 12px, auto;">
												<span class="signa-mini-video-badge">پیشنمایش</span>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-sms">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="6" cy="6" r="1"/><circle cx="12" cy="6" r="1"/><circle cx="18" cy="6" r="1"/><circle cx="6" cy="12" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="18" cy="12" r="1"/><circle cx="6" cy="18" r="1"/><circle cx="12" cy="18" r="1"/><circle cx="18" cy="18" r="1"/></svg>
												</span>
												<div class="signa-choice-top-left">
													<span class="signa-choice-tag is-blue">مدرن</span>
													<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
												</div>
											</div>
											<div class="signa-choice-body">
												<strong>ماتریس نقطه‌ای (Dots)</strong>
												<small>نقطه‌های ظریف و منظم به سبک پنل‌های SaaS</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'grid' === $bg_pattern ? 'selected' : ''; ?>">
											<input type="radio" name="signa[bg_pattern]" value="grid" <?php checked( $bg_pattern, 'grid' ); ?> />
											<div class="signa-mini-video" style="height:56px;background:linear-gradient(to right, rgba(148,163,184,0.25) 1px, transparent 1px), linear-gradient(to bottom, rgba(148,163,184,0.25) 1px, transparent 1px), #0f172a;background-size:14px 14px, 14px 14px, auto;">
												<span class="signa-mini-video-badge">پیشنمایش</span>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-passkey">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>
												</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
											<div class="signa-choice-body">
												<strong>شبکه‌ای مهندسی (Micro-Grid)</strong>
												<small>خطوط شطرنجی بسیار ظریف و مدرن</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'waves' === $bg_pattern ? 'selected' : ''; ?>">
											<input type="radio" name="signa[bg_pattern]" value="waves" <?php checked( $bg_pattern, 'waves' ); ?> />
											<div class="signa-mini-video" style="height:56px;background:repeating-radial-gradient(circle at 0 0, transparent 0, rgba(96,165,250,0.18) 10px, transparent 20px), #0f172a;">
												<span class="signa-mini-video-badge">پیشنمایش</span>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-email">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/></svg>
												</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
											<div class="signa-choice-body">
												<strong>موج‌های موازی (Waves)</strong>
												<small>بافت خطوط منحنی و موجی در پس‌زمینه</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'geometric' === $bg_pattern ? 'selected' : ''; ?>">
											<input type="radio" name="signa[bg_pattern]" value="geometric" <?php checked( $bg_pattern, 'geometric' ); ?> />
											<div class="signa-mini-video" style="height:56px;background:linear-gradient(30deg, rgba(96,165,250,0.22) 12%, transparent 12.5%, transparent 87%, rgba(96,165,250,0.22) 87.5%), #0f172a;background-size:20px 34px, auto;">
												<span class="signa-mini-video-badge">پیشنمایش</span>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-phone">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
												</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
											<div class="signa-choice-body">
												<strong>هندسی الماسی (Geometric)</strong>
												<small>الگوی چندضلعی ظریف روی محیط پس‌زمینه</small>
											</div>
										</label>
									</div>
								</div>
								</div>
							</div>

							<!-- CARD 2.8 (CATEGORY 3): Typography, Fonts & Input Field Styles -->
							<div class="signa-card signa-accordion-card" style="margin-bottom:16px;">
								<div class="signa-card-head signa-accordion-trigger">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-cyan">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
										</span>
										<div>
											<h2>۴. تایپوگرافی، فونت فارسی و استایل فیلدهای ورودی</h2>
											<p>انتخاب فونت، اندازه متون، طراحی کادر فیلدهای ورودی و پیش‌شماره/پرچم کشور</p>
										</div>
									</div>
									<div style="display:flex;align-items:center;gap:10px;">
										<span class="signa-pill is-info">تایپوگرافی و فیلدها</span>
										<span class="signa-accordion-chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></span>
									</div>
								</div>
								<div class="signa-accordion-body" style="display:none;">

								<!-- 1. Font Family & Text Size Sliders -->
								<div class="signa-fields-grid signa-cols-2">
									<div class="signa-field">
										<label for="font_family">خانواده فونت فرم ورود (Font Family)</label>
										<select name="signa[font_family]" id="font_family">
											<option value="vazirmatn" <?php selected( $font_family, 'vazirmatn' ); ?>>وزیرمتن (Vazirmatn — پیش‌فرض استاندارد وب)</option>
											<option value="iransans" <?php selected( $font_family, 'iransans' ); ?>>ایران‌سنس (IRANSans / IRANSansX)</option>
											<option value="yekanbakh" <?php selected( $font_family, 'yekanbakh' ); ?>>یکان‌بخ / ایران‌یکان (YekanBakh / IRANYekan)</option>
											<option value="dana" <?php selected( $font_family, 'dana' ); ?>>دانا / انجمن (Dana / Anjoman)</option>
											<option value="estedad" <?php selected( $font_family, 'estedad' ); ?>>استعداد / شبنم (Estedad / Shabnam)</option>
											<option value="theme_inherit" <?php selected( $font_family, 'theme_inherit' ); ?>>ارث‌بری خودکار از فونت قالب وردپرس (Inherit)</option>
										</select>
									</div>

									<div class="signa-field">
										<label for="input_addon_style">نمایش آیکون یا پیش‌شماره کنار فیلد موبایل</label>
										<select name="signa[input_addon_style]" id="input_addon_style">
											<option value="icon" <?php selected( $input_addon, 'icon' ); ?>>آیکون هوشمند موبایل / ایمیل (پیش‌فرض)</option>
											<option value="ir_flag" <?php selected( $input_addon, 'ir_flag' ); ?>>پرچم ایران 🇮🇷 و پیش‌شماره (+98)</option>
											<option value="none" <?php selected( $input_addon, 'none' ); ?>>ساده و بدون آیکون داخل فیلد</option>
										</select>
									</div>
								</div>

								<div class="signa-fields-grid signa-cols-3" style="margin-top:16px;">
									<div class="signa-field">
										<label for="title_font_size">اندازه تیتر اصلی: <strong id="title_size_val_label"><?php echo esc_html( (string) $settings['title_font_size'] ); ?>px</strong></label>
										<input type="range" name="signa[title_font_size]" id="title_font_size" min="16" max="28" value="<?php echo esc_attr( (string) $settings['title_font_size'] ); ?>" />
									</div>

									<div class="signa-field">
										<label for="subtitle_font_size">اندازه زیرعنوان: <strong id="subtitle_size_val_label"><?php echo esc_html( (string) $settings['subtitle_font_size'] ); ?>px</strong></label>
										<input type="range" name="signa[subtitle_font_size]" id="subtitle_font_size" min="12" max="17" value="<?php echo esc_attr( (string) $settings['subtitle_font_size'] ); ?>" />
									</div>

									<div class="signa-field">
										<label for="btn_font_size">اندازه متن دکمه‌ها: <strong id="btn_size_val_label"><?php echo esc_html( (string) $settings['btn_font_size'] ); ?>px</strong></label>
										<input type="range" name="signa[btn_font_size]" id="btn_font_size" min="13" max="18" value="<?php echo esc_attr( (string) $settings['btn_font_size'] ); ?>" />
									</div>
								</div>

								<!-- 2. Input Field Visual Styles (with Mini-Video Previews) -->
								<div style="margin-top:20px;padding-top:18px;border-top:1px solid var(--s-border);">
									<label class="signa-section-label">استایل ظاهری کادر فیلدهای ورودی (Input Field Style)</label>
									<div class="signa-choice-grid signa-cols-2">
										<label class="signa-choice-card <?php echo 'filled' === $input_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[input_style]" value="filled" <?php checked( $input_style, 'filled' ); ?> />
											<div class="signa-mini-video" style="height:62px;">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="width:130px;height:28px;border-radius:7px;background:#f8fafc;border:1.5px solid #3b82f6;display:flex;align-items:center;padding:0 8px;">
													<span style="width:65%;height:5px;border-radius:3px;background:#64748b;"></span>
												</div>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-phone">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="6" width="18" height="12" rx="3" fill="currentColor" fill-opacity="0.18"/></svg>
												</span>
												<div class="signa-choice-top-left">
													<span class="signa-choice-tag is-blue">پیش‌فرض</span>
													<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
												</div>
											</div>
											<div class="signa-choice-body">
												<strong>کادر توپر مدرن (Filled Box)</strong>
												<small>پس‌زمینه ملایم به همراه کادر دور استاندارد</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'outlined' === $input_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[input_style]" value="outlined" <?php checked( $input_style, 'outlined' ); ?> />
											<div class="signa-mini-video" style="height:62px;">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="width:130px;height:28px;border-radius:7px;background:transparent;border:1.5px solid #60a5fa;display:flex;align-items:center;padding:0 8px;">
													<span style="width:65%;height:5px;border-radius:3px;background:#93c5fd;"></span>
												</div>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-sms">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="6" width="18" height="12" rx="3"/></svg>
												</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
											<div class="signa-choice-body">
												<strong>کادر خطی شفاف (Outlined Clean)</strong>
												<small>پس‌زمینه شفاف همرنگ کارت با حاشیه ظریف</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'underlined' === $input_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[input_style]" value="underlined" <?php checked( $input_style, 'underlined' ); ?> />
											<div class="signa-mini-video" style="height:62px;">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="width:130px;height:28px;border-bottom:2.5px solid #38bdf8;display:flex;align-items:center;padding:0 4px;">
													<span style="width:65%;height:5px;border-radius:3px;background:#cbd5e1;"></span>
												</div>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-passkey">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="3" y1="18" x2="21" y2="18"/><line x1="6" y1="11" x2="14" y2="11"/></svg>
												</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
											<div class="signa-choice-body">
												<strong>خط زیرین مینیمال (Underlined)</strong>
												<small>فقط خط رنگی در پایین فیلد به سبک متریال</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'soft_pill' === $input_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[input_style]" value="soft_pill" <?php checked( $input_style, 'soft_pill' ); ?> />
											<div class="signa-mini-video" style="height:62px;">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="width:130px;height:28px;border-radius:99px;background:rgba(241,245,249,0.95);display:flex;align-items:center;padding:0 12px;">
													<span style="width:65%;height:5px;border-radius:99px;background:#64748b;"></span>
												</div>
											</div>
											<div class="signa-choice-card-top">
												<span class="signa-flow-node is-email">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="6" width="20" height="12" rx="6"/></svg>
												</span>
												<span class="signa-choice-check"><?php echo $svg_check_mark; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											</div>
											<div class="signa-choice-body">
												<strong>کپسولی گرد (Soft Pill)</strong>
												<small>فیلد و دکمه‌های کاملاً گرد و مدرن</small>
											</div>
										</label>
									</div>

									<div class="signa-fields-grid signa-cols-3" style="margin-top:16px;">
										<div class="signa-field">
											<label for="input_height">ارتفاع فیلدها و دکمه: <strong id="input_height_val_label"><?php echo esc_html( (string) $settings['input_height'] ); ?>px</strong></label>
											<input type="range" name="signa[input_height]" id="input_height" min="42" max="58" value="<?php echo esc_attr( (string) $settings['input_height'] ); ?>" />
										</div>

										<div class="signa-field">
											<label for="input_bg_color">رنگ پس‌زمینه فیلد ورودی</label>
											<div class="signa-color-input-wrap">
												<input type="color" name="signa[input_bg_color]" id="input_bg_color" value="<?php echo esc_attr( $settings['input_bg_color'] ); ?>" />
												<span id="input_bg_color_hex"><?php echo esc_html( $settings['input_bg_color'] ); ?></span>
											</div>
										</div>

										<div class="signa-field">
											<label for="input_border_color">رنگ کادر دور فیلد ورودی</label>
											<div class="signa-color-input-wrap">
												<input type="color" name="signa[input_border_color]" id="input_border_color" value="<?php echo esc_attr( $settings['input_border_color'] ); ?>" />
												<span id="input_border_color_hex"><?php echo esc_html( $settings['input_border_color'] ); ?></span>
											</div>
										</div>
									</div>
								</div>
								</div>
							</div>

							<!-- CARD 2.9 (CATEGORY 4): OTP Digit Boxes, Countdown Timer Styles & Micro-Animations -->
							<?php
							$digit_box_style    = isset( $settings['digit_box_style'] ) ? $settings['digit_box_style'] : 'box';
							$digit_box_size     = isset( $settings['digit_box_size'] ) ? absint( $settings['digit_box_size'] ) : 48;
							$digit_box_gap      = isset( $settings['digit_box_gap'] ) ? absint( $settings['digit_box_gap'] ) : 8;
							$timer_style        = isset( $settings['timer_style'] ) ? $settings['timer_style'] : 'progress_bar';
							$form_animation     = isset( $settings['form_animation'] ) ? $settings['form_animation'] : 'fade_up';
							$otp_auto_submit    = ! empty( $settings['otp_auto_submit'] );
							$error_shake_effect = ! empty( $settings['error_shake_effect'] );
							?>
							<div class="signa-card signa-accordion-card" style="margin-bottom:16px;">
								<div class="signa-card-head signa-accordion-trigger">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-green">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="5" height="12" rx="1.5"/><rect x="9.5" y="6" width="5" height="12" rx="1.5"/><rect x="17" y="6" width="5" height="12" rx="1.5"/></svg>
										</span>
										<div>
											<h2>۵. باکس‌های کد تایید (OTP)، تایمر شمارش معکوس و انیمیشن‌ها</h2>
											<p>طراحی خانه‌های ورود کد یکبارمصرف، استایل گرافیکی تایمر ارسال مجدد و انیمیشن‌های تعاملی فرم</p>
										</div>
									</div>
									<div style="display:flex;align-items:center;gap:10px;">
										<span class="signa-pill is-ok">مرحله ۲ و انیمیشن</span>
										<span class="signa-accordion-chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></span>
									</div>
								</div>
								<div class="signa-accordion-body" style="display:none;">

									<!-- 1. OTP Digit Box Styles with Animated Mini-Video Previews -->
									<label class="signa-section-label">الف) استایل ظاهری خانه‌های کد تایید (OTP Digit Boxes)</label>
									<div class="signa-choice-grid signa-cols-3">
										<label class="signa-choice-card <?php echo 'box' === $digit_box_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[digit_box_style]" class="signa-cat4-control" value="box" <?php checked( $digit_box_style, 'box' ); ?> />
											<div class="signa-mini-video">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="display:flex;gap:5px;direction:ltr;">
													<span style="width:22px;height:26px;border-radius:6px;background:#f8fafc;border:1.5px solid #cbd5e1;color:#0f172a;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">5</span>
													<span style="width:22px;height:26px;border-radius:6px;background:#f8fafc;border:1.5px solid #cbd5e1;color:#0f172a;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">8</span>
													<span style="width:22px;height:26px;border-radius:6px;background:#ffffff;border:2px solid #38bdf8;color:#0f172a;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;transform:translateY(-2px);">2</span>
													<span style="width:22px;height:26px;border-radius:6px;background:rgba(248,250,252,0.2);border:1.5px solid #64748b;"></span>
												</div>
											</div>
											<div class="signa-choice-body">
												<strong>مربعی مدرن (Modern Box)</strong>
												<small>خانه‌های مجزا با گوشه‌های گرد استاندارد</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'underline' === $digit_box_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[digit_box_style]" class="signa-cat4-control" value="underline" <?php checked( $digit_box_style, 'underline' ); ?> />
											<div class="signa-mini-video">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="display:flex;gap:6px;direction:ltr;">
													<span style="width:20px;height:26px;border-bottom:2.5px solid #38bdf8;color:#f8fafc;font-size:12px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">5</span>
													<span style="width:20px;height:26px;border-bottom:2.5px solid #38bdf8;color:#f8fafc;font-size:12px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">8</span>
													<span style="width:20px;height:26px;border-bottom:2.5px solid #10b981;color:#38bdf8;font-size:12px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">2</span>
													<span style="width:20px;height:26px;border-bottom:2px solid #64748b;"></span>
												</div>
											</div>
											<div class="signa-choice-body">
												<strong>خط تیره پایین (Underline)</strong>
												<small>مینیمال با خط شاخص در پایین هر رقم</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'pill' === $digit_box_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[digit_box_style]" class="signa-cat4-control" value="pill" <?php checked( $digit_box_style, 'pill' ); ?> />
											<div class="signa-mini-video">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="display:flex;gap:5px;direction:ltr;">
													<span style="width:22px;height:26px;border-radius:99px;background:#f8fafc;border:1.5px solid #cbd5e1;color:#0f172a;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">5</span>
													<span style="width:22px;height:26px;border-radius:99px;background:#f8fafc;border:1.5px solid #cbd5e1;color:#0f172a;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">8</span>
													<span style="width:22px;height:26px;border-radius:99px;background:#ffffff;border:2px solid #38bdf8;color:#0f172a;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">2</span>
													<span style="width:22px;height:26px;border-radius:99px;background:rgba(248,250,252,0.2);border:1.5px solid #64748b;"></span>
												</div>
											</div>
											<div class="signa-choice-body">
												<strong>کپسولی گرد (Soft Pill)</strong>
												<small>کادرهای کاملاً گرد و منحنی</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'separated_glow' === $digit_box_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[digit_box_style]" class="signa-cat4-control" value="separated_glow" <?php checked( $digit_box_style, 'separated_glow' ); ?> />
											<div class="signa-mini-video">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="display:flex;gap:5px;direction:ltr;">
													<span style="width:22px;height:26px;border-radius:7px;background:rgba(56,189,248,0.15);border:1.5px solid #38bdf8;box-shadow:0 0 10px rgba(56,189,248,0.45);color:#f8fafc;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">5</span>
													<span style="width:22px;height:26px;border-radius:7px;background:rgba(56,189,248,0.15);border:1.5px solid #38bdf8;box-shadow:0 0 10px rgba(56,189,248,0.45);color:#f8fafc;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">8</span>
													<span style="width:22px;height:26px;border-radius:7px;background:rgba(16,185,129,0.2);border:1.5px solid #10b981;box-shadow:0 0 12px rgba(16,185,129,0.6);color:#6ee7b7;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">2</span>
													<span style="width:22px;height:26px;border-radius:7px;background:rgba(15,23,42,0.5);border:1.5px solid #475569;"></span>
												</div>
											</div>
											<div class="signa-choice-body">
												<strong>نئونی درخشان (Glow Box)</strong>
												<small>درخشش نوری رنگ برند دور خانه‌های کد</small>
											</div>
										</label>

										<label class="signa-choice-card <?php echo 'connected' === $digit_box_style ? 'selected' : ''; ?>">
											<input type="radio" name="signa[digit_box_style]" class="signa-cat4-control" value="connected" <?php checked( $digit_box_style, 'connected' ); ?> />
											<div class="signa-mini-video">
												<span class="signa-mini-video-badge">پیشنمایش</span>
												<div style="display:inline-flex;border-radius:8px;overflow:hidden;border:1.5px solid #94a3b8;background:#f8fafc;direction:ltr;">
													<span style="width:22px;height:26px;border-right:1px solid #cbd5e1;color:#0f172a;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">5</span>
													<span style="width:22px;height:26px;border-right:1px solid #cbd5e1;color:#0f172a;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">8</span>
													<span style="width:22px;height:26px;border-right:1px solid #cbd5e1;background:#eff6ff;color:#2563eb;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">2</span>
													<span style="width:22px;height:26px;color:#94a3b8;font-size:11px;display:inline-flex;align-items:center;justify-content:center;">•</span>
												</div>
											</div>
											<div class="signa-choice-body">
												<strong>پیوسته یکپارچه (Connected)</strong>
												<small>نوار یکپارچه با جداکننده عمودی ظریف</small>
											</div>
										</label>
									</div>

									<!-- 2. Digit Box Size & Gap Sliders -->
									<div class="signa-fields-grid signa-cols-2" style="margin-top:18px;">
										<div class="signa-field">
											<label for="digit_box_size">اندازه و ارتفاع هر خانه کد: <strong id="digit_size_val_label"><?php echo esc_html( (string) $digit_box_size ); ?>px</strong></label>
											<input type="range" name="signa[digit_box_size]" id="digit_box_size" class="signa-cat4-control" min="38" max="58" value="<?php echo esc_attr( (string) $digit_box_size ); ?>" />
										</div>
										<div class="signa-field">
											<label for="digit_box_gap">فاصله افقی بین خانه‌های کد: <strong id="digit_gap_val_label"><?php echo esc_html( (string) $digit_box_gap ); ?>px</strong></label>
											<input type="range" name="signa[digit_box_gap]" id="digit_box_gap" class="signa-cat4-control" min="4" max="14" value="<?php echo esc_attr( (string) $digit_box_gap ); ?>" />
										</div>
									</div>

									<!-- 3. Countdown Timer Style with Animated Mini-Video Previews -->
									<div style="margin-top:22px;padding-top:18px;border-top:1px solid var(--s-border);">
										<label class="signa-section-label">ب) استایل تایمر شمارش معکوس ارسال مجدد کد (Countdown Timer)</label>
										<div class="signa-choice-grid signa-cols-2">
											<label class="signa-choice-card <?php echo 'progress_bar' === $timer_style ? 'selected' : ''; ?>">
												<input type="radio" name="signa[timer_style]" class="signa-cat4-control" value="progress_bar" <?php checked( $timer_style, 'progress_bar' ); ?> />
												<div class="signa-mini-video">
													<span class="signa-mini-video-badge">پیشنمایش</span>
													<div style="width:120px;display:flex;flex-direction:column;gap:5px;align-items:center;">
														<span style="font-size:10px;color:#e2e8f0;font-weight:700;">۰۱:۴۵ تا ارسال مجدد</span>
														<div style="width:100%;height:5px;border-radius:99px;background:rgba(148,163,184,0.25);overflow:hidden;">
															<div style="width:68%;height:100%;border-radius:99px;background:linear-gradient(90deg,#38bdf8,#2563eb);"></div>
														</div>
													</div>
												</div>
												<div class="signa-choice-body">
													<strong>نوار پیشرفت افقی (Progress Bar)</strong>
													<small>نوار گرادینت متحرک زیر زمان باقی‌مانده</small>
												</div>
											</label>

											<label class="signa-choice-card <?php echo 'circular_ring' === $timer_style ? 'selected' : ''; ?>">
												<input type="radio" name="signa[timer_style]" class="signa-cat4-control" value="circular_ring" <?php checked( $timer_style, 'circular_ring' ); ?> />
												<div class="signa-mini-video">
													<span class="signa-mini-video-badge">پیشنمایش</span>
													<div style="display:inline-flex;align-items:center;gap:8px;background:rgba(15,23,42,0.55);padding:5px 12px;border-radius:99px;border:1px solid rgba(56,189,248,0.3);">
														<svg width="22" height="22" viewBox="0 0 24 24" style="transform:rotate(-90deg);">
															<circle cx="12" cy="12" r="9" fill="none" stroke="rgba(148,163,184,0.25)" stroke-width="2.5"/>
															<circle cx="12" cy="12" r="9" fill="none" stroke="#38bdf8" stroke-width="2.5" stroke-dasharray="56.5" stroke-dashoffset="16" stroke-linecap="round"/>
														</svg>
														<span style="font-size:11px;color:#f8fafc;font-weight:800;" dir="ltr">01:45</span>
													</div>
												</div>
												<div class="signa-choice-body">
													<strong>حلقه گرافیکی دایره‌ای (Circular SVG Ring)</strong>
													<small>حلقه прогреس دایره‌ای مدرن کنار ثانیه‌شمار</small>
												</div>
											</label>

											<label class="signa-choice-card <?php echo 'minimal_badge' === $timer_style ? 'selected' : ''; ?>">
												<input type="radio" name="signa[timer_style]" class="signa-cat4-control" value="minimal_badge" <?php checked( $timer_style, 'minimal_badge' ); ?> />
												<div class="signa-mini-video">
													<span class="signa-mini-video-badge">پیشنمایش</span>
													<div style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:99px;background:rgba(59,130,246,0.18);border:1px solid rgba(59,130,246,0.4);color:#93c5fd;font-size:10.5px;font-weight:700;">
														<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
														<span>ارسال مجدد: ۰۱:۴۵</span>
													</div>
												</div>
												<div class="signa-choice-body">
													<strong>بج کپسولی مینیمال (Minimal Pill Badge)</strong>
													<small>نمایش زمان داخل تگ کپسولی به همراه آیکون ساعت</small>
												</div>
											</label>

											<label class="signa-choice-card <?php echo 'simple_text' === $timer_style ? 'selected' : ''; ?>">
												<input type="radio" name="signa[timer_style]" class="signa-cat4-control" value="simple_text" <?php checked( $timer_style, 'simple_text' ); ?> />
												<div class="signa-mini-video">
													<span class="signa-mini-video-badge">پیشنمایش</span>
													<span style="font-size:11px;color:#cbd5e1;font-weight:600;">ارسال مجدد کد تا <strong>۰۱:۴۵</strong> دیگر</span>
												</div>
												<div class="signa-choice-body">
													<strong>متن ساده کلاسیک (Simple Text)</strong>
													<small>نمایش متنی ساده بدون المان گرافیکی اضافه</small>
												</div>
											</label>
										</div>
									</div>

									<!-- 4. Form Entrance Animation & Interactive Micro-Interactions -->
									<div style="margin-top:22px;padding-top:18px;border-top:1px solid var(--s-border);">
										<div class="signa-fields-grid signa-cols-2" style="margin-bottom:14px;">
											<div class="signa-field">
												<label for="form_animation">ج) انیمیشن ورود فرم و تغییر مراحل</label>
												<select name="signa[form_animation]" id="form_animation">
													<option value="fade_up" <?php selected( $form_animation, 'fade_up' ); ?>>ظهور نرم از پایین (Smooth Fade Up)</option>
													<option value="zoom_spring" <?php selected( $form_animation, 'zoom_spring' ); ?>>بزرگ‌نمایی فنری مدرن (Spring Scale)</option>
													<option value="slide_rtl" <?php selected( $form_animation, 'slide_rtl' ); ?>>حرکت کشویی افقی (Slide Horizontal)</option>
													<option value="none" <?php selected( $form_animation, 'none' ); ?>>بدون انیمیشن (Instant)</option>
												</select>
											</div>
											<div class="signa-field" style="display:flex;flex-direction:column;justify-content:flex-end;">
												<button type="button" id="signa-test-shake-btn" class="signa-btn-secondary" style="height:42px;justify-content:center;gap:8px;">
													<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
													<span>تست زنده افکت لرزش خطا در پیش‌نمایش</span>
												</button>
											</div>
										</div>

										<div class="signa-switch-row" style="margin-bottom:10px;">
											<div class="signa-switch-text">
												<strong>ارسال خودکار به محض تکمیل آخرین رقم کد (Auto-Submit OTP)</strong>
												<p>به محض وارد کردن آخرین رقم کد تایید (یا خواندن خودکار پیامک توسط مرورگر)، فرم بدون نیاز به کلیک روی دکمه بررسی می‌شود.</p>
											</div>
											<label class="signa-switch">
												<input type="checkbox" name="signa[otp_auto_submit]" id="otp_auto_submit" value="1" <?php checked( $otp_auto_submit, true ); ?> />
												<span class="signa-slider"></span>
											</label>
										</div>

										<div class="signa-switch-row">
											<div class="signa-switch-text">
												<strong>افکت لرزش و قرمز شدن کادرها هنگام کد اشتباه (Error Shake Effect)</strong>
												<p>در صورت وارد کردن کد نادرست، خانه‌های کد با انیمیشن لرزش افقی و هایلایت قرمز به کاربر بازخورد بصری می‌دهند.</p>
											</div>
											<label class="signa-switch">
												<input type="checkbox" name="signa[error_shake_effect]" id="error_shake_effect" value="1" <?php checked( $error_shake_effect, true ); ?> />
												<span class="signa-slider"></span>
											</label>
										</div>
									</div>

								</div>
							</div>

							<!-- CARD 3: Color Presets, Card Colors & Dimensions -->
							<div class="signa-card signa-accordion-card" style="margin-bottom:16px;">
								<div class="signa-card-head signa-accordion-trigger">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-purple">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
										</span>
										<div>
											<h2>۶. پالت‌های رنگی و تم‌های آماده (Presets)</h2>
											<p>با یک کلیک استایل کلی فرم را تغییر دهید یا رنگ‌ها را سفارشی کنید (با تشخیص خودکار کنتراست تیره/روشن)</p>
										</div>
									</div>
									<div style="display:flex;align-items:center;gap:10px;">
										<span class="signa-pill is-ok">کنتراست هوشمند</span>
										<span class="signa-accordion-chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></span>
									</div>
								</div>
								<div class="signa-accordion-body" style="display:none;">

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
										<label for="text_color">رنگ متون اصلی <span id="signa-auto-contrast-badge" style="font-size:10px;font-weight:700;padding:1px 6px;border-radius:99px;background:rgba(37,99,235,0.12);color:#2563eb;margin-right:4px;">تشخیص خودکار</span></label>
										<div class="signa-color-input-wrap">
											<input type="color" name="signa[text_color]" id="text_color" value="<?php echo esc_attr( $settings['text_color'] ); ?>" />
											<span id="text_color_hex"><?php echo esc_html( $settings['text_color'] ); ?></span>
										</div>
									</div>
								</div>

								<div class="signa-fields-grid signa-cols-2" style="margin-top:16px;">
									<div class="signa-field">
										<label for="border_radius">گردی گوشه‌ها: <strong id="radius_val_label"><?php echo esc_html( (string) $settings['border_radius'] ); ?>px</strong></label>
										<input type="range" name="signa[border_radius]" id="border_radius" min="0" max="28" value="<?php echo esc_attr( (string) $settings['border_radius'] ); ?>" />
									</div>
									<div class="signa-field">
										<label for="form_max_width">حداکثر عرض کارت در سایت (px)</label>
										<input type="text" inputmode="numeric" name="signa[form_max_width]" id="form_max_width" value="<?php echo esc_attr( (string) $settings['form_max_width'] ); ?>" dir="ltr" />
									</div>
								</div>

								<div class="signa-field" style="margin-top:16px;">
									<label for="logo_url">تصویر لوگوی بالای فرم (اختیاری)</label>
									<div style="display:flex;gap:8px;">
										<input type="text" name="signa[logo_url]" id="logo_url" value="<?php echo esc_attr( $settings['logo_url'] ); ?>" dir="ltr" placeholder="https://example.com/logo.png" style="flex:1;" />
										<button type="button" id="signa_upload_logo_btn" class="signa-btn-secondary">انتخاب از رسانه</button>
									</div>
								</div>
								</div>
							</div>

							<!-- CARD 4: Form Texts & Custom CSS -->
							<div class="signa-card signa-accordion-card" style="margin-bottom:16px;">
								<div class="signa-card-head signa-accordion-trigger">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-blue">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
										</span>
										<div>
											<h2>۷. متن‌ها و برچسب‌های فرم</h2>
											<p>عنوان‌ها و متن دکمه‌ها را متناسب با لحن برند خود تغییر دهید</p>
										</div>
									</div>
									<div style="display:flex;align-items:center;gap:10px;">
										<span class="signa-accordion-chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></span>
									</div>
								</div>
								<div class="signa-accordion-body" style="display:none;">
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
						</div>

						<!-- Interactive Live Preview Stage (Left Sticky Column) -->
						<div class="signa-studio-preview-col">
							<div class="signa-preview-box">
								<div class="signa-preview-toolbar">
									<span style="display:inline-flex;align-items:center;gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> پیش‌نمایش زنده پویا</span>
									<div class="signa-preview-step-btns">
										<button type="button" class="signa-prev-step-btn active" data-step="1">مرحله ۱: شماره</button>
										<button type="button" class="signa-prev-step-btn" data-step="2">مرحله ۲: کد تایید</button>
									</div>
								</div>

								<!-- Dynamic Preview Mode Sub-Bar (Page Layout vs Modal/Drawer Animation + Wide Zoom) -->
								<div class="signa-preview-subbar">
									<div class="signa-preview-mode-tabs">
										<button type="button" class="signa-prev-mode-btn active" data-mode="page">نمای صفحه ورود</button>
										<button type="button" class="signa-prev-mode-btn" data-mode="modal">تست پاپ‌آپ / کشویی</button>
									</div>
									<button type="button" class="signa-prev-expand-btn" id="signa-prev-expand-btn" title="بزرگ‌نمایی ستون پیش‌نمایش">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
										<span>بزرگ‌نمایی</span>
									</button>
								</div>

								<div class="signa-preview-canvas" id="signa-preview-canvas" style="display:flex;flex-direction:column;align-items:<?php echo 'right' === $card_position ? 'flex-start' : ( 'left' === $card_position ? 'flex-end' : 'center' ); ?>;transition:background 0.4s ease, align-items 0.25s ease;">

									<!-- Ambient Decorative Glass Orbs (Makes Backdrop-Filter Blur Slider Visibly Blur Background Shapes in Real Time) -->
									<div id="signa-prev-glass-orbs" class="signa-prev-glass-orbs" aria-hidden="true">
										<span class="signa-glass-orb orb-1"></span>
										<span class="signa-glass-orb orb-2"></span>
										<span class="signa-glass-orb orb-3"></span>
									</div>

									<!-- Simulated Website Skeleton & Backdrop (Shown in Modal/Drawer Preview Mode) -->
									<div class="signa-prev-site-skeleton" aria-hidden="true">
										<div style="height:28px;border-radius:8px;background:rgba(148,163,184,0.25);display:flex;align-items:center;justify-content:space-between;padding:0 12px;">
											<span style="width:65px;height:10px;border-radius:4px;background:rgba(59,130,246,0.45);"></span>
											<span style="width:120px;height:8px;border-radius:4px;background:rgba(148,163,184,0.35);"></span>
										</div>
										<div style="height:110px;border-radius:12px;background:rgba(148,163,184,0.18);"></div>
										<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;flex:1;">
											<div style="border-radius:10px;background:rgba(148,163,184,0.16);"></div>
											<div style="border-radius:10px;background:rgba(148,163,184,0.16);"></div>
											<div style="border-radius:10px;background:rgba(148,163,184,0.16);"></div>
										</div>
									</div>
									<div class="signa-prev-modal-backdrop" aria-hidden="true"></div>

									<!-- Proportional Viewport Wrapper (Scales 720px Split-Screen smoothly so text never squishes) -->
									<div id="signa-preview-viewport" class="signa-preview-viewport <?php echo $is_split ? 'is-scaled-split' : ''; ?>" style="align-items:<?php echo 'right' === $card_position ? 'flex-start' : ( 'left' === $card_position ? 'flex-end' : 'center' ); ?>;">
										<div id="signa-live-preview-shell" class="signa-prev-shell <?php echo $is_split ? 'is-split' : ''; ?> <?php echo 'split_left' === $form_layout ? 'is-split-left' : ''; ?>" style="width:100%;max-width:<?php echo $is_split ? '720px' : '360px'; ?>;border-radius:<?php echo esc_attr( (string) $settings['border_radius'] ); ?>px;overflow:hidden;box-shadow:0 16px 36px -8px rgba(15,23,42,0.16);display:flex;flex-direction:<?php echo 'split_left' === $form_layout ? 'row-reverse' : 'row'; ?>;transition:all 0.35s ease;">

											<!-- Form Column -->
											<div id="signa-live-preview-card" class="signa-prev-card" style="flex:1;min-width:0;margin:0;box-shadow:none;background:<?php echo esc_attr( $settings['card_bg_color'] ); ?>;color:<?php echo esc_attr( $settings['text_color'] ); ?>;border-radius:0;transition:color 0.42s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.42s cubic-bezier(0.4, 0, 0.2, 1), backdrop-filter 0.2s ease, -webkit-backdrop-filter 0.2s ease;">
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
													<h3 id="signa-prev-title" style="margin:0 0 6px 0;font-size:17px;color:inherit;transition:color 0.42s cubic-bezier(0.4, 0, 0.2, 1);"><?php echo esc_html( $settings['form_title'] ); ?></h3>
													<p id="signa-prev-subtitle" style="margin:0;font-size:12.5px;opacity:0.82;line-height:1.6;color:inherit;transition:color 0.42s cubic-bezier(0.4, 0, 0.2, 1);"><?php echo esc_html( $settings['form_subtitle'] ); ?></p>
												</div>

												<!-- Preview Step 1 -->
												<div id="signa-prev-step-1">
													<label id="signa-prev-field-label" style="display:block;font-size:12.5px;font-weight:600;margin-bottom:6px;color:inherit;transition:color 0.42s cubic-bezier(0.4, 0, 0.2, 1);">شماره موبایل یا ایمیل</label>
													<div id="signa-prev-input-wrap" style="position:relative;margin-bottom:16px;">
														<input type="text" class="signa-prev-input" placeholder="شماره موبایل (0912...) یا ایمیل" dir="rtl" readonly style="margin-bottom:0 !important;transition:background-color 0.38s ease, color 0.38s ease, border-color 0.38s ease;" />
														<span id="signa-prev-input-addon" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:700;color:#64748b;pointer-events:none;transition:color 0.38s ease;" dir="ltr"></span>
													</div>
													<button type="button" id="signa-prev-btn-1" style="width:100%;height:44px;border:none;border-radius:10px;background:<?php echo esc_attr( $settings['primary_color'] ); ?>;color:#fff;font-weight:700;font-size:14px;cursor:default;transition:all 0.35s ease;">
														<?php echo esc_html( $settings['button_text'] ); ?>
													</button>
												</div>

												<!-- Preview Step 2 -->
												<div id="signa-prev-step-2" style="display:none;">
													<div style="display:flex;justify-content:space-between;background:rgba(156,163,175,0.15);padding:8px 12px;border-radius:8px;margin-bottom:14px;font-size:12px;color:inherit;transition:color 0.42s ease;">
														<strong dir="ltr">0912***6789</strong>
														<span style="color:<?php echo esc_attr( $settings['primary_color'] ); ?>;font-weight:600;">ویرایش</span>
													</div>
													<div id="signa-prev-digits" style="display:flex;justify-content:center;gap:6px;margin-bottom:14px;" dir="ltr">
														<span class="signa-prev-digit">5</span>
														<span class="signa-prev-digit">8</span>
														<span class="signa-prev-digit">2</span>
														<span class="signa-prev-digit">9</span>
														<span class="signa-prev-digit">1</span>
													</div>
													<div id="signa-prev-timer-box" style="margin-bottom:14px;text-align:center;"></div>
													<button type="button" id="signa-prev-btn-2" style="width:100%;height:44px;border:none;border-radius:10px;background:<?php echo esc_attr( $settings['primary_color'] ); ?>;color:#fff;font-weight:600;font-size:14px;cursor:default;transition:all 0.35s ease;">
														<?php echo esc_html( $settings['verify_button_text'] ); ?>
													</button>
												</div>
											</div>

											<!-- Split-Screen Side Banner Preview Column -->
											<div id="signa-prev-split-banner" style="<?php echo $is_split ? 'display:flex;' : 'display:none;'; ?>flex:1;min-width:0;padding:28px 24px;flex-direction:column;justify-content:space-between;color:#ffffff;background-color:<?php echo esc_attr( $settings['split_bg_color'] ); ?>;background-image:<?php echo ! empty( $settings['split_image_url'] ) ? 'linear-gradient(135deg, rgba(15,23,42,0.72), rgba(30,58,138,0.78)), url(' . esc_url( $settings['split_image_url'] ) . ')' : 'radial-gradient(circle at top left, rgba(255,255,255,0.16), transparent 65%)'; ?>;background-size:cover;background-position:center;transition:color 0.42s ease, background 0.42s ease;">
												<div>
													<span id="signa-prev-split-badge" style="display:inline-block;padding:4px 12px;border-radius:99px;font-size:11.5px;font-weight:700;background:rgba(255,255,255,0.18);backdrop-filter:blur(4px);margin-bottom:14px;transition:color 0.42s ease, background 0.42s ease;"><?php echo esc_html( $settings['split_badge_text'] ); ?></span>
													<h4 id="signa-prev-split-title" style="margin:0 0 10px 0;font-size:18px;font-weight:800;color:inherit;line-height:1.45;transition:color 0.42s ease;"><?php echo esc_html( $settings['split_title'] ); ?></h4>
													<p id="signa-prev-split-subtitle" style="margin:0;font-size:13px;color:inherit;opacity:0.9;line-height:1.75;transition:color 0.42s ease;"><?php echo esc_html( $settings['split_subtitle'] ); ?></p>
												</div>
												<ul id="signa-prev-split-features" style="list-style:none;margin:20px 0 0 0;padding:16px 0 0 0;border-top:1px solid rgba(255,255,255,0.16);display:flex;flex-direction:column;gap:8px;font-size:12.5px;color:inherit;opacity:0.95;transition:color 0.42s ease;">
													<?php foreach ( $split_features_list as $feat_line ) : ?>
														<li style="display:flex;align-items:center;gap:8px;margin:0;">
															<span style="display:inline-flex;width:18px;height:18px;border-radius:50%;background:rgba(16,185,129,0.28);color:#6ee7b7;align-items:center;justify-content:center;flex-shrink:0;">✓</span>
															<span><?php echo esc_html( $feat_line ); ?></span>
														</li>
													<?php endforeach; ?>
												</ul>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
					jQuery(function($){
						var currentPreviewMode = 'page';
						var imgLuminanceCache = {};

						// 1. Keep Sticky Preview Box Completely Visible Below Sticky Topbar on Scroll/Resize
						function syncStickyPreviewOffset() {
							var wpBarH = ($('#wpadminbar').length && $('#wpadminbar').is(':visible')) ? ($('#wpadminbar').outerHeight() || 32) : 0;
							var topbarH = $('.signa-topbar').length ? ($('.signa-topbar').outerHeight() || 76) : 76;
							var safeTop = Math.max(118, Math.round(wpBarH + topbarH + 16));
							$('.signa-studio-preview-col').each(function(){
								this.style.setProperty('position', 'sticky', 'important');
								this.style.setProperty('top', safeTop + 'px', 'important');
							});
						}
						$(window).on('scroll resize', syncStickyPreviewOffset);
						setTimeout(syncStickyPreviewOffset, 60);
						syncStickyPreviewOffset();

						// 2. Exclusive Collapsible Accordion Cards (Closed by default; clicking one opens it and closes others)
						$(document).off('click.signaAccordion').on('click.signaAccordion', '.signa-accordion-trigger', function(e){
							e.preventDefault();
							var $card = $(this).closest('.signa-accordion-card');
							var $body = $card.children('.signa-accordion-body');
							var isAlreadyOpen = $card.hasClass('is-open');

							// Close all other open accordion cards first
							$('.signa-accordion-card.is-open').not($card).each(function(){
								$(this).removeClass('is-open').children('.signa-accordion-body').stop(true, true).slideUp(220);
							});

							if (isAlreadyOpen) {
								$card.removeClass('is-open');
								$body.stop(true, true).slideUp(220);
							} else {
								$card.addClass('is-open');
								$body.stop(true, true).slideDown(240, function(){
									syncStickyPreviewOffset();
									var wpBarH = ($('#wpadminbar').length && $('#wpadminbar').is(':visible')) ? ($('#wpadminbar').outerHeight() || 32) : 0;
									var topbarH = $('.signa-topbar').length ? ($('.signa-topbar').outerHeight() || 76) : 76;
									var minVisibleTop = wpBarH + topbarH + 14;
									var cardRect = $card[0].getBoundingClientRect();
									if (cardRect.top < minVisibleTop) {
										window.scrollTo({
											top: window.pageYOffset + cardRect.top - minVisibleTop,
											behavior: 'smooth'
										});
									}
								});
							}
						});

						function parseHexRgb(hex){
							var c = String(hex || '#ffffff').replace('#','').trim();
							if(c.length === 3){ c = c[0]+c[0]+c[1]+c[1]+c[2]+c[2]; }
							return {
								r: isNaN(parseInt(c.substring(0,2),16)) ? 255 : parseInt(c.substring(0,2),16),
								g: isNaN(parseInt(c.substring(2,4),16)) ? 255 : parseInt(c.substring(2,4),16),
								b: isNaN(parseInt(c.substring(4,6),16)) ? 255 : parseInt(c.substring(4,6),16)
							};
						}

						function hexRgba(hex, pct){
							var rgb = parseHexRgb(hex);
							var a = Math.max(0.12, Math.min(1, (parseFloat(pct)||100)/100));
							return 'rgba('+rgb.r+', '+rgb.g+', '+rgb.b+', '+a+')';
						}

						// Relative perceived luminance (0.0 = pitch black, 1.0 = pure white)
						function hexLuminance(hex){
							var rgb = parseHexRgb(hex);
							return (0.299 * rgb.r + 0.587 * rgb.g + 0.114 * rgb.b) / 255;
						}

						// Sample average image luminance asynchronously (with CORS/fallback detection)
						function sampleImageLuminance(url, cb){
							var cleanUrl = String(url || '').trim();
							if (!cleanUrl) { cb(null); return; }
							if (typeof imgLuminanceCache[cleanUrl] === 'number') {
								cb(imgLuminanceCache[cleanUrl]);
								return;
							}
							var img = new Image();
							img.crossOrigin = 'anonymous';
							img.onload = function(){
								try {
									var cv = document.createElement('canvas');
									cv.width = 24;
									cv.height = 24;
									var ctx = cv.getContext('2d');
									ctx.drawImage(img, 0, 0, 24, 24);
									var data = ctx.getImageData(0, 0, 24, 24).data;
									var sum = 0, count = 0;
									for (var i = 0; i < data.length; i += 4) {
										sum += (0.299 * data[i] + 0.587 * data[i+1] + 0.114 * data[i+2]) / 255;
										count++;
									}
									var lum = count > 0 ? (sum / count) : 0.35;
									imgLuminanceCache[cleanUrl] = lum;
									cb(lum);
								} catch (err) {
									// External URL without CORS headers: treat custom image with dark overlay as dark (0.28)
									imgLuminanceCache[cleanUrl] = 0.28;
									cb(0.28);
								}
							};
							img.onerror = function(){
								imgLuminanceCache[cleanUrl] = 0.28;
								cb(0.28);
							};
							img.src = cleanUrl;
						}

						function syncStudioCat2(e){
							var triggeredById = (e && e.target && e.target.id) ? e.target.id : '';
							var primary = $('#primary_color').val() || '#2563eb';
							var secondary = $('#secondary_color').val() || '#4f46e5';
							var btnBgMode = $('#button_bg_mode').val() || 'solid';
							var bg = $('#card_bg_color').val() || '#ffffff';
							var text = $('#text_color').val() || '#111827';
							var radius = $('#border_radius').val() || 16;
							var isGlass = $('#glassmorphism').is(':checked');
							var cardOpacity = parseFloat($('#card_bg_opacity').val() || 85);
							var blurPx = parseFloat($('#backdrop_blur').val() || 16);
							var cardShadow = $('#card_shadow').val() || 'medium';
							var cardBorder = $('#card_border_style').val() || 'subtle';
							var cardPadding = $('#card_padding').val() || 32;
							var bgPattern = $('input[name="signa[bg_pattern]"]:checked').val() || 'none';
							var canvasBgStyle = $('#canvas_bg_style').val() || 'mesh_light';
							var canvasBgColor = $('#canvas_bg_color').val() || '#f1f5f9';
							var canvasBgImg = ($('#canvas_bg_image').val() || '').trim();
							var splitBgColor = $('#split_bg_color').val() || '#1e3a8a';
							var splitImgUrl = ($('#split_image_url').val() || '').trim();
							var formLayout = $('input[name="signa[form_layout]"]:checked').val() || 'card';
							var cardPosition = $('input[name="signa[card_position]"]:checked').val() || 'center';
							var modalStyle = $('input[name="signa[modal_style]"]:checked').val() || 'center';

							// Category 3 values
							var fontKey = $('#font_family').val() || 'vazirmatn';
							var titleSize = parseFloat($('#title_font_size').val() || 20);
							var subSize = parseFloat($('#subtitle_font_size').val() || 14);
							var btnSize = parseFloat($('#btn_font_size').val() || 15);
							var inputStyle = $('input[name="signa[input_style]"]:checked').val() || 'filled';
							var inputHeight = parseFloat($('#input_height').val() || 48);
							var inputBg = $('#input_bg_color').val() || '#f8fafc';
							var inputBorder = $('#input_border_color').val() || '#d1d5db';
							var inputAddon = $('#input_addon_style').val() || 'icon';

							// Category 4 values
							var digitStyle = $('input[name="signa[digit_box_style]"]:checked').val() || $('#digit_box_style').val() || 'box';
							var digitSize = parseFloat($('#digit_box_size').val() || 48);
							var digitGap = parseFloat($('#digit_box_gap').val() || 8);
							var timerStyle = $('input[name="signa[timer_style]"]:checked').val() || 'progress_bar';

							var isSplit = (formLayout === 'split_right' || formLayout === 'split_left');
							var isDrawerOrSheet = (currentPreviewMode === 'modal' && (modalStyle === 'drawer_left' || modalStyle === 'drawer_right' || modalStyle === 'bottom_sheet'));
							var showSplitBanner = isSplit && !isDrawerOrSheet;

							// Automatically widen preview column slightly when Split-Screen is active so both columns fit inside 100% of the canvas without overflowing
							$('.signa-studio-layout').toggleClass('is-split-preview-active', showSplitBanner);

							// 4. Smart Automatic Dark/Light Theme & Image Contrast Detection
							var cardLum = hexLuminance(bg);
							var canvasLum = 0.85;
							if (canvasBgStyle === 'mesh_dark') {
								canvasLum = 0.08;
							} else if (canvasBgStyle === 'solid') {
								canvasLum = hexLuminance(canvasBgColor);
							} else if (canvasBgStyle === 'custom_image' && canvasBgImg) {
								if (typeof imgLuminanceCache[canvasBgImg] === 'number') {
									canvasLum = imgLuminanceCache[canvasBgImg] * 0.55;
								} else {
									canvasLum = 0.25;
									sampleImageLuminance(canvasBgImg, function(){ syncStudioCat2(); });
								}
							} else {
								canvasLum = (hexLuminance(canvasBgColor) * 0.65) + 0.30;
							}

							var alpha = isGlass ? Math.max(0.15, Math.min(1, cardOpacity / 100)) : 1;
							var effectiveFormLum = isGlass ? ((cardLum * alpha) + (canvasLum * (1 - alpha))) : cardLum;

							// Also if Glassmorphism is active over a dark canvas/image (canvasLum < 0.42) or user uploaded a dark canvas image
							var isDarkFormSurface = (cardLum < 0.48) || (isGlass && (effectiveFormLum < 0.52 || canvasLum < 0.42));

							// Automatically transition text color between white (#f8fafc) and dark (#111827) unless user is manually dragging #text_color right now
							if (triggeredById !== 'text_color') {
								var targetTextColor = isDarkFormSurface ? '#f8fafc' : '#111827';
								if (text.toLowerCase() !== targetTextColor) {
									text = targetTextColor;
									$('#text_color').val(targetTextColor);
									$('#text_color_hex').text(targetTextColor);
								}
								// Also adapt input background/border for dark vs light surface if not manually editing input colors right now
								if (triggeredById !== 'input_bg_color' && triggeredById !== 'input_border_color') {
									if (isDarkFormSurface && hexLuminance(inputBg) > 0.7) {
										inputBg = '#1e293b';
										inputBorder = '#475569';
										$('#input_bg_color').val(inputBg);
										$('#input_border_color').val(inputBorder);
									} else if (!isDarkFormSurface && inputBg.toLowerCase() === '#1e293b') {
										inputBg = '#f8fafc';
										inputBorder = '#d1d5db';
										$('#input_bg_color').val(inputBg);
										$('#input_border_color').val(inputBorder);
									}
								}
							}

							// Update Smart Contrast Status Badge
							var $contrastBadge = $('#signa-auto-contrast-badge');
							if ($contrastBadge.length) {
								if (isDarkFormSurface) {
									$contrastBadge.text('تم تیره • متن سفید خودکار').css({ background: 'rgba(15, 23, 42, 0.88)', color: '#f8fafc' });
								} else {
									$contrastBadge.text('تم روشن • متن تیره خودکار').css({ background: 'rgba(37, 99, 235, 0.12)', color: '#2563eb' });
								}
							}

							// Also check Split-Screen Banner Image/Background Luminance for automatic text contrast
							var splitLum = hexLuminance(splitBgColor);
							if (splitImgUrl) {
								if (typeof imgLuminanceCache[splitImgUrl] === 'number') {
									splitLum = imgLuminanceCache[splitImgUrl] * 0.55;
								} else {
									splitLum = 0.25;
									sampleImageLuminance(splitImgUrl, function(){ syncStudioCat2(); });
								}
							}
							var splitTextColor = splitLum < 0.52 ? '#ffffff' : '#0f172a';
							$('#signa-prev-split-banner').css('color', splitTextColor);
							$('#signa-prev-split-title, #signa-prev-split-subtitle, #signa-prev-split-features').css('color', splitTextColor);

							$('#secondary_color_hex').text(secondary);
							$('#opacity_val_label').text(cardOpacity + '%');
							$('#blur_val_label').text(blurPx + 'px');
							$('#padding_val_label').text(cardPadding + 'px');
							$('#title_size_val_label').text(titleSize + 'px');
							$('#subtitle_size_val_label').text(subSize + 'px');
							$('#btn_size_val_label').text(btnSize + 'px');
							$('#input_height_val_label').text(inputHeight + 'px');
							$('#input_bg_color_hex').text(inputBg);
							$('#input_border_color_hex').text(inputBorder);
							$('#digit_size_val_label').text(digitSize + 'px');
							$('#digit_gap_val_label').text(digitGap + 'px');

							if (isGlass) { $('#signa-glassmorphism-controls').slideDown(180); } else { $('#signa-glassmorphism-controls').slideUp(180); }
							$('#signa-secondary-color-wrap').css('opacity', btnBgMode === 'gradient' ? '1' : '0.65');

							// Show vibrant ambient orbs behind card so Glassmorphism backdrop-filter blur is unmistakably visible
							$('#signa-prev-glass-orbs').toggleClass('is-glass-active', isGlass);
							$('#signa-prev-glass-orbs .orb-1').css('background', primary);
							$('#signa-prev-glass-orbs .orb-2').css('background', secondary);

							var canvasBgCss = '';
							if (canvasBgStyle === 'mesh_dark') {
								canvasBgCss = 'radial-gradient(circle at top right, #1e1b4b 0%, #0f172a 60%, #020617 100%)';
							} else if (canvasBgStyle === 'brand_gradient') {
								canvasBgCss = 'linear-gradient(135deg, ' + primary + '26 0%, #f8fafc 60%, ' + secondary + '1f 100%)';
							} else if (canvasBgStyle === 'custom_image' && canvasBgImg) {
								canvasBgCss = 'linear-gradient(rgba(15,23,42,0.45), rgba(15,23,42,0.45)), url(' + canvasBgImg + ') center/cover no-repeat';
							} else if (canvasBgStyle === 'solid') {
								canvasBgCss = canvasBgColor;
							} else {
								canvasBgCss = 'radial-gradient(circle at top right, #e0e7ff 0%, ' + canvasBgColor + ' 65%)';
							}
							var patternLayer = '', patternSize = 'auto';
							if (bgPattern === 'dots') {
								patternLayer = 'radial-gradient(rgba(99, 102, 241, 0.22) 1.25px, transparent 1.25px), ';
								patternSize = '18px 18px, auto';
							} else if (bgPattern === 'grid') {
								patternLayer = 'linear-gradient(to right, rgba(148, 163, 184, 0.16) 1px, transparent 1px), linear-gradient(to bottom, rgba(148, 163, 184, 0.16) 1px, transparent 1px), ';
								patternSize = '22px 22px, 22px 22px, auto';
							} else if (bgPattern === 'waves') {
								patternLayer = 'repeating-radial-gradient(circle at 0 0, transparent 0, rgba(99, 102, 241, 0.07) 12px, transparent 24px), ';
							} else if (bgPattern === 'geometric') {
								patternLayer = 'linear-gradient(30deg, rgba(99, 102, 241, 0.08) 12%, transparent 12.5%, transparent 87%, rgba(99, 102, 241, 0.08) 87.5%), ';
								patternSize = '28px 48px, auto';
							}

							var alignFlex = cardPosition === 'right' ? 'flex-start' : cardPosition === 'left' ? 'flex-end' : 'center';
							var $canvas = $('#signa-preview-canvas');
							var $viewport = $('#signa-preview-viewport');

							$canvas.removeClass('is-modal-mode sim-center sim-drawer_left sim-drawer_right sim-bottom_sheet');
							if (currentPreviewMode === 'modal') {
								$canvas.addClass('is-modal-mode sim-' + modalStyle);
							}

							$canvas.css({
								alignItems: alignFlex,
								background: patternLayer + canvasBgCss,
								backgroundSize: patternSize
							});

							$viewport.toggleClass('is-scaled-split', showSplitBanner);
							$viewport.css('alignItems', alignFlex);

							var shadowCss = '0 14px 32px -6px rgba(15, 23, 42, 0.12)';
							if (cardShadow === 'none') shadowCss = 'none';
							else if (cardShadow === 'soft') shadowCss = '0 4px 16px -2px rgba(15, 23, 42, 0.06)';
							else if (cardShadow === 'deep') shadowCss = '0 26px 58px -10px rgba(15, 23, 42, 0.28), 0 10px 24px -6px rgba(15, 23, 42, 0.14)';
							else if (cardShadow === 'glow') shadowCss = '0 0 34px -2px ' + hexRgba(primary, 45) + ', 0 12px 28px -6px rgba(15, 23, 42, 0.16)';

							var borderCss = '1px solid rgba(156, 163, 175, 0.25)', borderTopCss = borderCss;
							if (cardBorder === 'none') { borderCss = 'none'; borderTopCss = 'none'; }
							else if (cardBorder === 'glow') { borderCss = '1.5px solid ' + hexRgba(primary, 65); borderTopCss = borderCss; }
							else if (cardBorder === 'top_accent') { borderTopCss = '4px solid ' + primary; }

							var $shell = $('#signa-live-preview-shell');
							$shell.toggleClass('is-split', showSplitBanner);
							var shellDom = document.getElementById('signa-live-preview-shell');
							if (shellDom) {
								shellDom.style.setProperty('width', '100%', 'important');
								shellDom.style.setProperty('max-width', showSplitBanner ? '100%' : '340px', 'important');
								shellDom.style.setProperty('box-sizing', 'border-box', 'important');
								shellDom.style.setProperty('transform', 'none', 'important');
								shellDom.style.setProperty('margin', '0', 'important');
								shellDom.style.setProperty('flex-direction', formLayout === 'split_left' ? 'row-reverse' : 'row', 'important');
								shellDom.style.setProperty('box-shadow', shadowCss, 'important');
								shellDom.style.setProperty('border', borderCss, 'important');
								shellDom.style.setProperty('border-top', borderTopCss, 'important');
								shellDom.style.setProperty('background', 'transparent', 'important');
							}
							$('#signa-prev-split-banner').toggle(showSplitBanner);

							// 3. Apply Glassmorphism Backdrop Blur directly via native setProperty (with dark glass adaptation if background is dark)
							var effectiveCardBgHex = (isGlass && isDarkFormSurface && cardLum > 0.7) ? '#0f172a' : bg;
							var effectiveGlassOpacity = isGlass ? Math.min(cardOpacity, 88) : 100;
							var cardBgValue = isGlass ? hexRgba(effectiveCardBgHex, effectiveGlassOpacity) : bg;
							var blurValue = isGlass ? ('blur(' + blurPx + 'px) saturate(160%)') : 'none';
							var previewScaleFactor = showSplitBanner ? 0.62 : 0.85;

							var cardEl = document.getElementById('signa-live-preview-card');
							if (cardEl) {
								cardEl.style.setProperty('background', cardBgValue, 'important');
								cardEl.style.setProperty('backdrop-filter', blurValue, 'important');
								cardEl.style.setProperty('-webkit-backdrop-filter', blurValue, 'important');
								cardEl.style.setProperty('color', text, 'important');
								cardEl.style.setProperty('padding', Math.round(cardPadding * previewScaleFactor) + 'px', 'important');
							}

							var splitBannerEl = document.getElementById('signa-prev-split-banner');
							if (splitBannerEl && showSplitBanner) {
								splitBannerEl.style.setProperty('padding', Math.round(cardPadding * previewScaleFactor) + 'px', 'important');
							}

							// Ensure title, subtitle, and labels smoothly fade to the detected text color
							$('#signa-prev-title, #signa-prev-subtitle, #signa-prev-field-label').css('color', text);

							// Category 3: Apply Typography & Input Field Style in Live Preview
							var fontMap = {
								vazirmatn: "'Vazirmatn', Tahoma, sans-serif",
								iransans: "'IRANSansX', 'IRANSans', 'Vazirmatn', Tahoma, sans-serif",
								yekanbakh: "'YekanBakh', 'IRANYekan', 'Vazirmatn', Tahoma, sans-serif",
								dana: "'Dana', 'Anjoman', 'Vazirmatn', Tahoma, sans-serif",
								estedad: "'Estedad', 'Shabnam', 'Vazirmatn', Tahoma, sans-serif",
								theme_inherit: "inherit"
							};
							var activeFont = fontMap[fontKey] || fontMap.vazirmatn;
							$('#signa-live-preview-shell, #signa-live-preview-shell *').css('font-family', activeFont);
							var previewTitleSize = showSplitBanner ? Math.max(13, Math.round(titleSize * 0.78)) : titleSize;
							var previewSubSize = showSplitBanner ? Math.max(10.5, Math.round(subSize * 0.82)) : subSize;
							var previewBtnSize = showSplitBanner ? Math.max(12, Math.round(btnSize * 0.84)) : btnSize;
							var previewInputH = showSplitBanner ? Math.max(36, Math.round(inputHeight * 0.82)) : inputHeight;

							$('#signa-prev-title').css('font-size', previewTitleSize + 'px');
							$('#signa-prev-subtitle').css('font-size', previewSubSize + 'px');

							var $prevInput = $('#signa-live-preview-card input.signa-prev-input');
							var inputRad = inputStyle === 'soft_pill' ? '99px' : inputStyle === 'underlined' ? '0' : Math.round(radius * 0.68) + 'px';
							var btnRad = inputStyle === 'soft_pill' ? '99px' : Math.round(radius * 0.68) + 'px';

							if ($prevInput.length) {
								if (inputStyle === 'underlined') {
									$prevInput[0].style.setProperty('background-color', 'transparent', 'important');
									$prevInput[0].style.setProperty('border', 'none', 'important');
									$prevInput[0].style.setProperty('border-bottom', '2.5px solid ' + primary, 'important');
									$prevInput[0].style.setProperty('border-radius', '0', 'important');
								} else if (inputStyle === 'outlined') {
									$prevInput[0].style.setProperty('background-color', 'transparent', 'important');
									$prevInput[0].style.setProperty('border', '1.5px solid ' + inputBorder, 'important');
									$prevInput[0].style.setProperty('border-radius', inputRad, 'important');
								} else {
									$prevInput[0].style.setProperty('background-color', inputBg, 'important');
									$prevInput[0].style.setProperty('border', '1.5px solid ' + inputBorder, 'important');
									$prevInput[0].style.setProperty('border-radius', inputRad, 'important');
								}
								$prevInput[0].style.setProperty('color', text, 'important');
								$prevInput[0].style.setProperty('height', previewInputH + 'px', 'important');
							}

							var $addon = $('#signa-prev-input-addon');
							if (inputAddon === 'ir_flag') {
								$addon.html('<span style="font-size:13px;">🇮🇷</span><span>+98</span>').show();
								if ($prevInput.length) $prevInput[0].style.setProperty('padding-left', '56px', 'important');
							} else if (inputAddon === 'icon') {
								$addon.html('<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>').show();
								if ($prevInput.length) $prevInput[0].style.setProperty('padding-left', '38px', 'important');
							} else {
								$addon.hide();
								if ($prevInput.length) $prevInput[0].style.setProperty('padding-left', '14px', 'important');
							}
							$addon.css('color', isDarkFormSurface ? '#cbd5e1' : '#64748b');

							var btnBg = btnBgMode === 'gradient' ? 'linear-gradient(135deg, ' + primary + ', ' + secondary + ')' : primary;
							$('#signa-prev-btn-1, #signa-prev-btn-2').css({
								background: btnBg,
								borderRadius: btnRad,
								height: previewInputH + 'px',
								fontSize: previewBtnSize + 'px'
							});

							// Category 4: Sync OTP Digit Boxes & Countdown Timer in Step 2
							var scaledDigitSize = showSplitBanner ? Math.max(30, Math.round(digitSize * 0.72)) : Math.round(digitSize * 0.88);
							var scaledDigitGap = showSplitBanner ? Math.max(3, Math.round(digitGap * 0.65)) : digitGap;
							var $digitsWrap = $('#signa-prev-digits');
							var $digits = $('.signa-prev-digit');

							if (digitStyle === 'connected') {
								$digitsWrap.css({
									gap: '0px',
									border: '1.5px solid ' + inputBorder,
									borderRadius: Math.round(radius * 0.55) + 'px',
									overflow: 'hidden',
									background: inputBg,
									display: 'inline-flex',
									width: '100%'
								});
								$digits.each(function(idx){
									$(this).css({
										flex: '1',
										width: 'auto',
										height: scaledDigitSize + 'px',
										lineHeight: scaledDigitSize + 'px',
										border: 'none',
										borderRight: idx < 4 ? ('1px solid ' + inputBorder) : 'none',
										borderRadius: '0',
										background: idx === 2 ? hexRgba(primary, 14) : 'transparent',
										color: idx === 2 ? primary : text,
										boxShadow: 'none',
										fontSize: Math.round(scaledDigitSize * 0.4) + 'px'
									});
								});
							} else {
								$digitsWrap.css({
									gap: scaledDigitGap + 'px',
									border: 'none',
									borderRadius: '0',
									overflow: 'visible',
									background: 'transparent',
									display: 'flex',
									width: '100%'
								});
								$digits.each(function(idx){
									var isFocusIdx = (idx === 2);
									if (digitStyle === 'underline') {
										$(this).css({
											flex: '0 0 auto',
											width: Math.round(scaledDigitSize * 0.86) + 'px',
											height: scaledDigitSize + 'px',
											lineHeight: scaledDigitSize + 'px',
											border: 'none',
											borderBottom: '2.5px solid ' + (isFocusIdx ? primary : inputBorder),
											borderRadius: '0',
											background: 'transparent',
											color: text,
											boxShadow: 'none',
											fontSize: Math.round(scaledDigitSize * 0.42) + 'px'
										});
									} else if (digitStyle === 'pill') {
										$(this).css({
											flex: '0 0 auto',
											width: Math.round(scaledDigitSize * 0.88) + 'px',
											height: scaledDigitSize + 'px',
											lineHeight: scaledDigitSize + 'px',
											border: '1.5px solid ' + (isFocusIdx ? primary : inputBorder),
											borderRadius: '99px',
											background: inputBg,
											color: text,
											boxShadow: isFocusIdx ? ('0 0 0 3px ' + hexRgba(primary, 20)) : 'none',
											fontSize: Math.round(scaledDigitSize * 0.4) + 'px'
										});
									} else if (digitStyle === 'separated_glow') {
										$(this).css({
											flex: '0 0 auto',
											width: Math.round(scaledDigitSize * 0.88) + 'px',
											height: scaledDigitSize + 'px',
											lineHeight: scaledDigitSize + 'px',
											border: '1.5px solid ' + primary,
											borderRadius: Math.round(radius * 0.5) + 'px',
											background: hexRgba(primary, isDarkFormSurface ? 18 : 10),
											color: text,
											boxShadow: '0 0 12px ' + hexRgba(primary, isFocusIdx ? 55 : 28),
											fontSize: Math.round(scaledDigitSize * 0.4) + 'px'
										});
									} else {
										$(this).css({
											flex: '0 0 auto',
											width: Math.round(scaledDigitSize * 0.88) + 'px',
											height: scaledDigitSize + 'px',
											lineHeight: scaledDigitSize + 'px',
											border: '1.5px solid ' + (isFocusIdx ? primary : inputBorder),
											borderRadius: Math.round(radius * 0.5) + 'px',
											background: inputBg,
											color: text,
											boxShadow: isFocusIdx ? ('0 0 0 3px ' + hexRgba(primary, 18)) : 'none',
											fontSize: Math.round(scaledDigitSize * 0.4) + 'px'
										});
									}
								});
							}

							// Render Live Countdown Timer Preview in Step 2
							var $timerBox = $('#signa-prev-timer-box');
							if (timerStyle === 'circular_ring') {
								$timerBox.html(
									'<div style="display:inline-flex;align-items:center;gap:8px;padding:5px 14px;border-radius:99px;background:' + hexRgba(primary, 12) + ';border:1px solid ' + hexRgba(primary, 30) + ';color:' + text + ';font-size:11.5px;font-weight:700;">' +
									'<svg width="20" height="20" viewBox="0 0 24 24" style="transform:rotate(-90deg);flex-shrink:0;"><circle cx="12" cy="12" r="9" fill="none" stroke="rgba(148,163,184,0.28)" stroke-width="2.5"/><circle cx="12" cy="12" r="9" fill="none" stroke="' + primary + '" stroke-width="2.5" stroke-dasharray="56.5" stroke-dashoffset="16" stroke-linecap="round"/></svg>' +
									'<span>ارسال مجدد کد: <strong dir="ltr" style="color:' + primary + ';">01:45</strong></span>' +
									'</div>'
								);
							} else if (timerStyle === 'minimal_badge') {
								$timerBox.html(
									'<div style="display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:99px;background:' + hexRgba(primary, 12) + ';color:' + primary + ';font-size:11.5px;font-weight:700;">' +
									'<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>' +
									'<span>ارسال مجدد تا ۰۱:۴۵ دیگر</span>' +
									'</div>'
								);
							} else if (timerStyle === 'simple_text') {
								$timerBox.html(
									'<div style="font-size:11.5px;opacity:0.8;color:' + text + ';font-weight:600;">ارسال مجدد کد تا <strong style="color:' + primary + ';">۰۱:۴۵</strong> دیگر</div>'
								);
							} else {
								$timerBox.html(
									'<div style="display:flex;flex-direction:column;gap:5px;align-items:center;">' +
									'<span style="font-size:11.5px;opacity:0.85;color:' + text + ';font-weight:600;">ارسال مجدد کد تا <strong style="color:' + primary + ';">۰۱:۴۵</strong> دیگر</span>' +
									'<div style="width:100%;height:5px;border-radius:99px;background:rgba(148,163,184,0.22);overflow:hidden;">' +
									'<div style="width:68%;height:100%;border-radius:99px;background:' + btnBg + ';"></div>' +
									'</div></div>'
								);
							}
						}

						// Mode Tabs (Page vs Modal Simulation)
						$('.signa-prev-mode-btn').on('click', function(){
							currentPreviewMode = $(this).attr('data-mode') || 'page';
							$('.signa-prev-mode-btn').removeClass('active');
							$(this).addClass('active');
							syncStudioCat2();
						});

						// Auto-switch Live Preview to Modal mode when user selects a Modal/Drawer style
						$('input[name="signa[modal_style]"]').on('change', function(){
							currentPreviewMode = 'modal';
							$('.signa-prev-mode-btn').removeClass('active');
							$('.signa-prev-mode-btn[data-mode="modal"]').addClass('active');
							syncStudioCat2();
						});

						// Auto-switch Live Preview to Page mode when user changes Form Layout or Card Position
						$('input[name="signa[form_layout]"], input[name="signa[card_position]"], #canvas_bg_style, input[name="signa[bg_pattern]"]').on('change', function(){
							currentPreviewMode = 'page';
							$('.signa-prev-mode-btn').removeClass('active');
							$('.signa-prev-mode-btn[data-mode="page"]').addClass('active');
							syncStudioCat2();
						});

						// Auto-switch Live Preview to Step 2 when user changes any Category 4 OTP/Timer control
						$(document).on('input change', '.signa-cat4-control', function(){
							$('.signa-prev-step-btn').removeClass('active');
							$('.signa-prev-step-btn[data-step="2"]').addClass('active');
							$('#signa-prev-step-1').hide();
							$('#signa-prev-step-2').fadeIn(150);
							syncStudioCat2();
						});

						// Replay Form Entrance Animation in Live Preview when changed
						$('#form_animation').on('change', function(){
							var anim = $(this).val() || 'fade_up';
							var $card = $('#signa-live-preview-card');
							$card.removeClass('signa-anim-fade_up signa-anim-zoom_spring signa-anim-slide_rtl');
							if (anim !== 'none') {
								void $card[0].offsetWidth;
								$card.addClass('signa-anim-' + anim);
							}
						});

						// Live Error Shake Effect Test Button in Preview
						$('#signa-test-shake-btn').on('click', function(){
							$('.signa-prev-step-btn').removeClass('active');
							$('.signa-prev-step-btn[data-step="2"]').addClass('active');
							$('#signa-prev-step-1').hide();
							$('#signa-prev-step-2').show();
							var $digits = $('#signa-prev-digits');
							$digits.removeClass('signa-shake-anim');
							void $digits[0].offsetWidth;
							$digits.addClass('signa-shake-anim');
							$('.signa-prev-digit').css({ borderColor: '#ef4444', color: '#ef4444' });
							setTimeout(function(){
								$digits.removeClass('signa-shake-anim');
								syncStudioCat2();
							}, 750);
						});

						// When user adjusts Glassmorphism blur or opacity slider, auto-Lower opacity slightly if it was 100% so blur is immediately visible
						$('#backdrop_blur').on('input change', function(){
							if (!$('#glassmorphism').is(':checked')) {
								$('#glassmorphism').prop('checked', true);
							}
							var curOp = parseFloat($('#card_bg_opacity').val() || 85);
							if (curOp > 82) {
								$('#card_bg_opacity').val(68);
							}
							syncStudioCat2();
						});

						// Toggle Wide Preview Column
						$('#signa-prev-expand-btn').on('click', function(){
							$(this).toggleClass('active');
							$('.signa-studio-layout').toggleClass('is-wide-preview');
						});

						$('#signa-tab-appearance_studio').on('input change', 'input, select, textarea', syncStudioCat2);
						syncStudioCat2();
					});
					</script>
				</section>
