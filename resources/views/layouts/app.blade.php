<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AwadhBuildmate') — Construction ERP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* ==================== RESET & TOKENS ==================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:        #1A140F;   /* near-black brown — sidebar */
            --ink-2:      #2C2118;   /* lighter brown-black panel */
            --ink-soft:   rgba(255,255,255,.06);
            --brass:      #D2540C;   /* deep orange — primary accent */
            --brass-dark: #9C3D08;
            --brass-light:#FBE4D2;
            --brown:      #6B4A32;   /* secondary warm neutral */
            --brown-light:#E7DACB;
            --bg:         #F1ECE5;   /* warm stone background */
            --surf:       #FFFFFF;
            --bdr:        #E0D6C9;
            --txt:        #241B14;
            --muted:      #7C6B5A;
            --success:    #3F7A4E;
            --success-bg: #E9F2EA;
            --danger:     #A8341E;
            --danger-bg:  #FAEAE5;
            --warning:    #8A5A1E;
            --warning-bg: #F5E9D6;
            --info:       #3B6E91;
            --info-bg:    #E7F0F5;
            --sidebar-w: 248px;
            --topbar-h:  60px;
            --radius:    10px;
            --radius-lg: 14px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--txt);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
            transition: background .25s ease, color .25s ease;
        }

        .mono     { font-family: 'JetBrains Mono', monospace; }
        .display  { font-family: 'Archivo', sans-serif; }

        /* ==================== SIDEBAR ==================== */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--ink);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            top: 0; left: 0;
            z-index: 200;
            border-right: 1px solid rgba(255,255,255,.08);
            background-image:
                linear-gradient(var(--ink-soft) 1px, transparent 1px),
                linear-gradient(90deg, var(--ink-soft) 1px, transparent 1px);
            background-size: 24px 24px;
            transition: transform .28s cubic-bezier(.4,0,.2,1), background .25s ease, border-color .25s ease;
        }

        .sidebar-brand {
            padding: 22px 18px 18px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0;
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand-stamp {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 2px solid var(--brass);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            position: relative;
        }

        .brand-stamp i { color: var(--brass); font-size: 15px; }

        .brand-stamp::after {
            content: '';
            position: absolute;
            inset: -5px;
            border: 1px dashed rgba(210,84,12,.4);
            border-radius: 50%;
        }

        .brand-name {
            font-family: 'Archivo', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .2px;
            line-height: 1.2;
        }

        .brand-sub {
            font-size: 9px;
            color: var(--brass);
            letter-spacing: 1.8px;
            text-transform: uppercase;
            margin-top: 3px;
            font-weight: 600;
        }

        /* Nav scroll area */
        .nav-section {
            flex: 1;
            overflow-y: auto;
            padding: 14px 0 8px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .nav-section::-webkit-scrollbar { display: none; }

        .nav-label {
            font-family: 'Archivo', sans-serif;
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,.32);
            padding: 14px 18px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 18px 9px 15px;
            margin: 0 8px;
            border-radius: 6px;
            color: rgba(255,255,255,.62);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            position: relative;
            transition: color .2s, background .2s, transform .15s;
        }

        .nav-item .tick {
            width: 3px; height: 14px;
            background: transparent;
            border-radius: 2px;
            flex-shrink: 0;
            transition: background .2s;
        }

        .nav-item:hover {
            color: rgba(255,255,255,.92);
            background: rgba(255,255,255,.05);
        }

        .nav-item.active {
            color: var(--brass-light);
            background: linear-gradient(90deg, rgba(210,84,12,.22), rgba(210,84,12,.05));
        }
        .nav-item.active .tick { background: var(--brass); }

        .nav-item i { width: 15px; text-align: center; font-size: 13.5px; flex-shrink: 0; }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0;
        }

        .nav-logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 13px;
            background: transparent;
            color: rgba(255,255,255,.55);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 7px;
            font-size: 12.5px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: border-color .2s, color .2s;
            letter-spacing: .2px;
        }

        .nav-logout-btn i { font-size: 13px; width: 14px; text-align: center; }

        .nav-logout-btn:hover {
            border-color: var(--danger);
            color: #f0aaa0;
        }

        .sidebar-version {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9.5px;
            color: rgba(255,255,255,.25);
            margin-top: 12px;
            text-align: center;
            letter-spacing: 1px;
        }

        /* ==================== MAIN AREA ==================== */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ==================== TOPBAR ==================== */
        .topbar {
            background: var(--surf);
            border-bottom: 1px solid var(--bdr);
            padding: 0 28px;
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: background .25s ease, border-color .25s ease;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 18px;
            padding: 4px;
            line-height: 1;
        }

        .topbar-eyebrow {
            font-size: 10px;
            color: var(--brass-dark);
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 1px;
        }

        .topbar-title {
            font-family: 'Archivo', sans-serif;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -.2px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-date {
            font-size: 12.5px;
            color: var(--muted);
            font-family: 'JetBrains Mono', monospace;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: var(--bg);
            border-radius: 6px;
            border: 1px solid var(--bdr);
        }

        .topbar-date i { font-size: 13px; }

        .topbar-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--ink);
            border: 2px solid var(--brass);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            font-family: 'Archivo', sans-serif;
            flex-shrink: 0;
        }

        /* Theme toggle */
        .theme-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px;
            background: var(--bg);
            border: 1px solid var(--bdr);
            border-radius: 20px;
            cursor: pointer;
            user-select: none;
        }
        .theme-toggle .tt-opt {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
            transition: all .2s;
        }
        .theme-toggle .tt-opt i { font-size: 12px; }
        .theme-toggle .tt-opt.is-on {
            background: var(--ink);
            color: #fff;
        }
        body.theme-light .theme-toggle .tt-opt.is-on {
            background: var(--brass);
            color: #fff;
        }

        /* ==================== CONTENT WRAPPER ==================== */
        .content {
            padding: 28px;
            flex: 1;
            animation: fadeInUp .4s ease-out both;
        }

        /* ==================== PAGE HEADER ==================== */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 22px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-title {
            font-family: 'Archivo', sans-serif;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -.3px;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* ==================== SECTION LABEL ==================== */
        .sec-label {
            font-family: 'Archivo', sans-serif;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sec-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--bdr);
        }

        /* ==================== CARDS ==================== */
        .card {
            background: var(--surf);
            border: 1px solid var(--bdr);
            border-radius: var(--radius-lg);
            overflow: hidden;
            animation: fadeInUp .5s cubic-bezier(.4,0,.2,1) both;
            transition: background .25s ease, border-color .25s ease;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--bdr);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: 'Archivo', sans-serif;
            font-weight: 700;
            font-size: 14.5px;
        }

        .card-header i { color: var(--brass-dark); margin-right: 6px; }

        .card-body { padding: 18px; }

        /* ==================== STAT CARDS ==================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(195px, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: var(--surf);
            border: 1px solid var(--bdr);
            border-top: 3px solid var(--ink);
            border-radius: var(--radius-lg);
            padding: 18px 18px 16px;
            position: relative;
            overflow: hidden;
            cursor: default;
            transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease, background .25s ease;
            animation: scaleIn .4s cubic-bezier(.4,0,.2,1) both;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26,20,15,.1);
        }

        .stat-card.accent { border-top-color: var(--brass); }
        .stat-card.live   { border-top-color: var(--success); }
        .stat-card.alert  { border-top-color: var(--danger); }

        .stat-card:nth-child(1) { animation-delay: .05s; }
        .stat-card:nth-child(2) { animation-delay: .10s; }
        .stat-card:nth-child(3) { animation-delay: .15s; }
        .stat-card:nth-child(4) { animation-delay: .20s; }
        .stat-card:nth-child(5) { animation-delay: .25s; }
        .stat-card:nth-child(6) { animation-delay: .30s; }

        .stat-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .stat-tag {
            font-size: 10px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-badge {
            font-size: 9px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            letter-spacing: .3px;
        }

        .stat-badge.today  { background: var(--success-bg); color: var(--success); }
        .stat-badge.live   { background: var(--brass-light); color: var(--brass-dark); }
        .stat-badge.orange { background: var(--brass-light); color: var(--brass-dark); }

        .stat-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -.5px;
        }

        .stat-label {
            font-size: 11px;
            color: var(--muted);
            margin-top: 6px;
            font-weight: 500;
        }

        /* Ruler-tick progress indicator (replaces plain bar) */
        .stat-bar {
            margin-top: 14px;
            height: 6px;
            display: flex;
            align-items: flex-end;
            gap: 2px;
            background: transparent;
            border-radius: 0;
            overflow: visible;
        }
        .stat-bar-fill {
            height: 100%;
            border-radius: 2px;
            transition: width .9s cubic-bezier(.4,0,.2,1);
        }

        .stat-watermark {
            position: absolute;
            right: 12px;
            bottom: 8px;
            font-size: 34px;
            opacity: .05;
            pointer-events: none;
        }

        /* Colour helpers */
        .c-orange { color: var(--brass); }
        .c-blue   { color: var(--info); }
        .c-green  { color: var(--success); }
        .c-red    { color: var(--danger); }
        .c-yellow { color: var(--warning); }
        .c-muted  { color: var(--muted); }

        .bg-orange { background: var(--brass); }
        .bg-blue   { background: var(--info); }
        .bg-green  { background: var(--success); }
        .bg-red    { background: var(--danger); }
        .bg-yellow { background: var(--warning); }

        /* ==================== STAT ICON (legacy support) ==================== */
        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
        }

        .stat-icon.orange { background: var(--brass-light); color: var(--brass-dark); }
        .stat-icon.green  { background: var(--success-bg);  color: var(--success); }
        .stat-icon.red    { background: var(--danger-bg);   color: var(--danger); }
        .stat-icon.blue   { background: var(--info-bg);     color: var(--info); }
        .stat-icon.yellow { background: var(--warning-bg);  color: var(--warning); }

        /* ==================== BUTTONS ==================== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            transition: filter .18s, transform .15s, background .18s, border-color .18s;
            white-space: nowrap;
        }

        .btn:hover  { filter: brightness(1.06); transform: translateY(-1px); }
        .btn:active { transform: scale(.97); }

        .btn-primary   { background: var(--brass);   color: #fff; }
        .btn-secondary { background: var(--bg);       color: var(--txt); border: 1px solid var(--bdr); }
        .btn-success   { background: var(--success);  color: #fff; }
        .btn-danger    { background: var(--danger);   color: #fff; }
        .btn-warning   { background: var(--warning);  color: #fff; }
        .btn-info      { background: var(--info);     color: #fff; }
        .btn-dark      { background: var(--ink);      color: #fff; }
        .btn-outline   { background: transparent; border: 1px solid var(--bdr); color: var(--txt); }
        .btn-outline:hover { background: var(--bg); }
        .btn-sm  { padding: 5px 11px; font-size: 12px; }
        .btn-lg  { padding: 10px 22px; font-size: 14.5px; }
        .btn i   { font-size: 13px; }

        /* ==================== QUICK ACTIONS ROW ==================== */
        .qa-row {
            display: flex;
            gap: 9px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .qa-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 16px;
            background: var(--surf);
            border: 1px solid var(--bdr);
            border-radius: 8px;
            font-size: 12.5px; font-weight: 600; color: var(--txt);
            text-decoration: none; cursor: pointer;
            transition: all .18s;
        }
        .qa-btn i { color: var(--brass-dark); font-size: 13px; }
        .qa-btn:hover { border-color: var(--brass); background: var(--brass-light); transform: translateY(-1px); }
        .qa-btn.primary { background: var(--ink); color: #fff; border-color: var(--ink); }
        .qa-btn.primary i { color: var(--brass); }
        .qa-btn.primary:hover { background: var(--ink-2); }

        /* ==================== TABLE ==================== */
        .table-wrapper { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }

        thead th {
            background: var(--bg);
            padding: 10px 14px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
            border-bottom: 1px solid var(--bdr);
        }

        tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--bdr);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr {
            transition: background .15s;
            animation: slideInRow .35s ease both;
        }

        tbody tr:hover { background: var(--brass-light); }

        tbody tr:nth-child(1) { animation-delay: .00s; }
        tbody tr:nth-child(2) { animation-delay: .04s; }
        tbody tr:nth-child(3) { animation-delay: .08s; }
        tbody tr:nth-child(4) { animation-delay: .12s; }
        tbody tr:nth-child(5) { animation-delay: .16s; }
        tbody tr:nth-child(6) { animation-delay: .20s; }
        tbody tr:nth-child(7) { animation-delay: .24s; }
        tbody tr:nth-child(8) { animation-delay: .28s; }

        .mono-cell { font-family: 'JetBrains Mono', monospace; font-weight: 600; }

        /* ==================== FORMS ==================== */
        .form-group { margin-bottom: 18px; }

        label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 6px;
        }

        input, select, textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--bdr);
            border-radius: 8px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--txt);
            background: var(--surf);
            transition: border-color .2s, box-shadow .2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--brass);
            box-shadow: 0 0 0 3px rgba(210,84,12,.12);
        }

        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .form-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }

        /* ==================== BADGES ====================
           Trade/category chips keep distinct hues for fast scanning;
           status chips (success/danger/warning/info) follow the theme tokens. */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .badge-welder    { background: var(--brass-light); color: var(--brass-dark); }
        .badge-fitter    { background: #EAE3F2; color: #5B4B8A; }
        .badge-helper    { background: var(--success-bg);  color: var(--success); }
        .badge-rigger    { background: #F3E4E0; color: #8A3F2A; }
        .badge-assistant { background: var(--info-bg);     color: var(--info); }
        .badge-success   { background: var(--success-bg);  color: var(--success); }
        .badge-danger    { background: var(--danger-bg);   color: var(--danger); }
        .badge-warning   { background: var(--warning-bg);  color: var(--warning); }
        .badge-info      { background: var(--info-bg);     color: var(--info); }
        .badge-orange    { background: var(--brass-light); color: var(--brass-dark); }
        .badge-gray      { background: var(--bg);          color: var(--muted); }

        /* ==================== ALERTS ==================== */
        .alert {
            padding: 12px 16px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success { background: var(--success-bg); color: var(--success); border: 1px solid #BEDDC4; }
        .alert-danger  { background: var(--danger-bg);  color: var(--danger);  border: 1px solid #F0C5BB; }
        .alert-info    { background: var(--info-bg);    color: var(--info);    border: 1px solid #BFD8E5; }
        .alert-warning { background: var(--warning-bg); color: var(--warning); border: 1px solid #E8CFA0; }

        /* ==================== MISC UTILS ==================== */
        .d-flex       { display: flex; }
        .align-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2  { gap: 8px; }
        .gap-3  { gap: 12px; }
        .mt-1   { margin-top: 4px; }
        .mt-2   { margin-top: 8px; }
        .mt-3   { margin-top: 12px; }
        .mt-4   { margin-top: 16px; }
        .mb-2   { margin-bottom: 8px; }
        .mb-4   { margin-bottom: 16px; }
        .fw-700 { font-weight: 700; }
        .fw-600 { font-weight: 600; }
        .text-right  { text-align: right; }
        .text-center { text-align: center; }
        .text-muted  { color: var(--muted); }
        .text-sm     { font-size: 12px; }
        .divider     { border: none; border-top: 1px solid var(--bdr); margin: 20px 0; }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 42px;
            opacity: .2;
            margin-bottom: 12px;
            display: block;
            color: var(--brass);
        }

        /* ==================== CATEGORY BAR ROWS ==================== */
        .cat-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 9px;
        }

        .cat-name {
            font-size: 12.5px;
            font-weight: 500;
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cat-count {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            font-weight: 700;
            min-width: 20px;
            text-align: right;
        }

        .cat-track {
            flex: 2;
            height: 4px;
            background: var(--bdr);
            border-radius: 2px;
            overflow: hidden;
        }

        .cat-fill {
            height: 100%;
            border-radius: 2px;
            transition: width .9s cubic-bezier(.4,0,.2,1);
        }

        /* ==================== SELECT2 OVERRIDES ==================== */
        .select2-container { width: 100% !important; }

        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid var(--bdr) !important;
            border-radius: 8px !important;
            background: var(--surf) !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 14px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
            color: var(--txt) !important;
            padding-left: 0 !important;
            font-size: 13.5px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            right: 10px !important;
        }

        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--brass) !important;
            box-shadow: 0 0 0 3px rgba(210,84,12,.12) !important;
        }

        .select2-dropdown {
            overflow: hidden !important;
            border-radius: 8px !important;
            border: 1px solid var(--brass) !important;
        }

        .select2-search--dropdown { padding: 8px !important; }

        .select2-search__field {
            border: 1px solid var(--bdr) !important;
            border-radius: 7px !important;
            padding: 7px 10px !important;
            outline: none !important;
        }

        .select2-search__field:focus { border-color: var(--brass) !important; }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: var(--brass) !important;
            color: #fff !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background: var(--brass-light) !important;
            color: var(--brass-dark) !important;
        }

        /* Blue theme for staff form selects (kept distinct on purpose) */
        .select2-blue .select2-container .select2-selection--single {
            border-color: var(--info) !important;
            background: var(--info-bg) !important;
        }

        .select2-blue .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1e3a5f !important;
        }

        .select2-blue .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--info) !important;
            box-shadow: 0 0 0 3px rgba(59,110,145,.15) !important;
        }

        .select2-blue .select2-dropdown { border-color: var(--info) !important; }

        .select2-blue .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: var(--info) !important;
        }

        .select2-blue .select2-container--default .select2-results__option[aria-selected=true] {
            background: var(--info-bg) !important;
            color: #1e3a5f !important;
        }

        /* ==================== LIGHT & BRIGHT THEME ==================== */
        body.theme-light {
            --ink:         #FFFFFF;
            --ink-2:       #FFF8F2;
            --bg:          #FBF8F4;
            --bdr:         #EFE2D1;
            --txt:         #241B14;
            --muted:       #8C7A68;
            --brass:       #E8650F;
            --brass-dark:  #C2520B;
            --brass-light: #FFE7D1;
            --brown:       #8A6648;
        }

        body.theme-light .sidebar {
            border-right: 1px solid var(--bdr);
            box-shadow: 1px 0 0 rgba(36,27,20,.03);
            background-image:
                linear-gradient(rgba(36,27,20,.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(36,27,20,.045) 1px, transparent 1px);
        }
        body.theme-light .brand-name { color: var(--txt); }
        body.theme-light .nav-label  { color: rgba(36,27,20,.38); }
        body.theme-light .nav-item   { color: rgba(36,27,20,.62); }
        body.theme-light .nav-item:hover {
            color: var(--txt);
            background: rgba(36,27,20,.05);
        }
        body.theme-light .nav-item.active {
            color: var(--brass-dark);
            background: linear-gradient(90deg, rgba(232,101,15,.16), rgba(232,101,15,.03));
        }
        body.theme-light .nav-logout-btn { color: var(--muted); border-color: var(--bdr); }
        body.theme-light .nav-logout-btn:hover { border-color: var(--danger); color: var(--danger); }
        body.theme-light .sidebar-version { color: rgba(36,27,20,.32); }
        body.theme-light .topbar-avatar,
        body.theme-light .qa-btn.primary {
            background: var(--brass);
            border-color: var(--brass-dark);
            color: #fff;
        }
        body.theme-light .stat-card { border-top-color: var(--brown); }

        /* ==================== ANIMATIONS ==================== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(.95); }
            to   { opacity: 1; transform: scale(1); }
        }

        @keyframes slideInRow {
            from { opacity: 0; transform: translateX(-14px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Smooth global transitions */
        button, a, input, select { transition: all .2s cubic-bezier(.4,0,.2,1); }

        /* ==================== PRINT ==================== */
        @media print {
            @page { size: auto; margin-top: 5mm; margin-bottom: 0; }
            .sidebar, .topbar, .sidebar-toggle, .sidebar-overlay, .no-print { display: none !important; }
            .main { margin-left: 0 !important; }
            .content { padding: 0 !important; }
            body { background: #fff !important; }
        }

        /* ==================== MOBILE ==================== */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.45);
                z-index: 199;
            }
            .sidebar-overlay.open { display: block; }

            .main { margin-left: 0; }
            .sidebar-toggle { display: block; }

            .form-grid-2,
            .form-grid-3,
            .form-grid-4 { grid-template-columns: 1fr; }

            .stats-grid { grid-template-columns: 1fr 1fr; }

            .content { padding: 16px; }

            .theme-toggle .tt-opt span.tt-label { display: none; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ==================== SIDEBAR ==================== --}}
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-row">
            <div class="brand-stamp">
                {{-- <i class="fas fa-drafting-compass"></i> --}}
                 <img src="/images/projects/logo.png" style="width:22px;height:22px;border-radius:50%;object-fit:cover"> 
            </div>
            <div>
                <div class="brand-name">AwadhBuildmate</div>
                <div class="brand-sub">Made For Quality &amp; Trust</div>
            </div>
        </div>
    </div>

    <div class="nav-section">

        <div class="nav-label">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <div class="nav-label" style="margin-top:6px">Staff &amp; Labour</div>
        <a href="{{ route('labours.index') }}" class="nav-item {{ request()->routeIs('labours.*') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-users"></i> Labour Registry
        </a>
        <a href="{{ route('staff.index') }}" class="nav-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-user-tie"></i> Staff Registry
        </a>
        <a href="{{ route('attendance.index') }}" class="nav-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-calendar-check"></i> Daily Attendance
        </a>
        <a href="{{ route('attendance.monthly') }}" class="nav-item {{ request()->routeIs('attendance.monthly') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-calendar-alt"></i> Monthly Report
        </a>

        <div class="nav-label" style="margin-top:6px">Finance</div>
        <a href="{{ route('salarydashboard') }}" class="nav-item {{ request()->routeIs('salarydashboard') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-file-invoice-dollar"></i> Salary Slips
        </a>
        <a href="{{ route('salary.bankstatement') }}" class="nav-item {{ request()->routeIs('salary.bankstatement') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-building-columns"></i> Bank Statement
        </a>
        <a href="{{ route('salary.wages-sheet') }}" class="nav-item {{ request()->routeIs('salary.wages-sheet') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-table-list"></i> Wages Sheet
        </a>

        <div class="nav-label" style="margin-top:6px">Site Management</div>
        <a href="{{ route('sites.index') }}" class="nav-item {{ request()->routeIs('sites.*') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-map-pin"></i> Site
        </a>

        <div class="nav-label" style="margin-top:6px">Documents</div>
        <a href="{{ route('invoice.index') }}" class="nav-item {{ request()->routeIs('invoice.*') ? 'active' : '' }}">
            <span class="tick"></span><i class="fas fa-file-invoice"></i> Generate Invoice
        </a>

        <div class="nav-label" style="margin-top:6px">Enquiry</div>
        <a href="{{ route('admin.enquiries') }}" class="nav-item {{ request()->routeIs('enquiries.*') ? 'active' : '' }}">
            <span class="tick"></span><i class="fa fa-envelope"></i> Enquiries
        </a>

    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-logout-btn">
                <i class="fas fa-right-from-bracket"></i> Log out
            </button>
        </form>
        <div class="sidebar-version">Construction Site v1.0</div>
    </div>
</nav>

{{-- Overlay for mobile --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

{{-- ==================== MAIN ==================== --}}
<div class="main">

    {{-- TOPBAR --}}
    <div class="topbar">
        <div class="topbar-left">
            <button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <div class="topbar-eyebrow">Overview</div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            </div>
        </div>
        <div class="topbar-actions">
            <div class="theme-toggle" id="themeToggle" onclick="toggleTheme()">
                <span class="tt-opt" id="ttDark"><i class="fas fa-moon"></i><span class="tt-label">Espresso</span></span>
                <span class="tt-opt" id="ttLight"><i class="fas fa-sun"></i><span class="tt-label">Light</span></span>
            </div>
            <span class="topbar-date">
                <i class="fas fa-calendar"></i>
                {{ \Carbon\Carbon::now()->format('d M Y') }}
            </span>
            <div class="topbar-avatar">AB</div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">

        {{-- Flash messages --}}
        @if(session('success'))
            <div id="flash-success" class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div id="flash-info" class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                {{ session('info') }}
            </div>
        @endif

        @if(session('warning'))
            <div id="flash-warning" class="alert alert-warning">
                <i class="fas fa-triangle-exclamation"></i>
                {{ session('warning') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="list-style:none;margin:0;padding:0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </div>
</div>

{{-- ==================== SCRIPTS ==================== --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    /* ---------- Sidebar toggle (mobile) ---------- */
    function toggleSidebar() {
        const sb  = document.getElementById('sidebar');
        const ov  = document.getElementById('sidebar-overlay');
        sb.classList.toggle('open');
        ov.classList.toggle('open');
    }

    /* ---------- Theme toggle (Espresso / Light & Bright) ---------- */
    function setTheme(light) {
        document.body.classList.toggle('theme-light', light);
        document.getElementById('ttDark').classList.toggle('is-on', !light);
        document.getElementById('ttLight').classList.toggle('is-on', light);
        localStorage.setItem('abm-theme', light ? 'light' : 'dark');
    }

    function toggleTheme() {
        setTheme(!document.body.classList.contains('theme-light'));
    }

    (function initTheme() {
        const saved = localStorage.getItem('abm-theme');
        setTheme(saved === 'light');
    })();

    /* ---------- Auto-dismiss flash alerts ---------- */
    document.addEventListener('DOMContentLoaded', function () {
        ['flash-success', 'flash-info', 'flash-warning'].forEach(function (id) {
            const el = document.getElementById(id);
            if (!el) return;
            setTimeout(function () {
                el.style.transition = 'opacity .5s ease, transform .5s ease';
                el.style.opacity    = '0';
                el.style.transform  = 'translateY(-8px)';
                setTimeout(function () { el.remove(); }, 500);
            }, 3500);
        });
    });
</script>

@stack('scripts')

</body>
</html>