<?php
/**
 * Admin Settings Page View
 *
 * @package Signa_OTP
 * @var array $settings
 * @var array $sms_gateways
 * @var array $stats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap signa-admin-wrap" dir="rtl">
	<div class="signa-admin-header">
		<div>
			<h1>
				<span class="dashicons dashicons-smartphone" style="font-size:28px;width:28px;height:28px;color:#2563eb;margin-left:8px;"></span>
				پلاگین ورود و ثبت‌نام یکبارمصرف (Signa OTP)
				<span class="signa-version-badge">نسخه <?php echo esc_html( SIGNA_OTP_VERSION ); ?></span>
			</h1>
			<p class="signa-admin-subtitle">مدیریت درگاه‌های پیامک، پیام‌رسان بله، ایمیل، ووکامرس و امنیت ورود کاربران</p>
		</div>
		<div class="signa-header-actions">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp-logs' ) ); ?>" class="button button-secondary">
				مشاهده لاگ کدهای ارسالی (<?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?>)
			</a>
		</div>
	</div>

	<?php // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
	<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
		<div class="notice notice-success is-dismissible">
			<p><strong>تنظیمات با موفقیت ذخیره شد.</strong></p>
		</div>
	<?php endif; ?>

	<!-- Stats Overview -->
	<div class="signa-stats-grid">
		<div class="signa-stat-card">
			<span class="signa-stat-label">کل کدهای ارسال‌شده</span>
			<strong class="signa-stat-value"><?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?></strong>
		</div>
		<div class="signa-stat-card">
			<span class="signa-stat-label">ارسالی امروز</span>
			<strong class="signa-stat-value" style="color:#2563eb;"><?php echo esc_html( number_format_i18n( $stats['today'] ) ); ?></strong>
		</div>
		<div class="signa-stat-card">
			<span class="signa-stat-label">ورودهای موفق (Verified)</span>
			<strong class="signa-stat-value" style="color:#16a34a;"><?php echo esc_html( number_format_i18n( $stats['verified'] ) ); ?></strong>
		</div>
		<div class="signa-stat-card">
			<span class="signa-stat-label">ارسال‌های ناموفق</span>
			<strong class="signa-stat-value" style="color:#dc2626;"><?php echo esc_html( number_format_i18n( $stats['failed'] ) ); ?></strong>
		</div>
	</div>

	<!-- Navigation Tabs -->
	<nav class="signa-tabs-nav">
		<button type="button" class="signa-tab-btn active" data-tab="general">
			<span class="dashicons dashicons-admin-generic"></span> عمومی و سناریوی ورود
		</button>
		<button type="button" class="signa-tab-btn" data-tab="sms">
			<span class="dashicons dashicons-email-alt"></span> درگاه‌های پیامک (SMS)
		</button>
		<button type="button" class="signa-tab-btn" data-tab="bale_email">
			<span class="dashicons dashicons-format-chat"></span> پیام‌رسان بله و ایمیل
		</button>
		<button type="button" class="signa-tab-btn" data-tab="woocommerce_ui">
			<span class="dashicons dashicons-cart"></span> ووکامرس، شورت‌کد و ظاهر
		</button>
		<button type="button" class="signa-tab-btn" data-tab="security_test">
			<span class="dashicons dashicons-shield"></span> امنیت و تست زنده ارسال
		</button>
	</nav>

	<form method="post" action="">
		<?php wp_nonce_field( 'signa_save_settings_action', 'signa_settings_nonce' ); ?>

		<!-- TAB 1: GENERAL & AUTH FLOW -->
		<div class="signa-tab-panel active" id="signa-tab-general">
			<div class="signa-panel-card">
				<h2>تنظیمات عمومی و سناریوی ورود/ثبت‌نام</h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="login_mode">روش شناسایی کاربر در فرم</label></th>
						<td>
							<select name="signa[login_mode]" id="login_mode" class="regular-text">
								<option value="phone_and_email" <?php selected( $settings['login_mode'], 'phone_and_email' ); ?>>شماره موبایل یا ایمیل (تشخیص خودکار)</option>
								<option value="phone_only" <?php selected( $settings['login_mode'], 'phone_only' ); ?>>فقط شماره موبایل</option>
								<option value="email_only" <?php selected( $settings['login_mode'], 'email_only' ); ?>>فقط آدرس ایمیل</option>
							</select>
							<p class="description">مشخص کنید کاربران در فیلد ورودی چه مشخصه‌ای می‌توانند وارد کنند.</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="mobile_delivery_channel">کانال ارسال کد به شماره موبایل</label></th>
						<td>
							<select name="signa[mobile_delivery_channel]" id="mobile_delivery_channel" class="regular-text">
								<option value="sms" <?php selected( $settings['mobile_delivery_channel'], 'sms' ); ?>>فقط پیامک (درگاه پیامکی فعال)</option>
								<option value="bale_fallback_sms" <?php selected( $settings['mobile_delivery_channel'], 'bale_fallback_sms' ); ?>>هوشمند: اول پیام‌رسان بله، در صورت عدم ارسال ← پیامک (کاهش هزینه)</option>
								<option value="sms_fallback_bale" <?php selected( $settings['mobile_delivery_channel'], 'sms_fallback_bale' ); ?>>هوشمند: اول پیامک، در صورت خطا ← پیام‌رسان بله</option>
								<option value="bale" <?php selected( $settings['mobile_delivery_channel'], 'bale' ); ?>>فقط پیام‌رسان بله (سفیر / ربات)</option>
								<option value="both" <?php selected( $settings['mobile_delivery_channel'], 'both' ); ?>>ارسال همزمان در پیامک و پیام‌رسان بله</option>
							</select>
							<p class="description">در حالت هوشمند «اول بله سپس پیامک»، اگر کاربر بله داشته باشد کد با تعرفه بسیار ارزان‌تر سفیر بله ارسال می‌شود و در غیر این صورت خودکار پیامک می‌شود.</p>
						</td>
					</tr>

					<tr>
						<th scope="row">ثبت‌نام یکپارچه خودکار</th>
						<td>
							<label>
								<input type="checkbox" name="signa[auto_register]" value="1" <?php checked( $settings['auto_register'], 1 ); ?> />
								اگر شماره موبایل یا ایمیل در سایت وجود نداشت، به صورت خودکار حساب کاربری جدید ساخته شود.
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="default_user_role">نقش کاربری کاربران جدید</label></th>
						<td>
							<select name="signa[default_user_role]" id="default_user_role">
								<option value="customer" <?php selected( $settings['default_user_role'], 'customer' ); ?>>مشتری ووکامرس (Customer)</option>
								<option value="subscriber" <?php selected( $settings['default_user_role'], 'subscriber' ); ?>>مشترک وردپرس (Subscriber)</option>
							</select>
							<p class="description">اگر ووکامرس فعال نباشد، به صورت خودکار روی نقش پیش‌فرض وردپرس تنظیم می‌شود.</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="otp_length">تعداد ارقام کد تایید (OTP)</label></th>
						<td>
							<input type="number" name="signa[otp_length]" id="otp_length" value="<?php echo esc_attr( (string) $settings['otp_length'] ); ?>" min="4" max="8" class="small-text" /> رقم
							<p class="description">پیشنهاد استاندارد: ۵ یا ۶ رقم.</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="otp_expiry">مدت اعتبار کد (ثانیه)</label></th>
						<td>
							<input type="number" name="signa[otp_expiry]" id="otp_expiry" value="<?php echo esc_attr( (string) $settings['otp_expiry'] ); ?>" min="30" max="900" class="small-text" /> ثانیه
							<p class="description">پس از این زمان کد منقضی شده و کاربر باید کد جدید دریافت کند (پیش‌فرض: ۱۲۰ ثانیه).</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="resend_cooldown">فاصله زمانی ارسال مجدد کد</label></th>
						<td>
							<input type="number" name="signa[resend_cooldown]" id="resend_cooldown" value="<?php echo esc_attr( (string) $settings['resend_cooldown'] ); ?>" min="15" max="600" class="small-text" /> ثانیه
							<p class="description">تایمر شمارش معکوس قبل از فعال شدن دکمه «ارسال مجدد کد» (پیش‌فرض: ۶۰ ثانیه).</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="username_prefix">پیشوند نام کاربری خودکار</label></th>
						<td>
							<input type="text" name="signa[username_prefix]" id="username_prefix" value="<?php echo esc_attr( $settings['username_prefix'] ); ?>" class="small-text" dir="ltr" />
							<p class="description">مثلاً با پیشوند <code>u_</code> نام کاربری به صورت <code>u_09123456789</code> ثبت می‌شود.</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="redirect_url">آدرس انتقال (Redirect) پس از ورود</label></th>
						<td>
							<input type="url" name="signa[redirect_url]" id="redirect_url" value="<?php echo esc_attr( $settings['redirect_url'] ); ?>" class="regular-text" dir="ltr" placeholder="https://example.com/my-account" />
							<p class="description">در صورت خالی بودن، کاربر به صفحه حساب کاربری ووکامرس یا صفحه فعلی هدایت می‌شود.</p>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<!-- TAB 2: SMS GATEWAYS -->
		<div class="signa-tab-panel" id="signa-tab-sms">
			<div class="signa-panel-card">
				<h2>انتخاب و پیکربندی درگاه پیامک</h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="active_sms_gateway">درگاه پیامک فعال</label></th>
						<td>
							<select name="signa[active_sms_gateway]" id="active_sms_gateway" class="regular-text">
								<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
									<option value="<?php echo esc_attr( $gw_id ); ?>" <?php selected( $settings['active_sms_gateway'], $gw_id ); ?>>
										<?php echo esc_html( $gw_obj->get_title() ); ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="description">برای ارسال سریع و بدون بلاک شدن به شماره‌های مسدود تبلیغاتی، تمام درگاه‌ها از <strong>خط خدماتی (ارسال پترن / الگو)</strong> استفاده می‌کنند.</p>
						</td>
					</tr>
				</table>

				<!-- Sandbox Settings -->
				<div class="signa-gateway-box" data-gateway="sandbox">
					<h3>تنظیمات حالت تست / آزمایشی (Sandbox)</h3>
					<p class="description">در این حالت هیچ پیامکی به بیرون ارسال نمی‌شود اما کد تولیدشده در جدول <strong>لاگ کدهای ارسالی</strong> ثبت می‌شود تا بدون نیاز به خرید پنل پیامک، کل فرآیند را تست کنید.</p>
					<table class="form-table">
						<tr>
							<th scope="row">نمایش کد در کادر پیام فرم</th>
							<td>
								<label>
									<input type="checkbox" name="signa[show_debug_code_in_toast]" value="1" <?php checked( $settings['show_debug_code_in_toast'], 1 ); ?> />
									نمایش کد OTP در پیغام بالای فرم ورود (فقط مخصوص محیط توسعه و تست؛ در سایت اصلی غیرفعال کنید)
								</label>
							</td>
						</tr>
					</table>
				</div>

				<!-- SMS.ir Settings -->
				<div class="signa-gateway-box" data-gateway="smsir">
					<h3>پیکربندی درگاه SMS.ir (نسخه جدید پنل app.sms.ir)</h3>
					<table class="form-table">
						<tr>
							<th scope="row"><label for="smsir_api_key">کلید وب‌سرویس (API Key)</label></th>
							<td>
								<input type="text" name="signa[smsir_api_key]" id="smsir_api_key" value="<?php echo esc_attr( $settings['smsir_api_key'] ); ?>" class="regular-text" dir="ltr" />
								<p class="description">از منوی «توسعه‌دهندگان ← کلیدها» در پنل جدید SMS.ir دریافت کنید.</p>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="smsir_template_id">شناسه قالب (Template ID)</label></th>
							<td>
								<input type="text" name="signa[smsir_template_id]" id="smsir_template_id" value="<?php echo esc_attr( $settings['smsir_template_id'] ); ?>" class="regular-text" dir="ltr" placeholder="100000" />
								<p class="description">شناسه عددی قالب بازگشتی از بخش «ارسال سریع / اعتبارسنجی» در پنل SMS.ir.</p>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="smsir_param_name">نام متغیر کد در قالب</label></th>
							<td>
								<input type="text" name="signa[smsir_param_name]" id="smsir_param_name" value="<?php echo esc_attr( $settings['smsir_param_name'] ); ?>" class="small-text" dir="ltr" placeholder="CODE" />
								<p class="description">نام پارامتری که در قالب SMS.ir به صورت <code>#CODE#</code> تعریف کرده‌اید (بدون #، مثلاً <code>CODE</code>).</p>
							</td>
						</tr>
					</table>
				</div>

				<!-- Kavenegar Settings -->
				<div class="signa-gateway-box" data-gateway="kavenegar">
					<h3>پیکربندی درگاه کاوه‌نگار (Kavenegar)</h3>
					<table class="form-table">
						<tr>
							<th scope="row"><label for="kavenegar_api_key">کلید API (API Key)</label></th>
							<td>
								<input type="text" name="signa[kavenegar_api_key]" id="kavenegar_api_key" value="<?php echo esc_attr( $settings['kavenegar_api_key'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="kavenegar_template">نام الگوی اعتبارسنجی (Template)</label></th>
							<td>
								<input type="text" name="signa[kavenegar_template]" id="kavenegar_template" value="<?php echo esc_attr( $settings['kavenegar_template'] ); ?>" class="regular-text" dir="ltr" placeholder="verify-login" />
								<p class="description">نام الگوی تاییدشده در بخش «ارسال همنام / اعتبارسنجی» کاوه‌نگار که شامل متغیر <code>%token</code> است.</p>
							</td>
						</tr>
					</table>
				</div>

				<!-- Melipayamak Settings -->
				<div class="signa-gateway-box" data-gateway="melipayamak">
					<h3>پیکربندی درگاه ملی‌پیامک (Melipayamak)</h3>
					<table class="form-table">
						<tr>
							<th scope="row"><label for="melipayamak_username">نام کاربری پنل</label></th>
							<td>
								<input type="text" name="signa[melipayamak_username]" id="melipayamak_username" value="<?php echo esc_attr( $settings['melipayamak_username'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="melipayamak_password">رمز عبور یا API Key</label></th>
							<td>
								<input type="password" name="signa[melipayamak_password]" id="melipayamak_password" value="<?php echo esc_attr( $settings['melipayamak_password'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="melipayamak_body_id">کد متن خدماتی (bodyId)</label></th>
							<td>
								<input type="text" name="signa[melipayamak_body_id]" id="melipayamak_body_id" value="<?php echo esc_attr( $settings['melipayamak_body_id'] ); ?>" class="regular-text" dir="ltr" placeholder="12345" />
								<p class="description">کد عددی پترن تاییدشده در بخش «وب‌سرویس خدماتی» ملی‌پیامک که شامل <code>{0}</code> است.</p>
							</td>
						</tr>
					</table>
				</div>

				<!-- FarazSMS Settings -->
				<div class="signa-gateway-box" data-gateway="farazsms">
					<h3>پیکربندی درگاه فراز اس‌ام‌اس (FarazSMS)</h3>
					<table class="form-table">
						<tr>
							<th scope="row"><label for="farazsms_auth_type">روش احراز هویت</label></th>
							<td>
								<select name="signa[farazsms_auth_type]" id="farazsms_auth_type">
									<option value="apikey" <?php selected( $settings['farazsms_auth_type'], 'apikey' ); ?>>کلید دسترسی (API Key - پیشنهادی)</option>
									<option value="userpass" <?php selected( $settings['farazsms_auth_type'], 'userpass' ); ?>>نام کاربری و رمز عبور پنل</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="farazsms_api_key">کلید دسترسی (API Key)</label></th>
							<td>
								<input type="text" name="signa[farazsms_api_key]" id="farazsms_api_key" value="<?php echo esc_attr( $settings['farazsms_api_key'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="farazsms_username">نام کاربری (در حالت نام کاربری/رمز)</label></th>
							<td>
								<input type="text" name="signa[farazsms_username]" id="farazsms_username" value="<?php echo esc_attr( $settings['farazsms_username'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="farazsms_password">رمز عبور (در حالت نام کاربری/رمز)</label></th>
							<td>
								<input type="password" name="signa[farazsms_password]" id="farazsms_password" value="<?php echo esc_attr( $settings['farazsms_password'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="farazsms_from_number">شماره خط فرستنده</label></th>
							<td>
								<input type="text" name="signa[farazsms_from_number]" id="farazsms_from_number" value="<?php echo esc_attr( $settings['farazsms_from_number'] ); ?>" class="regular-text" dir="ltr" placeholder="+983000505" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="farazsms_pattern_code">کد پترن (Pattern Code)</label></th>
							<td>
								<input type="text" name="signa[farazsms_pattern_code]" id="farazsms_pattern_code" value="<?php echo esc_attr( $settings['farazsms_pattern_code'] ); ?>" class="regular-text" dir="ltr" placeholder="ab12cd34ef" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="farazsms_param_name">نام متغیر درون پترن</label></th>
							<td>
								<input type="text" name="signa[farazsms_param_name]" id="farazsms_param_name" value="<?php echo esc_attr( $settings['farazsms_param_name'] ); ?>" class="regular-text" dir="ltr" placeholder="verification-code" />
								<p class="description">نام متغیر تعریف شده در پترن فراز اس‌ام‌اس بدون درصد (مثلاً <code>verification-code</code> یا <code>code</code>).</p>
							</td>
						</tr>
					</table>
				</div>

				<!-- IPPanel Settings -->
				<div class="signa-gateway-box" data-gateway="ippanel">
					<h3>پیکربندی درگاه آی‌پی‌پنل (IPPanel)</h3>
					<table class="form-table">
						<tr>
							<th scope="row"><label for="ippanel_auth_type">نسخه وب‌سرویس IPPanel</label></th>
							<td>
								<select name="signa[ippanel_auth_type]" id="ippanel_auth_type">
									<option value="edge" <?php selected( $settings['ippanel_auth_type'], 'edge' ); ?>>وب‌سرویس جدید Edge (edge.ippanel.com)</option>
									<option value="apikey" <?php selected( $settings['ippanel_auth_type'], 'apikey' ); ?>>وب‌سرویس REST با کلید API (api2.ippanel.com)</option>
									<option value="userpass" <?php selected( $settings['ippanel_auth_type'], 'userpass' ); ?>>نام کاربری و رمز عبور کلاسیک</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="ippanel_api_key">کلید API / توکن Authorization</label></th>
							<td>
								<input type="text" name="signa[ippanel_api_key]" id="ippanel_api_key" value="<?php echo esc_attr( $settings['ippanel_api_key'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="ippanel_username">نام کاربری (در حالت کلاسیک)</label></th>
							<td>
								<input type="text" name="signa[ippanel_username]" id="ippanel_username" value="<?php echo esc_attr( $settings['ippanel_username'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="ippanel_password">رمز عبور (در حالت کلاسیک)</label></th>
							<td>
								<input type="password" name="signa[ippanel_password]" id="ippanel_password" value="<?php echo esc_attr( $settings['ippanel_password'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="ippanel_from_number">شماره خط فرستنده</label></th>
							<td>
								<input type="text" name="signa[ippanel_from_number]" id="ippanel_from_number" value="<?php echo esc_attr( $settings['ippanel_from_number'] ); ?>" class="regular-text" dir="ltr" placeholder="+983000505" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="ippanel_pattern_code">کد پترن (Pattern Code)</label></th>
							<td>
								<input type="text" name="signa[ippanel_pattern_code]" id="ippanel_pattern_code" value="<?php echo esc_attr( $settings['ippanel_pattern_code'] ); ?>" class="regular-text" dir="ltr" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="ippanel_param_name">نام متغیر درون پترن</label></th>
							<td>
								<input type="text" name="signa[ippanel_param_name]" id="ippanel_param_name" value="<?php echo esc_attr( $settings['ippanel_param_name'] ); ?>" class="regular-text" dir="ltr" placeholder="code" />
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<!-- TAB 3: BALE MESSENGER & EMAIL -->
		<div class="signa-tab-panel" id="signa-tab-bale_email">
			<div class="signa-panel-card">
				<h2>تنظیمات پیام‌رسان بله (Bale OTP)</h2>
				<p class="description">ارسال کد تایید از طریق پیام‌رسان بله به شماره موبایل کاربران (سرویس رسمی <strong>سفیر بله</strong> یا <strong>ربات بله</strong>).</p>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="bale_mode">روش ارسال در بله</label></th>
						<td>
							<select name="signa[bale_mode]" id="bale_mode">
								<option value="safir" <?php selected( $settings['bale_mode'], 'safir' ); ?>>وب‌سرویس رسمی سفیر بله (Safir OTP API - ارسال مستقیم به شماره موبایل)</option>
								<option value="bot" <?php selected( $settings['bale_mode'], 'bot' ); ?>>ربات بله (Bale Bot API - نیازمند Chat ID کاربر)</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="bale_client_id">شناسه کاربری سفیر (Client ID)</label></th>
						<td>
							<input type="text" name="signa[bale_client_id]" id="bale_client_id" value="<?php echo esc_attr( $settings['bale_client_id'] ); ?>" class="regular-text" dir="ltr" />
							<p class="description">دریافت از پنل کسب‌وکار سفیر بله (safir.bale.ai).</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="bale_client_secret">رمز عبور سفیر (Client Secret)</label></th>
						<td>
							<input type="password" name="signa[bale_client_secret]" id="bale_client_secret" value="<?php echo esc_attr( $settings['bale_client_secret'] ); ?>" class="regular-text" dir="ltr" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="bale_bot_token">توکن ربات بله (Bot Token)</label></th>
						<td>
							<input type="text" name="signa[bale_bot_token]" id="bale_bot_token" value="<?php echo esc_attr( $settings['bale_bot_token'] ); ?>" class="regular-text" dir="ltr" />
							<p class="description">فقط در صورت انتخاب حالت «ربات بله» استفاده می‌شود.</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="bale_message_template">قالب پیام ربات بله</label></th>
						<td>
							<textarea name="signa[bale_message_template]" id="bale_message_template" rows="3" class="large-text"><?php echo esc_textarea( $settings['bale_message_template'] ); ?></textarea>
							<p class="description">متغیرهای قابل استفاده: <code>{code}</code>، <code>{site_name}</code>، <code>{expiry}</code></p>
						</td>
					</tr>
				</table>
			</div>

			<div class="signa-panel-card" style="margin-top:20px;">
				<h2>تنظیمات ارسال ایمیل (Email OTP)</h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="email_from_name">نام فرستنده ایمیل</label></th>
						<td>
							<input type="text" name="signa[email_from_name]" id="email_from_name" value="<?php echo esc_attr( $settings['email_from_name'] ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="email_from_address">آدرس ایمیل فرستنده</label></th>
						<td>
							<input type="email" name="signa[email_from_address]" id="email_from_address" value="<?php echo esc_attr( $settings['email_from_address'] ); ?>" class="regular-text" dir="ltr" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="email_subject">موضوع ایمیل</label></th>
						<td>
							<input type="text" name="signa[email_subject]" id="email_subject" value="<?php echo esc_attr( $settings['email_subject'] ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="email_heading">تیتر داخل قالب ایمیل</label></th>
						<td>
							<input type="text" name="signa[email_heading]" id="email_heading" value="<?php echo esc_attr( $settings['email_heading'] ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="email_body_text">متن توضیحات ایمیل</label></th>
						<td>
							<textarea name="signa[email_body_text]" id="email_body_text" rows="3" class="large-text"><?php echo esc_textarea( $settings['email_body_text'] ); ?></textarea>
							<p class="description">متغیرهای مجاز: <code>{site_name}</code>، <code>{code}</code>، <code>{expiry}</code></p>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<!-- TAB 4: WOOCOMMERCE, SHORTCODES & UI -->
		<div class="signa-tab-panel" id="signa-tab-woocommerce_ui">
			<div class="signa-panel-card">
				<h2>یکپارچگی با ووکامرس و وردپرس</h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">جایگزینی فرم حساب کاربری ووکامرس</th>
						<td>
							<label>
								<input type="checkbox" name="signa[wc_replace_myaccount]" value="1" <?php checked( $settings['wc_replace_myaccount'], 1 ); ?> />
								فرم پیش‌فرض ورود/ثبت‌نام صفحه «حساب کاربری من» (My Account) ووکامرس با فرم OTP جایگزین شود.
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">ورود سریع در صفحه تسویه‌حساب (Checkout)</th>
						<td>
							<label>
								<input type="checkbox" name="signa[wc_checkout_otp_box]" value="1" <?php checked( $settings['wc_checkout_otp_box'], 1 ); ?> />
								نمایش نوار ورود سریع با کد یکبارمصرف بالای صفحه تسویه‌حساب ووکامرس برای کاربران مهمان.
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">مودال پاپ‌آپ سراسری</th>
						<td>
							<label>
								<input type="checkbox" name="signa[enable_global_modal]" value="1" <?php checked( $settings['enable_global_modal'], 1 ); ?> />
								بارگذاری مودال پاپ‌آپ ورود در فوتر سایت (باز شدن با کلاس <code>signa-open-modal</code> یا شورت‌کد دکمه).
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">صفحه ورود پیش‌فرض وردپرس (wp-login.php)</th>
						<td>
							<label>
								<input type="checkbox" name="signa[wp_login_integration]" value="1" <?php checked( $settings['wp_login_integration'], 1 ); ?> />
								نمایش فرم ورود با کد یکبارمصرف در صفحه <code>wp-login.php</code>
							</label>
						</td>
					</tr>
				</table>
			</div>

			<div class="signa-panel-card" style="margin-top:20px;">
				<h2>شخصی‌سازی ظاهر و متن‌های فرم</h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="primary_color">رنگ اصلی برند (Primary Color)</label></th>
						<td>
							<input type="color" name="signa[primary_color]" id="primary_color" value="<?php echo esc_attr( $settings['primary_color'] ); ?>" />
							<code><?php echo esc_html( $settings['primary_color'] ); ?></code>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="form_title">عنوان فرم ورود</label></th>
						<td>
							<input type="text" name="signa[form_title]" id="form_title" value="<?php echo esc_attr( $settings['form_title'] ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="form_subtitle">زیرعنوان (توضیح کوتاه فرم)</label></th>
						<td>
							<input type="text" name="signa[form_subtitle]" id="form_subtitle" value="<?php echo esc_attr( $settings['form_subtitle'] ); ?>" class="large-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="button_text">متن دکمه مرحله اول</label></th>
						<td>
							<input type="text" name="signa[button_text]" id="button_text" value="<?php echo esc_attr( $settings['button_text'] ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="verify_button_text">متن دکمه تایید کد</label></th>
						<td>
							<input type="text" name="signa[verify_button_text]" id="verify_button_text" value="<?php echo esc_attr( $settings['verify_button_text'] ); ?>" class="regular-text" />
						</td>
					</tr>
				</table>
			</div>

			<div class="signa-panel-card" style="margin-top:20px;">
				<h2>راهنمای شورت‌کدها و المنتور</h2>
				<div class="signa-shortcode-guide">
					<p><strong>۱. نمایش مستقیم فرم ورود در هر برگه یا ویجت المنتور:</strong></p>
					<code dir="ltr">[signa_otp_login]</code>
					<p>می‌توانید عنوان و آدرس ریدایرکت دلخواه هم بدهید:</p>
					<code dir="ltr">[signa_otp_login title="ورود به پنل کاربری" redirect="https://example.com/dashboard"]</code>

					<p style="margin-top:14px;"><strong>۲. نمایش دکمه بازکننده مودال پاپ‌آپ در هدر سایت:</strong></p>
					<code dir="ltr">[signa_otp_button text="ورود / عضویت" logged_in_text="حساب کاربری من"]</code>
					<p>یا به هر دکمه/لینک دلخواه در قالب یا المنتور کلاس CSS زیر را بدهید:</p>
					<code dir="ltr">signa-open-modal</code>
				</div>
			</div>
		</div>

		<!-- TAB 5: SECURITY, RATE LIMIT & LIVE TEST -->
		<div class="signa-tab-panel" id="signa-tab-security_test">
			<div class="signa-panel-card">
				<h2>تنظیمات امنیتی و محدودیت نرخ ارسال (Rate Limiting)</h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="max_requests_per_hour">حداکثر درخواست کد برای هر شماره/ایمیل در ساعت</label></th>
						<td>
							<input type="number" name="signa[max_requests_per_hour]" id="max_requests_per_hour" value="<?php echo esc_attr( (string) $settings['max_requests_per_hour'] ); ?>" min="1" max="50" class="small-text" /> بار در ساعت
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="max_ip_requests_per_hour">حداکثر درخواست کد برای هر IP در ساعت</label></th>
						<td>
							<input type="number" name="signa[max_ip_requests_per_hour]" id="max_ip_requests_per_hour" value="<?php echo esc_attr( (string) $settings['max_ip_requests_per_hour'] ); ?>" min="2" max="200" class="small-text" /> بار در ساعت
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="max_verify_attempts">حداکثر تلاش مجاز برای وارد کردن کد اشتباه</label></th>
						<td>
							<input type="number" name="signa[max_verify_attempts]" id="max_verify_attempts" value="<?php echo esc_attr( (string) $settings['max_verify_attempts'] ); ?>" min="2" max="15" class="small-text" /> تلاش
							<p class="description">در صورت وارد کردن کد اشتباه بیش از این تعداد، کد باطل شده و شماره/IP موقتاً قفل می‌شود.</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="lockout_duration">مدت زمان مسدودسازی موقت (Brute-force Lockout)</label></th>
						<td>
							<input type="number" name="signa[lockout_duration]" id="lockout_duration" value="<?php echo esc_attr( (string) $settings['lockout_duration'] ); ?>" min="60" max="86400" class="small-text" /> ثانیه (پیش‌فرض: ۹۰۰ ثانیه = ۱۵ دقیقه)
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="log_retention_days">مدت زمان نگهداری لاگ‌ها</label></th>
						<td>
							<input type="number" name="signa[log_retention_days]" id="log_retention_days" value="<?php echo esc_attr( (string) $settings['log_retention_days'] ); ?>" min="1" max="365" class="small-text" /> روز
						</td>
					</tr>
					<tr>
						<th scope="row">حذف کامل اطلاعات هنگام پاک کردن افزونه</th>
						<td>
							<label>
								<input type="checkbox" name="signa[delete_data_on_uninstall]" value="1" <?php checked( $settings['delete_data_on_uninstall'], 1 ); ?> />
								در صورت حذف کامل پلاگین از وردپرس، جدول لاگ‌ها و تنظیمات از دیتابیس پاک شوند.
							</label>
						</td>
					</tr>
				</table>
			</div>

			<!-- Live Gateway Tester -->
			<div class="signa-panel-card" style="margin-top:20px;border-right:4px solid #2563eb;">
				<h2>آزمایش زنده ارسال کد (تست اتصال درگاه‌ها)</h2>
				<p class="description">ابتدا تغییرات تنظیمات را ذخیره کنید، سپس شماره موبایل یا ایمیل خود را وارد کنید تا اتصال درگاه در لحظه بررسی شود.</p>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="signa_test_recipient">گیرنده تست (موبایل یا ایمیل)</label></th>
						<td>
							<input type="text" id="signa_test_recipient" class="regular-text" dir="ltr" placeholder="09123456789 یا test@example.com" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="signa_test_channel">کانال تست ارسال</label></th>
						<td>
							<select id="signa_test_channel">
								<option value="sms">درگاه پیامک فعال (<?php echo esc_html( $settings['active_sms_gateway'] ); ?>)</option>
								<option value="bale">پیام‌رسان بله (Bale)</option>
								<option value="email">ایمیل (wp_mail)</option>
							</select>
							<button type="button" id="signa_run_test_btn" class="button button-secondary" style="margin-right:8px;">
								ارسال کد آزمایشی
							</button>
						</td>
					</tr>
				</table>
				<div id="signa_test_result" style="display:none;margin-top:12px;padding:12px 16px;border-radius:8px;"></div>
			</div>
		</div>

		<p class="submit">
			<button type="submit" name="signa_save_settings" value="1" class="button button-primary button-hero">
				ذخیره تنظیمات Signa OTP
			</button>
		</p>
	</form>
</div>
