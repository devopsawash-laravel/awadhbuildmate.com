@extends('layouts.app')

@section('title', 'Payroll Management')

@section('page-title', 'Payroll Management')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400;500;600;700;800&family=Barlow:wght@300;400;500;600&display=swap');

    .pr-root {
        --orange:      #D95C2B;
        --orange-soft: #FEF0E8;
        --orange-text: #A3400F;
        --blue:        #0D2461;
        --blue-mid:    #1E40AF;
        --blue-soft:   #EBF0FD;
        --blue-text:   #0F2D8C;
        --ink:         #0F172A;
        --muted:       #64748B;
        --border:      #E2E8F0;
        --surface:     #F8FAFC;
        --white:       #ffffff;

        font-family: 'Barlow', sans-serif;
        font-weight: 400;
        color: var(--ink);
    }

    /* ─── Page header ─── */
    .pr-header {
        padding: 36px 0 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 40px;
    }

    .pr-eyebrow {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .pr-heading {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: clamp(26px, 3.5vw, 34px);
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
        letter-spacing: 0.01em;
        text-transform: uppercase;
    }

    .pr-heading span {
        color: var(--blue-mid);
    }

    .pr-header-badge {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.06em;
        color: var(--muted);
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 7px 14px;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .pr-header-badge i {
        color: var(--blue-mid);
        font-size: 11px;
    }

    /* ─── Grid ─── */
    .pr-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
        gap: 20px;
        max-width: 980px;
    }

    /* ─── Card ─── */
    .pr-card {
        position: relative;
        background: var(--white);
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border);
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
    }

    .pr-card:hover {
        transform: translateY(-4px);
    }

    .pr-card--labour:hover {
        border-color: #FBBFA0;
        box-shadow: 0 12px 36px rgba(217, 92, 43, 0.12);
    }

    .pr-card--staff:hover {
        border-color: #93B4F0;
        box-shadow: 0 12px 36px rgba(13, 36, 97, 0.12);
    }

    /* ─── Left accent bar ─── */
    .pr-card-accent {
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .pr-card--labour .pr-card-accent { background: var(--orange); }
    .pr-card--staff  .pr-card-accent { background: var(--blue); }

    /* ─── Card body ─── */
    .pr-card-body {
        padding: 28px 28px 20px 36px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* ─── Icon ─── */
    .pr-icon-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .pr-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .pr-card--labour .pr-icon-wrap { background: var(--orange-soft); color: var(--orange); }
    .pr-card--staff  .pr-icon-wrap { background: var(--blue-soft);   color: var(--blue);   }

    .pr-module-tag {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        padding: 3px 9px;
        border-radius: 4px;
    }

    .pr-card--labour .pr-module-tag { background: var(--orange-soft); color: var(--orange-text); }
    .pr-card--staff  .pr-module-tag { background: var(--blue-soft);   color: var(--blue-text);   }

    /* ─── Title & desc ─── */
    .pr-card-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        color: var(--ink);
        margin-bottom: 10px;
        line-height: 1;
    }

    .pr-card-desc {
        font-family: 'Barlow', sans-serif;
        font-size: 13.5px;
        font-weight: 400;
        line-height: 1.75;
        color: var(--muted);
        flex: 1;
    }

    /* ─── Pills ─── */
    .pr-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 18px;
    }

    .pr-pill {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border-radius: 4px;
        padding: 3px 9px;
    }

    .pr-card--labour .pr-pill { background: var(--orange-soft); color: var(--orange-text); }
    .pr-card--staff  .pr-pill { background: var(--blue-soft);   color: var(--blue-text);   }

    /* ─── Footer ─── */
    .pr-card-footer {
        margin: 0 28px 0 36px;
        padding: 14px 0;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pr-cta-text {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--muted);
    }

    .pr-cta-btn {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        height: 32px;
        padding: 0 14px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 7px;
        transition: gap 0.18s ease;
    }

    .pr-card:hover .pr-cta-btn { gap: 11px; }

    .pr-card--labour .pr-cta-btn { background: var(--orange); color: var(--white); }
    .pr-card--staff  .pr-cta-btn { background: var(--blue);   color: var(--white); }

    /* ─── Stats strip ─── */
    .pr-stats {
        display: flex;
        max-width: 980px;
        margin-top: 24px;
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        background: var(--surface);
    }

    .pr-stat {
        flex: 1;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-right: 1px solid var(--border);
    }

    .pr-stat:last-child { border-right: none; }

    .pr-stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }

    .pr-stat:nth-child(1) .pr-stat-icon { background: var(--orange-soft); color: var(--orange); }
    .pr-stat:nth-child(2) .pr-stat-icon { background: var(--blue-soft);   color: var(--blue);   }
    .pr-stat:nth-child(3) .pr-stat-icon { background: #ECFDF5; color: #059669; }

    .pr-stat-val {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        color: var(--ink);
        line-height: 1;
        margin-bottom: 2px;
    }

    .pr-stat-lbl {
        font-family: 'Barlow', sans-serif;
        font-size: 11.5px;
        color: var(--muted);
        font-weight: 400;
    }

    /* ─── Responsive ─── */
    @media (max-width: 640px) {
        .pr-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .pr-grid   { grid-template-columns: 1fr; }
        .pr-stats  { flex-direction: column; }
        .pr-stat   { border-right: none; border-bottom: 1px solid var(--border); }
        .pr-stat:last-child { border-bottom: none; }
        .pr-card-body   { padding: 22px 22px 16px 30px; }
        .pr-card-footer { margin: 0 22px 0 30px; }
    }
</style>

<div class="pr-root">

    {{-- Header --}}
    <div class="pr-header">
        <div>
            <div class="pr-eyebrow">Finance &amp; Operations</div>
            <h1 class="pr-heading">Payroll <span>Management</span></h1>
        </div>
        <div class="pr-header-badge">
            <i class="fas fa-calendar-alt"></i>
            {{ \Carbon\Carbon::now()->format('F Y') }}
        </div>
    </div>

    {{-- Cards --}}
    <div class="pr-grid">

        {{-- Labour Payroll --}}
        <a href="{{ route('salary.index') }}" class="pr-card pr-card--labour">
            <div class="pr-card-accent"></div>
            <div class="pr-card-body">
                <div class="pr-icon-row">
                    <div class="pr-icon-wrap"><i class="fas fa-hard-hat"></i></div>
                    <span class="pr-module-tag">Labour Module</span>
                </div>
                <div class="pr-card-title">Labour Payroll</div>
                <div class="pr-card-desc">
                    Attendance-based salary generation with overtime calculations,
                    advance tracking, and deduction management for your labour workforce.
                </div>
                <div class="pr-pills">
                    <span class="pr-pill">Attendance</span>
                    <span class="pr-pill">Overtime</span>
                    <span class="pr-pill">Advances</span>
                    <span class="pr-pill">Payslips</span>
                    <span class="pr-pill">Deductions</span>
                </div>
            </div>
            <div class="pr-card-footer">
                <span class="pr-cta-text">Open Labour Module</span>
                <span class="pr-cta-btn">Open <i class="fas fa-arrow-right"></i></span>
            </div>
        </a>

        {{-- Staff Payroll --}}
        <a href="{{ route('salary.staff-salary.index') }}" class="pr-card pr-card--staff">
            <div class="pr-card-accent"></div>
            <div class="pr-card-body">
                <div class="pr-icon-row">
                    <div class="pr-icon-wrap"><i class="fas fa-user-tie"></i></div>
                    <span class="pr-module-tag">Staff Module</span>
                </div>
                <div class="pr-card-title">Staff Payroll</div>
                <div class="pr-card-desc">
                    Fixed salary structures with allowances, statutory deductions,
                    payroll reports and printable salary slips for permanent staff.
                </div>
                <div class="pr-pills">
                    <span class="pr-pill">Fixed Salary</span>
                    <span class="pr-pill">Allowances</span>
                    <span class="pr-pill">Deductions</span>
                    <span class="pr-pill">Reports</span>
                    <span class="pr-pill">Payslips</span>
                </div>
            </div>
            <div class="pr-card-footer">
                <span class="pr-cta-text">Open Staff Module</span>
                <span class="pr-cta-btn">Open <i class="fas fa-arrow-right"></i></span>
            </div>
        </a>

    </div>

    {{-- Stats strip --}}
    <div class="pr-stats">
        <div class="pr-stat">
            <div class="pr-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="pr-stat-val">2 Modules</div>
                <div class="pr-stat-lbl">Active payroll modules</div>
            </div>
        </div>
        <div class="pr-stat">
            <div class="pr-stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <div>
                <div class="pr-stat-val">Centralised</div>
                <div class="pr-stat-lbl">Single payroll hub</div>
            </div>
        </div>
        <div class="pr-stat">
            <div class="pr-stat-icon"><i class="fas fa-shield-alt"></i></div>
            <div>
                <div class="pr-stat-val">Compliant</div>
                <div class="pr-stat-lbl">Statutory deductions</div>
            </div>
        </div>
    </div>

</div>

@endsection