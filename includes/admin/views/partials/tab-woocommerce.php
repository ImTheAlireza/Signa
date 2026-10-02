<?php
/**
 * Admin Settings Partial: tab-woocommerce.php (Side-by-Side Bento Grid + Vector Icons)
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<section class="signa-panel" id="signa-tab-woocommerce">
					<!-- TOP BENTO ROW: WooCommerce & WP Integration (Col 6) + Elementor Native Widgets (Col 6) -->
					<div class="signa-bento-row">
						<!-- Box 1: WooCommerce & WP Core Integration -->
						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-purple">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
									</span>
									<div>
										<h2>یکپارچگی با ووکامرس و وردپرس</h2>
										<p>جایگزینی خودکار فرم‌های پیش‌فرض با فرم OTP</p>
									</div>
								</div>
								<span class="signa-pill <?php echo ! empty( $wc_active ) ? 'is-ok' : 'is-warn'; ?>">
									<?php echo ! empty( $wc_active ) ? 'ووکامرس فعال' : 'هسته وردپرس'; ?>
								</span>
							</div>

							<div style="display:flex;flex-direction:column;gap:12px;">
								<div class="signa-switch-row">
									<div class="signa-switch-text">
										<strong>جایگزینی فرم حساب کاربری ووکامرس (My Account)</strong>
										<p>فرم ورود و عضویت پیش‌فرض ووکامرس با فرم OTP جایگزین شود.</p>
									</div>
									<label class="signa-switch">
										<input type="checkbox" name="signa[wc_replace_myaccount]" value="1" <?php checked( $settings['wc_replace_myaccount'], 1 ); ?> />
										<span class="signa-slider"></span>
									</label>
								</div>

								<div class="signa-switch-row">
									<div class="signa-switch-text">
										<strong>نوار ورود سریع در تسویه‌حساب (Checkout)</strong>
										<p>نمایش باکس ورود سریع با کد تایید بالای صفحه تسویه‌حساب برای مهمانان.</p>
									</div>
									<label class="signa-switch">
										<input type="checkbox" name="signa[wc_checkout_otp_box]" value="1" <?php checked( $settings['wc_checkout_otp_box'], 1 ); ?> />
										<span class="signa-slider"></span>
									</label>
								</div>

								<div class="signa-switch-row">
									<div class="signa-switch-text">
										<strong>مودال پاپ‌آپ سراسری (Global Modal)</strong>
										<p>بارگذاری پنجره پاپ‌آپ ورود در فوتر سایت برای شورت‌کد و ویجت المنتور.</p>
									</div>
									<label class="signa-switch">
										<input type="checkbox" name="signa[enable_global_modal]" value="1" <?php checked( $settings['enable_global_modal'], 1 ); ?> />
										<span class="signa-slider"></span>
									</label>
								</div>

								<div class="signa-switch-row">
									<div class="signa-switch-text">
										<strong>جایگزینی کامل صفحه ورود وردپرس (wp-login.php)</strong>
										<p>حذف فرم قدیمی وردپرس در <code>wp-login.php</code> و نمایش صفحه اختصاصی Signa.</p>
									</div>
									<label class="signa-switch">
										<input type="checkbox" name="signa[wp_login_integration]" value="1" <?php checked( $settings['wp_login_integration'], 1 ); ?> />
										<span class="signa-slider"></span>
									</label>
								</div>
							</div>
						</div>

						<!-- Box 2: Elementor Native Widgets Showcase -->
						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div class="signa-card-head-title">
									<span class="signa-card-icon is-blue">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
									</span>
									<div>
										<h2>ویجت‌های اختصاصی صفحه‌ساز المنتور</h2>
										<p>طراحی Drag &amp; Drop فرم ورود و دکمه مودال در المنتور</p>
									</div>
								</div>
								<span class="signa-pill <?php echo ! empty( $elementor_active ) ? 'is-ok' : 'is-info'; ?>">
									<?php echo ! empty( $elementor_active ) ? 'المنتور فعال است' : 'پشتیبانی کامل'; ?>
								</span>
							</div>

							<div style="display:flex;flex-direction:column;gap:14px;">
								<div class="signa-el-widget-card">
									<div class="signa-el-widget-icon">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
									</div>
									<div class="signa-el-widget-body">
										<div class="signa-el-widget-title-row">
											<strong>۱. ویجت «فرم ورود و ثبت‌نام یکبارمصرف (Signa)»</strong>
											<span class="signa-pill is-info">کارت کامل در برگه</span>
										</div>
										<p>نمایش کارت کامل ورود و ثبت‌نام در هر برگه المنتوری با قابلیت سفارشی‌سازی عنوان، زیرعنوان، رنگ برند، گردی گوشه‌ها و پیش‌نمایش زنده در محیط ادیتور.</p>
									</div>
								</div>

								<div class="signa-el-widget-card">
									<div class="signa-el-widget-icon is-purple">
										<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 12h6"/><path d="M12 9v6"/></svg>
									</div>
									<div class="signa-el-widget-body">
										<div class="signa-el-widget-title-row">
											<strong>۲. ویجت «دکمه پاپ‌آپ ورود سریع (Signa)»</strong>
											<span class="signa-pill is-info">ویژه هدرساز المنتور</span>
										</div>
										<p>دکمه هوشمند برای هدر سایت: برای مهمانان مودال پاپ‌آپ ورود را باز می‌کند و برای کاربران واردشده نام کاربر یا لینک «حساب کاربری» را نمایش می‌دهد.</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- BOTTOM CARD: Ready-to-Copy Shortcodes -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div class="signa-card-head-title">
								<span class="signa-card-icon is-cyan">
									<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
								</span>
								<div>
									<h2>شورت‌کدها و کلاس‌های آماده (کلیک برای کپی)</h2>
									<p>از این شورت‌کدها در برگه‌های گوتنبرگ، ابزارک‌ها یا منوی هدر قالب استفاده کنید</p>
								</div>
							</div>
						</div>
						<div class="signa-copy-cards-grid">
							<div class="signa-copy-card">
								<strong>فرم کامل ورود و ثبت‌نام در برگه</strong>
								<code dir="ltr">[signa_otp_login]</code>
								<button type="button" class="signa-copy-btn" data-copy="[signa_otp_login]">کپی شورت‌کد</button>
							</div>

							<div class="signa-copy-card">
								<strong>دکمه بازکننده مودال پاپ‌آپ (مناسب هدر)</strong>
								<code dir="ltr">[signa_otp_button text="ورود / عضویت"]</code>
								<button type="button" class="signa-copy-btn" data-copy='[signa_otp_button text="ورود / عضویت"]'>کپی شورت‌کد</button>
							</div>

							<div class="signa-copy-card">
								<strong>کلاس CSS بازکننده پاپ‌آپ روی هر دکمه دلخواه</strong>
								<code dir="ltr">signa-open-modal</code>
								<button type="button" class="signa-copy-btn" data-copy="signa-open-modal">کپی کلاس</button>
							</div>
						</div>
					</div>
				</section>
