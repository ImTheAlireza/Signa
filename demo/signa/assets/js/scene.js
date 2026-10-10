/* Hero scene simulation (static, no server calls).
 * Enter an Iranian mobile number on the laptop -> "sending" -> a wave travels from the laptop
 * to the phone -> the phone pulses -> a notification shows a random 5-digit code.
 * The user types the code on the laptop (or taps the notification to fill it) -> the laptop
 * and phone fade out and a success card appears with a restart button.
 * Nothing is sent anywhere. */
(function () {
	'use strict';

	var scene = document.getElementById('scene');
	if (!scene) { return; }

	var phone = document.getElementById('phone');
	var success = document.getElementById('sceneSuccess');
	var form = scene.querySelector('.sc-form');
	var input = document.getElementById('sceneNumber');
	var sendBtn = scene.querySelector('.sc-form .sc-send');
	var sendTxt = scene.querySelector('.sc-send-txt');
	var loginErr = scene.querySelector('.sc-err-login');
	var scrLogin = scene.querySelector('.sc-login');
	var scrVerify = scene.querySelector('.sc-verify');
	var verifyBtn = scene.querySelector('.sc-verify-btn');
	var digitsWrap = scene.querySelector('.sc-digits');
	var boxes = scene.querySelectorAll('.sc-box');
	var maskEl = scene.querySelector('.sc-mask');
	var verifyErr = scene.querySelector('.sc-err-verify');
	var resendTxt = scene.querySelector('.sc-resend-txt');
	var resendBtn = scene.querySelector('.sc-resend-btn');
	var backBtn = scene.querySelector('.sc-back');
	var notif = phone.querySelector('.notif');
	var notifCode = phone.querySelector('.notif-code');
	var successMask = document.getElementById('sceneSuccessMask');
	var restartBtn = success.querySelector('.sc-restart');

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

	// Digits only; strips +98 / 0098 / 98 so the national number starts with 9.
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

	/* ---------- sending animation: wave laptop -> phone, then notification ---------- */
	function sendWave() {
		scene.classList.remove('is-sending');
		void scene.offsetWidth;
		scene.classList.add('is-sending');
		later(function () { phone.classList.remove('is-pulse'); void phone.offsetWidth; phone.classList.add('is-pulse'); }, 1050);
		later(function () { notifCode.textContent = st.code; setNotif(true); }, 1400);
		later(function () { scene.classList.remove('is-sending'); }, 2200);
	}

	/* ---------- login step ---------- */
	function refreshLogin() {
		var n = normalize(input.value);
		if (input.value !== n) { input.value = n; }
		var err = '';
		if (n.charAt(0) === '0') { err = 'بدون صفر اول وارد کنید؛ مثلاً 9123456789.'; }
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
			sendWave();
		}, 700);
	});

	/* ---------- verify step ---------- */
	function showVerify() {
		scene.dataset.step = 'verify';
		scrLogin.classList.remove('is-on');
		scrVerify.classList.add('is-on');
		maskEl.textContent = mask(st.number);
		st.tries = 0;
		st.locked = false;
		setBoxes('');
		setLockedUI(false);
		verifyErr.textContent = '';
		startTimer();
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
		digitsWrap.classList.remove('sc-shake');
		void digitsWrap.offsetWidth;
		digitsWrap.classList.add('sc-shake');

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
		startTimer();
		sendWave();
	});

	// Tapping the notification fills the code in on the laptop (like iOS OTP autofill).
	notif.addEventListener('click', function () {
		if (scene.dataset.step !== 'verify' || st.locked) { return; }
		setBoxes(st.code);
		later(verify, 300);
	});

	backBtn.addEventListener('click', function () {
		clearLater();
		stopTimer();
		setNotif(false);
		scene.classList.remove('is-sending');
		scene.dataset.step = 'login';
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
		scene.dataset.step = 'done';
		successMask.innerHTML = 'شماره <span dir="ltr" class="sc-mask-ltr">' + mask(st.number) + '</span> با کد درست تأیید شد.';
	}

	function restart() {
		clearLater();
		stopTimer();
		st.number = '';
		st.code = '';
		st.tries = 0;
		st.locked = false;
		st.busy = false;
		scene.classList.remove('is-sending');
		scene.dataset.step = 'login';
		scrVerify.classList.remove('is-on');
		scrLogin.classList.add('is-on');
		setNotif(false);
		setBoxes('');
		setLockedUI(false);
		sendBtn.classList.remove('is-busy');
		sendTxt.textContent = 'دریافت کد';
		input.value = '';
		verifyErr.textContent = '';
		resendBtn.hidden = true;
		refreshLogin();
	}

	restartBtn.addEventListener('click', restart);

	/* ---------- boot ---------- */
	setNotif(false);
	resendBtn.hidden = true;
	refreshLogin();
})();
