<?php
/**
 * Admin Settings Partial: tab-tools.php
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<section class="signa-panel" id="signa-tab-tools_backup">
					<!-- Live Gateway Tester -->
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>آزمایشگاه تست زنده ارسال کد (Live Gateway Tester)</h2>
								<p>ارسال آنی کد آزمایشی برای اطمینان از صحت تنظیمات هر درگاه، پیام‌رسان بله و ایمیل</p>
							</div>
						</div>
						<div class="signa-fields-grid signa-cols-3">
							<div class="signa-field">
								<label for="signa_test_recipient">شماره موبایل یا ایمیل گیرنده تست</label>
								<input type="text" id="signa_test_recipient" dir="ltr" placeholder="09123456789 یا email@example.com" />
							</div>
							<div class="signa-field">
								<label for="signa_test_channel">کانال ارسال تست</label>
								<select id="signa_test_channel">
									<option value="sms">پیامک (درگاه انتخابی)</option>
									<option value="bale">پیام‌رسان بله (Bale)</option>
									<option value="email">ایمیل (wp_mail)</option>
								</select>
							</div>
							<div class="signa-field">
								<label for="signa_test_gateway_id">درگاه پیامک مشخص (اختیاری)</label>
								<select id="signa_test_gateway_id">
									<option value="">استفاده از درگاه اصلی فعال</option>
									<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
										<option value="<?php echo esc_attr( $gw_id ); ?>"><?php echo esc_html( $gw_obj->get_title() ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div style="margin-top:14px;">
							<button type="button" id="signa_run_test_btn" class="signa-btn-save">
								<span class="dashicons dashicons-controls-play"></span>
								ارسال کد آزمایشی همین الان
							</button>
						</div>
						<div id="signa_test_result" style="display:none;margin-top:14px;padding:14px 18px;border-radius:10px;"></div>
					</div>

					<!-- Export / Import / Reset Settings -->
					<div class="signa-bento-row" style="margin-top:20px;">
						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div>
									<h2>برون‌ریزی و درون‌ریزی تنظیمات (JSON Backup)</h2>
									<p>انتقال سریع تنظیمات بین سایت تستی و سایت اصلی</p>
								</div>
							</div>
							<div class="signa-field">
								<label>کد پشتیبان تنظیمات فعلی (Export JSON)</label>
								<textarea id="signa_export_json_box" rows="3" dir="ltr" readonly><?php echo esc_textarea( wp_json_encode( $settings ) ); ?></textarea>
								<button type="button" class="signa-btn-secondary signa-copy-btn" data-copy="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>" style="margin-top:8px;">
									کپی JSON تنظیمات
								</button>
							</div>
							<div class="signa-field" style="margin-top:16px;">
								<label for="signa_import_json_box">درون‌ریزی تنظیمات (Import JSON)</label>
								<textarea id="signa_import_json_box" rows="3" dir="ltr" placeholder='{"login_mode":"phone_and_email", ...}'></textarea>
								<button type="button" id="signa_import_settings_btn" class="signa-btn-secondary" style="margin-top:8px;">
									درون‌ریزی و جایگزینی تنظیمات
								</button>
							</div>
						</div>

						<div class="signa-card signa-col-6">
							<div class="signa-card-head">
								<div>
									<h2>نگهداری دیتابیس و بازنشانی</h2>
									<p>مدیریت طول عمر لاگ‌ها و بازگشت به تنظیمات کارخانه</p>
								</div>
							</div>
							<div class="signa-field">
								<label for="log_retention_days">مدت زمان نگهداری خودکار لاگ‌ها (روز)</label>
								<input type="number" name="signa[log_retention_days]" id="log_retention_days" value="<?php echo esc_attr( (string) $settings['log_retention_days'] ); ?>" min="1" max="365" />
							</div>
							<div class="signa-switch-row" style="margin-top:14px;">
								<div>
									<strong>پاکسازی کامل هنگام حذف افزونه</strong>
									<p>حذف جدول لاگ‌ها و تنظیمات از دیتابیس در صورت پاک کردن افزونه.</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[delete_data_on_uninstall]" value="1" <?php checked( $settings['delete_data_on_uninstall'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>
							<div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(156,163,175,0.2);">
								<button type="button" id="signa_reset_defaults_btn" class="signa-btn-danger">
									بازنشانی تمام تنظیمات به حالت پیش‌فرض کارخانه
								</button>
							</div>
						</div>
					</div>
				</section>
