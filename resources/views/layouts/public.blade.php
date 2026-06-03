<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Awadh Buildmate — Expert Fabrication, Erection & Structural Construction across India">
    <title>@yield('title', 'Awadh Buildmate') | Expert Construction & Fabrication</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --orange:      #E8500A;
            --orange-dark: #B83D08;
            --orange-glow: rgba(232,80,10,0.15);
            --black:       #0A0A0A;
            --dark:        #111111;
            --dark2:       #1A1A1A;
            --dark3:       #222222;
            --steel:       #2A2A2A;
            --border:      rgba(255,255,255,0.08);
            --text:        #F0EDE8;
            --muted:       #888888;
            --light-bg:    #F7F4EF;
            --light-dark:  #1C1C1C;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--black);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ─── NAVBAR ─── */
       .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 0 5%;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.3s, border-bottom 0.3s;
        }

        .navbar.scrolled {
            background: rgba(10,10,10,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        /* .nav-logo-icon {
            width: 42px; height: 42px;
            background: var(--orange);
            display: flex; align-items: center; justify-content: center;
            clip-path: polygon(0 0, 88% 0, 100% 12%, 100% 100%, 12% 100%, 0 88%);
        }

        .nav-logo-icon i { color: #fff; font-size: 1px; } */
/* Updated CSS for logo */
.nav-logo {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
}

.nav-logo-icon {
    width: 56px;
    height: 56px;
    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: center;

    /* optional shape */
    clip-path: polygon(0 0, 88% 0, 100% 12%, 100% 100%, 12% 100%, 0 88%);
}

.nav-logo-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* or contain */
    display: block;
}

.nav-brand {
    color: #ff5a00;
    font-size: 28px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.nav-tagline {
    color: #ff5a00;
    font-size: 12px;
    letter-spacing: 3px;
    text-transform: uppercase;
}
        .nav-logo-text { line-height: 1; }

        .nav-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px;
            letter-spacing: 2px;
            color: #ff5a00;
        }

        .nav-tagline {
            font-family: 'Rajdhani', sans-serif;
            font-size: 10px;
            letter-spacing: 3px;
            color: var(--orange);
            text-transform: uppercase;
            margin-top: 1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            font-family: 'Rajdhani', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-links a:hover, .nav-links a.active { color: #fff; }

        .nav-cta {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-nav-login {
            font-family: 'Rajdhani', sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid rgba(255,255,255,0.15);
            transition: all 0.2s;
        }

        .btn-nav-login:hover {
            color: #fff;
            border-color: rgba(255,255,255,0.4);
        }

        .btn-nav-contact {
            font-family: 'Rajdhani', sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #fff;
            text-decoration: none;
            padding: 9px 22px;
            background: var(--orange);
            clip-path: polygon(0 0, 94% 0, 100% 20%, 100% 100%, 6% 100%, 0 80%);
            transition: background 0.2s;
        }

        .btn-nav-contact:hover { background: var(--orange-dark); }

        /* ─── SECTIONS ─── */
        section { position: relative; }

        .section-tag {
            font-family: 'Rajdhani', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-tag::before {
            content: '';
            width: 32px;
            height: 2px;
            background: var(--orange);
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(42px, 6vw, 80px);
            letter-spacing: 2px;
            line-height: 0.95;
            color: #fff;
        }

        .section-subtitle {
            font-size: 16px;
            line-height: 1.7;
            color: var(--muted);
            max-width: 520px;
        }

        /* ─── FOOTER ─── */
        .footer {
            background: #050505;
            border-top: 1px solid var(--border);
            padding: 60px 5% 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }

        .footer-brand { font-family: 'Bebas Neue', sans-serif; font-size: 28px; letter-spacing: 2px; margin-bottom: 12px; }

        .footer-desc { font-size: 14px; color: var(--muted); line-height: 1.7; max-width: 280px; }

        .footer-heading {
            font-family: 'Rajdhani', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 20px;
        }

        .footer-links { list-style: none; }

        .footer-links li { margin-bottom: 10px; }

        .footer-links a {
            font-size: 14px;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: #fff; }

        .footer-bottom {
            border-top: 1px solid var(--border);
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #444;
        }

        /* ─── BUTTONS ─── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #fff;
            text-decoration: none;
            padding: 16px 36px;
            background: var(--orange);
            clip-path: polygon(0 0, 94% 0, 100% 20%, 100% 100%, 6% 100%, 0 80%);
            transition: background 0.2s, transform 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover { background: var(--orange-dark); transform: translateY(-2px); }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #fff;
            text-decoration: none;
            padding: 15px 35px;
            border: 1px solid rgba(255,255,255,0.25);
            transition: all 0.2s;
            background: transparent;
            cursor: pointer;
        }

        .btn-outline:hover { border-color: var(--orange); color: var(--orange); }

        /* ─── UTILITY ─── */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 5%; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; }

        .orange { color: var(--orange); }

        /* Noise overlay */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: 0.4;
        }

        @media (max-width: 900px) {
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
        }

        .mobile-menu-btn {
    display: none;
}

/* =========================================
   MOBILE NAVBAR
========================================= */

.mobile-menu-btn {
    display: none;
}

.mobile-menu {
    position: fixed;
    top: 72px;
    left: 0;
    width: 100%;
    background: rgba(10,10,10,0.98);
    backdrop-filter: blur(16px);

    padding: 24px;

    display: flex;
    flex-direction: column;
    gap: 20px;

    transform: translateY(-120%);
    transition: 0.4s ease;

    z-index: 999;
}

.mobile-menu.active {
    transform: translateY(0);
}

.mobile-menu a {
    color: #fff;
    text-decoration: none;

    font-family: 'Rajdhani', sans-serif;
    font-size: 18px;
    font-weight: 600;

    letter-spacing: 1px;
    text-transform: uppercase;
}

.mobile-menu-buttons {
    margin-top: 10px;
}

/* =========================================
   TABLET
========================================= */

@media (max-width: 992px) {

    .nav-links {
        gap: 20px;
    }

    .section-title {
        font-size: 60px;
    }

}

/* =========================================
   MOBILE
========================================= */

@media (max-width: 768px) {

    body {
        overflow-x: hidden;
    }

    .navbar {

        height: 78px;

        padding: 0 16px;

        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* HIDE DESKTOP MENU */

    .nav-links {
        display: none !important;
    }

    .btn-nav-contact {
        display: none;
    }

    /* SHOW HAMBURGER */

    .mobile-menu-btn {

        display: flex;

        width: 44px;
        height: 44px;

        align-items: center;
        justify-content: center;

        border: 1px solid rgba(255,255,255,0.12);

        color: #fff;

        font-size: 20px;

        cursor: pointer;

        flex-shrink: 0;
    }

    /* LOGO */

    .nav-logo {
        gap: 10px;
        max-width: 80%;
    }

    .nav-logo-icon {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
    }

    .nav-brand {
        font-size: 20px;
        letter-spacing: 1px;
    }

    .nav-tagline {
        font-size: 8px;
        letter-spacing: 2px;
    }

    /* FOOTER */

    .footer-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .footer-bottom {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

}
.footer-links {
    /* word-break: break-word; */
    overflow-wrap: anywhere;
    white-space: nowrap;
}
/* =========================================
   SMALL MOBILE
========================================= */

@media (max-width: 480px) {

    .nav-brand {
        font-size: 18px;
    }

    .nav-tagline {
        font-size: 7px;
    }

    .section-title {
        font-size: 38px;
    }

}
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar" id="navbar">
    <a href="{{ route('website.home') }}" class="nav-logo">
        {{-- <div class="nav-logo-icon"><i class="fas fa-hard-hat"></i></div> --}}
        <div class="nav-logo-icon"><img src="{{ asset('images/projects/logo.png') }}" alt="Awadh Buildmate Logo"></div>
        <div class="nav-logo-text">
            <div class="nav-brand">Awadh Buildmate</div>
            <div class="nav-tagline">Made for Quality and Trust</div>
        </div>
    </a>

    <ul class="nav-links">
        <li><a href="{{ route('website.home') }}" class="{{ request()->routeIs('website.home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('website.services') }}" class="{{ request()->routeIs('website.services') ? 'active' : '' }}">Services</a></li>
        <li><a href="{{ route('website.projects') }}" class="{{ request()->routeIs('projects') ? 'active' : '' }}">Projects</a></li>
        <li><a href="{{ route('website.about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
        <li><a href="{{ route('website.contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
    </ul>

        {{-- <div class="nav-cta">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn-nav-login"><i class="fas fa-th-large"></i> Admin Panel</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav-login"><i class="fas fa-lock"></i> Owner Login</a>
            @endauth
            <a href="{{ route('contact') }}" class="btn-nav-contact">Get Quote</a>
        </div> --}}
        {{-- @auth --}}
            {{-- Owner is logged in → show Admin Panel link --}}
            {{-- <a href="{{ route('admin.dashboard') }}" class="btn-nav-login"> --}}
                {{-- <i class="fas fa-th-large"></i> Admin Panel --}}
            {{-- </a> --}}
        {{-- @else --}}
            {{-- Not logged in → go to login page first --}}
            {{-- <a href="{{ route('admin.login') }}" class="btn-nav-login"> --}}
                {{-- <i class="fas fa-lock"></i> Owner Login --}}
            {{-- </a> --}}
        {{-- @endauth --}}
 
    <a href="{{ route('website.contact') }}" class="btn-nav-contact">Get Quote</a>
    <!-- MOBILE MENU BUTTON -->
<div class="mobile-menu-btn" id="mobileMenuBtn">
    <i class="fas fa-bars"></i>
</div>
</nav>
<!-- MOBILE MENU -->

<div class="mobile-menu" id="mobileMenu">

    <a href="{{ route('website.home') }}">Home</a>

    <a href="{{ route('website.services') }}">Services</a>

    <a href="{{ route('website.projects') }}">Projects</a>

    <a href="{{ route('website.about') }}">About</a>

    <a href="{{ route('website.contact') }}">Contact</a>

    <div class="mobile-menu-buttons">

        <a href="{{ route('website.contact') }}"
           class="btn-nav-contact">

           Get Quote

        </a>

    </div>

</div>

@yield('content')

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">Awadh <span class="orange">Buildmate</span></div>
                <p class="footer-desc">Made for Quality and Trust.</p>
                <div style="display:flex;gap:12px;margin-top:20px;">
                    <a href="#" style="width:36px;height:36px;border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:var(--muted);text-decoration:none;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--orange)';this.style.color='var(--orange)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.color='var(--muted)'"><i class="fab fa-linkedin-in" style="font-size:14px"></i></a>
                    <a href="#" style="width:36px;height:36px;border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:var(--muted);text-decoration:none;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--orange)';this.style.color='var(--orange)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.color='var(--muted)'"><i class="fab fa-instagram" style="font-size:14px"></i></a>
                    <a href="#" style="width:36px;height:36px;border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:var(--muted);text-decoration:none;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--orange)';this.style.color='var(--orange)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.color='var(--muted)'"><i class="fab fa-whatsapp" style="font-size:14px"></i></a>
                </div>
            </div>
            <div>
                <div class="footer-heading">Services</div>
                <ul class="footer-links">
                    <li><a href="{{ route('website.services') }}">Piping Fabrication and Erection</a></li>
                    <li><a href="{{ route('website.services') }}">UG Piping Works</a></li>
                    <li><a href="{{ route('website.services') }}">Structural Fabrication and Erection</a></li>
                    <li><a href="{{ route('website.services') }}">Boiler Fabrication and Erection</a></li>
                    {{-- <li><a href="{{ route('website.services') }}">Civil Works</a></li> --}}
                </ul>
            </div>
            <div>
                <div class="footer-heading">Company</div>
                <ul class="footer-links">
                    <li><a href="{{ route('website.about') }}">About Us</a></li>
                    <li><a href="{{ route('website.projects') }}">Our Projects</a></li>
                    <li><a href="{{ route('website.contact') }}">Contact</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Contact</div>
                <ul class="footer-links">
                    <li><a href="tel:+91 7275502405"><i class="fas fa-phone" style="color:var(--orange);margin-right:8px;font-size:12px"></i>+91 72755 02405</a></li>
                    <li><a href="mailto:awadhbuildmate@gmail.com"><i class="fas fa-envelope" style="color:var(--orange);margin-right:8px;font-size:12px"></i>awadhbuildmate@gmail.com</a></li>
                    <li style="color:var(--muted);font-size:14px;line-height:1.6;"><i class="fas fa-map-marker-alt" style="color:var(--orange);margin-right:8px;font-size:12px"></i>Vadodara, Gujarat, India</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Awadh Buildmate. All rights reserved.</span>
            <span>Fabrication · Erection · Structural Works</span>
        </div>
    </div>
</footer>

<script>
    // const navbar = document.getElementById('navbar');
    // window.addEventListener('scroll', () => {
    //     navbar.classList.toggle('scrolled', window.scrollY > 40);
    // });
    

    // NAVBAR SCROLL EFFECT

    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {

        navbar.classList.toggle('scrolled', window.scrollY > 40);

    });

    // MOBILE MENU

    const mobileBtn = document.getElementById('mobileMenuBtn');

    const mobileMenu = document.getElementById('mobileMenu');

    mobileBtn.addEventListener('click', () => {

        mobileMenu.classList.toggle('active');

        if (mobileMenu.classList.contains('active')) {

            mobileBtn.innerHTML =
                '<i class="fas fa-times"></i>';

        } else {

            mobileBtn.innerHTML =
                '<i class="fas fa-bars"></i>';

        }

    });

</script>

@stack('scripts')
</body>
</html>