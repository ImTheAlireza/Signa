<?php
/**
 * Signa OTP Login / Register Form Template (v2.0)
 *
 * Can be overridden by copying to yourtheme/signa/login-form.php
 *
 * @package Signa_OTP
 * @var array $args Template arguments.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$login_mode          = Signa_Helper::get_option( 'login_mode', 'phone_and_email' );
$otp_length          = absint( Signa_Helper::get_option( 'otp_length', 5 ) );
$primary_color       = Signa_Helper::get_option( 'primary_color', '#2563eb' );
$card_bg_color       = Signa_Helper::get_option( 'card_bg_color', '#ffffff' );
$text_color          = Signa_Helper::get_option( 'text_color', '#111827' );
$border_radius       = absint( Signa_Helper::get_option( 'border_radius', 16 ) );
$digit_box_style     = Signa_Helper::get_option( 'digit_box_style', 'box' );
$logo_url            = trim( (string) Signa_Helper::get_option( 'logo_url', '' ) );
$max_width           = max( 320, min( 640, absint( Signa_Helper::get_option( 'form_max_width', 420 ) ) ) );
$allow_password      = (bool) Signa_Helper::get_option( 'allow_password_login', 0 );
$show_terms          = (bool) Signa_Helper::get_option( 'show_terms_checkbox', 0 );
$terms_text          = Signa_Helper::get_option( 'terms_text', 'ورود و ثبت‌نام شما به معنای پذیرش قوانین و مقررات سایت است.' );
$terms_url           = trim( (string) Signa_Helper::get_option( 'terms_url', '' ) );
$captcha_type        = Signa_Helper::get_option( 'captcha_type', 'none' );
$captcha_site_key    = trim( (string) Signa_Helper::get_option( 'captcha_site_key', '' ) );
$math_captcha        = 'math' === $captcha_type ? Signa_Security::generate_math_captcha() : null;

if ( 'phone_only' === $login_mode ) {
	$input_label       = 'شماره موبایل';
	$input_placeholder = 'مثلاً: 09123456789';
	$input_type        = 'tel';
	$input_mode        = 'tel';
} elseif ( 'email_only' === $login_mode ) {
	$input_label       = 'آدرس ایمیل';
	$input_placeholder = 'name@example.com';
	$input_type        = 'email';
	$input_mode        = 'email';
} else {
	$input_label       = 'شماره موبایل یا ایمیل';
	$input_placeholder = '09123456789 یا ایمیل';
	$input_type        = 'text';
	$input_mode        = 'text';
}

$title       = ! empty( $args['title'] ) ? $args['title'] : Signa_Helper::get_option( 'form_title', 'ورود / ثبت‌نام' );
$subtitle    = ! empty( $args['subtitle'] ) ? $args['subtitle'] : Signa_Helper::get_option( 'form_subtitle', 'برای ادامه، شماره موبایل یا ایمیل خود را وارد کنید.' );
$btn_text    = Signa_Helper::get_option( 'button_text', 'دریافت کد تایید' );
$verify_text = Signa_Helper::get_option( 'verify_button_text', 'تایید و ورود به حساب' );
$redirect_to = ! empty( $args['redirect'] ) ? $args['redirect'] : '';
$context     = ! empty( $args['context'] ) ? $args['context'] : 'shortcode';

$inline_vars = sprintf(
	'--signa-primary:%s;--signa-bg:%s;--signa-text:%s;--signa-radius:%dpx;max-width:%dpx;',
	esc_attr( $primary_color ),
	esc_attr( $card_bg_color ),
	esc_attr( $text_color ),
	$border_radius,
	$max_width
);
?>
<div class="signa-otp-wrapper signa-digit-style-<?php echo esc_attr( $digit_box_style ); ?>" dir="rtl" style="<?php echo esc_attr( $inline_vars ); ?>" data-otp-length="<?php echo esc_attr( (string) $otp_length ); ?>" data-redirect="<?php echo esc_url( $redirect_to ); ?>" data-context="<?php echo esc_attr( $context ); ?>">
	<div class="signa-otp-card">
		<div class="signa-otp-header">
			<?php if ( ! empty( $logo_url ) ) : ?>
				<div class="signa-otp-custom-logo">
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
				</div>
			<?php else : ?>
				<div class="signa-otp-icon-badge" aria-hidden="true">
					<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
						<line x1="12" y1="18" x2="12.01" y2="18"></line>
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
						dir="ltr"
						autocomplete="username"
						required
					/>
				</div>
			</div>

			<?php if ( 'math' === $captcha_type && $math_captcha ) : ?>
				<div class="signa-field-group signa-captcha-box">
					<label class="signa-label signa-captcha-question"><?php echo esc_html( $math_captcha['question'] ); ?></label>
					<input type="text" inputmode="numeric" name="captcha_answer" class="signa-input signa-captcha-answer" placeholder="پاسخ عدد..." dir="ltr" required />
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
				<span class="signa-recipient-display" dir="ltr"></span>
				<button type="button" class="signa-btn-link signa-change-identifier">
					ویرایش
				</button>
			</div>

			<!-- New User Extra Registration Fields (Shown dynamically if user is new) -->
			<div class="signa-new-user-fields" style="display:none;">
				<div class="signa-field-group signa-reg-name-group" style="display:none;">
					<label class="signa-label">نام و نام خانوادگی <span class="signa-req-badge"></span></label>
					<input type="text" name="full_name" class="signa-input signa-reg-fullname" placeholder="مثلاً: علی محمدی" style="text-align:right;" />
				</div>
				<div class="signa-field-group signa-reg-email-group" style="display:none;">
					<label class="signa-label">آدرس ایمیل <span class="signa-req-badge"></span></label>
					<input type="email" name="user_email" class="signa-input signa-reg-email" placeholder="name@example.com" dir="ltr" />
				</div>
			</div>

			<div class="signa-field-group">
				<label class="signa-label">کد تایید <?php echo esc_html( (string) $otp_length ); ?> رقمی را وارد کنید</label>
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
					ارسال مجدد کد تایید
				</button>
			</div>
		</form>

		<?php if ( $allow_password ) : ?>
			<!-- Optional Step 3: Password Login Fallback -->
			<form class="signa-otp-form signa-step-password" style="display:none;" novalidate>
				<div class="signa-field-group">
					<label class="signa-label">شماره موبایل، ایمیل یا نام کاربری</label>
					<input type="text" name="pw_identifier" class="signa-input signa-pw-identifier" placeholder="09123456789 یا نام کاربری" dir="ltr" required />
				</div>
				<div class="signa-field-group">
					<label class="signa-label">رمز عبور</label>
					<input type="password" name="password" class="signa-input signa-pw-input" placeholder="••••••••" dir="ltr" required />
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
	</div>
</div>
