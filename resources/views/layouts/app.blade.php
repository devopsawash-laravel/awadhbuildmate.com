<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AwadhBuildmate') — Construction ERP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* ==================== RESET & TOKENS ==================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --pr:        #E8500A;
            --pr-dk:     #C2400A;
            --pr-lt:     #FFF0EA;
            --sec:       #1A1A2E;
            --sec-light: rgba(255,255,255,.06);
            --bg:        #F2F4F7;
            --surf:      #FFFFFF;
            --bdr:       #E2E5EA;
            --txt:       #1A1A2E;
            --muted:     #6B7280;
            --success:   #10B981;
            --danger:    #EF4444;
            --warning:   #F59E0B;
            --info:      #3B82F6;
            --sidebar-w: 230px;
            --topbar-h:  56px;
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
        }

        /* ==================== SIDEBAR ==================== */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sec);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            top: 0; left: 0;
            z-index: 200;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
        }

        .sidebar-brand {
            padding: 18px 16px 16px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: var(--pr);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .brand-icon i { color: #fff; font-size: 15px; }

        .brand-name {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .2px;
            line-height: 1.2;
        }

        .brand-sub {
            font-size: 9px;
            color: rgba(255,255,255,.3);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Nav scroll area */
        .nav-section {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0 8px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .nav-section::-webkit-scrollbar { display: none; }

        .nav-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,.25);
            padding: 10px 16px 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 16px;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-left: 2px solid transparent;
            position: relative;
            transition: color .2s, background .2s, border-color .2s, padding-left .2s;
        }

        .nav-item:hover {
            color: rgba(255,255,255,.9);
            background: rgba(255,255,255,.05);
        }

        .nav-item.active {
            color: var(--pr);
            background: rgba(232,80,10,.13);
            border-left-color: var(--pr);
        }

        .nav-item i {
            width: 16px;
            text-align: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 12px 16px;
            border-top: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }

        .nav-logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            background: rgba(239,68,68,.1);
            color: #f87171;
            border: 1px solid rgba(239,68,68,.18);
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background .2s, border-color .2s, color .2s;
            letter-spacing: .2px;
        }

        .nav-logout-btn i { font-size: 13px; width: 14px; text-align: center; }

        .nav-logout-btn:hover {
            background: rgba(239,68,68,.2);
            color: #fca5a5;
            border-color: rgba(239,68,68,.35);
        }

        .sidebar-version {
            font-size: 10px;
            color: rgba(255,255,255,.2);
            margin-top: 10px;
            text-align: center;
            letter-spacing: .5px;
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
            padding: 0 24px;
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
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

        .topbar-title {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -.1px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-date {
            font-size: 12.5px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .topbar-date i { font-size: 13px; }

        .topbar-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--pr);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        /* ==================== CONTENT WRAPPER ==================== */
        .content {
            padding: 24px;
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
            font-size: 24px;
            font-weight: 700;
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
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
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
        }

        .card-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--bdr);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            font-size: 14px;
        }

        .card-header i { color: var(--pr); margin-right: 6px; }

        .card-body { padding: 18px; }

        /* ==================== STAT CARDS ==================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(185px, 1fr));
            gap: 12px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: var(--surf);
            border: 1px solid var(--bdr);
            border-radius: var(--radius-lg);
            padding: 16px 18px;
            position: relative;
            overflow: hidden;
            cursor: default;
            transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
            animation: scaleIn .4s cubic-bezier(.4,0,.2,1) both;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--pr);
            box-shadow: 0 4px 16px rgba(232,80,10,.1);
        }

        .stat-card:nth-child(1) { animation-delay: .05s; }
        .stat-card:nth-child(2) { animation-delay: .10s; }
        .stat-card:nth-child(3) { animation-delay: .15s; }
        .stat-card:nth-child(4) { animation-delay: .20s; }
        .stat-card:nth-child(5) { animation-delay: .25s; }
        .stat-card:nth-child(6) { animation-delay: .30s; }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .stat-tag {
            font-size: 10px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .stat-badge {
            font-size: 9px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            letter-spacing: .3px;
        }

        .stat-badge.today  { background: #ECFDF5; color: #065F46; }
        .stat-badge.live   { background: #FFF0EA; color: #C2400A; }
        .stat-badge.orange { background: #FFF0EA; color: #C2400A; }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -.5px;
        }

        .stat-label {
            font-size: 11px;
            color: var(--muted);
            margin-top: 4px;
            font-weight: 500;
        }

        .stat-bar {
            height: 3px;
            border-radius: 2px;
            margin-top: 12px;
            background: var(--bdr);
            overflow: hidden;
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
            opacity: .06;
            pointer-events: none;
        }

        /* Colour helpers */
        .c-orange { color: var(--pr); }
        .c-blue   { color: var(--info); }
        .c-green  { color: var(--success); }
        .c-red    { color: var(--danger); }
        .c-yellow { color: var(--warning); }
        .c-muted  { color: var(--muted); }

        .bg-orange { background: var(--pr); }
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

        .stat-icon.orange { background: #FFF0EA; color: var(--pr); }
        .stat-icon.green  { background: #ECFDF5; color: var(--success); }
        .stat-icon.red    { background: #FEF2F2; color: var(--danger); }
        .stat-icon.blue   { background: #EFF6FF; color: var(--info); }
        .stat-icon.yellow { background: #FFFBEB; color: var(--warning); }

        /* ==================== BUTTONS ==================== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            transition: filter .18s, transform .15s, background .18s;
            white-space: nowrap;
        }

        .btn:hover  { filter: brightness(1.08); }
        .btn:active { transform: scale(.97); }

        .btn-primary   { background: var(--pr);      color: #fff; }
        .btn-secondary { background: #F3F4F6;         color: var(--txt); border: 1px solid var(--bdr); }
        .btn-success   { background: var(--success);  color: #fff; }
        .btn-danger    { background: var(--danger);   color: #fff; }
        .btn-warning   { background: var(--warning);  color: #fff; }
        .btn-info      { background: var(--info);     color: #fff; }
        .btn-dark      { background: var(--sec);      color: #fff; }
        .btn-outline   { background: transparent; border: 1px solid var(--bdr); color: var(--txt); }
        .btn-outline:hover { background: var(--bg); }
        .btn-sm  { padding: 5px 11px; font-size: 12px; }
        .btn-lg  { padding: 10px 22px; font-size: 14.5px; }
        .btn i   { font-size: 13px; }

        /* ==================== QUICK ACTIONS ROW ==================== */
        .qa-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        /* ==================== TABLE ==================== */
        .table-wrapper { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }

        thead th {
            background: #F8F9FA;
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

        tbody tr:hover { background: #FAFBFC; }

        tbody tr:nth-child(1) { animation-delay: .00s; }
        tbody tr:nth-child(2) { animation-delay: .04s; }
        tbody tr:nth-child(3) { animation-delay: .08s; }
        tbody tr:nth-child(4) { animation-delay: .12s; }
        tbody tr:nth-child(5) { animation-delay: .16s; }
        tbody tr:nth-child(6) { animation-delay: .20s; }
        tbody tr:nth-child(7) { animation-delay: .24s; }
        tbody tr:nth-child(8) { animation-delay: .28s; }

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
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--pr);
            box-shadow: 0 0 0 3px rgba(232,80,10,.1);
        }

        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .form-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }

        /* ==================== BADGES ==================== */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .badge-welder    { background: #FFF0EA; color: #C2400A; }
        .badge-fitter    { background: #EFF6FF; color: #1D4ED8; }
        .badge-helper    { background: #ECFDF5; color: #065F46; }
        .badge-rigger    { background: #FDF4FF; color: #7E22CE; }
        .badge-assistant { background: #EFF6FF; color: #1E40AF; }
        .badge-success   { background: #ECFDF5; color: #065F46; }
        .badge-danger    { background: #FEF2F2; color: #991B1B; }
        .badge-warning   { background: #FFFBEB; color: #92400E; }
        .badge-info      { background: #EFF6FF; color: #1E40AF; }
        .badge-orange    { background: #FFF0EA; color: #C2400A; }
        .badge-gray      { background: #F3F4F6; color: #374151; }

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

        .alert-success { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
        .alert-danger  { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
        .alert-info    { background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; }
        .alert-warning { background: #FFFBEB; color: #92400E; border: 1px solid #FDE68A; }

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
            opacity: .25;
            margin-bottom: 12px;
            display: block;
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
            background: #fff !important;
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
            border-color: var(--pr) !important;
            box-shadow: 0 0 0 3px rgba(232,80,10,.1) !important;
        }

        .select2-dropdown {
            overflow: hidden !important;
            border-radius: 8px !important;
            border: 1px solid var(--pr) !important;
        }

        .select2-search--dropdown { padding: 8px !important; }

        .select2-search__field {
            border: 1px solid var(--bdr) !important;
            border-radius: 7px !important;
            padding: 7px 10px !important;
            outline: none !important;
        }

        .select2-search__field:focus { border-color: var(--pr) !important; }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: var(--pr) !important;
            color: #fff !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background: #FFF0EA !important;
            color: var(--pr-dk) !important;
        }

        /* Blue theme for staff form selects */
        .select2-blue .select2-container .select2-selection--single {
            border-color: #2563EB !important;
            background: #EFF6FF !important;
        }

        .select2-blue .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1e3a8a !important;
        }

        .select2-blue .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #2563EB !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,.15) !important;
        }

        .select2-blue .select2-dropdown {
            border-color: #2563EB !important;
        }

        .select2-blue .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: #2563EB !important;
        }

        .select2-blue .select2-container--default .select2-results__option[aria-selected=true] {
            background: #DBEAFE !important;
            color: #1e3a8a !important;
        }

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
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

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
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ==================== SIDEBAR ==================== --}}
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-row">
            <div class="brand-icon">
                <i class="fas fa-hard-hat"></i>
                {{-- Or use image: <img src="/images/projects/logo.png" style="width:22px;height:22px;border-radius:4px;object-fit:cover"> --}}
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
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <div class="nav-label" style="margin-top:6px">Staff &amp; Labour</div>
        <a href="{{ route('labours.index') }}" class="nav-item {{ request()->routeIs('labours.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Labour Registry
        </a>
        <a href="{{ route('staff.index') }}" class="nav-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
            <i class="fas fa-user-tie"></i> Staff Registry
        </a>
        <a href="{{ route('attendance.index') }}" class="nav-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Daily Attendance
        </a>
        <a href="{{ route('attendance.monthly') }}" class="nav-item {{ request()->routeIs('attendance.monthly') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Monthly Report
        </a>

        <div class="nav-label" style="margin-top:6px">Finance</div>
        <a href="{{ route('salarydashboard') }}" class="nav-item {{ request()->routeIs('salarydashboard') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i> Salary Slips
        </a>
        <a href="{{ route('salary.bankstatement') }}" class="nav-item {{ request()->routeIs('salary.bankstatement') ? 'active' : '' }}">
            <i class="fas fa-building-columns"></i> Bank Statement
        </a>
        <a href="{{ route('salary.wages-sheet') }}" class="nav-item {{ request()->routeIs('salary.wages-sheet') ? 'active' : '' }}">
            <i class="fas fa-table-list"></i> Wages Sheet
        </a>

        <div class="nav-label" style="margin-top:6px">Site Management</div>
        <a href="{{ route('sites.index') }}" class="nav-item {{ request()->routeIs('sites.*') ? 'active' : '' }}">
            <i class="fas fa-map-pin"></i> Site
        </a>

        <div class="nav-label" style="margin-top:6px">Documents</div>
        <a href="{{ route('invoice.index') }}" class="nav-item {{ request()->routeIs('invoice.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i> Generate Invoice
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
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-actions">
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