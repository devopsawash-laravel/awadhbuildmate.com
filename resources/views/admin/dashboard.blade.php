@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800&family=Barlow:wght@300;400;500;600&display=swap');

    .db-root {
        --orange:       #D95C2B;
        --orange-soft:  #FEF0E8;
        --orange-text:  #A3400F;
        --blue:         #0D2461;
        --blue-mid:     #1E40AF;
        --blue-soft:    #EBF0FD;
        --blue-border:  #C4D4F8;
        --success:      #059669;
        --success-soft: #ECFDF5;
        --danger:       #DC2626;
        --danger-soft:  #FEF2F2;
        --warning:      #D97706;
        --warning-soft: #FFFBEB;
        --ink:          #0F172A;
        --muted:        #64748B;
        --border:       #E2E8F0;
        --border-light: #F1F5F9;
        --surface:      #F8FAFC;
        --white:        #ffffff;
        font-family: 'Barlow', sans-serif;
        color: var(--ink);
    }

    /* ── Header ── */
    .db-header {
        padding: 32px 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 28px;
    }

    .db-eyebrow {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 5px;
    }

    .db-heading {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: clamp(22px, 3vw, 30px);
        font-weight: 700;
        letter-spacing: 0.01em;
        text-transform: uppercase;
        color: var(--ink);
        line-height: 1;
        margin: 0;
    }

    .db-heading span { color: var(--blue-mid); }

    .db-date-badge {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.06em;
        color: var(--muted);
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 7px 14px;
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .db-date-badge i { color: var(--blue-mid); font-size: 11px; }

    /* ── Alert ── */
    .db-alert {
        background: var(--success-soft);
        border: 1px solid #A7F3D0;
        border-left: 4px solid var(--success);
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-family: 'Barlow', sans-serif;
        font-size: 13.5px;
        color: var(--success);
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.5s ease;
    }

    /* ── Quick actions card ── */
    .db-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .db-card--orange { border-top: 3px solid var(--orange); }
    .db-card--blue   { border-top: 3px solid var(--blue-mid); }

    .db-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        gap: 12px;
    }

    .db-card-header-left {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .db-card-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .db-card-icon--orange { background: var(--orange-soft); color: var(--orange); }
    .db-card-icon--blue   { background: var(--blue-soft);   color: var(--blue-mid); }

    .db-card-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--ink);
    }

    .db-card-body { padding: 18px 20px; }

    /* ── Quick action buttons ── */
    .db-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .db-action-btn {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-radius: 7px;
        height: 36px;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: opacity 0.18s, transform 0.15s;
        white-space: nowrap;
    }

    .db-action-btn:hover { opacity: 0.88; transform: translateY(-1px); }

    .db-action-btn--orange  { background: var(--orange);  color: var(--white); }
    .db-action-btn--success { background: var(--success); color: var(--white); }
    .db-action-btn--blue    { background: var(--blue-mid); color: var(--white); }
    .db-action-btn--outline {
        background: var(--white);
        color: var(--muted);
        border: 1px solid var(--border);
    }
    .db-action-btn--outline:hover { border-color: var(--blue-mid); color: var(--blue-mid); }
    .db-action-btn--danger  { background: var(--danger);  color: var(--white); }

    /* ── Stats grid ── */
    .db-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .db-stat-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .db-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }

    .db-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .db-stat-icon--orange  { background: var(--orange-soft);  color: var(--orange); }
    .db-stat-icon--green   { background: var(--success-soft); color: var(--success); }
    .db-stat-icon--red     { background: var(--danger-soft);  color: var(--danger); }
    .db-stat-icon--yellow  { background: var(--warning-soft); color: var(--warning); }
    .db-stat-icon--blue    { background: var(--blue-soft);    color: var(--blue-mid); }

    .db-stat-val {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 26px;
        font-weight: 800;
        line-height: 1;
        color: var(--ink);
        letter-spacing: -0.01em;
    }

    .db-stat-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: 4px;
    }

    /* ── Two-col grid ── */
    .db-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    /* ── Category bars ── */
    .db-bar-row { margin-bottom: 14px; }
    .db-bar-row:last-child { margin-bottom: 0; }

    .db-bar-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.04em;
        color: var(--ink);
    }

    .db-bar-meta span:last-child {
        font-size: 11px;
        color: var(--muted);
        background: var(--border-light);
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 1px 7px;
    }

    .db-bar-track {
        background: var(--border-light);
        border-radius: 99px;
        height: 5px;
        overflow: hidden;
    }

    .db-bar-fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, var(--orange) 0%, #F08050 100%);
        transition: width 1s ease;
    }

    /* ── Table inside card ── */
    .db-table-wrap { overflow-x: auto; }

    .db-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Barlow', sans-serif;
        font-size: 13px;
    }

    .db-table thead tr {
        background: var(--surface);
        border-bottom: 2px solid var(--border);
    }

    .db-table th {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 10px 16px;
        text-align: left;
    }

    .db-table td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }

    .db-table tbody tr:last-child td { border-bottom: none; }
    .db-table tbody tr { transition: background 0.14s; }
    .db-table tbody tr:hover { background: var(--surface); }

    .db-empty {
        text-align: center;
        padding: 36px 20px;
        color: var(--muted);
    }

    .db-empty i {
        font-size: 28px;
        opacity: 0.25;
        display: block;
        margin-bottom: 10px;
        color: var(--blue-mid);
    }

    .db-empty p {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin: 0;
    }

    @media (max-width: 768px) {
        .db-grid-2 { grid-template-columns: 1fr; }
        .db-header  { flex-direction: column; align-items: flex-start; gap: 10px; }
    }
    .db-action-btn--Info {
        background: #3b82f6;
        color: #fff;
    }
</style>

<div class="db-root">

    {{-- Alert --}}
    @if(session('success'))
        <div id="success-alert" class="db-alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const alertBox = document.getElementById('success-alert');
                setTimeout(() => {
                    alertBox.style.transition = 'all 0.5s ease';
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translateY(-10px)';
                    setTimeout(() => alertBox.remove(), 500);
                }, 3000);
            });
        </script>
    @endif

    {{-- ── Header ── --}}
    <div class="db-header">
        <div>
            <div class="db-eyebrow">Admin Panel</div>
            <h1 class="db-heading">Operations <span>Dashboard</span></h1>
        </div>
        <div class="db-date-badge">
            <i class="fas fa-calendar-alt"></i>
            {{ \Carbon\Carbon::now()->format('d M Y') }}
        </div>
    </div>

    {{-- ── Quick Actions ── --}}
    <div class="db-card db-card--orange">
        <div class="db-card-header">
            <div class="db-card-header-left">
                <div class="db-card-icon db-card-icon--orange">
                    <i class="fas fa-bolt"></i>
                </div>
                <span class="db-card-title">Quick Actions</span>
            </div>
        </div>
        <div class="db-card-body">
            <div class="db-actions">
                <a href="{{ route('labours.create') }}" class="db-action-btn db-action-btn--orange">
                    <i class="fas fa-user-plus"></i> Add Labour
                </a>
                <a href="{{ route('staff.create') }}" class="db-action-btn db-action-btn--Info">
                    <i class="fas fa-user-plus"></i> Add Staff
                </a>
                <a href="{{ route('attendance.index') }}" class="db-action-btn db-action-btn--success">
                    <i class="fas fa-calendar-check"></i> Mark Attendance
                </a>
                <a href="{{ route('salary.index') }}" class="db-action-btn db-action-btn--blue">
                    <i class="fas fa-file-invoice-dollar"></i> Salary Slips
                </a>
                <a href="{{ route('attendance.monthly') }}" class="db-action-btn db-action-btn--outline">
                    <i class="fas fa-calendar-alt"></i> Monthly Report
                </a>
                <a href="{{ route('admin.enquiries') }}" class="db-action-btn db-action-btn--outline">
                    <i class="fas fa-envelope"></i> View Enquiries
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="db-action-btn db-action-btn--danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Stats ── --}}
    <div class="db-stats">
        <div class="db-stat-card">
            <div class="db-stat-icon db-stat-icon--orange"><i class="fas fa-hard-hat"></i></div>
            <div>
                <div class="db-stat-val">{{ $totalLabours }}</div>
                <div class="db-stat-label">Active Labours</div>
            </div>
        </div>
        <div class="db-stat-card">
            <div class="db-stat-icon db-stat-icon--orange"><i class="fas fa-hard-hat"></i></div>
            <div>
                <div class="db-stat-val">{{ $totalStaff }}</div>
                <div class="db-stat-label">Active Staff</div>
            </div>
        </div>
        <div class="db-stat-card">
            <div class="db-stat-icon db-stat-icon--green"><i class="fas fa-user-check"></i></div>
            <div>
                <div class="db-stat-val">{{ $presentToday }}</div>
                <div class="db-stat-label">Present Today</div>
            </div>
        </div>
        <div class="db-stat-card">
            <div class="db-stat-icon db-stat-icon--red"><i class="fas fa-user-times"></i></div>
            <div>
                <div class="db-stat-val">{{ $absentToday }}</div>
                <div class="db-stat-label">Absent Today</div>
            </div>
        </div>
        <div class="db-stat-card">
            <div class="db-stat-icon db-stat-icon--yellow"><i class="fas fa-hand-holding-usd"></i></div>
            <div>
                <div class="db-stat-val">₹{{ number_format($pendingAdvances, 0) }}</div>
                <div class="db-stat-label">Pending Advances</div>
            </div>
        </div>
        <div class="db-stat-card">
            <div class="db-stat-icon db-stat-icon--blue"><i class="fas fa-envelope"></i></div>
            <div>
                <div class="db-stat-val">—</div>
                <div class="db-stat-label">New Enquiries</div>
            </div>
        </div>
    </div>

    {{-- ── Two column ── --}}
    <div class="db-grid-2">

        {{-- Labour by Category --}}
        <div class="db-card db-card--orange">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-icon db-card-icon--orange">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="db-card-title">Labour by Category</span>
                </div>
            </div>
            <div class="db-card-body">
                {{-- @foreach(['Welder','IBR Welder,'','Fitter','Helper','Rigger','Assistant'] as $cat) --}}
                    @foreach(['Welder','IBR Welder','Electrician','Fitter','Helper','Rigger','Assistant Fitter','Grinder','Taker Welder','Gas Cutter','Khallasi Helper','Visual Grinder','Structure Fitter'] as $cat)
                    @php $count = $categoryStats[$cat] ?? 0; @endphp
                    <div class="db-bar-row">
                        <div class="db-bar-meta">
                            <span>{{ $cat }}</span>
                            <span>{{ $count }}</span>
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
        <div class="db-card db-card--orange">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-icon db-card-icon--orange">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="db-card-title">Staff by Category</span>
                </div>
            </div>
            <div class="db-card-body">
                {{-- @foreach(['Welder','IBR Welder,'','Fitter','Helper','Rigger','Assistant'] as $cat) --}}
                    @foreach([
    'Site Incharge',
    'QC-Quality',
    'Safety Supervisor',
    'Planning',
    'Execution',
    'Admin',
    'Supervisor'
] as $cat)

    @php
        $count = $staffCategoryStats[$cat] ?? 0;
    @endphp

    <div class="db-bar-row">
        <div class="db-bar-meta">
            <span>{{ $cat }}</span>
            <span>{{ $count }}</span>
        </div>

        <div class="db-bar-track">
            <div class="db-bar-fill"
                 style="width:{{ $totalStaff > 0 ? ($count / $totalStaff) * 100 : 0 }}%">
            </div>
        </div>
    </div>

@endforeach
            </div>
        </div>
        {{-- Recent Enquiries --}}
        <div class="db-card db-card--blue">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-icon db-card-icon--blue">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <span class="db-card-title">Recent Enquiries</span>
                </div>
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
                        {{-- @foreach($recentEnquiries as $enq)
                        <tr>
                            <td>
                                <strong>{{ $enq->name }}</strong><br>
                                <small style="color:var(--muted);font-size:11px;">{{ $enq->company }}</small>
                            </td>
                            <td><span style="font-family:'Barlow Condensed',sans-serif;font-size:11px;background:var(--blue-soft);color:var(--blue-mid);border:1px solid var(--blue-border);border-radius:4px;padding:2px 8px;">{{ Str::limit($enq->service_type, 18) }}</span></td>
                            <td style="font-family:'Barlow Condensed',sans-serif;font-size:12px;color:var(--muted);">{{ $enq->created_at->format('d M') }}</td>
                        </tr>
                        @endforeach --}}
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

@endsection