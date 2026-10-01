/**
 * Signa OTP v2.0 - Enterprise SaaS Admin Dashboard Controller
 */
(function ($) {
	'use strict';

	$(function () {
		var $shell = $('#signa-app-shell');
		var $toast = $('#signa-toast');
		var toastTimer = null;

		function showToast(msg, isError) {
			if (toastTimer) {
				clearTimeout(toastTimer);
			}
			$toast
				.toggleClass('is-error', !!isError)
				.find('.signa-toast-text')
				.text(msg);
			$toast.fadeIn(180);
			toastTimer = setTimeout(function () {
				$toast.fadeOut(220);
			}, 3400);
		}

		// 1. Dark Mode Toggle with localStorage persistence
		function applyDarkMode(isDark) {
			$shell.toggleClass('is-dark', isDark);
			$('.signa-dark-icon').text(isDark ? '☀️' : '🌙');
		}

		try {
			var savedDark = localStorage.getItem('signa_admin_dark_mode') === '1';
			applyDarkMode(savedDark);
		} catch (e) {}

		$('#signa-theme-toggle').on('click', function () {
			var nextDark = !$shell.hasClass('is-dark');
			applyDarkMode(nextDark);
			try {
				localStorage.setItem('signa_admin_dark_mode', nextDark ? '1' : '0');
			} catch (e) {}
		});

		// 2. Sidebar Navigation Tabs
		var $navItems = $('.signa-nav-item');
		var $panels = $('.signa-panel');

		function activateTab(tabId) {
			if (!tabId || !$('#signa-tab-' + tabId).length) {
				return;
			}
			$navItems.removeClass('active');
			$navItems.filter('[data-tab="' + tabId + '"]').addClass('active');

			$panels.removeClass('active');
			$('#signa-tab-' + tabId).addClass('active');

			try {
				sessionStorage.setItem('signa_v2_active_tab', tabId);
			} catch (e) {}
		}

		$navItems.on('click', function () {
			activateTab($(this).attr('data-tab'));
		});

		$(document).on('click', '.signa-jump-tab', function () {
			var targetTab = $(this).attr('data-target-tab');
			if (targetTab) {
				activateTab(targetTab);
				window.scrollTo({ top: 0, behavior: 'smooth' });
			}
		});

		try {
			var lastTab = sessionStorage.getItem('signa_v2_active_tab');
			if (lastTab) {
				activateTab(lastTab);
			}
		} catch (e) {}

		// 3. Visual Radio Choice Cards
		$(document).on('change', '.signa-choice-card input[type="radio"]', function () {
			var name = $(this).attr('name');
			$('input[type="radio"][name="' + name + '"]')
				.closest('.signa-choice-card')
				.removeClass('selected');
			$(this).closest('.signa-choice-card').addClass('selected');
		});

		// 4. SMS Gateway Selector Cards & Inspector Pills
		var $gwHiddenInput = $('#active_sms_gateway');
		var $gwCards = $('.signa-gw-select-card');
		var $gwPills = $('.signa-gw-pill');
		var $gwBoxes = $('.signa-gateway-box');

		function showGatewayConfigBox(gwId) {
			$gwPills.removeClass('active');
			$gwPills.filter('[data-gw="' + gwId + '"]').addClass('active');
			$gwBoxes.hide();
			$gwBoxes.filter('[data-gateway="' + gwId + '"]').fadeIn(160);
		}

		if ($gwHiddenInput.length) {
			showGatewayConfigBox($gwHiddenInput.val());
		}

		$gwCards.on('click', function () {
			var $card = $(this);
			var gwId = $card.attr('data-gw-id');
			var gwTitle = $card.attr('data-gw-title');

			$gwCards.removeClass('selected');
			$card.addClass('selected');
			$gwHiddenInput.val(gwId);
			$('#signa-topbar-gw-name').text(gwTitle);
			showGatewayConfigBox(gwId);
		});

		$gwPills.on('click', function () {
			showGatewayConfigBox($(this).attr('data-gw'));
		});

		// 5. Interactive Appearance Studio & Live Preview
		function refreshLivePreview() {
			var primary = $('#primary_color').val() || '#2563eb';
			var bg = $('#card_bg_color').val() || '#ffffff';
			var text = $('#text_color').val() || '#111827';
			var radius = $('#border_radius').val() || 16;
			var digitStyle = $('#digit_box_style').val() || 'box';
			var logoUrl = ($('#logo_url').val() || '').trim();
			var title = $('#form_title').val() || 'ورود / ثبت‌نام';
			var subtitle = $('#form_subtitle').val() || '';
			var btn1 = $('#button_text').val() || 'دریافت کد تایید';
			var btn2 = $('#verify_button_text').val() || 'تایید و ورود به حساب';

			$('#primary_color_hex').text(primary);
			$('#card_bg_color_hex').text(bg);
			$('#text_color_hex').text(text);
			$('#radius_val_label').text(radius + 'px');

			var $card = $('#signa-live-preview-card');
			$card.css({
				background: bg,
				color: text,
				borderRadius: radius + 'px'
			});

			$('#signa-prev-badge-icon').css('color', primary);
			$('#signa-prev-title').text(title);
			$('#signa-prev-subtitle').text(subtitle);
			$('#signa-prev-btn-1').text(btn1).css({
				background: primary,
				borderRadius: Math.round(radius * 0.68) + 'px'
			});
			$('#signa-prev-btn-2').text(btn2).css({
				background: primary,
				borderRadius: Math.round(radius * 0.68) + 'px'
			});

			if (logoUrl) {
				$('#signa-prev-logo-img').attr('src', logoUrl);
				$('#signa-prev-logo-wrap').show();
				$('#signa-prev-badge-icon').hide();
			} else {
				$('#signa-prev-logo-wrap').hide();
				$('#signa-prev-badge-icon').css('display', 'inline-flex');
			}

			var $digits = $('.signa-prev-digit');
			if (digitStyle === 'underline') {
				$digits.css({
					border: 'none',
					borderBottom: '2.5px solid ' + primary,
					borderRadius: '0',
					background: 'transparent',
					color: text
				});
			} else if (digitStyle === 'pill') {
				$digits.css({
					border: '1.5px solid #cbd5e1',
					borderRadius: '99px',
					background: '#f8fafc',
					color: '#0f172a'
				});
			} else {
				$digits.css({
					border: '1.5px solid #cbd5e1',
					borderRadius: '9px',
					background: '#f8fafc',
					color: '#0f172a'
				});
			}
		}

		$('#primary_color, #card_bg_color, #text_color, #border_radius, #digit_box_style, #logo_url, #form_title, #form_subtitle, #button_text, #verify_button_text').on(
			'input change',
			refreshLivePreview
		);

		$('.signa-preset-btn').on('click', function () {
			var $btn = $(this);
			$('#primary_color').val($btn.attr('data-primary'));
			$('#card_bg_color').val($btn.attr('data-bg'));
			$('#text_color').val($btn.attr('data-text'));
			$('#border_radius').val($btn.attr('data-radius'));
			refreshLivePreview();
			showToast('پالت رنگی روی پیش‌نمایش اعمال شد!');
		});

		$('.signa-prev-step-btn').on('click', function () {
			var step = $(this).attr('data-step');
			$('.signa-prev-step-btn').removeClass('active');
			$(this).addClass('active');
			if (step === '2') {
				$('#signa-prev-step-1').hide();
				$('#signa-prev-step-2').fadeIn(150);
			} else {
				$('#signa-prev-step-2').hide();
				$('#signa-prev-step-1').fadeIn(150);
			}
		});

		// WordPress Media Uploader for Logo
		$('#signa_upload_logo_btn').on('click', function (e) {
			e.preventDefault();
			if (typeof wp === 'undefined' || !wp.media) {
				showToast('کتابخانه رسانه وردپرس در دسترس نیست.', true);
				return;
			}
			var frame = wp.media({
				title: 'انتخاب لوگوی فرم ورود',
				button: { text: 'استفاده از این تصویر' },
				multiple: false
			});
			frame.on('select', function () {
				var attachment = frame.state().get('selection').first().toJSON();
				if (attachment && attachment.url) {
					$('#logo_url').val(attachment.url).trigger('change');
				}
			});
			frame.open();
		});

		// 6. AJAX Save Settings, Unsaved Changes Indicator & Ctrl+S Shortcut
		var $settingsForm = $('#signa-settings-form');
		var $saveBtn = $('#signa-ajax-save-btn');
		var $unsavedDot = $('#signa-unsaved-dot');

		function markFormDirty() {
			$saveBtn.addClass('has-unsaved');
			$unsavedDot.show();
		}

		function clearFormDirty() {
			$saveBtn.removeClass('has-unsaved');
			$unsavedDot.hide();
		}

		$settingsForm.on('input change', 'input, select, textarea', function () {
			if ($(this).attr('id') === 'signa_test_recipient' || $(this).attr('id') === 'signa_import_json_box') {
				return;
			}
			markFormDirty();
		});

		$('.signa-gw-select-card, .signa-preset-btn').on('click', function () {
			markFormDirty();
		});

		$settingsForm.on('submit', function (e) {
			e.preventDefault();
			var rawArray = $settingsForm.serializeArray();
			var formData = [];
			for (var i = 0; i < rawArray.length; i++) {
				if (rawArray[i].name !== 'signa_save_settings' && rawArray[i].name !== 'signa_settings_nonce') {
					formData.push(rawArray[i]);
				}
			}
			formData.push({ name: 'action', value: 'signa_admin_save_settings' });
			formData.push({ name: 'nonce', value: signaAdminParams.nonce });

			$saveBtn.prop('disabled', true);
			$saveBtn.find('.signa-save-label').text('در حال ذخیره...');

			$.ajax({
				url: signaAdminParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: $.param(formData)
			})
				.done(function (res) {
					if (res && res.success) {
						clearFormDirty();
						showToast('✅ ' + res.data.message, false);
						if (res.data.settings) {
							$('#signa_export_json_box').val(JSON.stringify(res.data.settings));
						}
					} else {
						showToast('❌ خطا در ذخیره تنظیمات', true);
					}
				})
				.fail(function () {
					showToast('❌ خطا در ارتباط با سرور وردپرس', true);
				})
				.always(function () {
					$saveBtn.prop('disabled', false);
					$saveBtn.find('.signa-save-label').text('ذخیره تغییرات');
				});
		});

		$(document).on('keydown', function (e) {
			if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
				if ($settingsForm.length) {
					e.preventDefault();
					$settingsForm.trigger('submit');
				}
			}
		});

		// 7. Copy to Clipboard Buttons
		$(document).on('click', '.signa-copy-btn', function () {
			var text = $(this).attr('data-copy');
			if (navigator.clipboard && text) {
				navigator.clipboard.writeText(text).then(function () {
					showToast('📋 در کلیپ‌بورد کپی شد!');
				});
			}
		});

		// 8. Live Gateway Tester
		var $testBtn = $('#signa_run_test_btn');
		var $testResult = $('#signa_test_result');

		$testBtn.on('click', function () {
			var recipient = ($('#signa_test_recipient').val() || '').trim();
			var channel = $('#signa_test_channel').val();
			var gatewayId = $('#signa_test_gateway_id').val();

			if (!recipient) {
				showToast('لطفاً شماره موبایل یا ایمیل گیرنده تست را وارد کنید.', true);
				return;
			}

			$testBtn.prop('disabled', true).text('در حال ارسال کد آزمایشی...');
			$testResult.hide();

			$.ajax({
				url: signaAdminParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'signa_admin_test_gateway',
					nonce: signaAdminParams.nonce,
					recipient: recipient,
					channel: channel,
					gateway_id: gatewayId
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
					showToast('خطا در برقراری ارتباط با سرور', true);
				})
				.always(function () {
					$testBtn.prop('disabled', false).html('<span class="dashicons dashicons-controls-play"></span> ارسال کد آزمایشی همین الان');
				});
		});

		// 9. Unlock Active Lockout Button
		$(document).on('click', '.signa-unlock-btn', function () {
			var $btn = $(this);
			var target = $btn.attr('data-target');
			$btn.prop('disabled', true).text('در حال بازگشایی...');

			$.ajax({
				url: signaAdminParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'signa_admin_unlock_target',
					nonce: signaAdminParams.nonce,
					target: target
				}
			}).done(function (res) {
				if (res && res.success) {
					$btn.closest('tr').fadeOut(200);
					showToast('✅ مسدودی شماره/IP برطرف شد.');
				} else {
					$btn.prop('disabled', false).text('رفع مسدودی آنی (Unlock)');
				}
			});
		});

		// 10. Import JSON & Reset Settings
		$('#signa_import_settings_btn').on('click', function () {
			var jsonText = ($('#signa_import_json_box').val() || '').trim();
			if (!jsonText) {
				showToast('لطفاً ابتدا کد JSON تنظیمات را وارد کنید.', true);
				return;
			}
			$.ajax({
				url: signaAdminParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'signa_admin_import_settings',
					nonce: signaAdminParams.nonce,
					json_data: jsonText
				}
			}).done(function (res) {
				if (res && res.success) {
					showToast('✅ ' + res.data.message);
					setTimeout(function () {
						window.location.reload();
					}, 900);
				} else {
					showToast('❌ ' + (res && res.data ? res.data.message : 'خطا در درون‌ریزی'), true);
				}
			});
		});

		$('#signa_reset_defaults_btn').on('click', function () {
			if (!window.confirm('آیا مطمئن هستید که می‌خواهید تمام تنظیمات را به حالت پیش‌فرض بازنشانی کنید؟')) {
				return;
			}
			$.ajax({
				url: signaAdminParams.ajaxUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'signa_admin_reset_settings',
					nonce: signaAdminParams.nonce
				}
			}).done(function (res) {
				if (res && res.success) {
					showToast('✅ ' + res.data.message);
					setTimeout(function () {
						window.location.reload();
					}, 800);
				}
			});
		});
	});
})(jQuery);
