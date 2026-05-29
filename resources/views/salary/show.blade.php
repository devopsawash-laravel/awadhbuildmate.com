@extends('layouts.app')

@section('title', 'Salary Slip')
@section('page-title', 'Salary Slip')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet">

<style>
:root {
    --org-50:  #FFF7ED;
    --org-100: #FFEDD5;
    --org-200: #FED7AA;
    --org-400: #FB923C;
    --org-500: #F97316;
    --org-600: #EA580C;
    --org-700: #C2410C;
    --org-800: #9A3412;
    --org-900: #7C2D12;
    --gray-50:  #F8FAFC;
    --gray-100: #F1F5F9;
    --gray-200: #E2E8F0;
    --gray-400: #94A3B8;
    --gray-600: #475569;
    --gray-800: #1E293B;
    --green-50:  #EAF3DE;
    --green-600: #3B6D11;
    --green-800: #27500A;
    --red-50:   #FCEBEB;
    --red-600:  #A32D2D;
    --red-800:  #791F1F;
    --amber-50: #FAEEDA;
    --amber-600: #854F0B;
}

* { box-sizing: border-box; }

.slip-wrap {
    font-family: 'DM Sans', sans-serif;
    max-width: 1060px;
    margin: 0 auto;
    background: #fff;
    border: 1px solid var(--gray-200);
    border-radius: 14px;
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
.page-header-bar .main-title {
    font-family: 'Sora', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0;
}
.page-header-bar .sub-title {
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
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 500;
    border-radius: 6px;
    cursor: pointer;
    transition: background .15s, color .15s, border-color .15s;
    text-decoration: none;
    border: 1px solid transparent;
}
.btn-outline  { background:#fff; color:var(--gray-600); border-color:var(--gray-200); }
.btn-outline:hover { background:var(--gray-100); color:var(--gray-800); }
.btn-warning  { background:#fff; color:#92400E; border-color:#FCD34D; }
.btn-warning:hover { background:#FFFBEB; }
.btn-success  { background:var(--green-600); color:#fff; border-color:var(--green-600); }
.btn-success:hover { background:var(--green-800); border-color:var(--green-800); }

/* ── Company Header ───────────────────────────── */
.co-header {
    background: var(--org-900);
    padding: 28px 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.co-header::before {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.co-header::after {
    content: '';
    position: absolute;
    right: 60px;
    bottom: -60px;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}
.brand-name {
    font-family: 'Sora', sans-serif;
    font-size: 26px;
    font-weight: 700;
    color: #fff;
    letter-spacing: .5px;
    margin: 0;
}
.brand-tag {
    font-size: 11px;
    color: var(--org-200);
    margin-top: 4px;
    letter-spacing: .8px;
    text-transform: uppercase;
}
.slip-badge {
    display: inline-block;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.22);
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 6px;
    margin-bottom: 7px;
}
.slip-period { font-size: 12px; color: var(--org-200); text-align: right; }

/* ── Sections ─────────────────────────────────── */
.section {
    padding: 24px 36px;
    border-bottom: 1px solid var(--gray-200);
}
.section:last-child { border-bottom: none; }

.sec-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.sec-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 13px;
    border-radius: 3px;
    flex-shrink: 0;
}
.sec-title.orange  { color: var(--org-800); }
.sec-title.orange::before { background: var(--org-500); }
.sec-title.green   { color: var(--green-600); }
.sec-title.green::before  { background: #639922; }
.sec-title.red     { color: var(--red-600); }
.sec-title.red::before    { background: #E24B4A; }

/* ── Employee Grid ────────────────────────────── */
.emp-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px 18px;
}
.ef-label {
    font-size: 9px;
    font-weight: 700;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-bottom: 3px;
}
.ef-value {
    font-size: 13px;
    font-weight: 600;
    color: var(--gray-800);
}

/* ── Stat Cards ───────────────────────────────── */
.stats {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 12px;
}
.sc {
    background: var(--gray-100);
    border: 1px solid var(--gray-200);
    border-radius: 10px;
    padding: 14px 16px;
    text-align: center;
}
.sc.acc {
    background: var(--org-50);
    border-color: var(--org-200);
}
.sc.ot {
    background: var(--amber-50);
    border-color: #FCD34D;
}
.sc-lbl {
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--gray-400);
    margin-bottom: 5px;
}
.sc.acc .sc-lbl { color: var(--org-600); }
.sc.ot  .sc-lbl { color: var(--amber-600); }
.sc-val {
    font-family: 'Sora', sans-serif;
    font-size: 24px;
    font-weight: 700;
    color: var(--gray-800);
}
.sc.acc .sc-val { color: var(--org-800); }
.sc.ot  .sc-val { color: var(--amber-600); }

/* ── Earnings + Deductions ────────────────────── */
.ed-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 28px;
    align-items: start;
}

/* ── Tables ────────────────────────────────────── */
.slip-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.slip-table thead tr { background: var(--gray-100); }
.slip-table thead th {
    padding: 9px 12px;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--gray-600);
    border: 1px solid var(--gray-200);
}
.slip-table thead th:first-child  { text-align: left; }
.slip-table thead th:not(:first-child) { text-align: center; }
.slip-table tbody td {
    padding: 9px 12px;
    border: 1px solid var(--gray-200);
    color: var(--gray-800);
}
.slip-table tbody td:not(:first-child) { text-align: center; }
.slip-table tbody tr:hover td { background: var(--gray-50); }

.row-green td { background: var(--green-50) !important; font-weight: 600; color: var(--green-600) !important; }
.row-red   td { background: var(--red-50)   !important; font-weight: 600; color: var(--red-800)   !important; }

.deduct-input {
    width: 110px;
    padding: 6px 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    color: var(--gray-800);
    background: #fff;
    border: 1px solid var(--gray-200);
    border-radius: 5px;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.deduct-input:focus {
    border-color: var(--org-400);
    box-shadow: 0 0 0 3px var(--org-50);
}

.form-actions {
    margin-top: 16px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* ── Net Banner ────────────────────────────────── */
.net-banner {
    margin: 0 36px 26px;
    background: var(--org-900);
    border-radius: 10px;
    padding: 20px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.net-banner::before {
    content: '';
    position: absolute;
    right: -30px;
    top: -30px;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.nb-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--org-200);
}
.nb-amount {
    font-family: 'Sora', sans-serif;
    font-size: 30px;
    font-weight: 700;
    color: #fff;
    margin-top: 4px;
}
.nb-sub { font-size: 12px; color: var(--org-200); margin-top: 3px; }
.nb-badge {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 6px;
    padding: 10px 20px;
    color: #fff;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    position: relative;
}

/* ── Print ─────────────────────────────────────── */
@media print {
    .sidebar, .topbar, .page-header-bar, .btn, .form-actions { display: none !important; }
    .main  { margin-left: 0 !important; }
    .content { padding: 0 !important; }
    .slip-wrap { border: none !important; border-radius: 0 !important; }
    .deduct-input { border: none !important; background: transparent !important; }
}
</style>

{{-- Page Header --}}
<div class="page-header-bar">
    <div>
        <p class="main-title">Salary Slip</p>
        <p class="sub-title">{{ $salary->getMonthName() }} {{ $salary->year }}</p>
    </div>
    <div class="header-actions">
        <button onclick="window.print()" class="btn btn-outline">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="{{ route('salary.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="slip-wrap" id="salary-slip">

    {{-- Company Header --}}
    <div class="co-header">
        <div>
            <p class="brand-name">AWADH BUILDMATE</p>
            <p class="brand-tag">Made for Quality and Trust</p>
        </div>
        <div>
            <div class="slip-badge">Salary Slip</div>
            <p class="slip-period">For the Month of {{ $salary->getMonthName() }} {{ $salary->year }}</p>
        </div>
    </div>

    {{-- Employee Details --}}
    <div class="section">
        <div class="sec-title orange">Employee Details</div>
        <div class="emp-grid">

            <div>
                <div class="ef-label">Employee Name</div>
                <div class="ef-value">{{ $salary->labour->name }}</div>
            </div>

            <div>
                <div class="ef-label">Employee ID</div>
                <div class="ef-value">{{ $salary->labour->employee_id }}</div>
            </div>

            <div>
                <div class="ef-label">Category</div>
                <div class="ef-value">{{ $salary->labour->category }}</div>
            </div>

            <div>
                <div class="ef-label">Date of Joining</div>
                <div class="ef-value">
                    {{ \Carbon\Carbon::parse($salary->labour->joining_date)->format('d M Y') }}
                </div>
            </div>

            <div>
                <div class="ef-label">Site</div>
                <div class="ef-value">{{ $salary->labour->site->name ?? '—' }}</div>
            </div>

            <div>
                <div class="ef-label">UAN Number</div>
                <div class="ef-value">{{ $salary->labour->UAN ?? '—' }}</div>
            </div>

            <div>
                <div class="ef-label">ESIC Number</div>
                <div class="ef-value">{{ $salary->labour->ESIC_Number ?? '—' }}</div>
            </div>

            <div>
                <div class="ef-label">Bank Name</div>
                <div class="ef-value">{{ $salary->labour->bank->name ?? '—' }}</div>
            </div>

            <div>
                <div class="ef-label">Bank A/C No.</div>
                <div class="ef-value">{{ $salary->labour->Account_Number ?? '—' }}</div>
            </div>

            <div>
                <div class="ef-label">IFSC Code</div>
                <div class="ef-value">{{ $salary->labour->IFSC ?? '—' }}</div>
            </div>

        </div>
    </div>

    {{-- Working Details --}}
    @php
        $paidDays           = $salary->present_days + ($salary->half_days * 0.5) + $salary->week_off_days;
        $workingHoursPerDay = $salary->labour->working_hours_per_day ?? 8;
        $otMultiplier       = $salary->labour->ot_rate_multiplier ?? 1;
        $effectiveOtHours   = ($salary->overtime_hours ?? 0) * $otMultiplier;
        $otDays             = round($effectiveOtHours / $workingHoursPerDay, 2);
        $finalPayableDays   = floor(($paidDays + $otDays) * 10) / 10;
        $finalOtHours       = ($salary->overtime_hours ?? 0) * ($salary->ot_rate_multiplier ?? 1);
        $lastOT             = $finalOtHours * $otMultiplier;
    @endphp

    <div class="section">
        <div class="sec-title orange">Working Details</div>
        <div class="stats">

            <div class="sc">
                <div class="sc-lbl">Present Days</div>
                <div class="sc-val">{{ $salary->present_days }}</div>
            </div>

            <div class="sc">
                <div class="sc-lbl">Week Off</div>
                <div class="sc-val">{{ $salary->week_off_days }}</div>
            </div>

            <div class="sc acc">
                <div class="sc-lbl">Paid Days</div>
                <div class="sc-val">{{ $paidDays }}</div>
            </div>

            <div class="sc ot">
                <div class="sc-lbl">OT Hours</div>
                <div class="sc-val">{{ number_format($lastOT, 1) }}</div>
            </div>

            <div class="sc">
                <div class="sc-lbl">Total Days</div>
                <div class="sc-val">{{ $finalPayableDays }}</div>
            </div>

        </div>
    </div>

    {{-- Earnings + Deductions --}}
    <div class="section">
        <div class="ed-grid">

            {{-- Earnings --}}
            <div>
                <div class="sec-title green">Earnings Details</div>
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
                            <td>{{ number_format($salary->labour->basic_salary ?? 0, 2) }}</td>
                            <td>{{ number_format($salary->earned_basic ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>HRA</td>
                            <td>{{ number_format($salary->labour->hra ?? 0, 2) }}</td>
                            <td>{{ number_format($salary->earned_hra ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Other Allowance</td>
                            <td>{{ number_format($salary->labour->other_allowance ?? 0, 2) }}</td>
                            <td>{{ number_format($salary->earned_other_allowance ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>OT Amount</td>
                            <td>—</td>
                            <td>{{ number_format($salary->overtime_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr class="row-green">
                            <td>Gross Income</td>
                            <td>{{ number_format(
                                ($salary->labour->basic_salary ?? 0) +
                                ($salary->labour->hra ?? 0) +
                                ($salary->labour->other_allowance ?? 0), 2) }}</td>
                            <td>{{ number_format(
                                ($salary->earned_basic ?? 0) +
                                ($salary->earned_hra ?? 0) +
                                ($salary->earned_other_allowance ?? 0) +
                                ($salary->overtime_amount ?? 0), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Deductions --}}
            <div>
                <div class="sec-title red">Deduction Details</div>

                <form action="{{ route('salary.updateDeductions', $salary->id) }}" method="POST">
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
                                ['PF',              'pf_deduction',      number_format($salary->pf_deduction ?? 0, 2)],
                                ['ESIC',            'esic_deduction',    $salary->esic_deduction ?? 0],
                                ['Advance',         'advance_deduction', $salary->advance_deduction ?? 0],
                                ['PT',              'pt_deduction',      $salary->pt_deduction ?? 0],
                                ['LWF',             'lwf_deduction',     $salary->lwf_deduction ?? 0],
                                ['Other Deduction', 'other_deduction',   $salary->other_deduction ?? 0],
                            ] as [$label, $name, $val])
                            <tr>
                                <td>{{ $label }}</td>
                                <td><input type="number" step="0.01" name="{{ $name }}" value="{{ $val }}" class="deduct-input"></td>
                            </tr>
                            @endforeach

                            <tr class="row-red">
                                <td>Total Deductions</td>
                                <td>{{ number_format($salary->total_deduction ?? 0, 2) }}</td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Update Deductions
                        </button>
                        <a href="{{ route('salary.payslip', $salary->id) }}"
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
            <div class="nb-label">Net Payable Salary</div>
            <div class="nb-amount">₹{{ number_format($salary->net_salary) }}</div>
            <div class="nb-sub">{{ $salary->getMonthName() }} {{ $salary->year }} — {{ $salary->labour->name }}</div>
        </div>
        <div class="nb-badge">
            <i class="fas fa-check-circle" style="color:#86efac;"></i>
            Salary Processed
        </div>
    </div>

</div>
@endsection