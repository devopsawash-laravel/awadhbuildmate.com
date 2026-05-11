<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login — Awadh Buildmate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0A0A0A;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── LEFT BRAND PANEL ───────────────────────────────────────── */
        .left {
            flex: 1;
            background: #E8500A;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
            position: relative;
            overflow: hidden;
        }

        .left::before {
            content: '';
            position: absolute;
            bottom: -120px; right: -120px;
            width: 480px; height: 480px;
            border: 80px solid rgba(255,255,255,0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .left::after {
            content: '';
            position: absolute;
            top: -80px; left: -80px;
            width: 320px; height: 320px;
            border: 50px solid rgba(255,255,255,0.06);
            border-radius: 50%;
            pointer-events: none;
        }

        .left-top  { position: relative; z-index: 1; }
        .left-mid  { position: relative; z-index: 1; }
        .left-foot { position: relative; z-index: 1; font-size: 12px; color: rgba(255,255,255,0.3); }

        .brand-icon {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.2);
            clip-path: polygon(0 0, 88% 0, 100% 12%, 100% 100%, 12% 100%, 0 88%);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
        }
        .brand-icon i { color: #fff; font-size: 22px; }

        .brand-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 36px;
            letter-spacing: 3px;
            color: #fff;
            line-height: 1;
            margin-bottom: 5px;
        }

        .brand-sub {
            font-family: 'Rajdhani', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.55);
        }

        .left-headline {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 64px;
            line-height: 0.92;
            letter-spacing: 2px;
            color: #fff;
            margin-bottom: 18px;
        }

        .left-desc { font-size: 15px; color: rgba(255,255,255,0.68); line-height: 1.75; max-width: 360px; }

        .features { margin-top: 28px; display: flex; flex-direction: column; gap: 12px; }

        .feature {
            display: flex; align-items: center; gap: 12px;
            font-size: 13px; color: rgba(255,255,255,0.82);
        }

        .feature-dot {
            width: 7px; height: 7px;
            background: rgba(255,255,255,0.45);
            border-radius: 50%; flex-shrink: 0;
        }

        /* ── RIGHT FORM PANEL ───────────────────────────────────────── */
        .right {
            width: 500px;
            flex-shrink: 0;
            background: #111;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px 48px;
            position: relative;
            border-left: 1px solid rgba(255,255,255,0.05);
        }

        .right::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.014) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.014) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .back-link {
            position: absolute;
            top: 26px; left: 48px;
            display: flex; align-items: center; gap: 8px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 10px; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase;
            color: #3A3A3A; text-decoration: none;
            transition: color 0.2s; z-index: 1;
        }
        .back-link:hover { color: #fff; }

        .form-wrap {
            position: relative; z-index: 1;
            animation: fadeUp 0.38s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-heading {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 48px; letter-spacing: 2px;
            color: #fff; line-height: 1; margin-bottom: 5px;
        }

        .form-sub {
            font-size: 13px; color: #4A4A4A;
            margin-bottom: 28px;
            display: flex; align-items: center; gap: 7px;
        }
        .form-sub i { color: #E8500A; font-size: 11px; }

        /* ── TABS ───────────────────────────────────────────────────── */
        .tabs {
            display: flex;
            border-bottom: 1px solid #1E1E1E;
            margin-bottom: 26px;
        }

        .tab-btn {
            flex: 1;
            padding: 10px 0;
            font-family: 'Rajdhani', sans-serif;
            font-size: 11px; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase;
            color: #444; background: none; border: none;
            border-bottom: 2px solid transparent;
            cursor: pointer; transition: all 0.2s;
            margin-bottom: -1px;
        }

        .tab-btn:hover { color: #888; }

        .tab-btn.active {
            color: #E8500A;
            border-bottom-color: #E8500A;
        }

        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* ── ALERTS ─────────────────────────────────────────────────── */
        .alert {
            padding: 12px 15px; margin-bottom: 20px;
            font-size: 13px; display: flex; align-items: flex-start; gap: 10px;
        }
        .alert i { flex-shrink: 0; margin-top: 1px; }
        .alert-error   { background: rgba(239,68,68,0.07);  border: 1px solid rgba(239,68,68,0.2);  color: #f87171; }
        .alert-info    { background: rgba(232,80,10,0.07);  border: 1px solid rgba(232,80,10,0.2);  color: #fb923c; }
        .alert-success { background: rgba(16,185,129,0.07); border: 1px solid rgba(16,185,129,0.2); color: #34d399; }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%     { transform: translateX(-7px); }
            40%     { transform: translateX(7px); }
            60%     { transform: translateX(-4px); }
            80%     { transform: translateX(4px); }
        }
        .shake { animation: shake 0.38s ease; }

        /* ── FORM INPUTS ────────────────────────────────────────────── */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-family: 'Rajdhani', sans-serif;
            font-size: 10px; font-weight: 700;
            letter-spacing: 2.5px; text-transform: uppercase;
            color: #4A4A4A; margin-bottom: 7px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: #2E2E2E; font-size: 13px;
            pointer-events: none; transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            background: #0A0A0A;
            border: 1px solid #1C1C1C;
            color: #fff;
            padding: 12px 16px 12px 42px;
            font-size: 14px; font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            -webkit-appearance: none;
        }
        .form-input::placeholder { color: #2A2A2A; }
        .form-input:focus {
            border-color: #E8500A;
            box-shadow: 0 0 0 3px rgba(232,80,10,0.1);
        }

        .toggle-pw {
            position: absolute; right: 13px; top: 50%;
            transform: translateY(-50%);
            color: #2E2E2E; cursor: pointer;
            font-size: 13px; background: none; border: none; padding: 0;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: #E8500A; }

        /* ── REMEMBER ───────────────────────────────────────────────── */
        .remember-row { display: flex; align-items: center; margin-bottom: 22px; }

        .cb-label {
            display: flex; align-items: center; gap: 9px;
            cursor: pointer; font-size: 13px; color: #4A4A4A;
            user-select: none;
        }
        .cb-label input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: #E8500A; cursor: pointer;
        }

        /* ── SUBMIT BUTTON ──────────────────────────────────────────── */
        .btn-submit {
            width: 100%; background: #E8500A; color: #fff; border: none;
            padding: 14px 24px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 13px; font-weight: 700;
            letter-spacing: 2.5px; text-transform: uppercase;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            clip-path: polygon(0 0, 97% 0, 100% 18%, 100% 100%, 3% 100%, 0 82%);
            transition: background 0.2s, transform 0.15s;
        }
        .btn-submit:hover { background: #C2400A; transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.55; cursor: not-allowed; transform: none; }

        /* ── MAGIC LINK SUCCESS STATE ───────────────────────────────── */
        .magic-sent-box {
            text-align: center; padding: 30px 20px;
        }
        .magic-sent-icon {
            width: 64px; height: 64px;
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.25);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px;
        }
        .magic-sent-icon i { color: #34d399; font-size: 26px; }
        .magic-sent-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px; letter-spacing: 1px; color: #fff; margin-bottom: 10px;
        }
        .magic-sent-desc { font-size: 14px; color: #555; line-height: 1.7; }
        .magic-sent-note { font-size: 12px; color: #333; margin-top: 14px; }

        /* ── DIVIDER & FOOTER ───────────────────────────────────────── */
        .divider { border: none; border-top: 1px solid #181818; margin: 24px 0 20px; }

        .form-footer {
            font-size: 12px; color: #2E2E2E;
            text-align: center; line-height: 1.7;
        }
        .form-footer i { color: #E8500A; margin-right: 4px; }

        @media (max-width: 820px) {
            .left  { display: none; }
            .right { width: 100%; border: none; padding: 36px 24px; }
            .back-link { left: 24px; }
        }
    </style>
</head>
<body>

{{-- ── LEFT BRAND PANEL ─────────────────────────────────────────── --}}
<div class="left">
    <div class="left-top">
        <div class="brand-icon"><i class="fas fa-hard-hat"></i></div>
        <div class="brand-name">Awadh Buildmate</div>
        <div class="brand-sub">Build · Fabricate · Erect</div>
    </div>

    <div class="left-mid">
        <div class="left-headline">Admin<br>Portal</div>
        <p class="left-desc">Manage your entire workforce from one secure dashboard. Two ways to sign in — password or magic email link.</p>
        <div class="features">
            <div class="feature"><div class="feature-dot"></div> Labour Registry &amp; Category Management</div>
            <div class="feature"><div class="feature-dot"></div> Daily Attendance with Overtime Tracking</div>
            <div class="feature"><div class="feature-dot"></div> Automated Salary Slip Generation</div>
            <div class="feature"><div class="feature-dot"></div> PF &amp; Advance Deduction Automation</div>
            <div class="feature"><div class="feature-dot"></div> Website Enquiry Management</div>
        </div>
    </div>

    <div class="left-foot">
        &copy; {{ date('Y') }} Awadh Buildmate Pvt. Ltd. &mdash; Ankleshwar, Gujarat
    </div>
</div>

{{-- ── RIGHT FORM PANEL ─────────────────────────────────────────── --}}
<div class="right">

    <a href="{{ route('home1') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Website
    </a>

    <div class="form-wrap">

        <div class="form-heading">Sign In</div>
        <div class="form-sub">
            <i class="fas fa-lock"></i>
            Owner access only — all attempts are monitored
        </div>

        {{-- Redirect notice --}}
        @if(session('info'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        {{-- Credential error --}}
        @if($errors->any())
            <div class="alert alert-error shake">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Magic link sent success --}}
        @if(session('magic_sent'))
            <div class="magic-sent-box">
                <div class="magic-sent-icon"><i class="fas fa-paper-plane"></i></div>
                <div class="magic-sent-title">Check Your Email</div>
                <p class="magic-sent-desc">
                    If that email matches the owner account, a secure login link has been sent.<br>
                    Check your inbox and click the link to sign in.
                </p>
                <p class="magic-sent-note">
                    <i class="fas fa-clock" style="color:#E8500A"></i>
                    Link expires in 15 minutes &nbsp;·&nbsp;
                    <i class="fas fa-shield-alt" style="color:#E8500A"></i>
                    One-time use only
                </p>
                <div style="margin-top:20px">
                    <a href="{{ route('admin.login') }}" style="color:#E8500A;font-size:13px;font-family:'Rajdhani',sans-serif;font-weight:700;letter-spacing:1px;text-decoration:none">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                </div>
            </div>
        @else

            {{-- ── TABS ──────────────────────────────────────────────── --}}
            <div class="tabs">
                <button class="tab-btn active" onclick="switchTab('password', this)">
                    <i class="fas fa-key" style="margin-right:6px"></i> Password
                </button>
                <button class="tab-btn" onclick="switchTab('magic', this)">
                    <i class="fas fa-envelope" style="margin-right:6px"></i> Email Link
                </button>
            </div>

            {{-- ── TAB 1: PASSWORD LOGIN ──────────────────────────── --}}
            <div class="tab-panel active" id="tab-password">
                <form method="POST" action="{{ route('admin.login.post') }}" id="pw-form">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="input-wrap">
                            <input
                                type="email" name="email" id="email"
                                class="form-input"
                                value="{{ old('email') }}"
                                placeholder="owner@awadhbuildmate.com"
                                required autofocus autocomplete="email"
                            >
                            <i class="fas fa-envelope input-icon" id="icon-email"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap">
                            <input
                                type="password" name="password" id="password"
                                class="form-input"
                                placeholder="Enter your password"
                                required autocomplete="current-password"
                            >
                            <i class="fas fa-lock input-icon" id="icon-pw"></i>
                            <button type="button" class="toggle-pw" id="toggle-pw" tabindex="-1">
                                <i class="fas fa-eye" id="pw-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="remember-row">
                        <label class="cb-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Keep me signed in
                        </label>
                    </div>

                    <button type="submit" class="btn-submit" id="pw-submit">
                        <i class="fas fa-sign-in-alt"></i>
                        <span id="pw-btn-text">Sign In to Admin Panel</span>
                    </button>
                </form>
            </div>

            {{-- ── TAB 2: MAGIC EMAIL LINK ────────────────────────── --}}
            <div class="tab-panel" id="tab-magic">
                <p style="font-size:13px;color:#555;margin-bottom:20px;line-height:1.7;">
                    Enter your owner email address and we'll send you a <strong style="color:#888">one-click login link</strong> that expires in 15 minutes. No password needed.
                </p>

                <form method="POST" action="{{ route('admin.login') }}" id="magic-form">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="magic-email">Owner Email Address</label>
                        <div class="input-wrap">
                            <input
                                type="email" name="email" id="magic-email"
                                class="form-input"
                                value="{{ old('email') }}"
                                placeholder="owner@awadhbuildmate.com"
                                required
                            >
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="magic-submit" style="margin-top:4px">
                        <i class="fas fa-paper-plane"></i>
                        <span id="magic-btn-text">Send Login Link</span>
                    </button>
                </form>

                <p style="font-size:12px;color:#2E2E2E;margin-top:16px;text-align:center;">
                    <i class="fas fa-shield-alt" style="color:#E8500A"></i>
                    Link is sent only if the email matches the owner account.
                </p>
            </div>

        @endif

        <hr class="divider">

        <div class="form-footer">
            <i class="fas fa-shield-alt"></i>
            Authorized personnel only &nbsp;·&nbsp; Rate-limited &nbsp;·&nbsp; All attempts logged
        </div>

    </div>{{-- /.form-wrap --}}
</div>

<script>
    // ── Tab switching ─────────────────────────────────────────────────
    function switchTab(tab, btn) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        btn.classList.add('active');
    }

    // ── Show / hide password ──────────────────────────────────────────
    const pwField   = document.getElementById('password');
    const pwIcon    = document.getElementById('pw-icon');
    const toggleBtn = document.getElementById('toggle-pw');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const hidden = pwField.type === 'password';
            pwField.type = hidden ? 'text' : 'password';
            pwIcon.className = hidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    }

    // ── Focus colour on icons ─────────────────────────────────────────
    function focusIcon(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (!input || !icon) return;
        input.addEventListener('focus', () => icon.style.color = '#E8500A');
        input.addEventListener('blur',  () => icon.style.color = '#2E2E2E');
    }
    focusIcon('email',    'icon-email');
    focusIcon('password', 'icon-pw');

    
    // ── Loading state — password form ─────────────────────────────────
    const pwForm = document.getElementById('pw-form');
    if (pwForm) {
        pwForm.addEventListener('submit', function () {
            const btn  = document.getElementById('pw-submit');
            const text = document.getElementById('pw-btn-text');
            btn.disabled = true;
            btn.querySelector('i').className = 'fas fa-spinner fa-spin';
            text.textContent = 'Signing In…';
        });
    }

    // ── Loading state — magic form ────────────────────────────────────
    const magicForm = document.getElementById('magic-form');
    if (magicForm) {
        magicForm.addEventListener('submit', function () {
            const btn  = document.getElementById('magic-submit');
            const text = document.getElementById('magic-btn-text');
            btn.disabled = true;
            btn.querySelector('i').className = 'fas fa-spinner fa-spin';
            text.textContent = 'Sending Link…';
        });
    }

    // ── If errors exist and tab should be password, keep it active ────
    @if($errors->any())
        // Stay on password tab when there are errors
        switchTab('password', document.querySelectorAll('.tab-btn')[0]);
    @endif
</script>

</body>
</html>