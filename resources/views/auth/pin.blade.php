<!DOCTYPE html>
<html>
<head>
    <title>Verify PIN — Awadh Buildmate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #111; font-family: 'Barlow', sans-serif; }
        .ab-wrap { display: flex; width: 100%; max-width: 860px; min-height: 520px; border-radius: 12px; overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,0.5); }

        /* Left panel */
        .ab-left { background: #E85100; flex: 1.1; padding: 2.5rem 2.5rem 2rem; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; }
        .ab-left::after { content: ''; position: absolute; right: -70px; bottom: -70px; width: 320px; height: 320px; border-radius: 50%; background: rgba(255,255,255,0.08); }
        .ab-left::before { content: ''; position: absolute; right: 50px; bottom: 70px; width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,0.06); }
        .ab-logo-box { width: 44px; height: 44px; background: rgba(255,255,255,0.18); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .ab-brand { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 800; color: #fff; letter-spacing: 0.08em; margin-bottom: 3px; }
        .ab-tagline { font-size: 9px; color: rgba(255,255,255,0.7); letter-spacing: 0.18em; font-weight: 500; margin-bottom: 2rem; }
        .ab-heading { font-family: 'Barlow Condensed', sans-serif; font-size: 52px; font-weight: 800; color: #fff; line-height: 1; letter-spacing: 0.02em; text-transform: uppercase; margin-bottom: 1rem; }
        .ab-desc { font-size: 13px; color: rgba(255,255,255,0.85); line-height: 1.6; max-width: 220px; }
        .ab-footer { font-size: 10px; color: rgba(255,255,255,0.45); position: relative; z-index: 1; }

        /* Right panel */
        .ab-right { background: #1a1a1a; flex: 1; padding: 2.5rem 2rem; display: flex; flex-direction: column; }
        .ab-back { font-size: 11px; color: #666; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 1.75rem; display: flex; align-items: center; gap: 6px; text-decoration: none; }
        .ab-back:hover { color: #aaa; }
        .ab-title { font-family: 'Barlow Condensed', sans-serif; font-size: 36px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 5px; }
        .ab-monitored { font-size: 11px; color: #777; display: flex; align-items: center; gap: 6px; margin-bottom: 1.75rem; }
        .ab-pin-label { font-size: 10px; color: #666; letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 8px; font-weight: 500; }
        .ab-dots { display: flex; gap: 8px; margin-bottom: 1.25rem; }
        .ab-dot { width: 11px; height: 11px; border-radius: 50%; background: #2a2a2a; border: 1.5px solid #444; transition: all 0.15s; }
        .ab-dot.filled { background: #E85100; border-color: #E85100; }
        .ab-input-row { display: flex; align-items: center; background: #111; border: 1px solid #333; border-radius: 6px; padding: 0 12px; margin-bottom: 1.25rem; transition: border-color 0.15s; }
        .ab-input-row:focus-within { border-color: #E85100; }
        .ab-input-row i { color: #555; font-size: 17px; margin-right: 10px; }
        .ab-pin-input { background: transparent; border: none; outline: none; color: #fff; font-family: 'Barlow', sans-serif; font-size: 18px; letter-spacing: 0.25em; padding: 12px 0; flex: 1; width: 0; }
        .ab-pin-input::placeholder { color: #444; letter-spacing: 0.1em; font-size: 14px; }
        .ab-eye { background: none; border: none; color: #555; cursor: pointer; padding: 0; display: flex; }
        .ab-eye:hover { color: #888; }
        .ab-submit { width: 100%; padding: 13px; background: #E85100; border: none; border-radius: 6px; color: #fff; font-family: 'Barlow Condensed', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.15s, transform 0.1s; }
        .ab-submit:hover { background: #ff6010; }
        .ab-submit:active { transform: scale(0.98); }
        .ab-notes { margin-top: auto; padding-top: 1.25rem; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .ab-note { font-size: 10px; color: #555; display: flex; align-items: center; gap: 4px; }
    </style>
</head>
<body>
<div class="ab-wrap">
    <div class="ab-left">
        <div>
            <div class="ab-logo-box"><i class="ti ti-hard-hat" style="font-size:22px;color:#fff;"></i></div>
            <div class="ab-brand">AWADH BUILDMATE</div>
            <div class="ab-tagline">BUILD &nbsp;·&nbsp; FABRICATE &nbsp;·&nbsp; ERECT</div>
            <div class="ab-heading">VERIFY<br>YOUR<br>PIN</div>
            <p class="ab-desc">Confirm your identity with your secure 6-digit PIN to access the admin panel.</p>
        </div>
        <div class="ab-footer">© 2026 Awadh Buildmate Pvt. Ltd. — Ankleshwar, Gujarat</div>
    </div>

    <div class="ab-right">
        <a href="{{ route('admin.login') }}" class="ab-back">
            <i class="ti ti-arrow-left" style="font-size:13px;"></i> Back to sign in
        </a>
        <div class="ab-title">ENTER PIN</div>
        <div class="ab-monitored">
            <i class="ti ti-lock" style="font-size:13px;color:#E85100;"></i>
            Owner access only — all attempts are monitored
        </div>

        <form method="POST" action="">
            @csrf
            <div class="ab-pin-label">PIN Code</div>
            <div class="ab-dots" id="dots">
                @for ($i = 0; $i < 6; $i++)
                    <div class="ab-dot"></div>
                @endfor
            </div>
            <div class="ab-input-row">
                <i class="ti ti-lock"></i>
                <input class="ab-pin-input" id="pinInput" type="password" name="pin" placeholder="Enter PIN" maxlength="6" autocomplete="current-password" required>
                <button type="button" class="ab-eye" id="toggleBtn" aria-label="Show PIN">
                    <i class="ti ti-eye" id="eyeIcon" style="font-size:18px;"></i>
                </button>
            </div>
            <button class="ab-submit" type="submit">
                <i class="ti ti-login" style="font-size:16px;"></i>
                VERIFY &amp; CONTINUE
            </button>
        </form>

        <div class="ab-notes">
            <span class="ab-note"><i class="ti ti-shield" style="font-size:11px;color:#E85100;"></i> Authorized personnel only</span>
            <span class="ab-note">· Rate-limited</span>
            <span class="ab-note">· All attempts logged</span>
        </div>
    </div>
</div>

<script>
    const input = document.getElementById('pinInput');
    const dots = document.querySelectorAll('.ab-dot');
    const toggleBtn = document.getElementById('toggleBtn');
    const eyeIcon = document.getElementById('eyeIcon');
    let visible = false;

    input.addEventListener('input', () => {
        const len = input.value.length;
        dots.forEach((d, i) => d.classList.toggle('filled', i < len));
    });

    toggleBtn.addEventListener('click', () => {
        visible = !visible;
        input.type = visible ? 'text' : 'password';
        eyeIcon.className = visible ? 'ti ti-eye-off' : 'ti ti-eye';
        toggleBtn.setAttribute('aria-label', visible ? 'Hide PIN' : 'Show PIN');
    });
</script>
</body>
</html>