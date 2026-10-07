<?php
/**
 * Signa OTP Login / Register Form Template (v2.4)
 *
 * Can be overridden by copying to yourtheme/signa/login-form.php
 *
 * @package Signa_OTP
 * @var array $args Template arguments.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$login_mode       = Signa_Helper::get_option( 'login_mode', 'phone_and_email' );
$otp_length       = absint( Signa_Helper::get_option( 'otp_length', 5 ) );
$primary_color    = ! empty( $args['primary_color'] ) ? $args['primary_color'] : Signa_Helper::get_option( 'primary_color', '#2563eb' );
$secondary_color  = ! empty( $args['secondary_color'] ) ? $args['secondary_color'] : Signa_Helper::get_option( 'secondary_color', '#4f46e5' );
$button_bg_mode   = ! empty( $args['button_bg_mode'] ) ? $args['button_bg_mode'] : Signa_Helper::get_option( 'button_bg_mode', 'solid' );
$card_bg_color    = ! empty( $args['card_bg_color'] ) ? $args['card_bg_color'] : Signa_Helper::get_option( 'card_bg_color', '#ffffff' );
$text_color       = ! empty( $args['text_color'] ) ? $args['text_color'] : Signa_Helper::get_option( 'text_color', '#111827' );
$border_radius    = isset( $args['border_radius'] ) && null !== $args['border_radius'] ? absint( $args['border_radius'] ) : absint( Signa_Helper::get_option( 'border_radius', 16 ) );
$digit_box_style  = ! empty( $args['digit_box_style'] ) ? $args['digit_box_style'] : Signa_Helper::get_option( 'digit_box_style', 'box' );
$glassmorphism    = isset( $args['glassmorphism'] ) && null !== $args['glassmorphism'] ? (bool) $args['glassmorphism'] : (bool) Signa_Helper::get_option( 'glassmorphism', 0 );
$card_bg_opacity  = isset( $args['card_bg_opacity'] ) && null !== $args['card_bg_opacity'] ? absint( $args['card_bg_opacity'] ) : absint( Signa_Helper::get_option( 'card_bg_opacity', 85 ) );
$backdrop_blur    = isset( $args['backdrop_blur'] ) && null !== $args['backdrop_blur'] ? absint( $args['backdrop_blur'] ) : absint( Signa_Helper::get_option( 'backdrop_blur', 16 ) );
$card_shadow      = ! empty( $args['card_shadow'] ) ? $args['card_shadow'] : Signa_Helper::get_option( 'card_shadow', 'medium' );
$card_border      = ! empty( $args['card_border_style'] ) ? $args['card_border_style'] : Signa_Helper::get_option( 'card_border_style', 'subtle' );
$card_padding     = isset( $args['card_padding'] ) && null !== $args['card_padding'] ? absint( $args['card_padding'] ) : absint( Signa_Helper::get_option( 'card_padding', 32 ) );
$font_family      = ! empty( $args['font_family'] ) ? $args['font_family'] : Signa_Helper::get_option( 'font_family', 'vazirmatn' );
$title_size       = isset( $args['title_font_size'] ) && null !== $args['title_font_size'] ? absint( $args['title_font_size'] ) : absint( Signa_Helper::get_option( 'title_font_size', 20 ) );
$subtitle_size    = isset( $args['subtitle_font_size'] ) && null !== $args['subtitle_font_size'] ? absint( $args['subtitle_font_size'] ) : absint( Signa_Helper::get_option( 'subtitle_font_size', 14 ) );
$btn_size         = isset( $args['btn_font_size'] ) && null !== $args['btn_font_size'] ? absint( $args['btn_font_size'] ) : absint( Signa_Helper::get_option( 'btn_font_size', 15 ) );
$input_style      = ! empty( $args['input_style'] ) ? $args['input_style'] : Signa_Helper::get_option( 'input_style', 'filled' );
$input_height     = isset( $args['input_height'] ) && null !== $args['input_height'] ? absint( $args['input_height'] ) : absint( Signa_Helper::get_option( 'input_height', 48 ) );
$input_bg_color   = ! empty( $args['input_bg_color'] ) ? $args['input_bg_color'] : Signa_Helper::get_option( 'input_bg_color', '#f8fafc' );
$input_border_col = ! empty( $args['input_border_color'] ) ? $args['input_border_color'] : Signa_Helper::get_option( 'input_border_color', '#d1d5db' );
$input_addon      = ! empty( $args['input_addon_style'] ) ? $args['input_addon_style'] : Signa_Helper::get_option( 'input_addon_style', 'icon' );
$logo_url         = trim( (string) Signa_Helper::get_option( 'logo_url', '' ) );
$raw_max_width    = isset( $args['max_width'] ) && null !== $args['max_width'] ? absint( $args['max_width'] ) : absint( Signa_Helper::get_option( 'form_max_width', 420 ) );
$max_width        = max( 320, min( 640, $raw_max_width ) );
$allow_password   = (bool) Signa_Helper::get_option( 'allow_password_login', 0 );
$enable_passkey   = (bool) Signa_Helper::get_option( 'enable_passkey', 1 );
$passkey_prompt   = (bool) Signa_Helper::get_option( 'passkey_prompt_after_otp', 1 );
$passkey_btn_text = Signa_Helper::get_option( 'passkey_btn_text', 'ورود سریع با اثر انگشت / چهره (Passkey)' );
$show_terms       = (bool) Signa_Helper::get_option( 'show_terms_checkbox', 0 );
$terms_text       = Signa_Helper::get_option( 'terms_text', 'ورود و ثبت‌نام شما به معنای پذیرش قوانین و مقررات سایت است.' );
$terms_url        = trim( (string) Signa_Helper::get_option( 'terms_url', '' ) );
$captcha_type     = Signa_Helper::get_option( 'captcha_type', 'none' );
$captcha_site_key = trim( (string) Signa_Helper::get_option( 'captcha_site_key', '' ) );
$math_captcha     = 'math' === $captcha_type ? Signa_Security::generate_math_captcha() : null;

if ( 'phone_only' === $login_mode ) {
	$input_label       = 'شماره موبایل';
	$input_placeholder = 'مثلاً: 09123456789';
	$input_type        = 'tel';
	$input_mode        = 'tel';
} elseif ( 'email_only' === $login_mode ) {
	$input_label       = 'آدرس ایمیل';
	$input_placeholder = 'مثلاً: info@example.com';
	$input_type        = 'email';
	$input_mode        = 'email';
} else {
	$input_label       = 'شماره موبایل یا ایمیل';
	$input_placeholder = 'شماره موبایل (0912...) یا ایمیل';
	$input_type        = 'text';
	$input_mode        = 'text';
}

$title         = ! empty( $args['title'] ) ? $args['title'] : Signa_Helper::get_option( 'form_title', 'ورود / ثبت‌نام' );
$subtitle      = ! empty( $args['subtitle'] ) ? $args['subtitle'] : Signa_Helper::get_option( 'form_subtitle', 'برای ادامه، شماره موبایل یا ایمیل خود را وارد کنید.' );
$btn_text      = ! empty( $args['button_text'] ) ? $args['button_text'] : Signa_Helper::get_option( 'button_text', 'دریافت کد تایید' );
$verify_text   = ! empty( $args['verify_button_text'] ) ? $args['verify_button_text'] : Signa_Helper::get_option( 'verify_button_text', 'تایید و ورود به حساب' );
$redirect_to   = ! empty( $args['redirect'] ) ? $args['redirect'] : '';
$context       = ! empty( $args['context'] ) ? $args['context'] : 'shortcode';
$form_layout   = ! empty( $args['form_layout'] ) ? $args['form_layout'] : Signa_Helper::get_option( 'form_layout', 'card' );
$card_position = ! empty( $args['card_position'] ) ? $args['card_position'] : Signa_Helper::get_option( 'card_position', 'center' );
$modal_style   = Signa_Helper::get_option( 'modal_style', 'center' );

// In narrow slide-over drawers or checkout banner, force compact single-card layout
$is_narrow_ctx    = ( 'wc-checkout' === $context ) || ( 'modal' === $context && in_array( $modal_style, array( 'drawer_left', 'drawer_right', 'bottom_sheet' ), true ) );
$effective_layout = $is_narrow_ctx ? 'card' : $form_layout;
$is_split_layout  = in_array( $effective_layout, array( 'split_right', 'split_left' ), true );
$wrapper_max_w    = $is_split_layout ? max( 820, $max_width * 2 ) : $max_width;

$split_bg_color   = Signa_Helper::get_option( 'split_bg_color', '#1e3a8a' );
$split_image_url  = trim( (string) Signa_Helper::get_option( 'split_image_url', '' ) );
$split_badge_text = Signa_Helper::get_option( 'split_badge_text', 'احراز هویت سریع و امن' );
$split_title      = Signa_Helper::get_option( 'split_title', 'ورود آسان و بدون فراموشی رمز عبور' );
$split_subtitle   = Signa_Helper::get_option( 'split_subtitle', '' );
$split_features   = array_filter( array_map( 'trim', explode( "\n", (string) Signa_Helper::get_option( 'split_features', '' ) ) ) );

$effective_card_bg = $glassmorphism ? Signa_Helper::hex_to_rgba( $card_bg_color, $card_bg_opacity ) : $card_bg_color;
$btn_bg_css        = ( 'gradient' === $button_bg_mode )
	? sprintf( 'linear-gradient(135deg, %s, %s)', $primary_color, $secondary_color )
	: $primary_color;
$glow_shadow_rgba  = Signa_Helper::hex_to_rgba( $primary_color, 45 );
$glow_border_rgba  = Signa_Helper::hex_to_rgba( $primary_color, 65 );
$font_stack_css    = Signa_Helper::get_font_stack( $font_family );

$inline_vars = sprintf(
	'--signa-primary:%s;--signa-secondary:%s;--signa-btn-bg:%s;--signa-bg:%s;--signa-text:%s;--signa-radius:%dpx;--signa-split-bg:%s;--signa-blur:%dpx;--signa-card-pad:%dpx;--signa-glow-shadow:%s;--signa-glow-border:%s;--signa-font:%s;--signa-title-size:%dpx;--signa-subtitle-size:%dpx;--signa-btn-size:%dpx;--signa-input-h:%dpx;--signa-input-bg:%s;--signa-border:%s;max-width:%dpx;',
	esc_attr( $primary_color ),
	esc_attr( $secondary_color ),
	esc_attr( $btn_bg_css ),
	esc_attr( $effective_card_bg ),
	esc_attr( $text_color ),
	$border_radius,
	esc_attr( $split_bg_color ),
	$backdrop_blur,
	$card_padding,
	esc_attr( $glow_shadow_rgba ),
	esc_attr( $glow_border_rgba ),
	esc_attr( $font_stack_css ),
	$title_size,
	$subtitle_size,
	$btn_size,
	$input_height,
	esc_attr( $input_bg_color ),
	esc_attr( $input_border_col ),
	$wrapper_max_w
);

$wrapper_classes = sprintf(
	'signa-otp-wrapper signa-digit-style-%s signa-layout-%s signa-pos-%s signa-shadow-%s signa-border-%s signa-btn-mode-%s signa-input-style-%s signa-addon-%s%s',
	esc_attr( $digit_box_style ),
	esc_attr( $effective_layout ),
	esc_attr( $card_position ),
	esc_attr( $card_shadow ),
	esc_attr( $card_border ),
	esc_attr( $button_bg_mode ),
	esc_attr( $input_style ),
	esc_attr( $input_addon ),
	$glassmorphism ? ' signa-glassmorphism' : ''
);
?>
<div class="<?php echo esc_attr( $wrapper_classes ); ?>" dir="rtl" style="<?php echo esc_attr( $inline_vars ); ?>" data-otp-length="<?php echo esc_attr( (string) $otp_length ); ?>" data-redirect="<?php echo esc_url( $redirect_to ); ?>" data-context="<?php echo esc_attr( $context ); ?>" data-passkey-prompt="<?php echo $enable_passkey && $passkey_prompt ? '1' : '0'; ?>">
	<div class="signa-otp-card">
		<div class="signa-otp-header">
			<?php if ( ! empty( $logo_url ) ) : ?>
				<div class="signa-otp-custom-logo">
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" loading="lazy" />
				</div>
			<?php else : ?>
				<div class="signa-otp-icon-badge" aria-hidden="true">
					<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
						<path d="m9 12 2 2 4-4"></path>
					</svg>
				</div>
			<?php endif; ?>
			<h3 class="signa-otp-title"><?php echo esc_html( $title ); ?></h3>
			<p class="signa-otp-subtitle" data-default-subtitle="<?php echo esc_attr( $subtitle ); ?>">
				<?php echo esc_html( $subtitle ); ?>
			</p>
		</div>

		<div class="signa-otp-alert" role="alert" style="display:none;"></div>

		<!-- Step 1: Request OTP -->
		<form class="signa-otp-form signa-step-request" novalidate>
			<div class="signa-field-group">
				<label class="signa-label"><?php echo esc_html( $input_label ); ?></label>
				<div class="signa-input-wrap">
					<input
						type="<?php echo esc_attr( $input_type ); ?>"
						inputmode="<?php echo esc_attr( $input_mode ); ?>"
						name="identifier"
						class="signa-input signa-identifier-input"
						placeholder="<?php echo esc_attr( $input_placeholder ); ?>"
						dir="rtl"
						autocomplete="username webauthn"
						required
					/>
					<?php if ( 'ir_flag' === $input_addon && 'email_only' !== $login_mode ) : ?>
						<span class="signa-input-addon is-flag" dir="ltr" aria-hidden="true"><span>🇮🇷</span><strong>+98</strong></span>
					<?php elseif ( 'icon' === $input_addon ) : ?>
						<span class="signa-input-addon is-icon" aria-hidden="true">
							<?php if ( 'email_only' === $login_mode ) : ?>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
							<?php else : ?>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
							<?php endif; ?>
						</span>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( 'math' === $captcha_type && $math_captcha ) : ?>
				<div class="signa-field-group signa-captcha-box">
					<label class="signa-label signa-captcha-question"><?php echo esc_html( $math_captcha['question'] ); ?></label>
					<input type="text" inputmode="numeric" name="captcha_answer" class="signa-input signa-captcha-answer" placeholder="پاسخ عدد را وارد کنید..." dir="rtl" required />
					<input type="hidden" name="captcha_token" class="signa-captcha-token" value="<?php echo esc_attr( $math_captcha['token'] ); ?>" />
				</div>
			<?php elseif ( 'arcaptcha' === $captcha_type && ! empty( $captcha_site_key ) ) : ?>
				<div class="signa-field-group signa-captcha-box" style="display:flex;justify-content:center;">
					<div class="arcaptcha" data-site-key="<?php echo esc_attr( $captcha_site_key ); ?>" data-lang="fa"></div>
				</div>
			<?php elseif ( 'turnstile' === $captcha_type && ! empty( $captcha_site_key ) ) : ?>
				<div class="signa-field-group signa-captcha-box" style="display:flex;justify-content:center;">
					<div class="cf-turnstile" data-sitekey="<?php echo esc_attr( $captcha_site_key ); ?>"></div>
				</div>
			<?php endif; ?>

			<?php if ( $show_terms && ! empty( $terms_text ) ) : ?>
				<div class="signa-terms-row">
					<?php if ( ! empty( $terms_url ) ) : ?>
						<a href="<?php echo esc_url( $terms_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $terms_text ); ?></a>
					<?php else : ?>
						<span><?php echo esc_html( $terms_text ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<button type="submit" class="signa-btn signa-btn-primary signa-submit-request">
				<span class="signa-btn-text"><?php echo esc_html( $btn_text ); ?></span>
				<span class="signa-spinner" style="display:none;"></span>
			</button>

			<?php if ( $enable_passkey ) : ?>
				<div class="signa-passkey-login-wrap" style="display:none;">
					<div class="signa-passkey-divider"><span>یا ورود بدون پیامک</span></div>
					<button type="button" class="signa-btn signa-btn-passkey signa-trigger-passkey-login">
						<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/><path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/><path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/><path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/><path d="M8.65 22c.21-.66.45-1.32.57-2"/><path d="M14 13.12c0 2.38 0 6.38-1 8.88"/><path d="M21.8 16c.2-2 .131-5.354 0-6"/><path d="M9 6.8a6 6 0 0 1 9 5.2c0 .47 0 1.17-.02 2"/></svg>
						<span class="signa-btn-text"><?php echo esc_html( $passkey_btn_text ); ?></span>
						<span class="signa-spinner" style="display:none;"></span>
					</button>
				</div>
			<?php endif; ?>

			<?php if ( $allow_password ) : ?>
				<div class="signa-alt-action">
					<button type="button" class="signa-btn-link signa-switch-to-password">
						ورود با رمز عبور ثابت
					</button>
				</div>
			<?php endif; ?>
		</form>

		<!-- Step 2: Verify OTP (+ Optional New User Profile Fields) -->
		<form class="signa-otp-form signa-step-verify" style="display:none;" novalidate>
			<div class="signa-recipient-bar">
				<div class="signa-recipient-meta">
					<span class="signa-channel-pill">کد ارسالی به:</span>
					<span class="signa-recipient-display" dir="ltr"></span>
				</div>
				<button type="button" class="signa-btn-link signa-change-identifier">
					✎ ویرایش
				</button>
			</div>

			<!-- New User Extra Registration Fields (Shown dynamically if user is new) -->
			<div class="signa-new-user-fields" style="display:none;">
				<div class="signa-field-group signa-reg-name-group" style="display:none;">
					<label class="signa-label">نام و نام خانوادگی <span class="signa-req-badge"></span></label>
					<input type="text" name="full_name" class="signa-input signa-reg-fullname" placeholder="مثلاً: علی محمدی" dir="rtl" />
				</div>
				<div class="signa-field-group signa-reg-email-group" style="display:none;">
					<label class="signa-label">آدرس ایمیل <span class="signa-req-badge"></span></label>
					<input type="email" name="user_email" class="signa-input signa-reg-email" placeholder="مثلاً: name@example.com" dir="rtl" />
				</div>
			</div>

			<div class="signa-field-group">
				<label class="signa-label" style="text-align:center;">کد تایید <?php echo esc_html( (string) $otp_length ); ?> رقمی را وارد کنید</label>
				<div class="signa-otp-digits" dir="ltr">
					<?php for ( $i = 0; $i < $otp_length; $i++ ) : ?>
						<input
							type="text"
							inputmode="numeric"
							pattern="[0-9]*"
							maxlength="1"
							class="signa-digit-box"
							data-index="<?php echo esc_attr( (string) $i ); ?>"
							<?php echo 0 === $i ? 'autocomplete="one-time-code"' : 'autocomplete="off"'; ?>
							aria-label="<?php echo esc_attr( sprintf( 'رقم %d کد تایید', $i + 1 ) ); ?>"
						/>
					<?php endfor; ?>
				</div>
				<input type="hidden" name="code" class="signa-otp-hidden-code" value="" />
			</div>

			<button type="submit" class="signa-btn signa-btn-primary signa-submit-verify">
				<span class="signa-btn-text"><?php echo esc_html( $verify_text ); ?></span>
				<span class="signa-spinner" style="display:none;"></span>
			</button>

			<div class="signa-resend-row">
				<div class="signa-timer-wrap">
					<span>ارسال مجدد کد تا </span>
					<strong class="signa-timer-countdown" dir="ltr">01:00</strong>
					<span> دیگر</span>
				</div>
				<button type="button" class="signa-btn-link signa-resend-btn" style="display:none;">
					↻ ارسال مجدد کد تایید
				</button>
			</div>
		</form>

		<?php if ( $allow_password ) : ?>
			<!-- Optional Step 3: Password Login Fallback -->
			<form class="signa-otp-form signa-step-password" style="display:none;" novalidate>
				<div class="signa-field-group">
					<label class="signa-label">شماره موبایل، ایمیل یا نام کاربری</label>
					<input type="text" name="pw_identifier" class="signa-input signa-pw-identifier" placeholder="شماره موبایل یا نام کاربری" dir="rtl" required />
				</div>
				<div class="signa-field-group">
					<label class="signa-label">رمز عبور</label>
					<input type="password" name="password" class="signa-input signa-pw-input" placeholder="رمز عبور خود را وارد کنید" dir="rtl" required />
				</div>
				<button type="submit" class="signa-btn signa-btn-primary signa-submit-password">
					<span class="signa-btn-text">ورود به حساب</span>
					<span class="signa-spinner" style="display:none;"></span>
				</button>
				<div class="signa-alt-action">
					<button type="button" class="signa-btn-link signa-switch-to-otp">
						ورود با کد یکبارمصرف (OTP)
					</button>
				</div>
			</form>
		<?php endif; ?>

		<?php if ( $enable_passkey && $passkey_prompt ) : ?>
			<!-- Optional Step 4: Post-Login 1-Click Biometric Passkey Enrollment Prompt -->
			<div class="signa-otp-form signa-step-passkey-enroll" style="display:none;text-align:center;">
				<div class="signa-pk-enroll-icon">
					<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/><path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/><path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/><path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/><path d="M8.65 22c.21-.66.45-1.32.57-2"/><path d="M14 13.12c0 2.38 0 6.38-1 8.88"/><path d="M21.8 16c.2-2 .131-5.354 0-6"/><path d="M9 6.8a6 6 0 0 1 9 5.2c0 .47 0 1.17-.02 2"/></svg>
				</div>
				<h4 style="margin:8px 0 6px 0;font-size:16px;font-weight:800;">ورود بعدی فقط با اثر انگشت یا چهره!</h4>
				<p style="margin:0 0 16px 0;font-size:13px;opacity:0.8;line-height:1.6;">
					می‌خواهید این دستگاه را ثبت کنید تا دفعات بعد بدون صبر کردن برای پیامک، در ۱ ثانیه وارد شوید؟
				</p>
				<button type="button" class="signa-btn signa-btn-primary signa-enroll-passkey-now">
					<span class="signa-btn-text">فعال‌سازی ورود بیومتریک (Passkey)</span>
					<span class="signa-spinner" style="display:none;"></span>
				</button>
				<div class="signa-alt-action" style="margin-top:12px;">
					<button type="button" class="signa-btn-link signa-skip-passkey-enroll">
						فعلاً نه، ادامه و ورود به سایت &larr;
					</button>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $is_split_layout ) : ?>
		<?php
		$banner_bg_style = ! empty( $split_image_url )
			? sprintf( 'background-color:%1$s;background-image:linear-gradient(135deg, rgba(15,23,42,0.72), rgba(30,58,138,0.78)), url(%2$s);background-size:cover;background-position:center;', esc_attr( $split_bg_color ), esc_url( $split_image_url ) )
			: sprintf( 'background-color:%1$s;background-image:radial-gradient(circle at top left, rgba(255,255,255,0.16), transparent 65%%);', esc_attr( $split_bg_color ) );
		?>
		<div class="signa-otp-side-banner" style="<?php echo esc_attr( $banner_bg_style ); ?>">
			<div class="signa-side-banner-top">
				<?php if ( ! empty( $split_badge_text ) ) : ?>
					<span class="signa-side-banner-badge"><?php echo esc_html( $split_badge_text ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $split_title ) ) : ?>
					<h3 class="signa-side-banner-title"><?php echo esc_html( $split_title ); ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $split_subtitle ) ) : ?>
					<p class="signa-side-banner-subtitle"><?php echo esc_html( $split_subtitle ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $split_features ) ) : ?>
				<ul class="signa-side-banner-features">
					<?php foreach ( $split_features as $feature_item ) : ?>
						<li>
							<span class="signa-side-feature-icon" aria-hidden="true">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
							</span>
							<span><?php echo esc_html( $feature_item ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
