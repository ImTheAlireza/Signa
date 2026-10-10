/* Signa OTP – interactive demo (static, no server calls).
 * Mirrors the plugin's login form markup/classes so assets/css/frontend.css styles it exactly.
 * Nothing is sent anywhere: the demo code is 123456. */
(function () {
	'use strict';

	var DEMO_CODE = '123456';
	var MAX_ATTEMPTS = 3;
	var RESEND_SECONDS = 60;
	var RING_CIRC = 56.55; // 2 * pi * 9 (matches the plugin's ring markup)

	var DEFAULTS = { mode: 'page', layout: 'card', login: 'both', addon: 'icon', digits: 6, color: '#2563eb', radius: 16, font: 'vazirmatn' };
	var state = {};
	var flow = {};

	var stage = document.getElementById('stage');
	var panel = document.getElementById('stagePanel');
	var modeLabel = document.getElementById('modeLabel');
	var modeNames = { page: 'صفحه ورود', modal: 'مودال وسط', drawer_left: 'کشوی چپ', drawer_right: 'کشوی راست', sheet: 'شیت پایین' };

	/* ---------- helpers ---------- */
	function toEn(str) {
		return String(str || '').replace(/[\u06F0-\u06F9\u0660-\u0669]/g, function (c) {
			var code = c.charCodeAt(0);
			return String(code >= 0x06F0 ? code - 0x06F0 : code - 0x0660);
		});
	}

	// Same rule as frontend.js normalizeIrFlagInput(): strip +98 / 0098 / 98 prefixes and leading zeros.
	function normalizeIrFlag(str) {
		var s = String(str || '').trim();
		if (s.indexOf('@') !== -1 || !/^[0-9+\s\-]*$/.test(s)) {
			return s;
		}
		var d = s.replace(/[\s\-]/g, '');
		if (/^(\+98|0098|98)\d{10}$/.test(d)) {
			d = d.replace(/^(\+98|0098|98)/, '');
		}
		return d.replace(/\D/g, '').replace(/^0+/, '');
	}

	function isEmail(v) { return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v); }

	function fontStack(font) {
		return font === 'estedad'
			? "'Estedad', 'Vazirmatn', Tahoma, sans-serif"
			: "'Vazirmatn', Tahoma, -apple-system, BlinkMacSystemFont, sans-serif";
	}

	function varsString() {
		return [
			'--signa-primary:' + state.color,
			'--signa-btn-bg:' + state.color,
			'--signa-split-bg:' + state.color,
			'--signa-radius:' + state.radius + 'px',
			'--signa-font:' + fontStack(state.font)
		].join(';') + ';';
	}

	function loginLabel() {
		return state.login === 'phone' ? 'شماره موبایل' : state.login === 'email' ? 'آدرس ایمیل' : 'شماره موبایل یا ایمیل';
	}

	function placeholder() {
		var ir = state.addon === 'ir_flag';
		if (state.login === 'email') { return 'مثلاً: info@example.com'; }
		if (state.login === 'phone') { return ir ? 'مثلاً: 9123456789' : 'مثلاً: 09123456789'; }
		return ir ? 'شماره موبایل (912...) یا ایمیل' : 'شماره موبایل (0912...) یا ایمیل';
	}

	function addonHtml() {
		if (state.login === 'email') {
			return '';
		}
		if (state.addon === 'ir_flag') {
			return '<span class="signa-input-addon is-flag" dir="ltr" aria-hidden="true"><span>🇮🇷</span><strong>+98</strong></span>';
		}
		if (state.addon === 'icon') {
			return '<span class="signa-input-addon is-icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg></span>';
		}
		return '';
	}

	function digitBoxes() {
		var out = '';
		for (var i = 0; i < flow.digits; i++) {
			out += '<input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="signa-digit-box" data-index="' + i + '" aria-label="رقم ' + (i + 1) + ' کد تایید" autocomplete="' + (i === 0 ? 'one-time-code' : 'off') + '"/>';
		}
		return out;
	}

	function showAlert(msg, type) {
		var el = panel.querySelector('.signa-otp-alert');
		if (!el) { return; }
		if (!msg) { el.style.display = 'none'; el.textContent = ''; return; }
		el.className = 'signa-otp-alert is-' + (type || 'info');
		el.textContent = msg;
		el.style.display = 'block';
	}

	function setTitle(title, subtitle) {
		var t = panel.querySelector('.signa-otp-title');
		var s = panel.querySelector('.signa-otp-subtitle');
		if (t) { t.textContent = title; }
		if (s) { s.textContent = subtitle; }
	}

	function showStep(step) {
		flow.step = step;
		var req = panel.querySelector('.signa-step-request');
		var ver = panel.querySelector('.signa-step-verify');
		var done = panel.querySelector('.demo-success');
		if (req) { req.style.display = step === 'request' ? '' : 'none'; }
		if (ver) { ver.style.display = step === 'verify' ? '' : 'none'; }
		if (done) { done.style.display = step === 'done' ? '' : 'none'; }
	}

	/* ---------- rendering ---------- */
	function renderCard() {
		stopTimer();
		flow.digits = state.digits;
		flow.attempts = 0;
		flow.locked = false;
		flow.left = RESEND_SECONDS;
		var identifier = flow.identifier || '';

		var classes = [
			'signa-otp-wrapper',
			'signa-digit-style-connected',
			'signa-layout-' + state.layout,
			'signa-pos-center',
			'signa-shadow-medium',
			'signa-border-subtle',
			'signa-btn-mode-solid',
			'signa-input-style-filled',
			'signa-addon-' + state.addon,
			'signa-timer-circular_ring',
			'signa-anim-fade_up',
			'signa-theme-light'
		].join(' ');

		var banner = state.layout === 'card' ? '' :
			'<div class="signa-otp-side-banner" aria-hidden="false">' +
				'<span class="signa-banner-chip">احراز هویت سریع و امن</span>' +
				'<h4>ورود بدون نیاز به رمز عبور</h4>' +
				'<p>کد یکبارمصرف را در چند ثانیه دریافت کنید.</p>' +
				'<ul><li>بدون یادآوری رمز</li><li>پیامک، بله یا ایمیل</li><li>محافظت در برابر حدس زدن کد</li></ul>' +
			'</div>';

		var html =
			(state.mode === 'sheet' ? '<span class="stage-sheet-handle" aria-hidden="true"></span>' : '') +
			'<div class="' + classes + '" dir="rtl" style="' + varsString() + '" data-otp-length="' + state.digits + '">' +
				'<div class="signa-otp-card">' +
					'<div class="signa-otp-header">' +
						'<div class="signa-otp-icon-badge" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg></div>' +
						'<h3 class="signa-otp-title">ورود / ثبت‌نام</h3>' +
						'<p class="signa-otp-subtitle">برای ادامه، ' + (state.login === 'email' ? 'ایمیل' : state.login === 'phone' ? 'شماره موبایل' : 'شماره موبایل یا ایمیل') + ' خود را وارد کنید.</p>' +
					'</div>' +
					'<div class="signa-otp-alert" role="alert" style="display:none;"></div>' +

					'<form class="signa-otp-form signa-step-request" novalidate>' +
						'<div class="signa-field-group">' +
							'<label class="signa-label" for="demoIdentifier">' + loginLabel() + '</label>' +
							'<div class="signa-input-wrap">' +
								'<input id="demoIdentifier" type="text" inputmode="' + (state.login === 'email' ? 'email' : 'tel') + '" name="identifier" class="signa-input signa-identifier-input" placeholder="' + placeholder() + '" dir="rtl" autocomplete="off" value="' + identifier.replace(/"/g, '&quot;') + '" required/>' +
								addonHtml() +
							'</div>' +
						'</div>' +
						'<button type="submit" class="signa-btn signa-btn-primary signa-submit-request"><span class="signa-btn-text">دریافت کد تایید</span></button>' +
						'<div class="signa-alt-action"><span style="font-size:12px;color:var(--signa-muted,#6b7280);">کد آزمایشی دمو: <b dir="ltr">' + DEMO_CODE.slice(0, state.digits) + '</b></span></div>' +
					'</form>' +

					'<form class="signa-otp-form signa-step-verify" style="display:none;" novalidate>' +
						'<div class="signa-recipient-bar">' +
							'<div class="signa-recipient-meta"><span class="signa-channel-pill">کد ارسالی به:</span> <span class="signa-recipient-display" dir="ltr"></span></div>' +
							'<button type="button" class="signa-btn-link signa-change-identifier">✎ ویرایش</button>' +
						'</div>' +
						'<div class="signa-field-group">' +
							'<label class="signa-label" style="text-align:center;display:block;">کد تایید ' + state.digits + ' رقمی را وارد کنید</label>' +
							'<div class="signa-otp-digits" dir="ltr">' + digitBoxes() + '</div>' +
						'</div>' +
						'<button type="submit" class="signa-btn signa-btn-primary signa-submit-verify"><span class="signa-btn-text">تایید و ورود به حساب</span></button>' +
						'<div class="signa-resend-row">' +
							'<div class="signa-timer-wrap">' +
								'<div class="signa-timer-head">' +
									'<svg class="signa-timer-ring-svg" width="22" height="22" viewBox="0 0 24 24" aria-hidden="true"><circle class="signa-ring-bg" cx="12" cy="12" r="9" fill="none" stroke-width="2.5"></circle><circle class="signa-ring-fg" cx="12" cy="12" r="9" fill="none" stroke-width="2.5" stroke-dasharray="' + RING_CIRC + '" stroke-dashoffset="0" stroke-linecap="round"></circle></svg>' +
									'<span>ارسال مجدد کد تا </span><strong class="signa-timer-countdown" dir="ltr">01:00</strong><span> دیگر</span>' +
								'</div>' +
							'</div>' +
							'<button type="button" class="signa-btn-link signa-resend-btn" style="display:none;">↻ ارسال مجدد کد تایید</button>' +
						'</div>' +
					'</form>' +

					'<div class="demo-success" style="display:none;">' +
						'<div class="ok-ring" aria-hidden="true"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>' +
						'<h3>ورود موفق بود</h3>' +
						'<p>این نمونه‌ی دمو است. در سایت واقعی کاربر به حساب خود منتقل می‌شود.</p>' +
						'<button type="button" class="signa-btn signa-btn-primary signa-restart-demo"><span class="signa-btn-text">شروع دوباره‌ی دمو</span></button>' +
					'</div>' +
				'</div>' +
				banner +
			'</div>';

		panel.innerHTML = html;
		setTitle('ورود / ثبت‌نام', 'برای ادامه، ' + (state.login === 'email' ? 'ایمیل' : state.login === 'phone' ? 'شماره موبایل' : 'شماره موبایل یا ایمیل') + ' خود را وارد کنید.');
		showStep('request');
		showAlert('', 'info');
	}

	function applyVars() {
		var w = panel.querySelector('.signa-otp-wrapper');
		if (w) { w.setAttribute('style', varsString()); }
	}

	/* ---------- flow ---------- */
	function setRecipient() {
		var el = panel.querySelector('.signa-recipient-display');
		var v = flow.identifier;
		if (el) {
			el.textContent = state.addon === 'ir_flag' && v.indexOf('@') === -1 ? '+98 ' + v : v;
		}
	}

	function setDigits(value) {
		var boxes = panel.querySelectorAll('.signa-digit-box');
		for (var i = 0; i < boxes.length; i++) {
			boxes[i].value = value ? (value[i] || '') : '';
			boxes[i].classList.toggle('is-filled', !!boxes[i].value);
		}
		var wrap = panel.querySelector('.signa-otp-digits');
		if (wrap) { wrap.classList.remove('demo-wrong'); }
	}

	function getDigits() {
		var boxes = panel.querySelectorAll('.signa-digit-box');
		var s = '';
		for (var i = 0; i < boxes.length; i++) { s += boxes[i].value; }
		return s;
	}

	// The demo code is always 123456; with fewer digits it is the first N digits.
	function demoCode() {
		return DEMO_CODE.slice(0, flow.digits);
	}

	function setLocked(locked) {
		var boxes = panel.querySelectorAll('.signa-digit-box');
		for (var i = 0; i < boxes.length; i++) { boxes[i].disabled = locked; }
		var btn = panel.querySelector('.signa-submit-verify');
		if (btn) { btn.disabled = locked; }
	}

	function startTimer() {
		stopTimer();
		flow.left = RESEND_SECONDS;
		updateTimer();
		var head = panel.querySelector('.signa-timer-head');
		var btn = panel.querySelector('.signa-resend-btn');
		if (head) { head.style.display = ''; }
		if (btn) { btn.style.display = 'none'; }
		flow.timerId = setInterval(function () {
			flow.left -= 1;
			updateTimer();
			if (flow.left <= 0) {
				stopTimer();
				if (head) { head.style.display = 'none'; }
				if (btn) { btn.style.display = ''; }
			}
		}, 1000);
	}

	function updateTimer() {
		var cd = panel.querySelector('.signa-timer-countdown');
		var fg = panel.querySelector('.signa-ring-fg');
		var s = Math.max(0, flow.left);
		var mm = Math.floor(s / 60), ss = s % 60;
		if (cd) { cd.textContent = (mm < 10 ? '0' + mm : String(mm)) + ':' + (ss < 10 ? '0' + ss : String(ss)); }
		if (fg) { fg.style.strokeDashoffset = String(RING_CIRC * (1 - s / RESEND_SECONDS)); }
	}

	function stopTimer() {
		if (flow.timerId) { clearInterval(flow.timerId); flow.timerId = null; }
	}

	function goToVerify() {
		showStep('verify');
		setRecipient();
		setDigits('');
		setLocked(false);
		startTimer();
		showAlert('کد آزمایشی دمو: ' + demoCode() + ' (پیامکی ارسال نشد)', 'info');
		var first = panel.querySelector('.signa-digit-box');
		if (first) { first.focus(); }
	}

	function goToRequest() {
		stopTimer();
		showStep('request');
		setTitle('ورود / ثبت‌نام', 'برای ادامه، ' + (state.login === 'email' ? 'ایمیل' : state.login === 'phone' ? 'شماره موبایل' : 'شماره موبایل یا ایمیل') + ' خود را وارد کنید.');
		showAlert('', 'info');
		var input = panel.querySelector('.signa-identifier-input');
		if (input) { input.focus(); }
	}

	function handleRequest(e) {
		e.preventDefault();
		var input = panel.querySelector('.signa-identifier-input');
		var raw = toEn(input.value).trim();
		var value = state.addon === 'ir_flag' ? normalizeIrFlag(raw) : raw;
		var err = '';
		var asEmail = raw.indexOf('@') !== -1;

		if (!value) {
			err = 'لطفاً ' + (state.login === 'email' ? 'ایمیل' : state.login === 'phone' ? 'شماره موبایل' : 'شماره موبایل یا ایمیل') + ' خود را وارد کنید.';
		} else if (asEmail) {
			if (state.login === 'phone') { err = 'در این حالت فقط شماره موبایل پذیرفته می‌شود.'; }
			else if (!isEmail(raw)) { err = 'ایمیل وارد شده معتبر نیست.'; }
		} else if (state.login === 'email') {
			err = 'در این حالت فقط ایمیل پذیرفته می‌شود.';
		} else if (state.addon === 'ir_flag') {
			if (!/^9\d{9}$/.test(value)) { err = 'شماره را بدون صفر اول و با ۱۰ رقم وارد کنید؛ مثلاً 9123456789.'; }
		} else {
			var phone = value.replace(/^(\+98|0098)/, '0');
			if (!/^09\d{9}$/.test(phone)) { err = 'شماره موبایل باید ۱۱ رقمی و با 09 شروع شود.'; }
			else { value = phone; }
		}

		if (err) {
			showAlert(err, 'error');
			if (input) { input.focus(); }
			return;
		}
		flow.identifier = value;
		if (input) { input.value = value; }
		goToVerify();
	}

	function handleVerify(e) {
		if (e) { e.preventDefault(); }
		if (flow.locked) { return; }
		var code = getDigits();
		if (code.length < flow.digits) {
			showAlert('کد را کامل وارد کنید.', 'error');
			var boxes = panel.querySelectorAll('.signa-digit-box');
			for (var i = 0; i < boxes.length; i++) {
				if (!boxes[i].value) { boxes[i].focus(); break; }
			}
			return;
		}
		if (code === demoCode()) {
			stopTimer();
			showAlert('', 'info');
			showStep('done');
			setTitle('خوش آمدید', '');
			return;
		}
		flow.attempts += 1;
		setDigits('');
		var wrap = panel.querySelector('.signa-otp-digits');
		if (wrap) {
			wrap.classList.remove('is-shake');
			void wrap.offsetWidth;
			wrap.classList.add('is-shake', 'demo-wrong');
		}
		var remain = MAX_ATTEMPTS - flow.attempts;
		if (remain <= 0) {
			flow.locked = true;
			setLocked(true);
			showAlert('تعداد تلاش‌ها به پایان رسید. برای دریافت کد جدید «ارسال مجدد» را بزنید.', 'error');
			var resend = panel.querySelector('.signa-resend-btn');
			var head = panel.querySelector('.signa-timer-head');
			if (head) { head.style.display = 'none'; }
			if (resend) { resend.style.display = ''; }
			stopTimer();
		} else {
			showAlert('کد وارد شده اشتباه است. ' + remain + ' تلاش دیگر باقی مانده است.', 'error');
			var first = panel.querySelector('.signa-digit-box');
			if (first) { first.focus(); }
		}
	}

	function resendCode() {
		flow.locked = false;
		flow.attempts = 0;
		setLocked(false);
		setDigits('');
		startTimer();
		showAlert('کد جدید (دمو) ارسال شد: ' + demoCode(), 'info');
		var first = panel.querySelector('.signa-digit-box');
		if (first) { first.focus(); }
	}

	function restartFlow() {
		flow.identifier = '';
		renderCard();
	}

	/* ---------- panel events (delegated) ---------- */
	panel.addEventListener('submit', function (e) {
		if (e.target.matches('.signa-step-request')) { handleRequest(e); }
		else if (e.target.matches('.signa-step-verify')) { handleVerify(e); }
	});

	panel.addEventListener('click', function (e) {
		var t = e.target;
		if (t.closest('.signa-change-identifier')) { goToRequest(); }
		else if (t.closest('.signa-resend-btn')) { resendCode(); }
		else if (t.closest('.signa-restart-demo')) { restartFlow(); }
	});

	panel.addEventListener('input', function (e) {
		var t = e.target;
		if (t.matches('.signa-identifier-input')) {
			var converted = toEn(t.value);
			if (state.addon === 'ir_flag') { converted = normalizeIrFlag(converted); }
			if (converted !== t.value) { t.value = converted; }
		} else if (t.matches('.signa-digit-box')) {
			var idx = parseInt(t.getAttribute('data-index'), 10);
			var val = toEn(t.value).replace(/\D/g, '').slice(-1);
			t.value = val;
			t.classList.toggle('is-filled', !!val);
			var wrap = panel.querySelector('.signa-otp-digits');
			if (wrap) { wrap.classList.remove('demo-wrong'); }
			if (val && idx < flow.digits - 1) {
				var next = panel.querySelectorAll('.signa-digit-box')[idx + 1];
				if (next) { next.focus(); }
			}
			if (getDigits().length === flow.digits && !flow.locked) { handleVerify(null); }
		}
	});

	panel.addEventListener('keydown', function (e) {
		var t = e.target;
		if (t.matches('.signa-digit-box') && e.key === 'Backspace' && !t.value) {
			var idx = parseInt(t.getAttribute('data-index'), 10);
			var prev = panel.querySelectorAll('.signa-digit-box')[idx - 1];
			if (prev) { prev.value = ''; prev.classList.remove('is-filled'); prev.focus(); e.preventDefault(); }
		}
	});

	panel.addEventListener('paste', function (e) {
		var t = e.target;
		if (!t.matches('.signa-digit-box')) { return; }
		e.preventDefault();
		var text = toEn((e.clipboardData || window.clipboardData).getData('text')).replace(/\D/g, '').slice(0, flow.digits);
		setDigits(text);
		var boxes = panel.querySelectorAll('.signa-digit-box');
		if (boxes[text.length - 1]) { boxes[Math.min(text.length, flow.digits - 1)].focus(); }
		if (text.length === flow.digits && !flow.locked) { handleVerify(null); }
	});

	/* ---------- controls ---------- */
	function setMode(mode) {
		state.mode = mode;
		stage.setAttribute('data-mode', mode);
		stage.classList.toggle('is-overlay', mode !== 'page');
		modeLabel.textContent = 'حالت: ' + modeNames[mode];
		syncSeg('segMode', 'mode', mode);
		restartFlow();
	}

	function syncSeg(groupId, key, value) {
		var buttons = document.querySelectorAll('#' + groupId + ' button');
		for (var i = 0; i < buttons.length; i++) {
			buttons[i].setAttribute('aria-pressed', String(buttons[i].getAttribute('data-' + key) === String(value)));
		}
	}

	function bindSeg(groupId, key, cast, onChange) {
		var group = document.getElementById(groupId);
		group.addEventListener('click', function (e) {
			var btn = e.target.closest('button');
			if (!btn) { return; }
			state[key] = cast ? cast(btn.getAttribute('data-' + key)) : btn.getAttribute('data-' + key);
			syncSeg(groupId, key, state[key]);
			onChange();
		});
	}

	function setColor(c) {
		state.color = c;
		document.getElementById('colorInput').value = c;
		applyVars();
	}

	function setRadius(r) {
		state.radius = r;
		document.getElementById('radiusRange').value = String(r);
		document.getElementById('radiusOut').textContent = r + 'px';
		applyVars();
	}

	bindSeg('segMode', 'mode', null, function () { setMode(state.mode); });
	bindSeg('segLayout', 'layout', null, restartFlow);
	bindSeg('segLogin', 'login', null, restartFlow);
	bindSeg('segAddon', 'addon', null, restartFlow);
	bindSeg('segDigits', 'digits', function (v) { return parseInt(v, 10); }, restartFlow);

	document.querySelectorAll('#swatches button[data-color]').forEach(function (b) {
		b.addEventListener('click', function () { setColor(b.getAttribute('data-color')); });
	});
	document.getElementById('colorInput').addEventListener('input', function (e) { setColor(e.target.value); });
	document.getElementById('radiusRange').addEventListener('input', function (e) { setRadius(parseInt(e.target.value, 10)); });
	document.getElementById('fontSelect').addEventListener('change', function (e) { state.font = e.target.value; applyVars(); });
	document.getElementById('resetFlow').addEventListener('click', restartFlow);
	document.getElementById('resetAll').addEventListener('click', function () {
		state = JSON.parse(JSON.stringify(DEFAULTS));
		flow.identifier = '';
		document.getElementById('fontSelect').value = state.font;
		setColor(state.color);
		setRadius(state.radius);
		syncSeg('segLayout', 'layout', state.layout);
		syncSeg('segLogin', 'login', state.login);
		syncSeg('segAddon', 'addon', state.addon);
		syncSeg('segDigits', 'digits', state.digits);
		setMode(state.mode);
	});

	/* ---------- boot ---------- */
	state = JSON.parse(JSON.stringify(DEFAULTS));
	flow = { step: 'request', identifier: '', attempts: 0, locked: false, left: RESEND_SECONDS, timerId: null, digits: state.digits };
	setColor(state.color);
	setRadius(state.radius);
	setMode(state.mode);
})();
