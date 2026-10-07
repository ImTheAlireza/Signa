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
							<div class="signa-card" style="margin-bottom:20px;">
								<div class="signa-card-head">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-blue">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/></svg>
										</span>
										<div>
											<h2>۱. چیدمان و اسکلت صفحه ورود (Layout &amp; Alignment)</h2>
											<p>انتخاب حالت کارت تکی یا لی‌اوت دوتایی (Split-Screen) به همراه موقعیت قرارگیری در صفحه</p>
										</div>
									</div>
									<span class="signa-pill is-info">پیش‌نمایش زنده</span>
								</div>

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

							<!-- CARD 2: Slide-Over Drawer Modal & Standalone Full-Page Canvas -->
							<div class="signa-card" style="margin-bottom:20px;">
								<div class="signa-card-head">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-green">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18"/></svg>
										</span>
										<div>
											<h2>۲. استایل پاپ‌آپ (Drawer / Modal) و قالب تمام‌صفحه اختصاصی</h2>
											<p>تنظیم نحوه باز شدن مودال ورود (با کلیک روی هر گزینه، انیمیشن آن در پیش‌نمایش زنده اجرا می‌شود)</p>
										</div>
									</div>
								</div>

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

							<!-- CARD 2.5 (CATEGORY 2): Glassmorphism, Shadows, Borders, Gradients & SVG Background Patterns -->
							<div class="signa-card" style="margin-bottom:20px;">
								<div class="signa-card-head">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-amber">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
										</span>
										<div>
											<h2>۳. استایل کارت، افکت شیشه‌ای (Glassmorphism) و سایه‌ها</h2>
											<p>شخصی‌سازی افکت شیشه‌ای مات، عمق سایه، کادر دور کارت، گرادینت دکمه و پترن گرافیکی پس‌زمینه</p>
										</div>
									</div>
									<span class="signa-pill is-ok">افکت‌های مدرن</span>
								</div>

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

							<!-- CARD 3: Color Presets, Card Colors & Dimensions -->
							<div class="signa-card">
								<div class="signa-card-head">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-purple">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
										</span>
										<div>
											<h2>۴. پالت‌های رنگی و تم‌های آماده (Presets)</h2>
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

							<!-- CARD 4: Form Texts & Custom CSS -->
							<div class="signa-card" style="margin-top:20px;">
								<div class="signa-card-head">
									<div class="signa-card-head-title">
										<span class="signa-card-icon is-blue">
											<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
										</span>
										<div>
											<h2>۵. متن‌ها و برچسب‌های فرم</h2>
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

								<div class="signa-preview-canvas" id="signa-preview-canvas" style="display:flex;flex-direction:column;align-items:<?php echo 'right' === $card_position ? 'flex-start' : ( 'left' === $card_position ? 'flex-end' : 'center' ); ?>;transition:all 0.25s ease;">

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
										<div id="signa-live-preview-shell" class="signa-prev-shell <?php echo $is_split ? 'is-split' : ''; ?> <?php echo 'split_left' === $form_layout ? 'is-split-left' : ''; ?>" style="width:100%;max-width:<?php echo $is_split ? '720px' : '360px'; ?>;border-radius:<?php echo esc_attr( (string) $settings['border_radius'] ); ?>px;overflow:hidden;box-shadow:0 16px 36px -8px rgba(15,23,42,0.16);display:flex;flex-direction:<?php echo 'split_left' === $form_layout ? 'row-reverse' : 'row'; ?>;transition:all 0.25s ease;">

											<!-- Form Column -->
											<div id="signa-live-preview-card" class="signa-prev-card" style="flex:1;min-width:0;margin:0;box-shadow:none;background:<?php echo esc_attr( $settings['card_bg_color'] ); ?>;color:<?php echo esc_attr( $settings['text_color'] ); ?>;border-radius:0;">
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
													<h3 id="signa-prev-title" style="margin:0 0 6px 0;font-size:17px;color:inherit;"><?php echo esc_html( $settings['form_title'] ); ?></h3>
													<p id="signa-prev-subtitle" style="margin:0;font-size:12.5px;opacity:0.78;line-height:1.6;"><?php echo esc_html( $settings['form_subtitle'] ); ?></p>
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

											<!-- Split-Screen Side Banner Preview Column -->
											<div id="signa-prev-split-banner" style="<?php echo $is_split ? 'display:flex;' : 'display:none;'; ?>flex:1;min-width:0;padding:28px 24px;flex-direction:column;justify-content:space-between;color:#ffffff;background-color:<?php echo esc_attr( $settings['split_bg_color'] ); ?>;background-image:<?php echo ! empty( $settings['split_image_url'] ) ? 'linear-gradient(135deg, rgba(15,23,42,0.72), rgba(30,58,138,0.78)), url(' . esc_url( $settings['split_image_url'] ) . ')' : 'radial-gradient(circle at top left, rgba(255,255,255,0.16), transparent 65%)'; ?>;background-size:cover;background-position:center;">
												<div>
													<span id="signa-prev-split-badge" style="display:inline-block;padding:4px 12px;border-radius:99px;font-size:11.5px;font-weight:700;background:rgba(255,255,255,0.18);backdrop-filter:blur(4px);margin-bottom:14px;"><?php echo esc_html( $settings['split_badge_text'] ); ?></span>
													<h4 id="signa-prev-split-title" style="margin:0 0 10px 0;font-size:18px;font-weight:800;color:#ffffff;line-height:1.45;"><?php echo esc_html( $settings['split_title'] ); ?></h4>
													<p id="signa-prev-split-subtitle" style="margin:0;font-size:13px;color:rgba(255,255,255,0.88);line-height:1.75;"><?php echo esc_html( $settings['split_subtitle'] ); ?></p>
												</div>
												<ul id="signa-prev-split-features" style="list-style:none;margin:20px 0 0 0;padding:16px 0 0 0;border-top:1px solid rgba(255,255,255,0.16);display:flex;flex-direction:column;gap:8px;font-size:12.5px;color:rgba(255,255,255,0.95);">
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

						function hexRgba(hex, pct){
							var c = String(hex || '#ffffff').replace('#','').trim();
							if(c.length === 3){ c = c[0]+c[0]+c[1]+c[1]+c[2]+c[2]; }
							var r = parseInt(c.substring(0,2),16)||255, g = parseInt(c.substring(2,4),16)||255, b = parseInt(c.substring(4,6),16)||255;
							var a = Math.max(0.2, Math.min(1, (parseFloat(pct)||100)/100));
							return 'rgba('+r+', '+g+', '+b+', '+a+')';
						}

						function syncStudioCat2(){
							var primary = $('#primary_color').val() || '#2563eb';
							var secondary = $('#secondary_color').val() || '#4f46e5';
							var btnBgMode = $('#button_bg_mode').val() || 'solid';
							var bg = $('#card_bg_color').val() || '#ffffff';
							var text = $('#text_color').val() || '#111827';
							var radius = $('#border_radius').val() || 16;
							var isGlass = $('#glassmorphism').is(':checked');
							var cardOpacity = $('#card_bg_opacity').val() || 85;
							var blurPx = $('#backdrop_blur').val() || 16;
							var cardShadow = $('#card_shadow').val() || 'medium';
							var cardBorder = $('#card_border_style').val() || 'subtle';
							var cardPadding = $('#card_padding').val() || 32;
							var bgPattern = $('input[name="signa[bg_pattern]"]:checked').val() || 'none';
							var canvasBgStyle = $('#canvas_bg_style').val() || 'mesh_light';
							var canvasBgColor = $('#canvas_bg_color').val() || '#f1f5f9';
							var canvasBgImg = ($('#canvas_bg_image').val() || '').trim();
							var formLayout = $('input[name="signa[form_layout]"]:checked').val() || 'card';
							var cardPosition = $('input[name="signa[card_position]"]:checked').val() || 'center';
							var modalStyle = $('input[name="signa[modal_style]"]:checked').val() || 'center';

							var isSplit = (formLayout === 'split_right' || formLayout === 'split_left');
							var isDrawerOrSheet = (currentPreviewMode === 'modal' && (modalStyle === 'drawer_left' || modalStyle === 'drawer_right' || modalStyle === 'bottom_sheet'));
							var showSplitBanner = isSplit && !isDrawerOrSheet;

							$('#secondary_color_hex').text(secondary);
							$('#opacity_val_label').text(cardOpacity + '%');
							$('#blur_val_label').text(blurPx + 'px');
							$('#padding_val_label').text(cardPadding + 'px');

							if (isGlass) { $('#signa-glassmorphism-controls').slideDown(180); } else { $('#signa-glassmorphism-controls').slideUp(180); }
							$('#signa-secondary-color-wrap').css('opacity', btnBgMode === 'gradient' ? '1' : '0.65');

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

							$('#signa-live-preview-shell').css({
								maxWidth: showSplitBanner ? '720px' : '360px',
								width: showSplitBanner ? '720px' : '100%',
								flexDirection: formLayout === 'split_left' ? 'row-reverse' : 'row',
								boxShadow: shadowCss,
								border: borderCss,
								borderTop: borderTopCss
							});
							$('#signa-prev-split-banner').toggle(showSplitBanner);

							$('#signa-live-preview-card').css({
								background: isGlass ? hexRgba(bg, cardOpacity) : bg,
								backdropFilter: isGlass ? 'blur(' + blurPx + 'px)' : 'none',
								webkitBackdropFilter: isGlass ? 'blur(' + blurPx + 'px)' : 'none',
								color: text,
								padding: Math.round(cardPadding * 0.85) + 'px'
							});
							var btnBg = btnBgMode === 'gradient' ? 'linear-gradient(135deg, ' + primary + ', ' + secondary + ')' : primary;
							$('#signa-prev-btn-1, #signa-prev-btn-2').css({
								background: btnBg,
								borderRadius: Math.round(radius * 0.68) + 'px'
							});
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
