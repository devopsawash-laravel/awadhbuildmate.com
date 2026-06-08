@extends('layouts.app')

@section('title', 'Wages Sheet')
@section('page-title', 'Wages Sheet')

@section('content')

{{-- ══════════════════════════════════════════════════
     WAGES SHEET  —  FORM XVII  |  AWADH BUILDMATE
     ══════════════════════════════════════════════════ --}}

{{-- ── TOP FILTER BAR ──────────────────────────────── --}}
<div class="ws-filter-bar no-print">

    <form method="GET" class="ws-filter-form">

        <div class="ws-filter-group">

            {{-- Site --}}
            <div class="ws-field">
                <label>Site</label>
                <select name="site_id">
                    <option value="">All Sites</option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}"
                            {{ request('site_id') == $site->id ? 'selected' : '' }}>
                            {{ $site->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Month --}}
            <div class="ws-field">
                <label>Month</label>
                <select name="month">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$m,1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Year --}}
            <div class="ws-field">
                <label>Year</label>
                <select name="year">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="ws-filter-actions">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> View
                    </button>
                    <button type="button" onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="{{ route('wages.export', [
                        'site_id' => request('site_id'),
                        'month'   => $month,
                        'year'    => $year
                    ]) }}"
                    class="btn btn-success">
                    <i class="fas fa-file-download"></i>
                    Export Excel {{ date('F', mktime(0,0,0,$month,1)) }}
                </a>
            </div>
        </div>

        

    </form>

</div>

{{-- ── WAGES CONTAINER ─────────────────────────────── --}}
<div class="wages-container">

    {{-- Company Header --}}
    <div class="company-header">

        <div style="display:flex;align-items:center;gap:16px;">
            <img src="{{ asset('images/projects/logo.png') }}"
                alt="Logo"
                style="width:80px;height:80px;object-fit:contain;">
            <div>
                <div class="company-name">AWADH BUILDMATE</div>
                <div class="company-tagline">Made For Quality and Trust</div>
                <div class="company-subtitle">Fabrication &nbsp;|&nbsp; Erection &nbsp;|&nbsp; Structural Work</div>
            </div>
        </div>

        <div style="text-align:right;">
            <div class="sheet-title">FORM XVII &mdash; REGISTER OF WAGES</div>
            <div class="sheet-month">
                {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}
                @if(request('site_id'))
                    &nbsp;&mdash;&nbsp;
                    {{ $sites->firstWhere('id', request('site_id'))->name ?? '' }}
                @endif
            </div>
        </div>

    </div>

    {{-- Table --}}
    <div class="table-wrapper">

        <table class="wages-table">

            <thead>

                {{-- ROW 1 --}}
                <tr>
                    <th rowspan="2">Sr.</th>
                    <th rowspan="2">Type</th>
                    <th rowspan="2">Name of Workman</th>
                    <th rowspan="2">Designation</th>
                    <th rowspan="2">Total<br>Present</th>
                    <th rowspan="2">OT<br>Hours</th>

                    <th colspan="4" class="group-actual">Actual</th>
                    <th colspan="5" class="group-earned">Earned</th>
                    <th colspan="7" class="group-deduct">Deduction</th>

                    <th rowspan="2" class="col-payable">Total<br>Payable</th>
                </tr>

                {{-- ROW 2 --}}
                <tr>
                    {{-- Actual (4) --}}
                    <th class="sub-actual">Basic</th>
                    <th class="sub-actual">HRA</th>
                    <th class="sub-actual">Allow.</th>
                    <th class="sub-actual">Gross</th>

                    {{-- Earned (5) --}}
                    <th class="sub-earned">Basic</th>
                    <th class="sub-earned">HRA</th>
                    <th class="sub-earned">Convye.</th>
                    <th class="sub-earned">OT Amt</th>
                    <th class="sub-earned">Gross</th>

                    {{-- Deduction (6) --}}
                    <th class="sub-deduct">PF</th>
                    <th class="sub-deduct">ESIC</th>
                    <th class="sub-deduct">PT</th>
                    <th class="sub-deduct">ADV</th>
                    <th class="sub-deduct">LWF</th>
                    <th class="sub-deduct">Others</th>
                    <th class="sub-deduct">Total<br>Ded.</th>
                </tr>

            </thead>

            <tbody>

                @php
                    $totalPaidDays        = 0;
                    $totalOtHours         = 0;
                    $totalActualBasic     = 0;
                    $totalActualHra       = 0;
                    $totalActualAllowance = 0;
                    $totalActualGross     = 0;
                    $totalEarnedBasic     = 0;
                    $totalEarnedHra       = 0;
                    $totalEarnedAllowance = 0;
                    $totalOtAmount        = 0;
                    $totalEarnedGross     = 0;
                    $totalPf              = 0;
                    $totalEsic            = 0;
                    $totalPt              = 0;
                    $totalAdv             = 0;
                    $totalLWF             = 0;
                    $totalOther           = 0;
                    $grandTotalDeduction  = 0;
                    $grandTotalPayable    = 0;
                @endphp

                @foreach($combinedSlips as $i => $salary)

                @php
                    $workingHoursPerDay = $salary->labour->working_hours_per_day ?? 8;
                    $otMultiplier       = $salary->labour->ot_rate_multiplier ?? 1;
                    $effectiveOtHours   = ($salary->overtime_hours ?? 0) * $otMultiplier;
                    $otDays             = round($effectiveOtHours / $workingHoursPerDay, 2);

                    $paidDays           = $salary->present_days + ($salary->half_days * 0.5) + $salary->week_off_days;
                    $labourpaidDays     = round(($paidDays + $otDays) * 10) / 10;

                    // dd($labourpaidDays);
                    $finalOtHours       = ($salary->overtime_hours ?? 0) * ($salary->ot_rate_multiplier ?? 1);

                    $actualGross        = ($salary->employee->basic_salary ?? 0)
                                        + ($salary->employee->hra ?? 0)
                                        + ($salary->employee->other_allowance ?? 0);

                    $earnedGross        = ($salary->earned_basic ?? 0)
                                        + ($salary->earned_hra ?? 0)
                                        + ($salary->earned_other_allowance ?? 0)
                                        + ($salary->overtime_amount ?? 0);

                    $totalPayable       = $salary->net_salary ?? 0;

                    $presentDays = $salary->employee_type == 'Staff'
                        ? (($salary->paid_days ?? 0) + ($salary->week_off ?? 0))
                        : $labourpaidDays;
                    // dd($presentDays);
                    // dd($totalstaffandLabour);

                    // Running totals
                    $totalPaidDays        += $presentDays;
                    $totalOtHours         += $finalOtHours;
                    $totalActualBasic     += $salary->employee->basic_salary ?? 0;
                    $totalActualHra       += $salary->employee->hra ?? 0;
                    $totalActualAllowance += $salary->employee->other_allowance ?? 0;
                    $totalActualGross     += $actualGross;
                    $totalEarnedBasic     += $salary->earned_basic ?? 0;
                    $totalEarnedHra       += $salary->earned_hra ?? 0;
                    $totalEarnedAllowance += $salary->earned_other_allowance ?? 0;
                    $totalOtAmount        += $salary->overtime_amount ?? 0;
                    $totalEarnedGross     += $earnedGross;
                    $totalPf              += $salary->pf_deduction ?? 0;
                    $totalEsic            += $salary->esic_deduction ?? 0;
                    $totalPt              += $salary->pt_deduction ?? 0;
                    $totalAdv             += $salary->advance_deduction ?? 0;
                    $totalLWF             += $salary->lwf_deduction ?? 0;
                    $totalOther           += $salary->other_deduction ?? 0;
                    $grandTotalDeduction  += $salary->total_deduction ?? 0;
                    $grandTotalPayable    += $totalPayable;
                @endphp

                <tr>
                    <td>{{ $i + 1 }}</td>

                    <td>{{ $salary->employee_type }}</td>

                    <td style="text-align:left;padding-left:10px;font-weight:600;">
                        {{ $salary->employee->name }}
                    </td>

                    <td>{{ $salary->employee->category ?? $salary->employee->designation }}</td>

                    <td>{{ number_format($presentDays, 1) }}</td>
                    <td>{{ number_format($finalOtHours, 1) }}</td>

                    {{-- Actual --}}
                    <td>{{ number_format($salary->employee->basic_salary ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->employee->hra ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->employee->other_allowance ?? 0, 0) }}</td>
                    <td><strong>{{ number_format($actualGross, 0) }}</strong></td>

                    {{-- Earned --}}
                    <td>{{ number_format($salary->earned_basic ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->earned_hra ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->earned_other_allowance ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->overtime_amount ?? 0, 0) }}</td>
                    <td><strong>{{ number_format($earnedGross, 0) }}</strong></td>

                    {{-- Deduction --}}
                    <td>{{ number_format($salary->pf_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->esic_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->pt_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->advance_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->lwf_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->other_deduction ?? 0, 0) }}</td>

                    <td><strong>{{ number_format($salary->total_deduction ?? 0, 0) }}</strong></td>

                    {{-- ✅ Total Payable — correct column, no rowspan issue --}}
                    <td class="td-payable">
                        <strong>{{ number_format($totalPayable, 0) }}</strong>
                    </td>
                </tr>

                @endforeach

                {{-- TOTAL ROW --}}
                <tr class="total-row">
                    <td colspan="4"><strong>TOTAL</strong></td>
                    <td>{{ number_format($totalPaidDays, 1) }}</td>
                    <td>{{ number_format($totalOtHours, 1) }}</td>
                    <td>{{ number_format($totalActualBasic, 0) }}</td>
                    <td>{{ number_format($totalActualHra, 0) }}</td>
                    <td>{{ number_format($totalActualAllowance, 0) }}</td>
                    <td>{{ number_format($totalActualGross, 0) }}</td>
                    <td>{{ number_format($totalEarnedBasic, 0) }}</td>
                    <td>{{ number_format($totalEarnedHra, 0) }}</td>
                    <td>{{ number_format($totalEarnedAllowance, 0) }}</td>
                    <td>{{ number_format($totalOtAmount, 0) }}</td>
                    <td>{{ number_format($totalEarnedGross, 0) }}</td>
                    <td>{{ number_format($totalPf, 0) }}</td>
                    <td>{{ number_format($totalEsic, 0) }}</td>
                    <td>{{ number_format($totalPt, 0) }}</td>
                    <td>{{ number_format($totalAdv, 0) }}</td>
                    <td>{{ number_format($totalLWF, 0) }}</td>
                    <td>{{ number_format($totalOther, 0) }}</td>
                    <td>{{ number_format($grandTotalDeduction, 0) }}</td>
                    <td class="td-payable">
                        <strong>{{ number_format($grandTotalPayable, 0) }}</strong>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

<style>

/* ── TOKENS ─────────────────────────────────────────── */
:root {
    --primary:       #ea580c;
    --primary-dark:  #c2410c;
    --primary-light: #fff7ed;

    --text:   #1f2937;
    --muted:  #6b7280;

    --border:     #d1d5db;
    --header-bg:  #fffaf5;
    --table-head: #fff3e8;
    --total-bg:   #fff7ed;

    --actual-bg:  #eff6ff;
    --actual-sub: #dbeafe;
    --actual-txt: #1e40af;

    --earned-bg:  #f0fdf4;
    --earned-sub: #dcfce7;
    --earned-txt: #166534;

    --deduct-bg:  #fef2f2;
    --deduct-sub: #fee2e2;
    --deduct-txt: #991b1b;

    --payable-bg:  #faf5ff;
    --payable-sub: #e9d5ff;
    --payable-txt: #6b21a8;
}

/* ── FILTER BAR ─────────────────────────────────────── */
.ws-filter-bar {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
}

.ws-filter-form {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    width: 100%;
}

.ws-filter-group {
    display: flex;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 14px;
}

.ws-filter-actions {
    display: flex;
    gap: 10px;
    align-items: flex-end;
}

.ws-field label {
    display: block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

.ws-field select {
    height: 42px;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0 12px;
    background: #fff;
    color: #111827;
    font-weight: 500;
    min-width: 160px;
    font-size: 13.5px;
}

/* ── PAGE ───────────────────────────────────────────── */
.wages-container {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
}

/* ── COMPANY HEADER ─────────────────────────────────── */
.company-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 22px;
    padding-bottom: 16px;
    border-bottom: 2px solid var(--primary-light);
}

.company-name {
    font-size: 30px;
    font-weight: 800;
    letter-spacing: 0.5px;
    color: var(--primary);
    line-height: 1.1;
}

.company-tagline {
    font-size: 13px;
    color: var(--text);
    margin-top: 4px;
    font-weight: 600;
}

.company-subtitle {
    font-size: 12px;
    color: var(--muted);
    margin-top: 5px;
    letter-spacing: 0.3px;
}

.sheet-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--text);
}

.sheet-month {
    font-size: 13px;
    color: var(--primary-dark);
    margin-top: 6px;
    font-weight: 600;
}

/* ── TABLE ──────────────────────────────────────────── */
.table-wrapper {
    overflow: auto;
    border-radius: 10px;
}

.table-wrapper::-webkit-scrollbar        { height: 8px; }
.table-wrapper::-webkit-scrollbar-thumb  { background: #fdba74; border-radius: 20px; }

.wages-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    min-width: 1540px;
}

/* ── TABLE HEAD ─────────────────────────────────────── */
.wages-table thead th {
    background: var(--table-head);
    color: var(--text);
    font-weight: 700;
    border: 1px solid #d6d3d1;
    padding: 8px 6px;
    text-align: center;
    vertical-align: middle;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    font-size: 10.5px;
    line-height: 1.3;
    white-space: nowrap;
}

/* Group colour-coding */
.wages-table thead th.group-actual { background: var(--actual-bg);  color: var(--actual-txt); }
.wages-table thead th.group-earned { background: var(--earned-bg);  color: var(--earned-txt); }
.wages-table thead th.group-deduct { background: var(--deduct-bg);  color: var(--deduct-txt); }
.wages-table thead th.sub-actual   { background: var(--actual-sub); color: var(--actual-txt); }
.wages-table thead th.sub-earned   { background: var(--earned-sub); color: var(--earned-txt); }
.wages-table thead th.sub-deduct   { background: var(--deduct-sub); color: var(--deduct-txt); }
.wages-table thead th.col-payable  { background: var(--payable-sub); color: var(--payable-txt); }

/* ── TABLE BODY ─────────────────────────────────────── */
.wages-table td {
    border: 1px solid #e5e7eb;
    padding: 7px 6px;
    text-align: center;
    vertical-align: middle;
    color: #111827;
    background: #fff;
}

.wages-table tbody tr:hover td    { background: #fffaf5 !important; }
.wages-table tbody tr:nth-child(even) td { background: #fcfcfc; }

.td-payable {
    background: var(--payable-bg) !important;
    color: var(--payable-txt) !important;
}

/* ── TOTAL ROW ──────────────────────────────────────── */
.total-row td {
    font-weight: 800;
    background: var(--total-bg) !important;
    color: var(--primary-dark);
    border-top: 2px solid var(--primary);
    font-size: 11.5px;
}

.total-row .td-payable {
    background: var(--payable-sub) !important;
    color: var(--payable-txt) !important;
}

/* ── BUTTONS ────────────────────────────────────────── */
.btn {
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 13.5px;
    transition: 0.2s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}

.btn-primary          { background: var(--primary); color: #fff; }
.btn-primary:hover    { background: var(--primary-dark); transform: translateY(-1px); }
.btn-secondary        { background: #374151; color: #fff; }
.btn-secondary:hover  { background: #111827; transform: translateY(-1px); }

/* ── MOBILE ─────────────────────────────────────────── */
@media (max-width: 768px) {
    .ws-filter-bar    { padding: 14px; }
    .ws-filter-group  { width: 100%; }
    .ws-field select  { min-width: 100%; }
    .company-header   { flex-direction: column; align-items: flex-start; }
    .company-name     { font-size: 24px; }
    .wages-container  { padding: 14px; }
    .sheet-title      { font-size: 16px; }
}

/* ── PRINT ──────────────────────────────────────────── */
@media print {
    .sidebar,
    .topbar,
    .no-print { display: none !important; }

    .main    { margin-left: 0 !important; }
    .content { padding: 0 !important; }

    .wages-container {
        border: none;
        box-shadow: none;
        border-radius: 0;
        padding: 0;
    }

    .wages-table      { font-size: 9px; min-width: unset; width: 100%; }
    .wages-table th   { background: #f3f4f6 !important; color: #000 !important; padding: 4px 3px; }
    .wages-table td   { padding: 4px 3px; }
    .total-row td     { background: #f5f5f5 !important; color: #000 !important; }
    .td-payable       { background: #f3f0ff !important; }

    @page { size: landscape; margin: 5mm; }
}

</style>

@endsection