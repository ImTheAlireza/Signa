/* Hero phone simulation (static, no server calls).
 * Flow: enter an Iranian mobile number -> "sending" -> a random 5-digit code is generated
 * and shown in an iPhone-style notification -> user types it (or taps the notification)
 * -> phone fades out and a success card appears with a restart button.
 * Nothing is sent anywhere. */
(function () {
	'use strict';

	var root = document.getElementById('heroPhone');
	if (!root) { return; }

	var success = document.getElementById('heroSuccess');
	var form = root.querySelector('.hp-form');
	var input = document.getElementById('heroNumber');
	var sendBtn = root.querySelector('.hp-form .hp-send');
	var sendTxt = root.querySelector('.hp-send-txt');
	var loginErr = root.querySelector('.hp-err-login');
	var scrLogin = root.querySelector('.scr-login');
	var scrVerify = root.querySelector('.scr-verify');
	var verifyBtn = root.querySelector('.hp-verify');
	var digitsWrap = root.querySelector('.hp-digits');
	var boxes = root.querySelectorAll('.hp-box');
	var maskEl = root.querySelector('.hp-mask');
	var verifyErr = root.querySelector('.hp-err-verify');
	var resendTxt = root.querySelector('.hp-resend-txt');
	var resendBtn = root.querySelector('.hp-resend-btn');
	var backBtn = root.querySelector('.hp-back');
	var notif = root.querySelector('.notif');
	var notifCode = root.querySelector('.notif-code');
	var successMask = document.getElementById('heroSuccessMask');
	var restartBtn = success.querySelector('.hero-restart');

	var RESEND = 60;
	var MAX_TRIES = 3;
	var CODE_LEN = 5;
	var FA = '۰۱۲۳۴۵۶۷۸۹';

	var st = { number: '', code: '', tries: 0, locked: false, busy: false, left: RESEND, tick: null, timeouts: [] };

	/* ---------- helpers ---------- */
	function fa(s) { return String(s).replace(/[0-9]/g, function (d) { return FA.charAt(+d); }); }

	function toEn(s) {
		return String(s || '').replace(/[\u06F0-\u06F9\u0660-\u0669]/g, function (c) {
			var k = c.charCodeAt(0);
			return String(k >= 0x06F0 ? k - 0x06F0 : k - 0x0660);
		});
	}

	// Random 5-digit code (10000..99999) from the Web Crypto API.
	function makeCode() {
		var a = new Uint32Array(1);
		window.crypto.getRandomValues(a);
		return String(10000 + (a[0] % 90000));
	}

	// Digits only; strips +98 / 0098 / 98 prefixes so the national number starts with 9.
	function normalize(v) {
		var s = toEn(v).replace(/[\s\-()]/g, '');
		if (s.charAt(0) === '+') { s = s.slice(1); }
		if (/^0098\d{10}$/.test(s)) { s = s.slice(4); }
		else if (/^98\d{10}$/.test(s)) { s = s.slice(2); }
		return s.replace(/\D/g, '');
	}

	function isValid(n) { return /^9\d{9}$/.test(n); }

	// 9123456789 -> ۰۹۱۲***۶۷۸۹
	function mask(n) { return fa('0' + n.slice(0, 3) + '***' + n.slice(-4)); }

	function later(fn, ms) { st.timeouts.push(setTimeout(fn, ms)); }
	function clearLater() { st.timeouts.forEach(clearTimeout); st.timeouts = []; }
	function pad(n) { return n < 10 ? '0' + n : String(n); }

	function setNotif(on) {
		notif.classList.remove('is-on');
		if (on) { void notif.offsetWidth; notif.classList.add('is-on'); }
		notif.tabIndex = on ? 0 : -1;
	}

	function showNotif() {
		notifCode.textContent = st.code;
		setNotif(true);
	}

	function getCode() {
		var s = '';
		for (var i = 0; i < boxes.length; i++) { s += boxes[i].value; }
		return s;
	}

	function setBoxes(v) {
		for (var i = 0; i < boxes.length; i++) {
			boxes[i].value = v ? v.charAt(i) : '';
			boxes[i].classList.toggle('is-filled', !!boxes[i].value);
			boxes[i].classList.remove('is-wrong');
		}
	}

	function setLockedUI(locked) {
		for (var i = 0; i < boxes.length; i++) { boxes[i].disabled = locked; }
		verifyBtn.disabled = locked;
	}

	function focusBox(i) { if (boxes[i]) { boxes[i].focus(); } }

	/* ---------- login step ---------- */
	function refreshLogin() {
		var n = normalize(input.value);
		if (input.value !== n) { input.value = n; }
		var err = '';
		if (n.charAt(0) === '0') { err = 'شماره را بدون صفر اول وارد کنید؛ مثلاً 9123456789.'; }
		else if (n.length > 10) { err = 'شماره موبایل ۱۰ رقم است؛ بدون صفر اول.'; }
		loginErr.textContent = err;
		sendBtn.disabled = !isValid(n) || st.busy;
	}

	input.addEventListener('input', refreshLogin);

	form.addEventListener('submit', function (e) {
		e.preventDefault();
		var n = normalize(input.value);
		if (!isValid(n) || st.busy) { refreshLogin(); return; }
		st.number = n;
		st.busy = true;
		sendBtn.classList.add('is-busy');
		sendBtn.disabled = true;
		sendTxt.textContent = 'در حال ارسال';
		later(function () {
			st.busy = false;
			sendBtn.classList.remove('is-busy');
			sendTxt.textContent = 'دریافت کد';
			st.code = makeCode();
			showVerify();
		}, 900);
	});

	/* ---------- verify step ---------- */
	function showVerify() {
		scrLogin.classList.remove('is-on');
		scrVerify.classList.add('is-on');
		maskEl.textContent = mask(st.number);
		st.tries = 0;
		st.locked = false;
		setBoxes('');
		setLockedUI(false);
		verifyErr.textContent = '';
		startTimer();
		later(function () {
			if (scrVerify.classList.contains('is-on')) { showNotif(); }
		}, 500);
	}

	function renderTimer() {
		var m = Math.floor(st.left / 60);
		var s = st.left % 60;
		resendTxt.textContent = 'ارسال مجدد کد تا ' + fa(pad(m) + ':' + pad(s));
	}

	function stopTimer() {
		if (st.tick) { clearInterval(st.tick); st.tick = null; }
	}

	function enableResend() {
		resendTxt.hidden = true;
		resendBtn.hidden = false;
	}

	function startTimer() {
		stopTimer();
		st.left = RESEND;
		renderTimer();
		resendTxt.hidden = false;
		resendBtn.hidden = true;
		st.tick = setInterval(function () {
			st.left -= 1;
			renderTimer();
			if (st.left <= 0) {
				stopTimer();
				enableResend();
			}
		}, 1000);
	}

	function verify() {
		if (st.locked) { return; }
		var c = getCode();
		if (c.length < CODE_LEN) {
			verifyErr.textContent = 'کد را کامل وارد کنید.';
			focusBox(c.length);
			return;
		}
		if (c === st.code) { showSuccess(); return; }

		st.tries += 1;
		for (var i = 0; i < boxes.length; i++) { boxes[i].classList.add('is-wrong'); }
		digitsWrap.classList.remove('hp-shake');
		void digitsWrap.offsetWidth;
		digitsWrap.classList.add('hp-shake');

		var remain = MAX_TRIES - st.tries;
		if (remain <= 0) {
			st.locked = true;
			setLockedUI(true);
			stopTimer();
			enableResend();
			verifyErr.textContent = 'تعداد تلاش‌ها تمام شد. کد جدید بگیرید.';
			later(function () { setBoxes(''); }, 380);
			return;
		}
		verifyErr.textContent = 'کد اشتباه است. ' + fa(remain) + ' تلاش دیگر باقی است.';
		later(function () { setBoxes(''); focusBox(0); }, 380);
	}

	Array.prototype.forEach.call(boxes, function (box, idx) {
		box.addEventListener('input', function () {
			var v = toEn(box.value).replace(/\D/g, '').slice(-1);
			box.value = v;
			box.classList.toggle('is-filled', !!v);
			box.classList.remove('is-wrong');
			verifyErr.textContent = '';
			if (v && idx < boxes.length - 1) { focusBox(idx + 1); }
			if (getCode().length === CODE_LEN) { verify(); }
		});
		box.addEventListener('keydown', function (e) {
			if (e.key === 'Backspace' && !box.value && idx > 0) {
				e.preventDefault();
				boxes[idx - 1].value = '';
				boxes[idx - 1].classList.remove('is-filled');
				focusBox(idx - 1);
			}
		});
		box.addEventListener('paste', function (e) {
			e.preventDefault();
			var text = toEn((e.clipboardData || window.clipboardData).getData('text')).replace(/\D/g, '').slice(0, CODE_LEN);
			setBoxes(text);
			if (text.length === CODE_LEN) { verify(); } else { focusBox(text.length); }
		});
	});

	verifyBtn.addEventListener('click', verify);
	resendBtn.addEventListener('click', function () {
		st.code = makeCode();
		st.tries = 0;
		st.locked = false;
		setLockedUI(false);
		setBoxes('');
		verifyErr.textContent = 'کد جدید ارسال شد.';
		setNotif(false);
		later(showNotif, 350);
		startTimer();
	});

	// Tapping the notification fills the code in (like iOS OTP autofill).
	notif.addEventListener('click', function () {
		if (!scrVerify.classList.contains('is-on') || st.locked) { return; }
		setBoxes(st.code);
		later(verify, 300);
	});

	backBtn.addEventListener('click', function () {
		clearLater();
		stopTimer();
		setNotif(false);
		scrVerify.classList.remove('is-on');
		scrLogin.classList.add('is-on');
		st.busy = false;
		sendBtn.classList.remove('is-busy');
		sendTxt.textContent = 'دریافت کد';
		refreshLogin();
	});

	/* ---------- success + restart ---------- */
	function showSuccess() {
		clearLater();
		stopTimer();
		setNotif(false);
		scrVerify.classList.remove('is-on');
		successMask.innerHTML = 'شماره <span dir="ltr" class="hp-mask-ltr">' + mask(st.number) + '</span> با کد درست تأیید شد.';
		root.classList.add('is-off');
		success.classList.add('is-on');
	}

	function restart() {
		clearLater();
		stopTimer();
		st.number = '';
		st.code = '';
		st.tries = 0;
		st.locked = false;
		st.busy = false;
		success.classList.remove('is-on');
		root.classList.remove('is-off');
		scrVerify.classList.remove('is-on');
		scrLogin.classList.add('is-on');
		setNotif(false);
		setBoxes('');
		setLockedUI(false);
		sendBtn.classList.remove('is-busy');
		sendTxt.textContent = 'دریافت کد';
		input.value = '';
		verifyErr.textContent = '';
		refreshLogin();
	}

	restartBtn.addEventListener('click', restart);

	/* ---------- boot ---------- */
	setNotif(false);
	resendBtn.hidden = true;
	refreshLogin();
})();
