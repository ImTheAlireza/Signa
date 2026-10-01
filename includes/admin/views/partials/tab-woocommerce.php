<?php
/**
 * Admin Settings Partial: tab-woocommerce.php
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<section class="signa-panel" id="signa-tab-woocommerce">
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>یکپارچگی با ووکامرس و وردپرس</h2>
								<p>جایگزینی خودکار فرم‌های پیش‌فرض وردپرس و ووکامرس با فرم ورود یکبارمصرف Signa</p>
							</div>
						</div>

						<div class="signa-switches-grid">
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
									<p>بارگذاری پنجره پاپ‌آپ ورود در فوتر سایت برای شورت‌کد دکمه، ویجت المنتور و کلاس CSS.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[enable_global_modal]" value="1" <?php checked( $settings['enable_global_modal'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>

							<div class="signa-switch-row">
								<div class="signa-switch-text">
									<strong>جایگزینی کامل صفحه ورود وردپرس (wp-login.php)</strong>
									<p>حذف فرم قدیمی وردپرس در <code>wp-login.php</code> و نمایش صفحه اختصاصی Signa OTP.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[wp_login_integration]" value="1" <?php checked( $settings['wp_login_integration'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>
						</div>
					</div>

					<!-- Elementor Native Widgets Showcase Card -->
					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>ویجت‌های اختصاصی صفحه‌ساز المنتور (Elementor Native Widgets)</h2>
								<p>طراحی و استایل‌دهی مستقیم فرم ورود و دکمه مودال در محیط Drag &amp; Drop المنتور</p>
							</div>
							<span class="signa-pill <?php echo ! empty( $elementor_active ) ? 'is-ok' : 'is-info'; ?>">
								<?php echo ! empty( $elementor_active ) ? 'المنتور فعال است • آماده استفاده' : 'پشتیبانی کامل از المنتور'; ?>
							</span>
						</div>

						<div class="signa-elementor-showcase-grid">
							<div class="signa-el-widget-card">
								<div class="signa-el-widget-icon">
									<span class="dashicons dashicons-lock"></span>
								</div>
								<div class="signa-el-widget-body">
									<div class="signa-el-widget-title-row">
										<strong>۱. ویجت «فرم ورود و ثبت‌نام یکبارمصرف (Signa)»</strong>
										<span class="signa-pill is-info">دسته: احراز هویت سیگنا</span>
									</div>
									<p>نمایش کارت کامل ورود و ثبت‌نام در هر برگه المنتوری با قابلیت سفارشی‌سازی عنوان، زیرعنوان، متن دکمه، رنگ برند، گردی گوشه‌ها و پیش‌نمایش زنده در محیط ادیتور.</p>
								</div>
							</div>

							<div class="signa-el-widget-card">
								<div class="signa-el-widget-icon is-purple">
									<span class="dashicons dashicons-external"></span>
								</div>
								<div class="signa-el-widget-body">
									<div class="signa-el-widget-title-row">
										<strong>۲. ویجت «دکمه پاپ‌آپ ورود سریع (Signa)»</strong>
										<span class="signa-pill is-info">مناسب هدر ساز المنتور</span>
									</div>
									<p>دکمه هوشمند برای قرارگیری در هدر سایت: برای مهمانان مودال پاپ‌آپ ورود را باز می‌کند و برای کاربران واردشده نام کاربر یا لینک «حساب کاربری» را نمایش می‌دهد.</p>
								</div>
							</div>
						</div>
					</div>

					<div class="signa-card" style="margin-top:20px;">
						<div class="signa-card-head">
							<div>
								<h2>شورت‌کدها و کلاس‌های آماده (کلیک برای کپی)</h2>
								<p>از این شورت‌کدها در برگه‌های گوتنبرگ، ابزارک‌ها یا هدر قالب استفاده کنید</p>
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
