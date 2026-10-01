<?php
/**
 * Admin Settings Partial: tab-sms-gateways.php
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<section class="signa-panel" id="signa-tab-sms_gateways">
					<?php
					$gw_logos = array(
						'sandbox'     => '<span class="signa-gw-logo is-sandbox"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3h6m-5 0v5.172a2 2 0 0 1-.586 1.414l-4.828 4.828A2 2 0 0 0 4 15.828V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3.172a2 2 0 0 0-.586-1.414l-4.828-4.828A2 2 0 0 1 14 8.172V3"/></svg></span>',
						'smsir'       => '<span class="signa-gw-logo is-smsir"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/><path d="M8 11h8m-8 4h5"/></svg></span>',
						'kavenegar'   => '<span class="signa-gw-logo is-kavenegar"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg></span>',
						'melipayamak' => '<span class="signa-gw-logo is-melipayamak"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></span>',
						'farazsms'    => '<span class="signa-gw-logo is-farazsms"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg></span>',
						'ippanel'     => '<span class="signa-gw-logo is-ippanel"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>',
					);
					$b1_selected = ! empty( $settings['backup_sms_gateway_1'] ) && 'none' !== $settings['backup_sms_gateway_1']
						? $settings['backup_sms_gateway_1']
						: $settings['backup_sms_gateway'];
					?>
					<div class="signa-card">
						<div class="signa-card-head">
							<div>
								<h2>انتخاب سامانه پیامک اصلی و ۳ درگاه پشتیبان خودکار (Failover)</h2>
								<p>درگاه اصلی را انتخاب کنید و تا ۳ سامانه پشتیبان به ترتیب اولویت برای مواقع قطعی یا اتمام شارژ تعیین نمایید</p>
							</div>
						</div>

						<!-- Primary SMS Gateway Visual Selector Cards with Logos -->
						<label class="signa-section-label">۱. انتخاب سامانه پیامک اصلی (Primary Gateway)</label>
						<input type="hidden" name="signa[active_sms_gateway]" id="active_sms_gateway" value="<?php echo esc_attr( $settings['active_sms_gateway'] ); ?>" />
						<div class="signa-gw-selector-grid">
							<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
								<button type="button" class="signa-gw-select-card <?php echo $settings['active_sms_gateway'] === $gw_id ? 'selected' : ''; ?>" data-gw-id="<?php echo esc_attr( $gw_id ); ?>" data-gw-title="<?php echo esc_attr( $gw_obj->get_title() ); ?>">
									<?php
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo isset( $gw_logos[ $gw_id ] ) ? $gw_logos[ $gw_id ] : '';
									?>
									<span class="signa-gw-card-title"><?php echo esc_html( $gw_obj->get_title() ); ?></span>
									<span class="signa-gw-check-badge">فعال</span>
								</button>
							<?php endforeach; ?>
						</div>

						<!-- 3 Prioritized Backup Gateways -->
						<label class="signa-section-label" style="margin-top:24px;">۲. زنجیره ۳ درگاه پشتیبان خودکار (Failover Chain)</label>
						<div class="signa-fields-grid signa-cols-3">
							<div class="signa-field">
								<label for="backup_sms_gateway_1">پشتیبان اول (اولویت ۱)</label>
								<select name="signa[backup_sms_gateway_1]" id="backup_sms_gateway_1">
									<option value="none" <?php selected( $b1_selected, 'none' ); ?>>غیرفعال (بدون پشتیبان اول)</option>
									<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
										<?php if ( 'sandbox' !== $gw_id ) : ?>
											<option value="<?php echo esc_attr( $gw_id ); ?>" <?php selected( $b1_selected, $gw_id ); ?>>
												<?php echo esc_html( $gw_obj->get_title() ); ?>
											</option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
								<small>در صورت خطای درگاه اصلی، ابتدا از این سامانه ارسال می‌شود.</small>
							</div>

							<div class="signa-field">
								<label for="backup_sms_gateway_2">پشتیبان دوم (اولویت ۲)</label>
								<select name="signa[backup_sms_gateway_2]" id="backup_sms_gateway_2">
									<option value="none" <?php selected( $settings['backup_sms_gateway_2'], 'none' ); ?>>غیرفعال (بدون پشتیبان دوم)</option>
									<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
										<?php if ( 'sandbox' !== $gw_id ) : ?>
											<option value="<?php echo esc_attr( $gw_id ); ?>" <?php selected( $settings['backup_sms_gateway_2'], $gw_id ); ?>>
												<?php echo esc_html( $gw_obj->get_title() ); ?>
											</option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
								<small>در صورت عدم موفقیت پشتیبان اول، نوبت این درگاه است.</small>
							</div>

							<div class="signa-field">
								<label for="backup_sms_gateway_3">پشتیبان سوم (اولویت ۳)</label>
								<select name="signa[backup_sms_gateway_3]" id="backup_sms_gateway_3">
									<option value="none" <?php selected( $settings['backup_sms_gateway_3'], 'none' ); ?>>غیرفعال (بدون پشتیبان سوم)</option>
									<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
										<?php if ( 'sandbox' !== $gw_id ) : ?>
											<option value="<?php echo esc_attr( $gw_id ); ?>" <?php selected( $settings['backup_sms_gateway_3'], $gw_id ); ?>>
												<?php echo esc_html( $gw_obj->get_title() ); ?>
											</option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
								<small>آخرین حلقه پشتیبان برای تضمین ۱۰۰٪ تحویل پیامک.</small>
							</div>
						</div>

						<!-- Gateway Switcher Pills with Logos to Inspect/Edit Any Gateway -->
						<div class="signa-gw-tabs-bar">
							<span class="signa-section-label" style="margin:0;">۳. مشاهده و ویرایش اطلاعات اتصال هر سامانه:</span>
							<div class="signa-gw-pills">
								<?php foreach ( $sms_gateways as $gw_id => $gw_obj ) : ?>
									<button type="button" class="signa-gw-pill" data-gw="<?php echo esc_attr( $gw_id ); ?>">
										<?php
										// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										echo isset( $gw_logos[ $gw_id ] ) ? $gw_logos[ $gw_id ] : '';
										?>
										<span><?php echo esc_html( $gw_obj->get_title() ); ?></span>
									</button>
								<?php endforeach; ?>
							</div>
						</div>

						<!-- 1. Sandbox Box -->
						<div class="signa-gateway-box" data-gateway="sandbox">
							<div class="signa-gw-box-head">
								<h3>🧪 حالت تست / آزمایشی (Sandbox)</h3>
								<span class="signa-pill is-warn">مخصوص توسعه و تست لوکال</span>
							</div>
							<p class="description">در این حالت هیچ پیامکی به بیرون ارسال نمی‌شود، اما کد تولیدشده در جدول لاگ ثبت می‌شود تا بدون نیاز به پنل پیامک، کل فرآیند را روی لوکال تست کنید.</p>
							<div class="signa-switch-row" style="margin-top:14px;">
								<div>
									<strong>نمایش کد OTP در کادر پیام بالای فرم ورود</strong>
									<p>هنگام درخواست کد، خودِ کد آزمایشی در پیغام سبز بالای فرم به کاربر نمایش داده شود (در سایت عملیاتی خاموش کنید).</p>
								</div>
								<label class="signa-switch">
									<input type="checkbox" name="signa[show_debug_code_in_toast]" value="1" <?php checked( $settings['show_debug_code_in_toast'], 1 ); ?> />
									<span class="signa-slider"></span>
								</label>
							</div>
						</div>

						<!-- 2. SMS.ir Box -->
						<div class="signa-gateway-box" data-gateway="smsir">
							<div class="signa-gw-box-head">
								<h3>💬 پیکربندی درگاه SMS.ir (نسخه جدید REST v1)</h3>
								<span class="signa-pill is-info">api.sms.ir/v1/send/verify</span>
							</div>
							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="smsir_api_key">کلید وب‌سرویس (API Key)</label>
									<input type="text" name="signa[smsir_api_key]" id="smsir_api_key" value="<?php echo esc_attr( $settings['smsir_api_key'] ); ?>" dir="ltr" placeholder="کلید دریافتی از پنل app.sms.ir" />
								</div>
								<div class="signa-field">
									<label for="smsir_template_id">شناسه قالب (Template ID)</label>
									<input type="text" name="signa[smsir_template_id]" id="smsir_template_id" value="<?php echo esc_attr( $settings['smsir_template_id'] ); ?>" dir="ltr" placeholder="100000" />
								</div>
								<div class="signa-field">
									<label for="smsir_param_name">نام متغیر کد در قالب</label>
									<input type="text" name="signa[smsir_param_name]" id="smsir_param_name" value="<?php echo esc_attr( $settings['smsir_param_name'] ); ?>" dir="ltr" placeholder="CODE" />
								</div>
							</div>
						</div>

						<!-- 3. Kavenegar Box -->
						<div class="signa-gateway-box" data-gateway="kavenegar">
							<div class="signa-gw-box-head">
								<h3>📨 پیکربندی درگاه کاوه‌نگار (Kavenegar)</h3>
								<span class="signa-pill is-info">verify/lookup.json</span>
							</div>
							<div class="signa-fields-grid signa-cols-2">
								<div class="signa-field">
									<label for="kavenegar_api_key">کلید API (API Key)</label>
									<input type="text" name="signa[kavenegar_api_key]" id="kavenegar_api_key" value="<?php echo esc_attr( $settings['kavenegar_api_key'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="kavenegar_template">نام الگوی اعتبارسنجی (Template)</label>
									<input type="text" name="signa[kavenegar_template]" id="kavenegar_template" value="<?php echo esc_attr( $settings['kavenegar_template'] ); ?>" dir="ltr" placeholder="verify-login" />
									<small>الگو باید در پنل کاوه‌نگار شامل متغیر <code>%token</code> باشد.</small>
								</div>
							</div>
						</div>

						<!-- 4. Melipayamak Box -->
						<div class="signa-gateway-box" data-gateway="melipayamak">
							<div class="signa-gw-box-head">
								<h3>📱 پیکربندی درگاه ملی‌پیامک (Melipayamak)</h3>
								<span class="signa-pill is-info">BaseServiceNumber</span>
							</div>
							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="melipayamak_username">نام کاربری پنل</label>
									<input type="text" name="signa[melipayamak_username]" id="melipayamak_username" value="<?php echo esc_attr( $settings['melipayamak_username'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="melipayamak_password">رمز عبور یا API Key</label>
									<input type="password" name="signa[melipayamak_password]" id="melipayamak_password" value="<?php echo esc_attr( $settings['melipayamak_password'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="melipayamak_body_id">کد متن خدماتی (bodyId)</label>
									<input type="text" name="signa[melipayamak_body_id]" id="melipayamak_body_id" value="<?php echo esc_attr( $settings['melipayamak_body_id'] ); ?>" dir="ltr" placeholder="12345" />
								</div>
							</div>
						</div>

						<!-- 5. FarazSMS Box -->
						<div class="signa-gateway-box" data-gateway="farazsms">
							<div class="signa-gw-box-head">
								<h3>🚀 پیکربندی درگاه فراز اس‌ام‌اس (FarazSMS)</h3>
								<span class="signa-pill is-info">ارسال پترن خدماتی</span>
							</div>
							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="farazsms_auth_type">روش احراز هویت</label>
									<select name="signa[farazsms_auth_type]" id="farazsms_auth_type">
										<option value="apikey" <?php selected( $settings['farazsms_auth_type'], 'apikey' ); ?>>کلید دسترسی (API Key)</option>
										<option value="userpass" <?php selected( $settings['farazsms_auth_type'], 'userpass' ); ?>>نام کاربری و رمز عبور</option>
									</select>
								</div>
								<div class="signa-field">
									<label for="farazsms_api_key">کلید دسترسی (API Key)</label>
									<input type="text" name="signa[farazsms_api_key]" id="farazsms_api_key" value="<?php echo esc_attr( $settings['farazsms_api_key'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="farazsms_from_number">شماره خط فرستنده</label>
									<input type="text" name="signa[farazsms_from_number]" id="farazsms_from_number" value="<?php echo esc_attr( $settings['farazsms_from_number'] ); ?>" dir="ltr" placeholder="+983000505" />
								</div>
								<div class="signa-field">
									<label for="farazsms_pattern_code">کد پترن (Pattern Code)</label>
									<input type="text" name="signa[farazsms_pattern_code]" id="farazsms_pattern_code" value="<?php echo esc_attr( $settings['farazsms_pattern_code'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="farazsms_param_name">نام متغیر درون پترن</label>
									<input type="text" name="signa[farazsms_param_name]" id="farazsms_param_name" value="<?php echo esc_attr( $settings['farazsms_param_name'] ); ?>" dir="ltr" placeholder="verification-code" />
								</div>
								<div class="signa-field">
									<label for="farazsms_username">نام کاربری و رمز (در حالت سنتی)</label>
									<div style="display:flex;gap:6px;">
										<input type="text" name="signa[farazsms_username]" id="farazsms_username" value="<?php echo esc_attr( $settings['farazsms_username'] ); ?>" dir="ltr" placeholder="Username" />
										<input type="password" name="signa[farazsms_password]" id="farazsms_password" value="<?php echo esc_attr( $settings['farazsms_password'] ); ?>" dir="ltr" placeholder="Password" />
									</div>
								</div>
							</div>
						</div>

						<!-- 6. IPPanel Box -->
						<div class="signa-gateway-box" data-gateway="ippanel">
							<div class="signa-gw-box-head">
								<h3>🌐 پیکربندی درگاه آی‌پی‌پنل (IPPanel Edge / REST)</h3>
								<span class="signa-pill is-info">edge.ippanel.com</span>
							</div>
							<div class="signa-fields-grid signa-cols-3">
								<div class="signa-field">
									<label for="ippanel_auth_type">نسخه وب‌سرویس IPPanel</label>
									<select name="signa[ippanel_auth_type]" id="ippanel_auth_type">
										<option value="edge" <?php selected( $settings['ippanel_auth_type'], 'edge' ); ?>>وب‌سرویس جدید Edge (پیشنهادی)</option>
										<option value="apikey" <?php selected( $settings['ippanel_auth_type'], 'apikey' ); ?>>وب‌سرویس REST با کلید API</option>
										<option value="userpass" <?php selected( $settings['ippanel_auth_type'], 'userpass' ); ?>>نام کاربری و رمز عبور</option>
									</select>
								</div>
								<div class="signa-field">
									<label for="ippanel_api_key">کلید API / توکن Authorization</label>
									<input type="text" name="signa[ippanel_api_key]" id="ippanel_api_key" value="<?php echo esc_attr( $settings['ippanel_api_key'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="ippanel_from_number">شماره خط فرستنده</label>
									<input type="text" name="signa[ippanel_from_number]" id="ippanel_from_number" value="<?php echo esc_attr( $settings['ippanel_from_number'] ); ?>" dir="ltr" placeholder="+983000505" />
								</div>
								<div class="signa-field">
									<label for="ippanel_pattern_code">کد پترن (Pattern Code)</label>
									<input type="text" name="signa[ippanel_pattern_code]" id="ippanel_pattern_code" value="<?php echo esc_attr( $settings['ippanel_pattern_code'] ); ?>" dir="ltr" />
								</div>
								<div class="signa-field">
									<label for="ippanel_param_name">نام متغیر درون پترن</label>
									<input type="text" name="signa[ippanel_param_name]" id="ippanel_param_name" value="<?php echo esc_attr( $settings['ippanel_param_name'] ); ?>" dir="ltr" placeholder="code" />
								</div>
								<div class="signa-field">
									<label>نام کاربری و رمز (در حالت کلاسیک)</label>
									<div style="display:flex;gap:6px;">
										<input type="text" name="signa[ippanel_username]" value="<?php echo esc_attr( $settings['ippanel_username'] ); ?>" dir="ltr" placeholder="Username" />
										<input type="password" name="signa[ippanel_password]" value="<?php echo esc_attr( $settings['ippanel_password'] ); ?>" dir="ltr" placeholder="Password" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
