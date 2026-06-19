@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap');

.db {
    --orange:        #D95C2B;
    --orange-dark:   #B84A1F;
    --orange-soft:   #FFF3EE;
    --orange-mid:    #FDE0D0;
    --orange-text:   #92330A;

    --success:       #059669;
    --success-soft:  #ECFDF5;
    --danger:        #DC2626;
    --danger-soft:   #FEF2F2;
    --warning:       #D97706;
    --warning-soft:  #FFFBEB;
    --info:          #2563EB;
    --info-soft:     #EFF6FF;

    --ink:           #111827;
    --ink-2:         #374151;
    --muted:         #6B7280;
    --muted-light:   #9CA3AF;
    --border:        #E5E7EB;
    --border-light:  #F3F4F6;
    --surface:       #F9FAFB;
    --surface-2:     #F3F4F6;
    --white:         #FFFFFF;

    font-family: 'Inter', sans-serif;
    color: var(--ink);
    background: var(--surface);
    padding: 0 0 48px;
}

/* ── PAGE HERO BANNER ── */
.db-hero {
    background: linear-gradient(135deg, #1C1C1C 0%, #2D1810 50%, #3D2010 100%);
    padding: 28px 32px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}
.db-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D95C2B' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 1;
}
.db-hero::after {
    content: '';
    position: absolute; right: -40px; top: -40px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(217,92,43,0.25) 0%, transparent 70%);
    border-radius: 50%;
}
.db-hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: space-between; gap: 16px;
    flex-wrap: wrap;
}
.db-hero-eyebrow {
    font-size: 10px; font-weight: 700; letter-spacing: 0.2em;
    text-transform: uppercase; color: var(--orange); margin-bottom: 6px;
    display: flex; align-items: center; gap: 7px;
}
.db-hero-eyebrow::before {
    content: ''; width: 16px; height: 2px; background: var(--orange); border-radius: 1px;
}
.db-hero-title {
    font-size: clamp(20px, 2.5vw, 26px); font-weight: 800;
    color: #FFFFFF; letter-spacing: -0.02em; line-height: 1.1;
}
.db-hero-title span { color: var(--orange); }
.db-hero-sub {
    font-size: 12px; color: rgba(255,255,255,0.45); margin-top: 5px; font-weight: 400;
}
.db-date-pill {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 8px; padding: 10px 16px;
    display: flex; align-items: center; gap: 8px;
    font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,0.8);
    white-space: nowrap; backdrop-filter: blur(4px);
}
.db-date-pill i { color: var(--orange); font-size: 12px; }

/* ── SECTION WRAP ── */
.db-section { padding: 0 28px; }

/* ── ALERT ── */
.db-alert {
    background: var(--success-soft); border: 1px solid #A7F3D0;
    border-left: 4px solid var(--success); border-radius: 8px;
    padding: 12px 16px; margin-bottom: 20px; font-size: 13px;
    color: var(--success); display: flex; align-items: center; gap: 10px;
}

/* ── QUICK ACTIONS ── */
.db-actions-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: 12px; margin-bottom: 24px; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.db-actions-header {
    display: flex; align-items: center; gap: 10px;
    padding: 13px 20px; border-bottom: 1px solid var(--border);
    background: var(--surface);
}
.db-actions-header-icon {
    width: 26px; height: 26px; border-radius: 6px;
    background: var(--orange-soft); color: var(--orange);
    display: flex; align-items: center; justify-content: center; font-size: 11px;
}
.db-actions-header-title {
    font-size: 11px; font-weight: 700; letter-spacing: 0.12em;
    text-transform: uppercase; color: var(--muted);
}
.db-actions-body { padding: 16px 20px; display: flex; gap: 8px; flex-wrap: wrap; }

.db-btn {
    display: inline-flex; align-items: center; gap: 7px;
    height: 36px; padding: 0 16px; border-radius: 8px;
    font-size: 12.5px; font-weight: 600; font-family: 'Inter', sans-serif;
    text-decoration: none; border: none; cursor: pointer;
    transition: all 0.15s; white-space: nowrap; letter-spacing: 0.01em;
}
.db-btn:hover { transform: translateY(-1px); }
.db-btn:active { transform: translateY(0); }
.db-btn-orange  { background: var(--orange); color: #fff; box-shadow: 0 2px 8px rgba(217,92,43,0.3); }
.db-btn-orange:hover  { background: var(--orange-dark); }
.db-btn-green   { background: var(--success); color: #fff; box-shadow: 0 2px 8px rgba(5,150,105,0.25); }
.db-btn-green:hover   { background: #047857; }
.db-btn-blue    { background: var(--info); color: #fff; box-shadow: 0 2px 8px rgba(37,99,235,0.25); }
.db-btn-blue:hover    { background: #1D4ED8; }
.db-btn-outline {
    background: var(--white); color: var(--muted);
    border: 1px solid var(--border);
}
.db-btn-outline:hover { border-color: var(--orange); color: var(--orange); background: var(--orange-soft); }
.db-btn-danger  { background: var(--danger); color: #fff; box-shadow: 0 2px 8px rgba(220,38,38,0.25); }
.db-btn-danger:hover  { background: #B91C1C; }

/* ── STATS ── */
.db-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(175px, 1fr));
    gap: 14px; margin-bottom: 24px;
}
.db-stat {
    background: var(--white); border: 1px solid var(--border);
    border-radius: 12px; padding: 18px 16px 16px;
    position: relative; overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: box-shadow 0.2s, transform 0.2s;
}
.db-stat:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); transform: translateY(-2px); }
.db-stat-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px; }
.db-stat-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; font-size: 16px;
}
.db-stat-icon-orange { background: var(--orange-soft);  color: var(--orange); }
.db-stat-icon-green  { background: var(--success-soft); color: var(--success); }
.db-stat-icon-red    { background: var(--danger-soft);  color: var(--danger); }
.db-stat-icon-yellow { background: var(--warning-soft); color: var(--warning); }
.db-stat-icon-blue   { background: var(--info-soft);    color: var(--info); }
.db-stat-badge {
    font-size: 10px; font-weight: 600; padding: 2px 7px; border-radius: 999px;
}
.db-stat-badge-green  { background: var(--success-soft); color: var(--success); }
.db-stat-badge-red    { background: var(--danger-soft);  color: var(--danger); }
.db-stat-badge-muted  { background: var(--surface-2);    color: var(--muted); }
.db-stat-val {
    font-family: 'JetBrains Mono', monospace;
    font-size: 28px; font-weight: 700; color: var(--ink);
    line-height: 1; letter-spacing: -0.02em;
}
.db-stat-label {
    font-size: 11px; font-weight: 600; color: var(--muted-light);
    text-transform: uppercase; letter-spacing: 0.08em; margin-top: 4px;
}
/* accent stripe at bottom */
.db-stat::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0;
    height: 2px; background: var(--border-light);
}
.db-stat.s-orange::after { background: linear-gradient(90deg, var(--orange), transparent); }
.db-stat.s-green::after  { background: linear-gradient(90deg, var(--success), transparent); }
.db-stat.s-red::after    { background: linear-gradient(90deg, var(--danger), transparent); }
.db-stat.s-yellow::after { background: linear-gradient(90deg, var(--warning), transparent); }
.db-stat.s-blue::after   { background: linear-gradient(90deg, var(--info), transparent); }

/* ── TWO-COL GRID ── */
.db-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 20px; margin-bottom: 24px;
}

/* ── CARD ── */
.db-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.db-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 18px; border-bottom: 1px solid var(--border);
    background: var(--surface);
}
.db-card-head-left { display: flex; align-items: center; gap: 9px; }
.db-card-head-icon {
    width: 26px; height: 26px; border-radius: 6px;
    display: flex; align-items: center; justify-content: center; font-size: 11px;
}
.db-card-head-icon-orange { background: var(--orange-soft); color: var(--orange); }
.db-card-head-icon-blue   { background: var(--info-soft);   color: var(--info); }
.db-card-head-title {
    font-size: 11.5px; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--ink-2);
}
.db-card-body { padding: 16px 18px; }

/* ── BAR ROWS ── */
.db-bar { margin-bottom: 13px; }
.db-bar:last-child { margin-bottom: 0; }
.db-bar-meta {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 6px;
}
.db-bar-name {
    font-size: 12.5px; font-weight: 500; color: var(--ink-2);
}
.db-bar-count {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px; font-weight: 600; color: var(--muted);
    background: var(--surface-2); border: 1px solid var(--border);
    border-radius: 4px; padding: 1px 8px; min-width: 28px; text-align: center;
}
.db-bar-track {
    background: var(--border-light); border-radius: 99px; height: 4px; overflow: hidden;
}
.db-bar-fill {
    height: 100%; border-radius: 99px;
    background: linear-gradient(90deg, var(--orange) 0%, #F5956A 100%);
    transition: width 0.9s cubic-bezier(0.4,0,0.2,1);
}
.db-bar-fill-blue {
    background: linear-gradient(90deg, var(--info) 0%, #60A5FA 100%);
}

/* ── TABLE ── */
.db-table-wrap { overflow-x: auto; }
.db-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.db-table thead tr {
    background: var(--surface); border-bottom: 1px solid var(--border);
}
.db-table th {
    font-size: 10px; font-weight: 700; letter-spacing: 0.12em;
    text-transform: uppercase; color: var(--muted-light);
    padding: 10px 16px; text-align: left;
}
.db-table td {
    padding: 12px 16px; border-bottom: 1px solid var(--border-light);
    vertical-align: middle; color: var(--ink-2);
}
.db-table tbody tr:last-child td { border-bottom: none; }
.db-table tbody tr:hover { background: var(--orange-soft); }
.db-empty {
    text-align: center; padding: 40px 20px; color: var(--muted-light);
}
.db-empty i { font-size: 28px; opacity: 0.25; display: block; margin-bottom: 10px; }
.db-empty p { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin: 0; }

/* ── DIVIDER LABEL ── */
.db-section-label {
    font-size: 10px; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--muted-light); margin-bottom: 12px;
    display: flex; align-items: center; gap: 10px;
}
.db-section-label::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
}

@media (max-width: 900px) {
    .db-grid { grid-template-columns: 1fr; }
    .db-hero { padding: 22px 20px; }
    .db-section { padding: 0 16px; }
}
@media (max-width: 600px) {
    .db-stats { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="db">

    {{-- ── HERO BANNER ── --}}
    <div class="db-hero">
        <div class="db-hero-inner">
            <div>
                <div class="db-hero-eyebrow">Admin Panel</div>
                <div class="db-hero-title">Operations <span>Dashboard</span></div>
                <div class="db-hero-sub">Awadh Buildmate · Construction Site v1.0</div>
            </div>
            <div class="db-date-pill">
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::now()->format('d M Y') }}
            </div>
        </div>
    </div>

    <div class="db-section">

        {{-- Alert --}}
        @if(session('success'))
            <div id="db-alert" class="db-alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const el = document.getElementById('db-alert');
                    setTimeout(() => {
                        el.style.transition = 'opacity 0.4s, transform 0.4s';
                        el.style.opacity = '0'; el.style.transform = 'translateY(-6px)';
                        setTimeout(() => el.remove(), 400);
                    }, 3000);
                });
            </script>
        @endif

        {{-- ── QUICK ACTIONS ── --}}
        <div class="db-section-label">Quick Actions</div>
        <div class="db-actions-card">
            <div class="db-actions-body">
                <a href="{{ route('labours.create') }}" class="db-btn db-btn-orange">
                    <i class="fas fa-user-plus"></i> Add Labour
                </a>
                <a href="{{ route('staff.create') }}" class="db-btn db-btn-blue">
                    <i class="fas fa-user-plus"></i> Add Staff
                </a>
                <a href="{{ route('attendance.index') }}" class="db-btn db-btn-green">
                    <i class="fas fa-calendar-check"></i> Mark Attendance
                </a>
                <a href="{{ route('salary.index') }}" class="db-btn db-btn-blue">
                    <i class="fas fa-file-invoice-dollar"></i> Salary Slips
                </a>
                <a href="{{ route('attendance.monthly') }}" class="db-btn db-btn-outline">
                    <i class="fas fa-calendar-alt"></i> Monthly Report
                </a>
                <a href="{{ route('admin.enquiries') }}" class="db-btn db-btn-outline">
                    <i class="fas fa-envelope"></i> Enquiries
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="db-btn db-btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- ── STATS ── --}}
        <div class="db-section-label">Overview</div>
        <div class="db-stats">

            <div class="db-stat s-orange">
                <div class="db-stat-top">
                    <div class="db-stat-icon db-stat-icon-orange"><i class="fas fa-hard-hat"></i></div>
                    <span class="db-stat-badge db-stat-badge-muted">Labour</span>
                </div>
                <div class="db-stat-val">{{ $totalLabours }}</div>
                <div class="db-stat-label">Active Labours</div>
            </div>

            <div class="db-stat s-orange">
                <div class="db-stat-top">
                    <div class="db-stat-icon db-stat-icon-orange"><i class="fas fa-users-cog"></i></div>
                    <span class="db-stat-badge db-stat-badge-muted">Staff</span>
                </div>
                <div class="db-stat-val">{{ $totalStaff }}</div>
                <div class="db-stat-label">Active Staff</div>
            </div>

            <div class="db-stat s-green">
                <div class="db-stat-top">
                    <div class="db-stat-icon db-stat-icon-green"><i class="fas fa-user-check"></i></div>
                    <span class="db-stat-badge db-stat-badge-green">Today</span>
                </div>
                <div class="db-stat-val">{{ $presentToday }}</div>
                <div class="db-stat-label">Present Today</div>
            </div>

            <div class="db-stat s-red">
                <div class="db-stat-top">
                    <div class="db-stat-icon db-stat-icon-red"><i class="fas fa-user-times"></i></div>
                    <span class="db-stat-badge db-stat-badge-red">Today</span>
                </div>
                <div class="db-stat-val">{{ $absentToday }}</div>
                <div class="db-stat-label">Absent Today</div>
            </div>

            <div class="db-stat s-yellow">
                <div class="db-stat-top">
                    <div class="db-stat-icon db-stat-icon-yellow"><i class="fas fa-hand-holding-usd"></i></div>
                    <span class="db-stat-badge db-stat-badge-muted">Finance</span>
                </div>
                <div class="db-stat-val" style="font-size:20px;">₹{{ number_format($pendingAdvances, 0) }}</div>
                <div class="db-stat-label">Pending Advances</div>
            </div>

            <div class="db-stat s-blue">
                <div class="db-stat-top">
                    <div class="db-stat-icon db-stat-icon-blue"><i class="fas fa-envelope"></i></div>
                    <span class="db-stat-badge db-stat-badge-muted">Inbox</span>
                </div>
                <div class="db-stat-val">—</div>
                <div class="db-stat-label">New Enquiries</div>
            </div>

        </div>

        {{-- ── TWO COL ── --}}
        <div class="db-section-label">Workforce Breakdown</div>
        <div class="db-grid">

            {{-- Labour by Category --}}
            <div class="db-card">
                <div class="db-card-head">
                    <div class="db-card-head-left">
                        <div class="db-card-head-icon db-card-head-icon-orange">
                            <i class="fas fa-hard-hat"></i>
                        </div>
                        <span class="db-card-head-title">Labour by Category</span>
                    </div>
                </div>
                <div class="db-card-body">
                    @foreach(['Welder','IBR Welder','Electrician','Fitter','Helper','Rigger','Assistant Fitter','Grinder','Taker Welder','Gas Cutter','Khallasi Helper','Visual Grinder','Structure Fitter'] as $cat)
                        @php $count = $categoryStats[$cat] ?? 0; @endphp
                        <div class="db-bar">
                            <div class="db-bar-meta">
                                <span class="db-bar-name">{{ $cat }}</span>
                                <span class="db-bar-count">{{ $count }}</span>
                            </div>
                            <div class="db-bar-track">
                                <div class="db-bar-fill"
                                     style="width:{{ $totalLabours > 0 ? ($count/$totalLabours)*100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Staff by Category --}}
            <div class="db-card">
                <div class="db-card-head">
                    <div class="db-card-head-left">
                        <div class="db-card-head-icon db-card-head-icon-blue">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <span class="db-card-head-title">Staff by Category</span>
                    </div>
                </div>
                <div class="db-card-body">
                    @foreach(['Site Incharge','QC-Quality','Safety Supervisor','Planning','Execution','Admin','Supervisor'] as $cat)
                        @php $count = $staffCategoryStats[$cat] ?? 0; @endphp
                        <div class="db-bar">
                            <div class="db-bar-meta">
                                <span class="db-bar-name">{{ $cat }}</span>
                                <span class="db-bar-count">{{ $count }}</span>
                            </div>
                            <div class="db-bar-track">
                                <div class="db-bar-fill db-bar-fill-blue"
                                     style="width:{{ $totalStaff > 0 ? ($count/$totalStaff)*100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent Enquiries --}}
            <div class="db-card" style="grid-column: span 2;">
                <div class="db-card-head">
                    <div class="db-card-head-left">
                        <div class="db-card-head-icon db-card-head-icon-blue">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <span class="db-card-head-title">Recent Enquiries</span>
                    </div>
                    <a href="{{ route('admin.enquiries') }}" style="font-size:11.5px;font-weight:600;color:var(--orange);text-decoration:none;">
                        View All <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>
                <div class="db-table-wrap">
                    <table class="db-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Service</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($recentEnquiries as $enq) ... @endforeach --}}
                            <tr>
                                <td colspan="3">
                                    <div class="db-empty">
                                        <i class="fas fa-inbox"></i>
                                        <p>No enquiries yet</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection