/**
 * Signa OTP Frontend Controller
 */
(function ($) {
	'use strict';

	/**
	 * Convert Persian and Arabic numerals to English numerals
	 *
	 * @param {string} str
	 * @return {string}
	 */
	function toEnglishDigits(str) {
		if (!str) {
			return '';
		}
		var persian = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
		var arabic = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
		var result = String(str);
		for (var i = 0; i < 10; i++) {
			result = result.replace(persian[i], i).replace(arabic[i], i);
		}
		return result;
	}

	/**
	 * Format seconds into MM:SS
	 *
	 * @param {number} seconds
	 * @return {string}
	 */
	function formatCountdown(seconds) {
		var s = Math.max(0, parseInt(seconds, 10) || 0);
		var mins = Math.floor(s / 60);
		var secs = s % 60;
		return (mins < 10 ? '0' + mins : mins) + ':' + (secs < 10 ? '0' + secs : secs);
	}

	/**
	 * Initialize a single .signa-otp-wrapper instance
	 *
	 * @param {jQuery} $wrapper
	 */
	function initOtpWrapper($wrapper) {
		if ($wrapper.data('signa-initialized')) {
			return;
		}
		$wrapper.data('signa-initialized', true);

		var $stepRequest = $wrapper.find('.signa-step-request');
		var $stepVerify = $wrapper.find('.signa-step-verify');
		var $identifierInput = $wrapper.find('.signa-identifier-input');
		var $digitBoxes = $wrapper.find('.signa-digit-box');
		var $hiddenCode = $wrapper.find('.signa-otp-hidden-code');
		var $alert = $wrapper.find('.signa-otp-alert');
		var $recipientDisplay = $wrapper.find('.signa-recipient-display');
		var $timerWrap = $wrapper.find('.signa-timer-wrap');
		var $timerCountdown = $wrapper.find('.signa-timer-countdown');
		var $resendBtn = $wrapper.find('.signa-resend-btn');
		var $changeBtn = $wrapper.find('.signa-change-identifier');

		var otpLength = parseInt($wrapper.attr('data-otp-length'), 10) || 5;
		var redirectTo = $wrapper.attr('data-redirect') || '';
		var currentIdentifier = '';
		var timerInterval = null;

		function showAlert(message, type) {
			$alert
				.removeClass('is-error is-success is-info')
				.addClass('is-' + (type || 'info'))
				.html(message)
				.slideDown(180);
		}

		function hideAlert() {
			$alert.slideUp(150);
		}

		function setLoading($btn, isLoading) {
			$btn.prop('disabled', isLoading);
			if (isLoading) {
				$btn.find('.signa-spinner').show();
			} else {
				$btn.find('.signa-spinner').hide();
			}
		}

		function startCountdown(seconds) {
			if (timerInterval) {
				clearInterval(timerInterval);
			}
			var remaining = parseInt(seconds, 10) || 60;
			$resendBtn.hide();
			$timerWrap.show();
			$timerCountdown.text(formatCountdown(remaining));

			timerInterval = setInterval(function () {
				remaining--;
				if (remaining <= 0) {
					clearInterval(timerInterval);
					$timerWrap.hide();
					$resendBtn.fadeIn(150);
				} else {
					$timerCountdown.text(formatCountdown(remaining));
				}
			}, 1000);
		}

		function syncDigitsToHidden() {
			var code = '';
			$digitBoxes.each(function () {
				code += toEnglishDigits($(this).val());
			});
			$hiddenCode.val(code);
			return code;
		}

		function clearDigits() {
			$digitBoxes.val('');
			$hiddenCode.val('');
		}

		// Convert Persian/Arabic digits live on identifier input
		$identifierInput.on('input', function () {
			var converted = toEnglishDigits($(this).val());
			if (converted !== $(this).val()) {
				$(this).val(converted);
			}
		});

		// Handle Segmented OTP Digit Boxes
		$digitBoxes.on('input', function () {
			var $this = $(this);
			var val = toEnglishDigits($this.val()).replace(/[^0-9]/g, '');
			$this.val(val.slice(-1));

			var fullCode = syncDigitsToHidden();
			var idx = parseInt($this.attr('data-index'), 10);

			if (val && idx < otpLength - 1) {
				$digitBoxes.eq(idx + 1).trigger('focus').trigger('select');
			}

			if (fullCode.length === otpLength) {
				$stepVerify.trigger('submit');
			}
		});

		$digitBoxes.on('keydown', function (e) {
			var $this = $(this);
			var idx = parseInt($this.attr('data-index'), 10);

			if (e.key === 'Backspace' && !$this.val() && idx > 0) {
				$digitBoxes.eq(idx - 1).val('').trigger('focus');
				syncDigitsToHidden();
			} else if (e.key === 'ArrowLeft' && idx > 0) {
				$digitBoxes.eq(idx - 1).trigger('focus');
			} else if (e.key === 'ArrowRight' && idx < otpLength - 1) {
				$digitBoxes.eq(idx + 1).trigger('focus');
			}
		});

		// Support pasting full OTP code into any digit box
		$digitBoxes.on('paste', function (e) {
			var clipboardData = (e.originalEvent || e).clipboardData;
			if (!clipboardData) {
				return;
			}
			var pasted = toEnglishDigits(clipboardData.getData('text')).replace(/[^0-9]/g, '');
			if (pasted.length > 1) {
				e.preventDefault();
				for (var i = 0; i < otpLength; i++) {
					$digitBoxes.eq(i).val(pasted.charAt(i) || '');
				}
				var code = syncDigitsToHidden();
				if (code.length === otpLength) {
					$stepVerify.trigger('submit');
				}
			}
		});

		// Try WebOTP API for mobile browsers
		function listenForWebOTP() {
			if ('OTPCredential' in window && navigator.credentials) {
				var ac = new AbortController();
				navigator.credentials
					.get({
						otp: { transport: ['sms'] },
						signal: ac.signal
					})
					.then(function (otp) {
						if (otp && otp.code) {
							var clean = toEnglishDigits(otp.code).replace(/[^0-9]/g, '');
							for (var i = 0; i < otpLength; i++) {
								$digitBoxes.eq(i).val(clean.charAt(i) || '');
							}
							if (syncDigitsToHidden().length === otpLength) {
								$stepVerify.trigger('submit');
							}
						}
					})
					.catch(function () {
						// Ignore abort or unsupported
					});
			}
		}

		// Step 1: Request OTP
		function requestOtp(identifier) {
			var $submitBtn = $stepRequest.find('.signa-submit-request');
			hideAlert();
			setLoading($submitBtn, true);

			$.ajax({
				url: signaOtpParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'signa_request_otp',
					nonce: signaOtpParams.nonce,
					identifier: identifier
				}
			})
				.done(function (res) {
					if (res && res.success) {
						currentIdentifier = res.data.identifier;
						$recipientDisplay.text(res.data.masked || currentIdentifier);
						$stepRequest.hide();
						$stepVerify.fadeIn(200);
						clearDigits();

						var msg = res.data.message;
						if (res.data.debug_code) {
							msg += '<br><strong>کد آزمایشی (Sandbox): <code dir="ltr">' + res.data.debug_code + '</code></strong>';
						}
						showAlert(msg, 'success');
						startCountdown(res.data.cooldown || 60);
						setTimeout(function () {
							$digitBoxes.eq(0).trigger('focus');
						}, 220);
						listenForWebOTP();
					} else {
						var errMsg = res && res.data && res.data.message ? res.data.message : signaOtpParams.i18n.networkError;
						showAlert(errMsg, 'error');
					}
				})
				.fail(function () {
					showAlert(signaOtpParams.i18n.networkError, 'error');
				})
				.always(function () {
					setLoading($submitBtn, false);
				});
		}

		$stepRequest.on('submit', function (e) {
			e.preventDefault();
			var val = toEnglishDigits($identifierInput.val()).trim();
			if (!val) {
				showAlert('لطفاً شماره موبایل یا ایمیل خود را وارد کنید.', 'error');
				$identifierInput.trigger('focus');
				return;
			}
			requestOtp(val);
		});

		// Change identifier button (Go back to Step 1)
		$changeBtn.on('click', function () {
			if (timerInterval) {
				clearInterval(timerInterval);
			}
			hideAlert();
			$stepVerify.hide();
			$stepRequest.fadeIn(180);
			$identifierInput.trigger('focus').trigger('select');
		});

		// Resend button
		$resendBtn.on('click', function () {
			if (currentIdentifier) {
				requestOtp(currentIdentifier);
			}
		});

		// Step 2: Verify OTP
		$stepVerify.on('submit', function (e) {
			e.preventDefault();
			var code = syncDigitsToHidden();
			if (code.length < otpLength) {
				showAlert('لطفاً کد تایید را به صورت کامل وارد کنید.', 'error');
				return;
			}

			var $verifyBtn = $stepVerify.find('.signa-submit-verify');
			hideAlert();
			setLoading($verifyBtn, true);

			$.ajax({
				url: signaOtpParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'signa_verify_otp',
					nonce: signaOtpParams.nonce,
					identifier: currentIdentifier,
					code: code,
					redirect_to: redirectTo
				}
			})
				.done(function (res) {
					if (res && res.success) {
						showAlert(res.data.message, 'success');
						setTimeout(function () {
							if (res.data.redirect_to) {
								window.location.href = res.data.redirect_to;
							} else {
								window.location.reload();
							}
						}, 600);
					} else {
						var errMsg = res && res.data && res.data.message ? res.data.message : signaOtpParams.i18n.networkError;
						showAlert(errMsg, 'error');
						setLoading($verifyBtn, false);
					}
				})
				.fail(function () {
					showAlert(signaOtpParams.i18n.networkError, 'error');
					setLoading($verifyBtn, false);
				});
		});
	}

	$(function () {
		// Initialize all OTP forms on page
		$('.signa-otp-wrapper').each(function () {
			initOtpWrapper($(this));
		});

		// Global Modal Open / Close
		var $modal = $('#signa-otp-modal');
		$(document).on('click', '.signa-open-modal, a[href="#signa-login-modal"]', function (e) {
			if ($modal.length) {
				e.preventDefault();
				$modal.fadeIn(180);
				$modal.find('.signa-identifier-input').trigger('focus');
			}
		});

		$(document).on('click', '.signa-modal-close', function () {
			$modal.fadeOut(150);
		});

		$modal.on('click', function (e) {
			if ($(e.target).is('.signa-modal-overlay')) {
				$modal.fadeOut(150);
			}
		});

		$(document).on('keydown', function (e) {
			if (e.key === 'Escape' && $modal.is(':visible')) {
				$modal.fadeOut(150);
			}
		});

		// WooCommerce Checkout OTP Toggle
		$(document).on('click', '.signa-toggle-checkout-otp', function () {
			$('.signa-wc-checkout-form-holder').slideToggle(200);
		});
	});
})(jQuery);
