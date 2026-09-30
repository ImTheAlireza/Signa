/**
 * Signa OTP Admin Dashboard Scripts
 */
(function ($) {
	'use strict';

	$(function () {
		// 1. Tab Switching with sessionStorage persistence
		var $tabBtns = $('.signa-tab-btn');
		var $tabPanels = $('.signa-tab-panel');

		function activateTab(tabId) {
			if (!tabId || !$('#signa-tab-' + tabId).length) {
				return;
			}
			$tabBtns.removeClass('active');
			$tabBtns.filter('[data-tab="' + tabId + '"]').addClass('active');

			$tabPanels.removeClass('active');
			$('#signa-tab-' + tabId).addClass('active');

			try {
				sessionStorage.setItem('signa_active_admin_tab', tabId);
			} catch (e) {}
		}

		$tabBtns.on('click', function () {
			activateTab($(this).attr('data-tab'));
		});

		try {
			var savedTab = sessionStorage.getItem('signa_active_admin_tab');
			if (savedTab) {
				activateTab(savedTab);
			}
		} catch (e) {}

		// 2. Active SMS Gateway Box Toggle
		var $gatewaySelect = $('#active_sms_gateway');
		var $gatewayBoxes = $('.signa-gateway-box');

		function updateGatewayBox() {
			var selected = $gatewaySelect.val();
			$gatewayBoxes.hide();
			$gatewayBoxes.filter('[data-gateway="' + selected + '"]').fadeIn(150);
		}

		if ($gatewaySelect.length) {
			updateGatewayBox();
			$gatewaySelect.on('change', updateGatewayBox);
		}

		// 3. Live Gateway Tester AJAX
		var $testBtn = $('#signa_run_test_btn');
		var $testResult = $('#signa_test_result');

		$testBtn.on('click', function () {
			var recipient = $('#signa_test_recipient').val().trim();
			var channel = $('#signa_test_channel').val();

			if (!recipient) {
				$testResult
					.css({ background: '#fef2f2', color: '#b91c1c', border: '1px solid #fecaca' })
					.text('لطفاً شماره موبایل یا ایمیل گیرنده تست را وارد کنید.')
					.slideDown(150);
				return;
			}

			$testBtn.prop('disabled', true).text('در حال ارسال...');
			$testResult.hide();

			$.ajax({
				url: signaAdminParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'signa_admin_test_gateway',
					nonce: signaAdminParams.nonce,
					recipient: recipient,
					channel: channel
				}
			})
				.done(function (res) {
					if (res && res.success) {
						$testResult
							.css({ background: '#f0fdf4', color: '#15803d', border: '1px solid #bbf7d0' })
							.html('<strong>✅ ' + res.data.message + '</strong>')
							.slideDown(150);
					} else {
						var err = res && res.data && res.data.message ? res.data.message : 'خطای نامشخص';
						$testResult
							.css({ background: '#fef2f2', color: '#b91c1c', border: '1px solid #fecaca' })
							.html('<strong>❌ ' + err + '</strong>')
							.slideDown(150);
					}
				})
				.fail(function () {
					$testResult
						.css({ background: '#fef2f2', color: '#b91c1c', border: '1px solid #fecaca' })
						.text('خطا در ارتباط با سرور وردپرس.')
						.slideDown(150);
				})
				.always(function () {
					$testBtn.prop('disabled', false).text('ارسال کد آزمایشی');
				});
		});
	});
})(jQuery);
