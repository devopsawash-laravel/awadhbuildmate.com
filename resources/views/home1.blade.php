<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Awadh Buildmate — Expert Fabrication, Erection & Structural Construction across India">
    <title>Awadh Buildmate | Expert Construction & Fabrication</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>

/* ═══════════════════════════════════════════
   ROOT — DARK (charcoal) THEME
═══════════════════════════════════════════ */
:root {
    --orange:        #E8500A;
    --orange-dark:   #B83D08;
    --orange-light:  #FF6A1A;
    --orange-glow:   rgba(232,80,10,0.18);
}

[data-theme="dark"] {
    --bg:            #1C1C1C;   /* dark charcoal */
    --bg2:           #242424;
    --bg3:           #2C2C2C;
    --bg4:           #333333;
    --surface:       #282828;
    --border:        rgba(255,255,255,0.08);
    --border-o:      rgba(232,80,10,0.22);
    --text:          #F0EDE8;
    --text-muted:    #909090;
    --nav-bg:        rgba(22,22,22,0.96);
    --card-bg:       #242424;
    --footer-bg:     #141414;
    --shadow:        0 8px 40px rgba(0,0,0,0.5);
    --noise-op:      0.35;
}

[data-theme="light"] {
    --bg:            #F2EFE9;
    --bg2:           #E8E4DD;
    --bg3:           #DDD8CF;
    --bg4:           #D0CAC0;
    --surface:       #FFFFFF;
    --border:        rgba(0,0,0,0.09);
    --border-o:      rgba(232,80,10,0.25);
    --text:          #1C1C1C;
    --text-muted:    #666666;
    --nav-bg:        rgba(242,239,233,0.96);
    --card-bg:       #FFFFFF;
    --footer-bg:     #1C1C1C;
    --shadow:        0 8px 40px rgba(0,0,0,0.12);
    --noise-op:      0.15;
}

/* ═══════════════════════════════════════════
   RESET & BASE
═══════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
html, body { overflow-x: hidden; width: 100%; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    transition: background 0.4s, color 0.4s;
}
main { flex: 1; }
a { text-decoration: none; color: inherit; }

/* Noise overlay */
body::after {
    content: '';
    position: fixed; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 9999;
    opacity: var(--noise-op);
    transition: opacity 0.4s;
}

::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 2px; }

/* ═══════════════════════════════════════════
   NAVBAR — REDESIGNED
═══════════════════════════════════════════ */

/* Two-row header wrapper */
.navbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    background: var(--nav-bg);              /* always on, not just when scrolled */
    transition: background 0.35s, box-shadow 0.35s, backdrop-filter 0.35s;
}
.navbar.scrolled {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
}

/* ── TOP BAR: logo + right actions ── */
.nav-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 5%;
    height: 64px;
    border-bottom: 1px solid var(--border);
}

/* Logo block */
.nav-logo { display: flex; align-items: center; gap: 14px; text-decoration: none; }

/* .nav-logo-icon {
    width: 44px; height: 44px;
    background: var(--orange);
    display: flex; align-items: center; justify-content: center;
    transform: rotate(45deg);
    border-radius: 3px; flex-shrink: 0;
    transition: background 0.25s;
}
.nav-logo-icon:hover { background: var(--orange-dark); }
.nav-logo-icon span {
    transform: rotate(-45deg);
    font-family: 'Bebas Neue', sans-serif;
    font-size: 16px; color: #fff; letter-spacing: 1px;
} */

.nav-logo-text { line-height: 1.1; }

/* Brand name — WHITE, large, not orange */
.nav-brand {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 24px; letter-spacing: 3px;
    color: var(--text);           /* white in dark, dark in light */
    text-transform: uppercase;
}

/* Taglines — small, muted grey */
.nav-tagline-1 {
    font-family: 'Rajdhani', sans-serif;
    font-size: 9.5px; letter-spacing: 2.5px;
    color: var(--text-muted);
    text-transform: uppercase; margin-top: 2px;
}
.nav-tagline-2 {
    font-family: 'Rajdhani', sans-serif;
    font-size: 9px; letter-spacing: 2px;
    color: var(--orange);          /* only the services line gets orange */
    text-transform: uppercase; margin-top: 1px;
    opacity: 0.85;
}

/* Right side of top bar */
.nav-top-right { display: flex; align-items: center; gap: 10px; }

/* Theme toggle pill */
.theme-toggle {
    width: 50px; height: 26px;
    background: var(--bg3);
    border: 1px solid var(--border);
    border-radius: 13px;
    position: relative; cursor: pointer;
    transition: background 0.4s;
    flex-shrink: 0;
}
.theme-toggle::before {
    content: '';
    position: absolute;
    width: 20px; height: 20px;
    border-radius: 50%; top: 2px; left: 2px;
    background: var(--orange);
    box-shadow: 0 2px 6px var(--orange-glow);
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
[data-theme="light"] .theme-toggle::before { transform: translateX(24px); }
.t-icon {
    position: absolute; font-size: 10px;
    top: 50%; transform: translateY(-50%);
    transition: opacity 0.3s; pointer-events: none;
}
.t-moon { left: 5px; opacity: 1; }
.t-sun  { right: 5px; opacity: 0; }
[data-theme="light"] .t-moon { opacity: 0; }
[data-theme="light"] .t-sun  { opacity: 1; }

/* Admin login — subtle, grey */
.btn-nav-login {
    font-family: 'Rajdhani', sans-serif;
    font-size: 12px; font-weight: 600;
    letter-spacing: 1.5px; text-transform: uppercase;
    color: var(--text-muted);
    padding: 7px 14px;
    border: 1px solid var(--border);
    background: transparent;
    transition: all 0.2s; cursor: pointer;
    display: flex; align-items: center; gap: 6px;
}
.btn-nav-login:hover {
    color: var(--text);
    border-color: rgba(255,255,255,0.25);
    background: rgba(255,255,255,0.04);
}
[data-theme="light"] .btn-nav-login:hover {
    background: rgba(0,0,0,0.04);
    border-color: rgba(0,0,0,0.2);
}

/* Get Quote — orange filled */
.btn-nav-contact {
    font-family: 'Rajdhani', sans-serif;
    font-size: 12px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: #fff; padding: 8px 20px;
    background: var(--orange);
    clip-path: polygon(0 0,93% 0,100% 22%,100% 100%,7% 100%,0 78%);
    transition: background 0.2s;
    white-space: nowrap;
}
.btn-nav-contact:hover { background: var(--orange-dark); }

/* ── BOTTOM BAR: nav links ── */
.nav-bottom {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 5%;
    height: 44px;
    gap: 0;
}

.nav-links { display: flex; align-items: center; gap: 0; list-style: none; }

.nav-links a {
    font-family: 'Rajdhani', sans-serif;
    font-size: 12.5px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: var(--text-muted);
    padding: 0 24px;
    height: 44px; display: flex; align-items: center;
    position: relative;
    transition: color 0.2s;
    border-right: 1px solid var(--border);
}
.nav-links li:first-child a { border-left: 1px solid var(--border); }

/* Orange bottom highlight on active/hover */
.nav-links a::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px; background: var(--orange);
    transform: scaleX(0); transform-origin: center;
    transition: transform 0.25s;
}
.nav-links a:hover, .nav-links a.active { color: var(--text); }
.nav-links a:hover::after, .nav-links a.active::after { transform: scaleX(1); }

/* Active tab gets subtle orange tint background */
.nav-links a.active {
    background: rgba(232,80,10,0.07);
    color: var(--orange);
}

/* ── MOBILE ── */
.mobile-menu-btn {
    display: none; width: 40px; height: 40px;
    border: 1px solid var(--border);
    align-items: center; justify-content: center;
    cursor: pointer; color: var(--text); font-size: 17px;
    background: transparent; transition: border-color 0.2s, color 0.2s;
}
.mobile-menu-btn:hover { border-color: var(--orange); color: var(--orange); }

.mobile-menu {
    position: fixed; top: 108px; left: 0; width: 100%;
    background: var(--nav-bg);
    backdrop-filter: blur(20px);
    padding: 20px 5%;
    display: flex; flex-direction: column; gap: 0;
    transform: translateY(-110%);
    transition: transform 0.4s ease;
    z-index: 998;
    border-bottom: 1px solid var(--border);
}
.mobile-menu.active { transform: translateY(0); }
.mobile-menu a {
    font-family: 'Rajdhani', sans-serif;
    font-size: 17px; font-weight: 600;
    text-transform: uppercase; letter-spacing: 1.5px;
    color: var(--text-muted);
    padding: 14px 0;
    border-bottom: 1px solid var(--border);
    transition: color 0.2s, padding-left 0.2s;
}
.mobile-menu a:hover { color: var(--orange); padding-left: 8px; }
.mobile-menu a:last-of-type { border-bottom: none; }

/* ═══════════════════════════════════════════
   UTILITY
═══════════════════════════════════════════ */
.container { max-width: 1280px; margin: 0 auto; padding: 0 5%; }
.orange { color: var(--orange); }

.section-tag {
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase;
    color: var(--orange); margin-bottom: 12px;
    display: flex; align-items: center; gap: 10px;
}
.section-tag::before { content: ''; width: 32px; height: 2px; background: var(--orange); }

.section-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(42px,6vw,80px);
    letter-spacing: 2px; line-height: 0.95;
    color: var(--text);
}
.section-subtitle {
    font-size: 16px; line-height: 1.75;
    color: var(--text-muted); max-width: 520px;
}

.btn-primary {
    display: inline-flex; align-items: center; gap: 10px;
    font-family: 'Rajdhani', sans-serif;
    font-size: 14px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: #fff; padding: 16px 36px;
    background: var(--orange);
    clip-path: polygon(0 0,94% 0,100% 20%,100% 100%,6% 100%,0 80%);
    transition: background 0.2s, transform 0.2s;
    border: none; cursor: pointer;
}
.btn-primary:hover { background: var(--orange-dark); transform: translateY(-2px); }

.btn-outline {
    display: inline-flex; align-items: center; gap: 10px;
    font-family: 'Rajdhani', sans-serif;
    font-size: 14px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: var(--text); padding: 15px 35px;
    border: 1px solid var(--border);
    transition: all 0.2s; background: transparent; cursor: pointer;
}
.btn-outline:hover { border-color: var(--orange); color: var(--orange); }

/* Reveal animation */
.reveal { opacity: 0; transform: translateY(32px); transition: opacity 0.7s, transform 0.7s; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.rd1 { transition-delay: 0.1s; }
.rd2 { transition-delay: 0.2s; }
.rd3 { transition-delay: 0.3s; }
.rd4 { transition-delay: 0.4s; }

/* ═══════════════════════════════════════════
   HERO
═══════════════════════════════════════════ */
.hero {
    min-height: 100vh; padding-top: 108px;
    display: flex; align-items: center;
    position: relative; overflow: hidden;
    background: var(--bg);
}

/* Diagonal right panel */
.hero-slash {
    position: absolute; right: 0; top: 0; bottom: 0; width: 50%;
    background: var(--bg2);
    clip-path: polygon(12% 0,100% 0,100% 100%,0% 100%);
    overflow: hidden;
    transition: background 0.4s;
}
.hero-slash::before {
    content: ''; position: absolute; inset: -100%;
    background: repeating-linear-gradient(
        -55deg, transparent, transparent 28px,
        rgba(232,80,10,0.04) 28px, rgba(232,80,10,0.04) 30px
    );
    animation: slashMove 22s linear infinite;
}
@keyframes slashMove { 0%{transform:translate(0,0)} 100%{transform:translate(60px,60px)} }

/* Corner triangle */
.hero-corner {
    position: absolute; top: 72px; right: 0;
    width: 0; height: 0;
    border-top: 88px solid var(--orange);
    border-left: 88px solid transparent;
    opacity: 0.55;
}
.hero-corner {
    animation: cornerPulse 3s ease-in-out infinite;
}
@keyframes cornerPulse {
    0%, 100% { opacity: 0.45; }
    50% { opacity: 0.75; }
}
.btn-primary, .btn-outline {
    position: relative;
    overflow: hidden;
}
.btn-primary::after, .btn-outline::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: rgba(255,255,255,0.15);
    transition: left 0.4s ease;
}
.btn-primary:hover::after, .btn-outline:hover::after {
    left: 100%;
}
.ticker-strip:hover .ticker-track {
    animation-play-state: paused;
}
.svc-icon {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.service-card:hover .svc-icon {
    transform: scale(1.15) rotate(-6deg);
}
.trust-logo {
    transition: opacity 0.3s, color 0.3s, transform 0.3s;
}
.trust-logo:hover {
    transform: translateY(-3px);
}
.hero-content { position: relative; z-index: 2; padding: 5rem 5%; max-width: 700px; }

.hero-eyebrow {
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase;
    color: var(--orange);
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 20px;
    opacity: 0; transform: translateX(-20px);
    animation: fadeRight 0.6s 0.3s forwards;
}
.hero-eyebrow::before { content: ''; width: 32px; height: 2px; background: var(--orange); }

.hero h1 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(4rem,8vw,7rem);
    letter-spacing: 2px; line-height: 0.92; color: var(--text);
    margin-bottom: 24px;
    opacity: 0; transform: translateY(30px);
    animation: fadeUp 0.8s 0.5s forwards;
}
.hero h1 .h-outline {
    -webkit-text-stroke: 2px var(--orange);
    color: transparent;
}

.hero-bar {
    width: 60px; height: 4px; background: var(--orange);
    margin-bottom: 20px;
    opacity: 0; animation: fadeUp 0.6s 0.7s forwards;
}

.hero p {
    font-size: 16px; line-height: 1.8; color: var(--text-muted);
    max-width: 480px; margin-bottom: 36px;
    opacity: 0; transform: translateY(20px);
    animation: fadeUp 0.8s 0.8s forwards;
}

.hero-actions {
    display: flex; gap: 16px; flex-wrap: wrap;
    opacity: 0; transform: translateY(20px);
    animation: fadeUp 0.8s 1s forwards;
}

.hero-stats {
    display: flex; gap: 0;
    margin-top: 52px; padding-top: 36px;
    border-top: 1px solid var(--border);
    flex-wrap: wrap;
    opacity: 0; animation: fadeUp 0.8s 1.2s forwards;
}
.stat { padding: 0 28px 0 0; margin-right: 28px; border-right: 1px solid var(--border); }
.stat:last-child { border-right: none; margin-right: 0; padding-right: 0; }
.stat .num {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3rem; color: var(--orange); line-height: 1;
}
.stat .lbl {
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px; letter-spacing: 2px;
    text-transform: uppercase; color: var(--text-muted); margin-top: 4px;
}

/* Scroll hint */
.scroll-hint {
    position: absolute; bottom: 2rem; left: 5%;
    display: flex; align-items: center; gap: 12px;
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px; letter-spacing: 3px;
    text-transform: uppercase; color: var(--text-muted);
    animation: scrollPulse 2.5s ease-in-out infinite;
}
.scroll-hint::before { content: ''; width: 40px; height: 1px; background: var(--orange); }
@keyframes scrollPulse { 0%,100%{opacity:0.4;transform:translateX(0)} 50%{opacity:0.9;transform:translateX(8px)} }

/* ═══════════════════════════════════════════
   ORANGE TICKER STRIP
═══════════════════════════════════════════ */
.ticker-strip {
    background: var(--orange); overflow: hidden;
    height: 46px; display: flex; align-items: center;
}
.ticker-track {
    display: flex; width: max-content;
    animation: ticker 22s linear infinite;
}
.ticker-track span {
    display: inline-flex; align-items: center;
    padding: 0 28px;
    font-family: 'Rajdhani', sans-serif;
    font-size: 13px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase;
    color: #fff; white-space: nowrap;
}
.ticker-track span::after { content: '◆'; margin-left: 28px; opacity: 0.45; font-size: 7px; }
@keyframes ticker { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* ═══════════════════════════════════════════
   SERVICES
═══════════════════════════════════════════ */
.services-section { padding: 120px 5%; background: var(--bg2); transition: background 0.4s; }

.services-grid {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 1px; margin-top: 52px;
    background: var(--border); border: 1px solid var(--border);
}
.service-card {
    background: var(--card-bg); padding: 40px 32px;
    position: relative; overflow: hidden; cursor: pointer;
    transition: background 0.3s;
}
.service-card::before {
    content: ''; position: absolute;
    left: 0; top: 0; bottom: 0; width: 3px;
    background: var(--orange);
    transform: scaleY(0); transform-origin: bottom;
    transition: transform 0.4s;
}
.service-card:hover::before { transform: scaleY(1); }
.service-card:hover { background: var(--bg3); }
.svc-num {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3.5rem; line-height: 1;
    color: var(--border-o); margin-bottom: 8px;
    transition: color 0.3s;
}
.service-card:hover .svc-num { color: rgba(232,80,10,0.25); }
.svc-icon { font-size: 1.6rem; color: var(--orange); margin-bottom: 16px; }
.service-card h3 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.4rem; letter-spacing: 1px;
    color: var(--text); margin-bottom: 12px;
}
.service-card p { font-size: 14px; color: var(--text-muted); line-height: 1.75; }
.svc-more {
    display: inline-flex; align-items: center; gap: 8px;
    margin-top: 20px;
    font-family: 'Rajdhani', sans-serif;
    font-size: 12px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: var(--orange); transition: gap 0.2s;
}
.service-card:hover .svc-more { gap: 14px; }

.service-card {
    opacity: 0;
    transform: translateY(24px);
    animation: cardRise 0.6s ease forwards;
}
.service-card:nth-child(1) { animation-delay: 0.05s; }
.service-card:nth-child(2) { animation-delay: 0.15s; }
.service-card:nth-child(3) { animation-delay: 0.25s; }
.service-card:nth-child(4) { animation-delay: 0.35s; }

@keyframes cardRise {
    to { opacity: 1; transform: translateY(0); }
}
/* ═══════════════════════════════════════════
   PROJECT MARQUEE (exact from your blade)
═══════════════════════════════════════════ */
/* ═══ PROJECTS GRID ═══ */
.projects-section { padding: 120px 5%; background: var(--bg); transition: background 0.4s; }

.projects-header {
    display: flex; justify-content: space-between;
    align-items: flex-end; flex-wrap: wrap; gap: 1rem;
    margin-bottom: 48px;
}
.filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
.filter-tab {
    font-family: 'Rajdhani', sans-serif;
    font-size: 12px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    padding: 7px 18px;
    border: 1px solid var(--border);
    background: transparent; color: var(--text-muted);
    cursor: pointer; transition: all 0.25s;
}
.filter-tab.active, .filter-tab:hover {
    background: var(--orange); border-color: var(--orange); color: #fff;
}

/* Mosaic grid — same layout as original first version */
.projects-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-auto-rows: 280px;
    gap: 4px;
}
.project-card {
    position: relative; overflow: hidden; cursor: pointer;
    background: var(--bg2);
    border: 1px solid var(--border);
    transition: border-color 0.3s;
}
.project-card:hover { border-color: var(--border-o); }
.project-card:nth-child(1) { grid-column: span 7; grid-row: span 2; }
.project-card:nth-child(2) { grid-column: span 5; }
.project-card:nth-child(3) { grid-column: span 5; }
.project-card:nth-child(4) { grid-column: span 4; }
.project-card:nth-child(5) { grid-column: span 4; }
.project-card:nth-child(6) { grid-column: span 4; }

.pc-bg {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 5rem; opacity: 0.1;
    transition: transform 0.6s cubic-bezier(0.4,0,0.2,1);
}
.project-card:hover .pc-bg { transform: scale(1.07); }

.pc-bg1 { background: linear-gradient(135deg,#2a2318,#3d2f14); }
.pc-bg2 { background: linear-gradient(135deg,#1c2030,#242a3d); }
.pc-bg3 { background: linear-gradient(135deg,#1c2820,#24352a); }
.pc-bg4 { background: linear-gradient(135deg,#2d1c14,#3d2418); }
.pc-bg5 { background: linear-gradient(135deg,#202828,#2a3535); }
.pc-bg6 { background: linear-gradient(135deg,#221c2a,#2e2438); }

.pc-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.35) 50%, transparent 80%);
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 2rem;
    transform: translateY(6px); transition: transform 0.4s;
}
.project-card:hover .pc-overlay { transform: translateY(0); }

.pc-type {
    font-family: 'Rajdhani', sans-serif;
    font-size: 10px; font-weight: 700;
    letter-spacing: 3px; color: var(--orange);
    text-transform: uppercase; margin-bottom: 6px;
}
.pc-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.4rem; letter-spacing: 1px; color: #fff; margin-bottom: 4px;
}
.project-card:nth-child(1) .pc-name { font-size: 2rem; }
.pc-loc { font-size: 12px; color: rgba(255,255,255,0.5); }

.pc-tag {
    position: absolute; top: 1rem; left: 1rem;
    padding: 4px 12px; background: var(--orange);
    font-family: 'Rajdhani', sans-serif;
    font-size: 10px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: #fff;
}

/* ═══════════════════════════════════════════
   ABOUT
═══════════════════════════════════════════ */
.about-section { padding: 120px 5%; background: var(--bg2); transition: background 0.4s; }
.about-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 72px; align-items: center; }

.about-visual { position: relative; }
.about-img-box {
    aspect-ratio: 4/3; background: var(--bg3);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 7rem; opacity: 0.13;
    position: relative; overflow: hidden;
    transition: background 0.4s;
}
.about-img-box::before {
    content: ''; position: absolute; top: 0; right: 0;
    width: 0; height: 0;
    border-top: 100px solid var(--orange);
    border-left: 100px solid transparent; opacity: 0.35;
}
.about-badge {
    position: absolute; bottom: -2rem; right: -2rem;
    width: 140px; height: 140px;
    background: var(--orange);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    border: 4px solid var(--bg2);
    transition: border-color 0.4s;
}
.about-badge .big { font-family: 'Bebas Neue', sans-serif; font-size: 3rem; color: #fff; line-height: 1; }
.about-badge .sm {
    font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700;
    color: rgba(255,255,255,0.8); letter-spacing: 1px;
    text-transform: uppercase; text-align: center; margin-top: 4px;
}

.about-text { font-size: 15px; color: var(--text-muted); line-height: 1.85; margin: 16px 0 28px; }

.values-list { display: flex; flex-direction: column; gap: 12px; }
.value-item {
    display: flex; align-items: center; gap: 16px;
    padding: 14px 16px; background: var(--bg3);
    border: 1px solid var(--border); border-left: 3px solid var(--orange);
    transition: background 0.3s, border-left-width 0.3s;
}
.value-item:hover { background: var(--bg4); border-left-width: 5px; }
.vi-icon { font-size: 1.1rem; color: var(--orange); flex-shrink: 0; }
.vi-text h4 {
    font-family: 'Rajdhani', sans-serif;
    font-size: 14px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1px;
    color: var(--text); margin-bottom: 2px;
}
.vi-text p { font-size: 13px; color: var(--text-muted); }

/* ═══════════════════════════════════════════
   TRUST BAND
═══════════════════════════════════════════ */
.trust-band {
    background: var(--bg3); padding: 48px 5%;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    text-align: center; transition: background 0.4s;
}
.trust-label {
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase;
    color: var(--text-muted); margin-bottom: 28px;
}
.trust-logos { display: flex; justify-content: center; align-items: center; gap: 48px; flex-wrap: wrap; }
.trust-logo {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.3rem; letter-spacing: 2px;
    color: var(--text-muted); opacity: 0.45;
    transition: opacity 0.3s, color 0.3s; cursor: default;
}
.trust-logo:hover { opacity: 1; color: var(--orange); }

/* ═══════════════════════════════════════════
   CONTACT
═══════════════════════════════════════════ */
.contact-section { padding: 120px 5%; background: var(--bg); transition: background 0.4s; }
.contact-inner { display: grid; grid-template-columns: 1fr 1.6fr; gap: 72px; }

.contact-h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2.5rem,4vw,3.5rem);
    letter-spacing: 2px; line-height: 1;
    color: var(--text); margin-bottom: 16px;
}
.contact-sub { font-size: 14px; color: var(--text-muted); line-height: 1.8; margin-bottom: 32px; }
.contact-details { display: flex; flex-direction: column; gap: 12px; }
.contact-item {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 16px; background: var(--bg2);
    border: 1px solid var(--border); border-left: 3px solid var(--orange);
    transition: background 0.3s;
}
.contact-item:hover { background: var(--bg3); }
.ci-icon {
    width: 36px; height: 36px;
    background: rgba(232,80,10,0.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--orange); flex-shrink: 0;
}
.ci-label {
    font-family: 'Rajdhani', sans-serif;
    font-size: 10px; font-weight: 700;
    letter-spacing: 2px; color: var(--orange); text-transform: uppercase;
}
.ci-val { font-size: 1px; color: var(--text); margin-top: 2px; }

/* Form */
.contact-form { display: flex; flex-direction: column; gap: 16px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group label {
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted);
}
.form-group input,
.form-group select,
.form-group textarea {
    padding: 12px 14px; background: var(--bg2);
    border: 1px solid var(--border); color: var(--text);
    font-family: 'DM Sans', sans-serif; font-size: 14px;
    outline: none; resize: vertical;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.form-group input::placeholder,
.form-group textarea::placeholder { color: var(--text-muted); }
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(232,80,10,0.1);
}
.form-group select option { background: var(--bg2); color: var(--text); }
.form-group textarea { min-height: 120px; }

/* ═══════════════════════════════════════════
   FOOTER (exact from your blade code)
═══════════════════════════════════════════ */
.footer {
    background: var(--footer-bg);
    border-top: 1px solid var(--border);
    padding: 60px 5% 30px;
    transition: background 0.4s;
}
.footer-grid {
    display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 48px; margin-bottom: 48px;
}
.footer-brand {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 28px; letter-spacing: 2px;
    color: #F0EDE8; margin-bottom: 12px;
}
[data-theme="light"] .footer-brand { color: #F0EDE8; }
.footer-desc { font-size: 14px; color: #909090; line-height: 1.7; max-width: 280px; }
.footer-heading {
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase;
    color: var(--orange); margin-bottom: 20px;
}
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 10px; }
.footer-links a,
.footer-links .address {
    display: flex; align-items: flex-start; gap: 8px;
    color: #909090; font-size: 14px; line-height: 1.6;
    transition: color 0.2s;
}
.footer-links a:hover { color: #fff; }
.footer-links i { color: var(--orange); font-size: 12px; margin-top: 5px; flex-shrink: 0; }
.email-link { word-break: break-word; overflow-wrap: anywhere; }
.footer-social { display: flex; gap: 12px; margin-top: 20px; }
.social-btn {
    width: 36px; height: 36px;
    border: 1px solid rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center;
    color: #909090; font-size: 14px; cursor: pointer;
    transition: all 0.2s;
}
.social-btn:hover { border-color: var(--orange); color: var(--orange); }
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.06);
    padding-top: 24px;
    display: flex; justify-content: space-between; align-items: center;
    font-size: 13px; color: #444; flex-wrap: wrap; gap: 10px;
}

/* ═══════════════════════════════════════════
   KEYFRAMES
═══════════════════════════════════════════ */
@keyframes fadeUp   { to { opacity:1; transform:translateY(0); } }
@keyframes fadeRight{ to { opacity:1; transform:translateX(0); } }

/* ═══════════════════════════════════════════
   RESPONSIVE (exact from your blade)
═══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .nav-top { padding: 0 20px; }
    .nav-links a { padding: 0 16px; font-size: 12px; }
    .services-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 900px) {
    .nav-bottom { display: none; }
    .btn-nav-login, .btn-nav-contact { display: none; }
    .mobile-menu-btn { display: flex; }
    .hero { padding-top: 64px; }
    .mobile-menu { top: 64px; }
    .about-inner { grid-template-columns: 1fr; gap: 4rem; }
    .about-badge { right: 0; bottom: -1rem; width: 110px; height: 110px; }
    .about-badge .big { font-size: 2.3rem; }
    .contact-inner { grid-template-columns: 1fr; gap: 3rem; }
    .footer-grid { grid-template-columns: 1fr 1fr; }
    .services-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .navbar { height: 75px; }
    .nav-brand { font-size: 22px; }
    .nav-tagline { font-size: 8px; letter-spacing: 2px; }
    .projects-grid { grid-template-columns: repeat(6,1fr); grid-auto-rows: 220px; }
    .project-card:nth-child(1) { grid-column: span 6; grid-row: span 1; }
    .project-card:nth-child(n) { grid-column: span 3; }
    .projects-section, .services-section, .about-section, .contact-section { padding: 80px 5%; }
    .form-row { grid-template-columns: 1fr; }
    .footer-grid { grid-template-columns: 1fr; }
    .footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
}
@media (max-width: 480px) {
    .section-title { font-size: 34px; }
    .projects-grid { grid-template-columns: 1fr; grid-auto-rows: 240px; }
    .project-card:nth-child(n) { grid-column: span 1; grid-row: span 1; }
    .hero-stats { gap: 1rem; }
    .stat { margin-right: 1rem; padding-right: 1rem; }
}
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
}

.nav-logo-icon {
    width: 50px;
    height: 50px;
    object-fit: contain;
    flex-shrink: 0;
    display: block;
}
.nav-logo-icon:hover {
    transform: scale(1.05);
}

/* Css for service List */
.svc-list {
    list-style: none;
    margin: 16px 0 4px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.svc-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: var(--text-muted);
    font-family: 'DM Sans', sans-serif;
}
.svc-list li i {
    color: var(--orange);
    font-size: 11px;
    flex-shrink: 0;
}

.form-error {
    font-size: 12px;
    color: #ff5a5a;
    min-height: 14px;
    display: block;
}
</style>
</head>
<body>

<!-- ═══ NAVBAR — Two-row clean layout ═══ -->
<nav class="navbar" id="navbar">

    <!-- TOP ROW: Logo  |  Theme + Admin + Quote -->
            <div class="nav-top">
                <a href="#home" class="nav-logo">
    <img src="images/projects/logo.png" alt="Awadh Buildmate" class="nav-logo-icon">
    <div class="nav-logo-text">
        <div class="nav-brand">Awadh Buildmate</div>
        <div class="nav-tagline-1">Made for Quality and Trust</div>
        <div class="nav-tagline-2">Fabrication · Erection · Structural Works</div>
    </div>
</a>

        <div class="nav-top-right">
            <!-- Theme toggle -->
            <div class="theme-toggle" id="themeToggle" title="Toggle light / dark">
                <span class="t-icon t-moon">🌙</span>
                <span class="t-icon t-sun">☀️</span>
            </div>
            <a href="{{ route('admin.login') }}" class="btn-nav-login"><i class="fas fa-lock"></i> Admin Login</a>
            <a href="#contact" class="btn-nav-contact">Get Quote</a>
            <div class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i></div>
        </div>
    </div>

    <!-- BOTTOM ROW: Nav links centered -->
    <div class="nav-bottom">
        <ul class="nav-links">
            <li><a href="#home"     class="nav-link active">Home</a></li>
            <li><a href="#services" class="nav-link">Services</a></li>
            <li><a href="#projects" class="nav-link">Projects</a></li>
            <li><a href="#about"    class="nav-link">About</a></li>
            <li><a href="#contact"  class="nav-link">Contact</a></li>
        </ul>
    </div>

</nav>

<!-- Mobile menu -->
<div class="mobile-menu" id="mobileMenu">
    <a href="#home">Home</a>
    <a href="#services">Services</a>
    <a href="#projects">Projects</a>
    <a href="#about">About</a>
    <a href="#contact">Contact</a>
    <div style="margin-top:16px">
        <a href="#contact" class="btn-nav-contact">Get Quote</a>
    </div>
</div>

<!-- ═══ HERO ═══ -->
<section id="home" class="hero">
    <div class="hero-slash"></div>
    <div class="hero-corner"></div>
    <div class="hero-content">
        <!--<div class="hero-eyebrow">Est. 2025 · Vadodara, India</div>-->
        <h1>
            Building<br>
            <span style="color:var(--orange)">Construction</span><br>
            <span class="h-outline">Excellence</span>
        </h1>
        <div class="hero-bar"></div>
        <p>Delivering high-quality fabrication, erection and industrial construction projects across India..</p>
        <div class="hero-actions">
            <a href="#projects" class="btn-primary"><i class="fas fa-hard-hat"></i> Our Projects</a>
            <a href="#contact"  class="btn-outline"><i class="fas fa-envelope"></i> Get a Quote</a>
        </div>
        <div class="hero-stats">
            <div class="stat"><div class="num" data-count="1">0</div><div class="lbl">Years Active</div></div>
            <div class="stat"><div class="num" data-count="1">0</div><div class="lbl">Projects Done</div></div>
            <div class="stat"><div class="num" data-count="80">0</div><div class="lbl">Expert Team</div></div>
            <div class="stat"><div class="num" data-count="98">0</div><div class="lbl">% Satisfaction</div></div>
        </div>
    </div>
    <div class="scroll-hint">Scroll Down</div>
</section>

<!-- ═══ TICKER ═══ -->
<div class="ticker-strip">
    <div class="ticker-track">
        <span>Structural Fabrication</span><span>Piping Fabrication and Erection</span>
        <span>UG Piping Works</span><span>UG Piping works</span>
        <span>Boiler Fabrication</span><span>Structural Fabrication and Erection</span>
        <span>Steel Structures</span><span>Boiler Fabrication and Erection</span>
    </div>
</div>

<!-- ═══ SERVICES ═══ -->
<section id="services" class="services-section">
    <div class="reveal"><span class="section-tag">What We Do</span></div>
    <div class="reveal rd1"><h2 class="section-title">Our Core <span class="orange">Services</span></h2></div>
    <div class="reveal rd2"><p class="section-subtitle" style="margin-bottom:0">From structural steel fabrication to underground piping — we handle every phase of industrial construction with unmatched precision and safety.</p></div>
    <div class="services-grid reveal rd3">
        <div class="service-card">
            <div class="svc-num">01</div>
            <div class="svc-icon"><i class="fas fa-industry"></i></div>
            <h3>Piping Fabrication &amp; Erection</h3>
            <p>We provide comprehensive industrial piping solutions, from high-precision fabrication to seamless on-site installation and erection. Equipped with advanced machinery and certified welders, we ensure absolute integrity, safety, and compliance with global engineering standards for all fluid and gas transport systems</p>
            <ul class="svc-list">
                <li><i class="fas fa-check"></i>Process and Utility Piping Networks (Carbon Steel, Stainless Steel)s</li>
                <li><i class="fas fa-check"></i> Pre-Fabricated Pipe Spools and Skid Packages</li>
                <li><i class="fas fa-check"></i> High-Pressure Piping and Cross-Country Pipelinest</li>
                <li><i class="fas fa-check"></i> ​On-Site Pipe Routing, Alignment, Support Installation, and Erection</li>
                <li><i class="fas fa-check"></i> ​Hydrotesting, Non-Destructive Testing (NDT), and Quality Assurance</li>
            </ul>
            <div class="svc-more">Learn More <i class="fas fa-arrow-right"></i></div>
        </div>

        <div class="service-card">
            <div class="svc-num">02</div>
            <div class="svc-icon"><i class="fas fa-tools"></i></div>
            <h3>UG Piping works</h3>
            <p>We deliver end-to-end underground (UG) piping solutions engineered to withstand subterranean pressure, soil corrosion, and environmental factors. From precise trenching and excavation to advanced anti-corrosive wrapping, laying, and backfilling, we ensure long-term durability and structural safety for critical sub-surface fluid networks.</p>
            <ul class="svc-list">
                <li><i class="fas fa-check"></i>Trenching, Excavation, and Bedding Preparation</li>
                <li><i class="fas fa-check"></i>Industrial Cooling Water, Firewater, and Effluent UG Networks</li>
                <li><i class="fas fa-check"></i>Anti-Corrosion Protection (Coal Tar Tape Wrapping, 3LPE, and Cathodic Protection)</li>
                <li><i class="fas fa-check"></i>Jointing, Welding, and Holiday Testing for Coating Integrity</li>
                <li><i class="fas fa-check"></i>Hydrotesting, Backfilling, and Soil Compaction Compliance</li>
            </ul>
            <div class="svc-more">Learn More <i class="fas fa-arrow-right"></i></div>
        </div>

        <div class="service-card">
            <div class="svc-num">03</div>
            <div class="svc-icon"><i class="fas fa-hard-hat"></i></div>
            <h3>Structural Fabrication and Erection</h3>
            <p>We specialize in heavy-duty structural steel fabrication and erection, delivering robust frameworks for complex industrial infrastructures. Combining precision workshop engineering with highly planned heavy-lifting and site assembly, we build durable, high-load structures that form the backbone of modern factories, warehouses, and process plants.</p>
           <ul class="svc-list">
                <li><i class="fas fa-check"></i>​Heavy Structural Steel Beams, Columns, Bracings, and Trusses</li>
                <li><i class="fas fa-check"></i>​Industrial Sheds, Warehouses, and Pre-Engineered Building (PEB) Frameworks</li>
                <li><i class="fas fa-check"></i>Pipe Racks, Cable Tray Supports, and Technological Structures</li>
                <li><i class="fas fa-check"></i>​Industrial Platforms, Walkways, Mezzanine Floors, and Safety Staircases</li>
                <li><i class="fas fa-check"></i>Crane-Assisted Heavy Lifts, Rigging, and Safe On-Site Assembly</li>
            </ul>
            <div class="svc-more">Learn More <i class="fas fa-arrow-right"></i></div>
        </div>

        <div class="service-card">
            <div class="svc-num">04</div>
            <div class="svc-icon"><i class="fas fa-fire"></i></div>
            <h3>Boiler Fabrication &amp; Erection</h3>
            <p>We offer expert engineering solutions for industrial boiler fabrication and on-site erection, ensuring high thermal efficiency and absolute operational safety. Adhering strictly to IBR (Indian Boiler Regulations) and global safety codes, our certified team handles everything from precision pressure part fabrication to complex field installation and commissioning.</p>
            <ul class="svc-list">
                <li><i class="fas fa-check"></i>​Fabrication of Boiler Pressure Parts (Waterwalls, Superheaters, Economizers, and Coils)</li>
                <li><i class="fas fa-check"></i>Structural Framework, Boiler Casing, and Ducting Fabrication</li>
                <li><i class="fas fa-check"></i>On-Site Positioning, Alignment, Structural Support, and Boiler Erection</li>
                <li><i class="fas fa-check"></i>​High-Pressure Piping Integration and Header Interconnections</li>
                <li><i class="fas fa-check"></i>​Pre-Commissioning Hydrotests, NDT Inspections, and Regulatory (IBR) Approvals</li>
            </ul>
            <div class="svc-more">Learn More <i class="fas fa-arrow-right"></i></div>
        </div>
        
    </div>
</section>

<!-- ═══ PROJECTS GRID ═══ -->
<section id="projects" class="projects-section">
    <div class="projects-header">
        <div>
            <div class="reveal"><span class="section-tag">Our Projects</span></div>
            <div class="reveal rd1"><h2 class="section-title">Construction <span class="orange">In Motion</span></h2></div>
        </div>
        <div class="filter-tabs reveal rd2">
            <button class="filter-tab active" onclick="setFilter(this)">All</button>
            <button class="filter-tab" onclick="setFilter(this)">Structural</button>
            <button class="filter-tab" onclick="setFilter(this)">Piping</button>
            <button class="filter-tab" onclick="setFilter(this)">Civil</button>
        </div>
    </div>

    <div class="projects-grid reveal rd3">
        <div class="project-card">
            <div class="pc-bg pc-bg1">🏗️</div>
            <div class="pc-tag">Featured</div>
            <div class="pc-overlay">
                <div class="pc-type">IBR Piping Fabrication & Erection</div>
                <div class="pc-name">Asian Paints(L&T)</div>
                <div class="pc-loc"><i class="fas fa-map-marker-alt" style="color:var(--orange);margin-right:5px"></i>L&T, Dahej</div>
            </div>
        </div>
        <div class="project-card">
            <div class="pc-bg pc-bg2">🔩</div>
            <div class="pc-overlay">
                <div class="pc-type">Structure</div>
                <div class="pc-name">Adani Power Limited(FabTech)</div>
                <div class="pc-loc"><i class="fas fa-map-marker-alt" style="color:var(--orange);margin-right:5px"></i>Mundra</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ ABOUT ═══ -->
<section id="about" class="about-section">
    <div class="about-inner">
        <div class="about-visual reveal">
            <div class="about-img-box">🏗️</div>
            <div class="about-badge">
                <div class="big">1.5+</div>
                <div class="sm">Years of<br>Excellence</div>
            </div>
        </div>
        <div>
            <div class="reveal"><span class="section-tag">Who we are...</span></div>
            <div class="reveal rd1"><h2 class="section-title">Built for <span class="orange">Quality</span> &amp; Trust</h2></div>
            <div class="reveal rd2"><p class="about-text">At Awadh Buildmate, we are dedicated to engineering excellence, specializing in high-precision mechanical piping, IBR boiler fabrication, and heavy structural steel erection. We serve as a trusted partner to core industries—including power plants, refineries, chemical units, and manufacturing facilities—by turning complex engineering blueprints into robust, safely executed realities..</p></div>
            <div class="reveal rd2"><p class="about-text">Our mission is to deliver dependable, high-integrity mechanical and structural contracting services that exceed client expectations. Driven by absolute technical precision, strict regulatory compliance, and transparent project management, we ensure every asset we build is engineered for maximum performance, durability, and operational safety.</p></div>
                <div class="value-item"><div class="vi-icon"><i class="fas fa-certificate"></i></div><div class="vi-text"><h4>ISO Certified Quality</h4><p>All works comply with national and international quality standards.</p></div></div>
                <div class="value-item"><div class="vi-icon"><i class="fas fa-hard-hat"></i></div><div class="vi-text"><h4>Zero Compromise on Safety</h4><p>Rigorous HSE protocols across every site, every single day.</p></div></div>
                <div class="value-item"><div class="vi-icon"><i class="fas fa-clock"></i></div><div class="vi-text"><h4>On-Time Every Time</h4><p>97% of our projects delivered on or before the committed date.</p></div></div>
                <div class="value-item"><div class="vi-icon"><i class="fas fa-tools"></i></div><div class="vi-text"><h4>In-House Fabrication</h4><p>Fully equipped fabrication yard for faster turnaround and cost savings.</p></div></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ TRUST BAND ═══ -->
<div class="trust-band reveal">
    <div class="trust-label">Trusted by leading industries across India</div>
    <div class="trust-logos">
        <div class="trust-logo">ONGC</div>
        <div class="trust-logo">NTPC</div>
        <div class="trust-logo">BPCL</div>
        <div class="trust-logo">L&amp;T</div>
        <div class="trust-logo">TATA Projects</div>
        <div class="trust-logo">HPCL</div>
    </div>
</div>

<!-- ═══ CONTACT ═══ -->
<section id="contact" class="contact-section">
    <div class="contact-inner">
        <div class="reveal">
            <span class="section-tag">Get In Touch</span>
            <h2 class="contact-h2">Start Your <span class="orange">Project</span> With Us</h2>
            <p class="contact-sub">Our experienced team is ready to assess your requirements and deliver a cost-effective, time-bound solution tailored to your industry.</p>
            <div class="contact-details">
                <!--<div class="contact-item"><div class="ci-icon"><i class="fas fa-phone"></i></div><div><div class="ci-label">Phone</div><div class="ci-val">+91 7275502405</div></div></div>-->
                <div class="contact-item"><div class="ci-icon"><i class="fas fa-envelope"></i></div><div><div class="ci-label">Email</div><div class="ci-val">awadhbuildmate@gmail.com</div></div></div>
                <div class="contact-item"><div class="ci-icon"><i class="fas fa-map-marker-alt"></i></div><div><div class="ci-label">Location</div><div class="ci-val">Vadodara, Gujarat, India</div></div></div>
                <div class="contact-item"><div class="ci-icon"><i class="fas fa-clock"></i></div><div><div class="ci-label">Working Hours</div><div class="ci-val">Mon–Sat: 9:00 AM – 6:00 PM</div></div></div>
            </div>
        </div>
        <div class="reveal rd2">
           <form method="POST" action="{{ route('website.submit') }}" id="contactForm">
    @csrf
    <div class="contact-form">
        <div class="form-row">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="name" placeholder="Ramesh Shah" required>
                <span class="form-error" data-field="name"></span>
            </div>
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" name="company" placeholder="Shah Industries Ltd.">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="you@example.com">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" placeholder="+91 XXXXXXXXXX" required>
                <span class="form-error" data-field="phone"></span>
            </div>
        </div>
        <div class="form-group">
            <label>Service Required</label>
            <select name="service_type">
                <option value="">Select a service...</option>
                <option>Piping Fabrication and Erection</option>
                <option>UG Piping Works</option>
                <option>Structural Fabrication and Erection</option>
                <option>Boiler Fabrication and Erection</option>
                <option>Civil &amp; RCC Works</option>
                <option>Shutdown &amp; Maintenance</option>
            </select>
        </div>
        <div class="form-group">
            <label>Project Details</label>
            <textarea name="message" placeholder="Describe your project — location, scope, timeline, budget range..."></textarea>
            <span class="form-error" data-field="message"></span>
        </div>
        <button type="submit" id="submitBtn" class="btn-primary" style="width:100%;padding:18px;justify-content:center;">
            <i class="fas fa-paper-plane"></i> <span id="submitBtnText">Send Message</span>
        </button>
    </div>
</form>
            </div>
        </div>
    </div>

</section>

<!-- ═══ FOOTER (exact from your blade) ═══ -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">Awadh <span class="orange">Buildmate</span></div>
                <p class="footer-desc">Made for Quality and Trust.</p>
                <div class="footer-social">
                    <a class="social-btn" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="social-btn" href="#"><i class="fab fa-instagram"></i></a>
                    <a class="social-btn" href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div>
                <div class="footer-heading">Services</div>
                <ul class="footer-links">
                    <li><a href="#services">Piping Fabrication and Erection</a></li>
                    <li><a href="#services">UG Piping Works</a></li>
                    <li><a href="#services">Structural Fabrication and Erection</a></li>
                    <li><a href="#services">Boiler Fabrication and Erection</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Company</div>
                <ul class="footer-links">
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#projects">Our Projects</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Contact</div>
                <ul class="footer-links">
                    <!--<li><a href="tel:+917275502405"><i class="fas fa-phone"></i>+91 7275502405</a></li>-->
                    <li><a href="mailto:awadhbuildmate@gmail.com" class="email-link"><i class="fas fa-envelope"></i>awadhbuildmate@gmail.com</a></li>
                    <li class="address" style="display:flex;align-items:flex-start;gap:8px">
                        <i class="fas fa-map-marker-alt" style="color:var(--orange);font-size:12px;margin-top:5px;flex-shrink:0"></i>
                        <span style="color:#909090;font-size:14px">Vadodara, Gujarat, India</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; 2024 Awadh Buildmate. All rights reserved.</span>
            <span>Fabrication · Erection · Structural Works</span>
        </div>
    </div>
</footer>

<script>
/* ─── NAVBAR SCROLL (exact from your blade) ─── */
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
}, { passive: true });

/* ─── THEME TOGGLE ─── */
const html = document.documentElement;
const themeToggle = document.getElementById('themeToggle');
const saved = localStorage.getItem('ab-theme') || 'dark';
html.setAttribute('data-theme', saved);

themeToggle.addEventListener('click', () => {
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('ab-theme', next);
});

/* ─── MOBILE MENU (exact from your blade) ─── */
const mobileBtn  = document.getElementById('mobileMenuBtn');
const mobileMenu = document.getElementById('mobileMenu');
mobileBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('active');
    mobileBtn.innerHTML = mobileMenu.classList.contains('active')
        ? '<i class="fas fa-times"></i>'
        : '<i class="fas fa-bars"></i>';
});
mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
    mobileMenu.classList.remove('active');
    mobileBtn.innerHTML = '<i class="fas fa-bars"></i>';
}));

/* ─── SCROLL REVEAL ─── */
const revObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.reveal').forEach(el => revObs.observe(el));

/* ─── COUNTER ANIMATION ─── */
function animCounter(el) {
    const target = parseInt(el.dataset.count);
    const isPercent = target === 98;
    const dur = 2200, start = performance.now();
    function upd(now) {
        const p = Math.min((now - start) / dur, 1);
        const ease = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.floor(ease * target) + (p >= 1 ? (isPercent ? '' : '+') : '');
        if (p < 1) requestAnimationFrame(upd);
        else el.textContent = target + (isPercent ? '' : '+');
    }
    requestAnimationFrame(upd);
}
const cntObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting && !e.target.classList.contains('counted')) {
            e.target.classList.add('counted'); animCounter(e.target);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-count]').forEach(el => cntObs.observe(el));

/* ─── ACTIVE NAV ─── */
const secs  = document.querySelectorAll('section[id]');
const navAs = document.querySelectorAll('.nav-link');
window.addEventListener('scroll', () => {
    let cur = '';
    secs.forEach(s => { if (window.scrollY >= s.offsetTop - 120) cur = s.id; });
    navAs.forEach(a => {
        a.classList.remove('active');
        if (a.getAttribute('href') === '#' + cur) a.classList.add('active');
    });
}, { passive: true });

/* ─── FILTER TABS ─── */
function setFilter(el) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}


function handleSubmit(btn) {
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    btn.style.opacity = '0.7';
    setTimeout(() => {
        btn.innerHTML = '<i class="fas fa-check"></i> Message Sent!';
        btn.style.background = '#22c55e'; btn.style.opacity = '1';
        setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; }, 3500);
    }, 1600);
}
</script>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('submitBtnText');
        if (btn) {
            btn.innerHTML = '<i class="fas fa-check"></i> {{ session('success') }}';
            btn.style.background = '#22c55e';
            btn.disabled = true;
            // Optional: revert after a few seconds
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Message';
                btn.style.background = '';
                btn.disabled = false;
            }, 5000);
        }
        // Scroll to the contact section so the user actually sees it
        document.getElementById('contact')?.scrollIntoView({ behavior: 'smooth' });
    });
</script>
@endif

<script>
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const btn = document.getElementById('submitBtn');
        const originalHTML = '<i class="fas fa-paper-plane"></i> Send Message';

        document.querySelectorAll('.form-error').forEach(el => el.textContent = '');

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        btn.style.background = '';

        try {
            const formData = new FormData(contactForm);
            const res = await fetch(contactForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const data = await res.json();

            if (res.ok) {
                btn.innerHTML = '<i class="fas fa-check"></i> ' + (data.message || 'Thanks for contacting Awadh Buildmate!');
                btn.style.background = '#22c55e';
                contactForm.reset();

                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 4000);
            } else if (res.status === 422) {
                const errors = data.errors || {};
                Object.keys(errors).forEach(field => {
                    const el = document.querySelector(`.form-error[data-field="${field}"]`);
                    if (el) el.textContent = errors[field][0];
                });
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            } else {
                throw new Error('Server error');
            }
        } catch (err) {
            btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Something went wrong';
            btn.style.background = '#dc2626';
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.style.background = '';
                btn.disabled = false;
            }, 3000);
        }
    });
}
</script>   
</body>
</html>