<?php
/**
 * Signa OTP Login / Register Form Template
 *
 * Can be overridden by copying to yourtheme/signa/login-form.php
 *
 * @package Signa_OTP
 * @var array $args Template arguments.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$login_mode    = Signa_Helper::get_option( 'login_mode', 'phone_and_email' );
$otp_length    = absint( Signa_Helper::get_option( 'otp_length', 5 ) );
$primary_color = Signa_Helper::get_option( 'primary_color', '#2563eb' );

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
?>
<div class="signa-otp-wrapper" dir="rtl" style="--signa-primary: <?php echo esc_attr( $primary_color ); ?>;" data-otp-length="<?php echo esc_attr( (string) $otp_length ); ?>" data-redirect="<?php echo esc_url( $redirect_to ); ?>" data-context="<?php echo esc_attr( $context ); ?>">
	<div class="signa-otp-card">
		<div class="signa-otp-header">
			<div class="signa-otp-icon-badge" aria-hidden="true">
				<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
					<line x1="12" y1="18" x2="12.01" y2="18"></line>
				</svg>
			</div>
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

			<button type="submit" class="signa-btn signa-btn-primary signa-submit-request">
				<span class="signa-btn-text"><?php echo esc_html( $btn_text ); ?></span>
				<span class="signa-spinner" style="display:none;"></span>
			</button>
		</form>

		<!-- Step 2: Verify OTP -->
		<form class="signa-otp-form signa-step-verify" style="display:none;" novalidate>
			<div class="signa-recipient-bar">
				<span class="signa-recipient-display" dir="ltr"></span>
				<button type="button" class="signa-btn-link signa-change-identifier">
					ویرایش
				</button>
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
	</div>
</div>
