<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Awadh Buildmate</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #E8500A;
            --primary-dark: #C2400A;
            --secondary: #111111;
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
            --sidebar-w: 250px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--secondary);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .brand-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20px;
            letter-spacing: 2px;
            color: #fff;
            line-height: 1.1;
        }

        .brand-name span { color: var(--primary); }

        .brand-module {
            font-family: 'Rajdhani', sans-serif;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            margin-top: 3px;
        }

        .sidebar-owner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .owner-avatar {
            width: 32px; height: 32px;
            background: var(--primary);
            clip-path: polygon(0 0, 88% 0, 100% 12%, 100% 100%, 12% 100%, 0 88%);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 14px;
            color: #fff;
            flex-shrink: 0;
        }

        .owner-name { font-size: 13px; font-weight: 500; color: #fff; }
        .owner-role { font-size: 10px; color: rgba(255,255,255,0.35); margin-top: 1px; letter-spacing: 1px; text-transform: uppercase; font-family: 'Rajdhani', sans-serif; }

        .nav-section { padding: 12px 0; flex: 1; overflow-y: auto; }

        .nav-label {
            font-family: 'Rajdhani', sans-serif;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 3px;
            color: rgba(255,255,255,0.2);
            text-transform: uppercase;
            padding: 10px 18px 5px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 18px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover { background: rgba(255,255,255,0.04); color: #fff; }
        .nav-item.active { background: rgba(232,80,10,0.12); color: var(--primary); border-left-color: var(--primary); }
        .nav-item i { width: 16px; text-align: center; font-size: 14px; }

        .sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .btn-website {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            padding: 8px 0;
            transition: color 0.2s;
            margin-bottom: 10px;
        }
        .btn-website:hover { color: #fff; }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(239,68,68,0.6);
            text-decoration: none;
            cursor: pointer;
            background: none;
            border: none;
            padding: 8px 0;
            transition: color 0.2s;
            width: 100%;
            text-align: left;
        }
        .btn-logout:hover { color: #ef4444; }

        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }

        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .content { padding: 24px; flex: 1; }

        /* Cards, Tables, Buttons — reuse from previous project */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; }
        .card-header { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; font-weight: 600; font-size: 14px; }
        .card-body { padding: 18px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 14px; margin-bottom: 22px; }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 18px; display: flex; align-items: center; gap: 14px; }
        .stat-icon { width: 46px; height: 46px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .stat-icon.orange { background: #FFF0EA; color: var(--primary); }
        .stat-icon.green  { background: #ECFDF5; color: var(--success); }
        .stat-icon.red    { background: #FEF2F2; color: var(--danger); }
        .stat-icon.blue   { background: #EFF6FF; color: var(--info); }
        .stat-icon.yellow { background: #FFFBEB; color: var(--warning); }
        .stat-value { font-size: 24px; font-weight: 700; line-height: 1; }
        .stat-label { font-size: 11px; color: var(--text-muted); margin-top: 3px; font-weight: 500; }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead th { background: #F8F9FA; padding: 10px 13px; text-align: left; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); border-bottom: 1px solid var(--border); }
        tbody td { padding: 12px 13px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #FAFBFC; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all 0.18s; font-family: 'DM Sans', sans-serif; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { background: #F3F4F6; color: var(--text); border: 1px solid var(--border); }
        .btn-secondary:hover { background: #E9ECEF; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-warning { background: var(--warning); color: #fff; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-outline:hover { background: var(--bg); }
        .btn-sm { padding: 4px 9px; font-size: 11px; }
        .badge { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; letter-spacing: 0.5px; }
        .badge-welder  { background: #FFF0EA; color: #C2400A; }
        .badge-fitter  { background: #EFF6FF; color: #1D4ED8; }
        .badge-helper  { background: #ECFDF5; color: #065F46; }
        .badge-rigger  { background: #FDF4FF; color: #7E22CE; }
        .badge-success { background: #ECFDF5; color: #065F46; }
        .badge-danger  { background: #FEF2F2; color: #991B1B; }
        .badge-warning { background: #FFFBEB; color: #92400E; }
        .badge-info    { background: #EFF6FF; color: #1E40AF; }
        .alert { padding: 11px 15px; border-radius: 7px; margin-bottom: 18px; font-size: 13px; display: flex; align-items: center; gap: 9px; }
        .alert-success { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
        .alert-danger  { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
        .alert-info    { background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .page-title { font-family: 'Bebas Neue', sans-serif; font-size: 30px; letter-spacing: 1px; }
        .page-subtitle { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 5px; }
        input, select, textarea { width: 100%; padding: 8px 11px; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; font-family: 'DM Sans', sans-serif; color: var(--text); background: #fff; transition: border-color 0.2s; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(232,80,10,0.1); }
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
        .divider { border: none; border-top: 1px solid var(--border); margin: 18px 0; }
        .empty-state { text-align: center; padding: 44px 20px; color: var(--text-muted); }
        .empty-state i { font-size: 36px; opacity: 0.3; margin-bottom: 10px; display: block; }
        .text-muted { color: var(--text-muted); }
        .text-right { text-align: right; }
        .mt-4 { margin-top: 16px; }
        .mb-4 { margin-bottom: 16px; }
        .hidden { display: none !important; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">Awadh <span>Buildmate</span></div>
        <div class="brand-module">Labour Management System</div>
    </div>

    <div class="sidebar-owner">
        <div class="owner-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 2)) }}</div>
        <div>
            <div class="owner-name">{{ Auth::user()->name ?? 'Owner' }}</div>
            <div class="owner-role">Site Administrator</div>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <div class="nav-label" style="margin-top:6px">Labour</div>
        <a href="{{ route('admin.labours.index') }}" class="nav-item {{ request()->routeIs('admin.labours.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Labour Registry
        </a>
        <a href="{{ route('admin.attendance.index') }}" class="nav-item {{ request()->routeIs('admin.attendance.index') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Daily Attendance
        </a>
        <a href="{{ route('admin.attendance.monthly') }}" class="nav-item {{ request()->routeIs('admin.attendance.monthly') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Monthly Report
        </a>

        <div class="nav-label" style="margin-top:6px">Finance</div>
        <a href="{{ route('admin.salary.index') }}" class="nav-item {{ request()->routeIs('admin.salary.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i> Salary Slips
        </a>

        <div class="nav-label" style="margin-top:6px">Business</div>
        <a href="{{ route('admin.enquiries') }}" class="nav-item {{ request()->routeIs('admin.enquiries') ? 'active' : '' }}">
            <i class="fas fa-envelope-open-text"></i> Enquiries
        </a>
    </div>

    <div class="sidebar-footer">
    {{-- Link to public website (opens in new tab) --}}
    <a href="{{ route('home1') }}" class="btn-website" target="_blank">
        <i class="fas fa-external-link-alt"></i> View Website
    </a>
 
    {{-- Logout — posts to admin.logout route --}}
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Sign Out
        </button>
    </form>
    </div>
</nav>

<div class="main">
    <div class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div style="font-size:12px;color:var(--text-muted)">
            <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::now()->format('d M Y, D') }}
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>