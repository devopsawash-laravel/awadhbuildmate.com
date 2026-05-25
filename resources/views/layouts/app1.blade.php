<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ConstructPro') — Labour Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Barlow+Condensed:wght@600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        :root {
            --primary: #E8500A;
            --primary-dark: #C2400A;
            --secondary: #1A1A2E;
            --accent: #F5A623;
            --bg: #F4F5F7;
            --surface: #FFFFFF;
            --border: #E2E5EA;
            --text: #1A1A2E;
            --text-muted: #6B7280;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --info: #3B82F6;
            --sidebar-w: 240px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Barlow', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* =========================
            SIDEBAR
        ========================= */

        .sidebar {
            width: var(--sidebar-w);
            background: var(--secondary);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-logo {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo i {
            font-size: 20px;
        }

        .brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            margin-top: 3px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .nav-section {
            padding: 16px 0;
            flex: 1;
            overflow-y: auto;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            padding: 10px 20px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
        }

        .nav-item.active {
            background: rgba(232,80,10,0.15);
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
            font-size: 12px;
            color: rgba(255,255,255,0.3);
        }

        /* =========================
            MAIN
        ========================= */

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            min-width: 0;
        }

        /* =========================
            TOPBAR
        ========================= */

        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .topbar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* =========================
            TOGGLE BUTTON
        ========================= */

        .menu-toggle {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 8px;
            background: #F3F4F6;
            color: var(--text);
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .menu-toggle:hover {
            background: #E5E7EB;
        }

        /* =========================
            OVERLAY
        ========================= */

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* =========================
            CONTENT
        ========================= */

        .content {
            padding: 28px;
            flex: 1;
            width: 100%;
            overflow-x: hidden;
        }

        /* =========================
            CARDS
        ========================= */

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            font-size: 15px;
        }

        .card-body {
            padding: 20px;
        }

        /* =========================
            STATS
        ========================= */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-icon.orange { background: #FFF0EA; color: var(--primary); }
        .stat-icon.green  { background: #ECFDF5; color: var(--success); }
        .stat-icon.red    { background: #FEF2F2; color: var(--danger); }
        .stat-icon.blue   { background: #EFF6FF; color: var(--info); }
        .stat-icon.yellow { background: #FFFBEB; color: var(--warning); }

        .stat-value {
            font-size: 26px;
            font-weight: 700;
            line-height: 1;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
            font-weight: 500;
        }

        /* =========================
            TABLE
        ========================= */

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 700px;
        }

        thead th {
            background: #F8F9FA;
            padding: 11px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        tbody td {
            padding: 13px 14px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            white-space: nowrap;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #FAFBFC;
        }

        /* =========================
            BUTTONS
        ========================= */

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.18s;
            font-family: 'Barlow', sans-serif;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: #F3F4F6;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: #E9ECEF;
        }

        .btn-success {
            background: var(--success);
            color: #fff;
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-warning {
            background: var(--warning);
            color: #fff;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        /* =========================
            FORMS
        ========================= */

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 7px;
            font-size: 14px;
            font-family: 'Barlow', sans-serif;
            color: var(--text);
            background: #fff;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232,80,10,0.1);
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
        }

        /* =========================
            BADGES
        ========================= */

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: #ECFDF5;
            color: #065F46;
        }

        .badge-danger {
            background: #FEF2F2;
            color: #991B1B;
        }

        .badge-warning {
            background: #FFFBEB;
            color: #92400E;
        }

        .badge-info {
            background: #EFF6FF;
            color: #1E40AF;
        }

        /* =========================
            ALERTS
        ========================= */

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-danger {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .alert-info {
            background: #EFF6FF;
            color: #1E40AF;
            border: 1px solid #BFDBFE;
        }

        /* =========================
            PAGE
        ========================= */

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            gap: 15px;
        }

        .page-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* =========================
            RESPONSIVE
        ========================= */

        @media (max-width: 992px) {

            .menu-toggle {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .content {
                padding: 20px;
            }

            .topbar {
                padding: 0 20px;
            }

        }

        @media (max-width: 768px) {

            .topbar {
                padding: 0 15px;
            }

            .topbar-title {
                font-size: 18px;
            }

            .content {
                padding: 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-title {
                font-size: 22px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-grid-2,
            .form-grid-3 {
                grid-template-columns: 1fr;
            }

            .card-body {
                padding: 15px;
            }

            .card-header {
                padding: 14px 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .topbar-actions small {
                display: none;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

<!-- OVERLAY -->

<div class="overlay" id="overlay"></div>

<!-- SIDEBAR -->

<nav class="sidebar" id="sidebar">

    <div class="sidebar-brand">

        <div class="brand-logo">
            <i class="fas fa-hard-hat"></i>
            ConstructPro
        </div>

        <div class="brand-sub">
            Labour Management
        </div>

    </div>

    <div class="nav-section">

        <div class="nav-label">Main</div>

        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <i class="fas fa-chart-pie"></i>
            Dashboard

        </a>

        <div class="nav-label" style="margin-top:8px;">
            Staff and Labours
        </div>

        <a href="{{ route('labours.index') }}"
           class="nav-item {{ request()->routeIs('labours.*') ? 'active' : '' }}">

            <i class="fas fa-users"></i>
            Labour Registry

        </a>

        <a href="{{ route('staff.create') }}"
           class="nav-item {{ request()->routeIs('Staff.create') ? 'active' : '' }}">

            <i class="fas fa-users"></i>
            Staff Registry

        </a>

        <a href="{{ route('attendance.index') }}"
           class="nav-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}">

            <i class="fas fa-calendar-check"></i>
            Daily Attendance

        </a>

        <a href="{{ route('attendance.monthly') }}"
           class="nav-item {{ request()->routeIs('attendance.monthly') ? 'active' : '' }}">

            <i class="fas fa-calendar-alt"></i>
            Monthly Report

        </a>

        <div class="nav-label" style="margin-top:8px;">
            Finance
        </div>

        <a href="{{ route('salary.index') }}"
           class="nav-item {{ request()->routeIs('salary.index') ? 'active' : '' }}">

            <i class="fas fa-file-invoice-dollar"></i>
            Salary Slips

        </a>

        <div class="nav-label" style="margin-top:8px;">
            Bank Statement
        </div>

        <a href="{{ route('salary.bankstatement') }}"
           class="nav-item {{ request()->routeIs('salary.bankstatement') ? 'active' : '' }}">

            <i class="fas fa-building-columns"></i>
            Bank Statement

        </a>

        <a href="{{ route('salary.wages-sheet') }}"
           class="nav-item {{ request()->routeIs('salary.wages-sheet') ? 'active' : '' }}">

            <i class="fas fa-sheet-plastic"></i>
            Wages Sheet

        </a>

        <div class="nav-label" style="margin-top:8px;">
            Site Management
        </div>

        <a href="{{ route('sites.index') }}"
           class="nav-item {{ request()->routeIs('sites.*') ? 'active' : '' }}">

            <i class="fas fa-building-columns"></i>
            Site

        </a>

    </div>

    <div class="sidebar-footer">
        <i class="fas fa-building"></i>
        &nbsp;Construction Site v1.0
    </div>

</nav>

<!-- MAIN -->

<div class="main">

    <!-- TOPBAR -->

    <div class="topbar">

        <div class="topbar-left">

            <!-- TOGGLE -->

            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>

            <div class="topbar-title">
                @yield('page-title', 'Dashboard')
            </div>

        </div>

        <div class="topbar-actions">

            <span style="font-size:13px;color:var(--text-muted)">
                <i class="fas fa-calendar"></i>
                {{ \Carbon\Carbon::now()->format('d M Y') }}
            </span>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="content">

        @if(session('success'))

            <div id="success-alert" class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>

        @endif

        @if(session('info'))

            <div id="info-alert" class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                {{ session('info') }}
            </div>

        @endif

        @if($errors->any())

            <div class="alert alert-danger">

                <i class="fas fa-exclamation-circle"></i>

                <ul style="list-style:none;margin:0;padding:0">

                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        @yield('content')

    </div>

</div>

<!-- ALERT HIDE -->

<script>

    document.addEventListener('DOMContentLoaded', function () {

        function hideAlert(id) {

            const alertBox = document.getElementById(id);

            if (alertBox) {

                setTimeout(() => {

                    alertBox.style.transition = 'all 0.5s ease';
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translateY(-10px)';

                    setTimeout(() => {

                        alertBox.remove();

                    }, 500);

                }, 3000);

            }

        }

        hideAlert('success-alert');
        hideAlert('info-alert');

    });

</script>

<!-- SIDEBAR TOGGLE -->

<script>

    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuToggle.addEventListener('click', function () {

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');

    });

    overlay.addEventListener('click', function () {

        sidebar.classList.remove('active');
        overlay.classList.remove('active');

    });

</script>

@stack('scripts')

</body>
</html>