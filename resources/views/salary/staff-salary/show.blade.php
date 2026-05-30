@extends('layouts.app')

@section('title', 'Salary Slip')
@section('page-title', 'Salary Slip')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet">

<style>
:root {
    --blue-50:  #E6F1FB;
    --blue-100: #B5D4F4;
    --blue-200: #85B7EB;
    --blue-400: #378ADD;
    --blue-600: #185FA5;
    --blue-800: #0C447C;
    --blue-900: #042C53;
    --gray-50:  #F8FAFC;
    --gray-100: #F1F5F9;
    --gray-200: #E2E8F0;
    --gray-400: #94A3B8;
    --gray-600: #475569;
    --gray-800: #1E293B;
    --green-50:  #EAF3DE;
    --green-100: #C0DD97;
    --green-600: #3B6D11;
    --green-800: #27500A;
    --red-50:   #FCEBEB;
    --red-100:  #F7C1C1;
    --red-600:  #A32D2D;
    --red-800:  #791F1F;
    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 14px;
    --font-ui: 'DM Sans', sans-serif;
    --font-display: 'Sora', sans-serif;
}

* { box-sizing: border-box; }

.slip-wrap {
    font-family: var(--font-ui);
    max-width: 1060px;
    margin: 0 auto;
    background: #fff;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

/* ── Page Header ─────────────────────────────── */
.page-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    padding: 0 2px;
}
.page-header-bar .title-block .main-title {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0;
}
.page-header-bar .title-block .sub-title {
    font-size: 13px;
    color: var(--gray-400);
    margin-top: 3px;
}
.header-actions { display: flex; gap: 10px; }

.btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    font-family: var(--font-ui);
    font-size: 13px;
    font-weight: 500;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: background 0.15s, color 0.15s, border-color 0.15s;
    text-decoration: none;
    border: 1px solid transparent;
}
.btn-primary {
    background: var(--blue-600);
    color: #fff;
    border-color: var(--blue-600);
}
.btn-primary:hover { background: var(--blue-800); border-color: var(--blue-800); }
.btn-outline {
    background: #fff;
    color: var(--gray-600);
    border-color: var(--gray-200);
}
.btn-outline:hover { background: var(--gray-100); color: var(--gray-800); }
.btn-warning {
    background: #fff;
    color: #B45309;
    border-color: #FCD34D;
}
.btn-warning:hover { background: #FFFBEB; }
.btn-success {
    background: var(--green-600);
    color: #fff;
    border-color: var(--green-600);
}
.btn-success:hover { background: var(--green-800); border-color: var(--green-800); }

/* ── Company Header ───────────────────────────── */
.company-header {
    background: var(--blue-900);
    padding: 28px 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.company-header .brand-col {}
.company-header .brand-name {
    font-family: var(--font-display);
    font-size: 26px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 0.5px;
    margin: 0;
}
.company-header .brand-tagline {
    font-size: 12px;
    color: var(--blue-200);
    margin-top: 4px;
    letter-spacing: 0.8px;
    text-transform: uppercase;
}
.company-header .slip-meta {
    text-align: right;
}
.company-header .slip-badge {
    display: inline-block;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.22);
    color: #fff;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 6px 16px;
    border-radius: var(--radius-sm);
    margin-bottom: 8px;
}
.company-header .slip-period {
    font-size: 13px;
    color: var(--blue-100);
}

/* ── Section Wrapper ──────────────────────────── */
.section {
    padding: 26px 36px;
    border-bottom: 1px solid var(--gray-200);
}
.section:last-child { border-bottom: none; }

.section-title {
    font-family: var(--font-display);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 14px;
    border-radius: 3px;
    flex-shrink: 0;
}
.section-title.blue { color: var(--blue-800); }
.section-title.blue::before { background: var(--blue-400); }
.section-title.green { color: var(--green-600); }
.section-title.green::before { background: #639922; }
.section-title.red { color: var(--red-600); }
.section-title.red::before { background: #E24B4A; }

/* ── Employee Grid ────────────────────────────── */
.emp-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px 20px;
}
.emp-field .ef-label {
    font-size: 10px;
    font-weight: 600;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 4px;
}
.emp-field .ef-value {
    font-size: 13px;
    font-weight: 500;
    color: var(--gray-800);
}

/* ── Working Days Stats ───────────────────────── */
.working-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}
.stat-card {
    background: var(--gray-100);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-md);
    padding: 16px 18px;
    text-align: center;
}
.stat-card.accent {
    background: var(--blue-50);
    border-color: var(--blue-100);
}
.stat-card .sc-label {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--gray-400);
    margin-bottom: 6px;
}
.stat-card.accent .sc-label { color: var(--blue-600); }
.stat-card .sc-value {
    font-family: var(--font-display);
    font-size: 26px;
    font-weight: 700;
    color: var(--gray-800);
}
.stat-card.accent .sc-value { color: var(--blue-800); }

/* ── Earnings + Deductions Layout ─────────────── */
.earnings-deductions {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 30px;
    align-items: start;
}

/* ── Tables ────────────────────────────────────── */
.slip-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.slip-table thead tr {
    background: var(--gray-100);
}
.slip-table thead th {
    padding: 10px 14px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--gray-600);
    border: 1px solid var(--gray-200);
}
.slip-table thead th:first-child { text-align: left; }
.slip-table thead th:not(:first-child) { text-align: center; }
.slip-table tbody td {
    padding: 10px 14px;
    border: 1px solid var(--gray-200);
    color: var(--gray-800);
}
.slip-table tbody td:not(:first-child) { text-align: center; }
.slip-table tbody tr:hover { background: var(--gray-50); }

.row-total-green {
    background: var(--green-50) !important;
    font-weight: 600;
}
.row-total-green td { color: var(--green-600) !important; }
.row-total-red {
    background: var(--red-50) !important;
    font-weight: 600;
}
.row-total-red td { color: var(--red-800) !important; }
.row-net {
    background: var(--blue-50) !important;
    font-weight: 700;
}
.row-net td {
    color: var(--blue-800) !important;
    font-size: 14px !important;
}

/* Deduction inputs */
.deduct-input {
    width: 110px;
    padding: 6px 10px;
    font-family: var(--font-ui);
    font-size: 13px;
    color: var(--gray-800);
    background: #fff;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    transition: border-color 0.15s, box-shadow 0.15s;
    outline: none;
}
.deduct-input:focus {
    border-color: var(--blue-400);
    box-shadow: 0 0 0 3px var(--blue-50);
}

/* ── Form Actions ──────────────────────────────── */
.form-actions {
    margin-top: 18px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* ── Net Payable Banner ────────────────────────── */
.net-banner {
    margin: 0 36px 26px;
    background: var(--blue-900);
    border-radius: var(--radius-md);
    padding: 20px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.net-banner .nb-label {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--blue-200);
}
.net-banner .nb-amount {
    font-family: var(--font-display);
    font-size: 30px;
    font-weight: 700;
    color: #fff;
    margin-top: 4px;
}
.net-banner .nb-words {
    font-size: 12px;
    color: var(--blue-200);
    margin-top: 4px;
}
.net-banner .nb-badge {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: var(--radius-sm);
    padding: 8px 18px;
    color: #fff;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ── Print ─────────────────────────────────────── */
@media print {
    .sidebar, .topbar, .page-header-bar, .btn, .form-actions { display: none !important; }
    .main { margin-left: 0 !important; }
    .content { padding: 0 !important; }
    .slip-wrap { border: none !important; border-radius: 0 !important; }
    .deduct-input { border: none !important; background: transparent !important; }
}
</style>

{{-- Page Header --}}
<div class="page-header-bar">
    <div class="title-block">
        <p class="main-title">Salary Slip</p>
        <p class="sub-title">{{ $salary->getMonthName() }} {{ $salary->year }}</p>
    </div>
    <div class="header-actions">
        <button onclick="window.print()" class="btn btn-outline">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="{{ route('staff-salary.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="slip-wrap" id="salary-slip">

    {{-- Company Header --}}
    <div class="company-header">
        <div class="brand-col">
            <p class="brand-name">AWADH BUILDMATE</p>
            <p class="brand-tagline">Made for Quality and Trust</p>
        </div>
        <div class="slip-meta">
            <div class="slip-badge">Salary Slip</div>
            <p class="slip-period">For the Month of {{ $salary->getMonthName() }} {{ $salary->year }}</p>
        </div>
    </div>

    {{-- Employee Details --}}
    <div class="section">
        <div class="section-title blue">Employee Details</div>
        <div class="emp-grid">

            <div class="emp-field">
                <div class="ef-label">Employee Name</div>
                <div class="ef-value">{{ $salary->staff->name ?? 'N/A' }}</div>
            </div>

            <div class="emp-field">
                <div class="ef-label">Employee ID</div>
                <div class="ef-value">{{ $salary->staff->employee_id ?? 'N/A' }}</div>
            </div>

            <div class="emp-field">
                <div class="ef-label">Category</div>
                <div class="ef-value">{{ $salary->staff->category ?? 'N/A' }}</div>
            </div>

            <div class="emp-field">
                <div class="ef-label">Date of Joining</div>
                <div class="ef-value">
                    {{ $salary->staff?->joining_date
                        ? \Carbon\Carbon::parse($salary->staff->joining_date)->format('d M Y')
                        : 'N/A' }}
                </div>
            </div>

            <div class="emp-field">
                <div class="ef-label">Site</div>
                <div class="ef-value">{{ $salary->staff->site->name ?? 'N/A' }}</div>
            </div>

            <div class="emp-field">
                <div class="ef-label">UAN Number</div>
                <div class="ef-value">{{ $salary->staff->UAN ?? '—' }}</div>
            </div>

            <div class="emp-field">
                <div class="ef-label">ESIC Number</div>
                <div class="ef-value">{{ $salary->staff->ESIC_Number ?? '—' }}</div>
            </div>

            <div class="emp-field">
                <div class="ef-label">Bank Name</div>
                <div class="ef-value">{{ $salary->staff->bank->name ?? '—' }}</div>
            </div>

            <div class="emp-field">
                <div class="ef-label">Bank A/C No.</div>
                <div class="ef-value">{{ $salary->staff->Account_Number ?? '—' }}</div>
            </div>

            <div class="emp-field">
                <div class="ef-label">IFSC Code</div>
                <div class="ef-value">{{ $salary->staff->IFSC ?? '—' }}</div>
            </div>

        </div>
    </div>

    {{-- Working Details --}}
    @php
        $presentDays = $salary->paid_days ?? 0;
        $weekOff     = $salary->week_off ?? 0;
        $paidDays    = $presentDays + $weekOff;
        $totalDays   = $salary->working_days ?? 0;
    @endphp

    <div class="section">
        <div class="section-title blue">Working Details</div>
        <div class="working-stats">

            <div class="stat-card">
                <div class="sc-label">Present Days</div>
                <div class="sc-value">{{ $presentDays }}</div>
            </div>

            <div class="stat-card">
                <div class="sc-label">Week Off</div>
                <div class="sc-value">{{ $weekOff }}</div>
            </div>

            <div class="stat-card accent">
                <div class="sc-label">Paid Days</div>
                <div class="sc-value">{{ $paidDays }}</div>
            </div>

            <div class="stat-card">
                <div class="sc-label">Total Days</div>
                {{-- <div class="sc-value">{{ $totalDays }}</div> --}}
                <div class="sc-value">{{ $paidDays }}</div>
            </div>

        </div>
    </div>

    {{-- Earnings + Deductions --}}
    <div class="section">
        <div class="earnings-deductions">

            {{-- Earnings --}}
            <div>
                <div class="section-title green">Earnings Details</div>
                <table class="slip-table">
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th>Actual (₹)</th>
                            <th>Earned (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Salary</td>
                            <td>{{ number_format($salary->staff->basic_salary ?? 0, 2) }}</td>
                            <td>{{ number_format($salary->earned_basic ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>HRA</td>
                            <td>{{ number_format($salary->staff->hra ?? 0, 2) }}</td>
                            <td>{{ number_format($salary->earned_hra ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Other Allowance</td>
                            <td>{{ number_format($salary->staff->other_allowance ?? 0, 2) }}</td>
                            <td>{{ number_format($salary->earned_other_allowance ?? 0, 2) }}</td>
                        </tr>
                        <tr class="row-total-green">
                            <td>Gross Income</td>
                            <td>{{ number_format($salary->staff->total_salary ?? 0, 2) }}</td>
                            <td>
                                ₹{{ number_format(
                                    round(($salary->earned_basic ?? 0) +
                                    ($salary->earned_hra ?? 0) +
                                    ($salary->earned_other_allowance ?? 0)),
                                2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Deductions --}}
            <div>
                <div class="section-title red">Deduction Details</div>

                <form action="{{ route('staff-salary.updateDeductions', $salary->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <table class="slip-table">
                        <thead>
                            <tr>
                                <th>Deduction</th>
                                <th>Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach([
                                ['PF',               'pf_deduction',      $salary->pf_deduction ?? 0],
                                ['ESIC',             'esic_deduction',    $salary->esic_deduction ?? 0],
                                ['Advance',          'advance_deduction', $salary->advance_deduction ?? 0],
                                ['PT',               'pt_deduction',      $salary->pt_deduction ?? 0],
                                ['LWF',              'lwf_deduction',     $salary->lwf_deduction ?? 0],
                                ['Other Deduction',  'other_deduction',   $salary->other_deduction ?? 0],
                            ] as [$label, $name, $val])
                            <tr>
                                <td>{{ $label }}</td>
                                <td>
                                    <input
                                        type="number"
                                        step="0.01"
                                        name="{{ $name }}"
                                        value="{{ $val }}"
                                        class="deduct-input"
                                    >
                                </td>
                            </tr>
                            @endforeach

                            <tr class="row-total-red">
                                <td>Total Deductions</td>
                                    <td>
                                        ₹{{ number_format(
                                            ($salary->pf_deduction ?? 0) +
                                            ($salary->esic_deduction ?? 0) +
                                            ($salary->advance_deduction ?? 0) +
                                            ($salary->pt_deduction ?? 0) +
                                            ($salary->lwf_deduction ?? 0) +
                                            ($salary->other_deduction ?? 0),
                                        2) }}
                                    </td>
                                </tr>

                        </tbody>
                    </table>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Update Deductions
                        </button>
                        <a href="{{ route('staff-salary.payslip', $salary->id) }}"
                           class="btn btn-success"
                           target="_blank">
                            <i class="fas fa-download"></i> Download Payslip
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>

    {{-- Net Payable Banner --}}
<div class="net-banner">
    <div>
        <div class="nb-label">
            Net Payable Salary
        </div>

        <div class="nb-amount">
             ₹{{ number_format(round($salary->net_salary ?? 0,2)) }}
        </div>

        <div class="nb-words">
            Employee: {{ $salary->staff->name ?? 'N/A' }} |
            Month: {{ $salary->getMonthName() }} {{ $salary->year }} |
            Paid Days: {{ ($salary->paid_days ?? 0) + ($salary->week_off ?? 0) }} |
            Total Deductions: ₹{{ number_format($salary->total_deduction ?? 0,2) }}
        </div>

    </div>

    <div class="nb-badge">
        <i class="fas fa-check-circle"></i>
        Salary Processed
    </div>

</div>
</div>
@endsection