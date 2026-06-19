@extends('layouts.app')

@section('title', 'Wages Sheet')
@section('page-title', 'Wages Sheet')

@section('content')

<style>
*, *::before, *::after { box-sizing: border-box; }

/* ── Filter bar ── */
.ws-filter-bar {
    background: #fff;
    border: 1px solid #E5E7EB;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 18px;
    display: flex;
    align-items: flex-end;
    gap: 12px;
    flex-wrap: wrap;
}
.ws-filter-form {
    display: flex;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 12px;
    width: 100%;
}
.ws-filter-group {
    display: flex;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 12px;
    flex: 1;
}
.ws-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.ws-field label {
    font-size: 11px;
    font-weight: 500;
    color: #6B7280;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.ws-field select {
    height: 38px;
    border: 1px solid #D1D5DB;
    border-radius: 6px;
    padding: 0 10px;
    background: #fff;
    color: #111827;
    font-size: 13px;
    min-width: 150px;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
    accent-color: #ea580c;
}
.ws-field select:focus {
    border-color: #ea580c;
    box-shadow: 0 0 0 3px rgba(234,88,12,.1);
}
.ws-filter-actions {
    display: flex;
    gap: 8px;
    align-items: flex-end;
    margin-left: auto;
}

/* ── Buttons ── */
.ws-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    height: 38px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    border: 1px solid transparent;
    text-decoration: none;
    white-space: nowrap;
    line-height: 1;
    transition: filter .12s, transform .1s;
}
.ws-btn:hover  { filter: brightness(.91); transform: translateY(-1px); }
.ws-btn:active { filter: brightness(.84); transform: translateY(0); }
.ws-btn i { font-size: 14px; }

.ws-btn-teal   { background: #1D9E75; border-color: #0F6E56; color: #fff; }
.ws-btn-orange { background: #D85A30; border-color: #993C1D; color: #fff; }
.ws-btn-green  { background: #639922; border-color: #3B6D11; color: #fff; }

/* ── Wages container ── */
.wages-container {
    background: #fff;
    border: 1px solid #d1d5db;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
}

/* ── Company header ── */
.company-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    padding: 20px 24px 18px;
    border-bottom: 2px solid #fff7ed;
    background: #fffaf5;
}
.company-header-left { display: flex; align-items: center; gap: 14px; }
.company-logo {
    width: 70px; height: 70px;
    object-fit: contain;
    border-radius: 10px;
    flex-shrink: 0;
}
.company-name    { font-size: 26px; font-weight: 800; color: #ea580c; letter-spacing: .3px; line-height: 1.1; }
.company-tagline { font-size: 13px; color: #1f2937; margin-top: 4px; font-weight: 600; }
.company-subtitle{ font-size: 12px; color: #6b7280; margin-top: 3px; letter-spacing: .3px; }
.company-header-right { text-align: right; }
.sheet-title  { font-size: 20px; font-weight: 800; color: #1f2937; }
.sheet-month  { font-size: 13px; color: #c2410c; margin-top: 5px; font-weight: 600; }
.sheet-badge  {
    display: inline-block; margin-top: 6px;
    padding: 3px 10px; border-radius: 6px;
    background: #fff7ed; color: #c2410c;
    border: 1px solid #fed7aa;
    font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: .4px;
}

/* ── Table wrapper ── */
.table-wrapper {
    overflow-x: auto;
}
.table-wrapper::-webkit-scrollbar       { height: 6px; }
.table-wrapper::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 10px; }

/* ── Wages table ── */
.wages-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    min-width: 1540px;
}

/* thead */
.wages-table thead th {
    padding: 9px 8px;
    text-align: center;
    vertical-align: middle;
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    line-height: 1.3;
    white-space: nowrap;
    border: 1px solid #d6d3d1;
    color: #1f2937;
    background: #fff3e8;
}

/* Group headers */
.wages-table thead th.group-actual { background: #eff6ff; color: #1e40af; border-bottom: none; }
.wages-table thead th.group-earned { background: #f0fdf4; color: #166534; border-bottom: none; }
.wages-table thead th.group-deduct { background: #fef2f2; color: #991b1b; border-bottom: none; }
.wages-table thead th.col-payable  { background: #e9d5ff; color: #6b21a8; }

/* Sub headers */
.wages-table thead th.sub-actual { background: #dbeafe; color: #1e40af; }
.wages-table thead th.sub-earned { background: #dcfce7; color: #166534; }
.wages-table thead th.sub-deduct { background: #fee2e2; color: #991b1b; }

/* tbody */
.wages-table tbody td {
    padding: 8px 7px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #e5e7eb;
    color: #111827;
    background: #fff;
    font-size: 12px;
}
.wages-table tbody tr:nth-child(even) td { background: #fcfcfc; }
.wages-table tbody tr:hover td { background: #fffaf5 !important; }

.td-payable {
    background: #faf5ff !important;
    color: #6b21a8 !important;
    font-weight: 500;
}

/* total row */
.total-row td {
    font-weight: 800;
    background: #fff7ed !important;
    color: #c2410c;
    border-top: 2px solid #ea580c;
    font-size: 11.5px;
}
.total-row .td-payable {
    background: #e9d5ff !important;
    color: #6b21a8 !important;
}

/* ── Search bar ── */
.ws-search-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-bottom: 1px solid #e5e7eb;
    flex-wrap: wrap;
    background: #fffaf5;
}
.ws-search-field {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.ws-search-field label {
    font-size: 10px;
    font-weight: 500;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.ws-search-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.ws-search-input-wrap i {
    position: absolute;
    left: 9px;
    font-size: 13px;
    color: #9CA3AF;
    pointer-events: none;
}
.ws-search-input {
    height: 34px;
    border: 1px solid #D1D5DB;
    border-radius: 6px;
    padding: 0 10px 0 30px;
    font-size: 13px;
    color: #111827;
    background: #fff;
    outline: none;
    min-width: 200px;
    transition: border-color .15s, box-shadow .15s;
}
.ws-search-input:focus {
    border-color: #ea580c;
    box-shadow: 0 0 0 3px rgba(234,88,12,.1);
}
.ws-search-select {
    height: 34px;
    border: 1px solid #D1D5DB;
    border-radius: 6px;
    padding: 0 10px;
    font-size: 13px;
    color: #111827;
    background: #fff;
    outline: none;
    min-width: 140px;
    accent-color: #ea580c;
    transition: border-color .15s, box-shadow .15s;
}
.ws-search-select:focus {
    border-color: #ea580c;
    box-shadow: 0 0 0 3px rgba(234,88,12,.1);
}
.ws-search-count {
    margin-left: auto;
    font-size: 12px;
    color: #6B7280;
    white-space: nowrap;
}
.ws-search-count span { font-weight: 600; color: #ea580c; }
.ws-no-results {
    display: none;
    text-align: center;
    padding: 28px 16px;
    font-size: 13px;
    color: #9CA3AF;
}

/* ── Table wrapper ── */
.table-wrapper { overflow-x: auto; }
.table-wrapper::-webkit-scrollbar       { height: 8px; }
.table-wrapper::-webkit-scrollbar-thumb { background: #fdba74; border-radius: 20px; }

/* ── Print ── */
@media print {
    /* Hide sidebar, topbar, filter bar, logo */
    .sidebar,
    .topbar,
    nav,
    header,
    .no-print,
    .company-logo { display: none !important; }

    /* Reset layout margins injected by the app shell */
    .main-content,
    .content-wrapper,
    .page-content,
    .main,
    .content { margin: 0 !important; padding: 0 !important; }

    /* Container reset */
    .wages-container {
        border: 1px solid #d1d5db !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        margin: 0 !important;
        width: 100% !important;
    }
    .company-header { background: #fff !important; }

    /* Table */
    .wages-table { font-size: 9px !important; min-width: unset !important; width: 100% !important; }
    .wages-table th, .wages-table td { padding: 4px 3px !important; }
    .wages-table thead th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .total-row td { background: #fff7ed !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

    /* Show timestamp */
    .ws-print-ts { display: block !important; }

    @page { size: landscape; margin: 8mm; }
}

/* Timestamp — hidden on screen, shown on print */
.ws-print-ts {
    display: none;
    text-align: right;
    font-size: 10px;
    color: #6b7280;
    padding: 8px 16px 10px;
    border-top: 1px solid #e5e7eb;
    margin-top: 2px;
}

@media (max-width: 768px) {
    .company-header { flex-direction: column; align-items: flex-start; }
    .company-name   { font-size: 22px; }
    .ws-field select { min-width: 120px; }
}
</style>

{{-- ── Filter bar ── --}}
<div class="ws-filter-bar no-print">
    <form method="GET" class="ws-filter-form">
        <div class="ws-filter-group">
            <div class="ws-field">
                <label>Site</label>
                <select name="site_id">
                    <option value="">All Sites</option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>
                            {{ $site->name }}
                        </option>
                    @endforeach
                </select>
            </div>
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
            <div class="ws-field">
                <label>Year</label>
                <select name="year">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="ws-filter-actions">
            <button type="submit" class="ws-btn ws-btn-teal">
                <i class="fas fa-search"></i> View
            </button>
            <button type="button" onclick="window.print()" class="ws-btn ws-btn-orange">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="{{ route('wages.export', [
                'site_id' => request('site_id'),
                'month'   => $month,
                'year'    => $year
            ]) }}" class="ws-btn ws-btn-green">
                <i class="fas fa-file-download"></i>
                Export Excel {{ date('F', mktime(0,0,0,$month,1)) }}
            </a>
        </div>
    </form>
</div>

{{-- ── Wages container ── --}}
<div class="wages-container">

    {{-- Company header --}}
    <div class="company-header">
        <div class="company-header-left">
            <img src="{{ asset('images/projects/logo.png') }}" alt="Awadh Buildmate" class="company-logo">
            <div>
                <div class="company-name">Awadh Buildmate</div>
                <div class="company-tagline">Made for Quality and Trust</div>
                <div class="company-subtitle">Fabrication &middot; Erection &middot; Structural Work</div>
            </div>
        </div>
        <div class="company-header-right">
            <div class="sheet-title">Form XVII &mdash; Register of Wages</div>
            <div class="sheet-month">
                {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}
                @if(request('site_id'))
                    &nbsp;&middot;&nbsp;
                    {{ $sites->firstWhere('id', request('site_id'))->name ?? '' }}
                @endif
            </div>
            <div class="sheet-badge">Wages Register</div>
        </div>
    </div>


    {{-- Search bar (hidden on print) --}}
    <div class="ws-search-bar no-print">
        <div class="ws-search-field">
            <label>Search by name</label>
            <div class="ws-search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="ws-name-search" class="ws-search-input" placeholder="Employee name...">
            </div>
        </div>
        <div class="ws-search-field">
            <label>Category</label>
            <div class="ws-search-input-wrap">
                <i class="fas fa-tag"></i>
                <input type="text" id="ws-category-search" class="ws-search-input" placeholder="Designation...">
            </div>
        </div>
        <div class="ws-search-field">
            <label>Employee type</label>
            <select id="ws-type-filter" class="ws-search-select">
                <option value="">All types</option>
                <option value="Labour">Labour</option>
                <option value="Staff">Staff</option>
            </select>
        </div>
        <div class="ws-search-count">
            Showing <span id="ws-visible-count">—</span> of <span id="ws-total-count">—</span> employees
        </div>
    </div>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="wages-table">
            <thead>
                {{-- Row 1 --}}
                <tr>
                    <th rowspan="2">Sr.</th>
                    <th rowspan="2">Type</th>
                    <th rowspan="2">Name of workman</th>
                    <th rowspan="2">Designation</th>
                    <th rowspan="2">Total<br>present</th>
                    <th rowspan="2">OT<br>hours</th>
                    <th colspan="4" class="group-actual">Actual</th>
                    <th colspan="5" class="group-earned">Earned</th>
                    <th colspan="7" class="group-deduct">Deduction</th>
                    <th rowspan="2" class="col-payable">Total<br>payable</th>
                </tr>
                {{-- Row 2 --}}
                <tr>
                    <th class="sub-actual">Basic</th>
                    <th class="sub-actual">HRA</th>
                    <th class="sub-actual">Allow.</th>
                    <th class="sub-actual">Gross</th>
                    <th class="sub-earned">Basic</th>
                    <th class="sub-earned">HRA</th>
                    <th class="sub-earned">Convye.</th>
                    <th class="sub-earned">OT amt</th>
                    <th class="sub-earned">Gross</th>
                    <th class="sub-deduct">PF</th>
                    <th class="sub-deduct">ESIC</th>
                    <th class="sub-deduct">PT</th>
                    <th class="sub-deduct">ADV</th>
                    <th class="sub-deduct">LWF</th>
                    <th class="sub-deduct">Others</th>
                    <th class="sub-deduct">Total<br>ded.</th>
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

                    $finalOtHours       = ($salary->overtime_hours ?? 0) * ($salary->ot_rate_multiplier ?? 1);
                    $totalOTHours       = ($finalOtHours) * 2;

                    $actualGross        = ($salary->employee->basic_salary ?? 0)
                                        + ($salary->employee->hra ?? 0)
                                        + ($salary->employee->other_allowance ?? 0);

                    $earnedGross        = ($salary->earned_basic ?? 0)
                                        + ($salary->earned_hra ?? 0)
                                        + ($salary->earned_other_allowance ?? 0)
                                        + ($salary->overtime_amount ?? 0);

                    $totalPayable       = $salary->net_salary ?? 0;

                    $presentDays        = $salary->employee_type == 'Staff'
                                        ? ($salary->paid_days ?? 0) + ($salary->week_off ?? 0)
                                        : $labourpaidDays;

                    $totalPaidDays        += $presentDays;
                    $totalOtHours         += $totalOTHours;
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
                    <td style="text-align:left;padding-left:10px;font-weight:500;">{{ $salary->employee->name }}</td>
                    <td>{{ $salary->employee->category ?? $salary->employee->designation }}</td>
                    <td>{{ number_format($presentDays, 1) }}</td>
                    <td>{{ number_format($effectiveOtHours, 1) }}</td>
                    <td>{{ number_format($salary->employee->basic_salary ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->employee->hra ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->employee->other_allowance ?? 0, 0) }}</td>
                    <td><strong>{{ number_format($actualGross, 0) }}</strong></td>
                    <td>{{ number_format($salary->earned_basic ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->earned_hra ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->earned_other_allowance ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->overtime_amount ?? 0, 0) }}</td>
                    <td><strong>{{ number_format($earnedGross, 0) }}</strong></td>
                    <td>{{ number_format($salary->pf_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->esic_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->pt_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->advance_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->lwf_deduction ?? 0, 0) }}</td>
                    <td>{{ number_format($salary->other_deduction ?? 0, 0) }}</td>
                    <td><strong>{{ number_format($salary->total_deduction ?? 0, 0) }}</strong></td>
                    <td class="td-payable"><strong>{{ number_format($totalPayable, 0) }}</strong></td>
                </tr>
                @endforeach

                {{-- No results row --}}
                <tr id="ws-no-results-row" style="display:none;">
                    <td colspan="23" style="text-align:center;padding:28px 16px;font-size:13px;color:#9CA3AF;">
                        <i class="fas fa-search" style="margin-right:6px;"></i> No employees match your search.
                    </td>
                </tr>

                {{-- Total row --}}
                <tr class="total-row">
                    <td colspan="4" style="text-align:right;font-size:11px;font-weight:500;color:#6B7280;text-transform:uppercase;letter-spacing:.4px;">Total</td>
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
                    <td class="td-payable"><strong>{{ number_format($grandTotalPayable, 0) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Print timestamp (hidden on screen, shown on print) --}}
    <div class="ws-print-ts">
        Printed on: <span id="ws-print-time"></span>
    </div>

</div>

<script>
    document.getElementById('ws-print-time').textContent = new Date().toLocaleString('en-IN', {
        day: '2-digit', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit', hour12: true
    });
</script>

<script>
(function () {
    var nameInput     = document.getElementById('ws-name-search');
    var categoryInput = document.getElementById('ws-category-search');
    var typeSelect    = document.getElementById('ws-type-filter');
    var visibleCount  = document.getElementById('ws-visible-count');
    var totalCount    = document.getElementById('ws-total-count');
    var noResultsRow  = document.getElementById('ws-no-results-row');

    // Data rows only (exclude total-row and no-results-row)
    var rows = Array.from(document.querySelectorAll('.wages-table tbody tr')).filter(function(r) {
        return !r.classList.contains('total-row') && r.id !== 'ws-no-results-row';
    });

    totalCount.textContent = rows.length;
    visibleCount.textContent = rows.length;

    function filter() {
        var name     = nameInput.value.trim().toLowerCase();
        var category = categoryInput.value.trim().toLowerCase();
        var type     = typeSelect.value.toLowerCase();
        var shown    = 0;

        rows.forEach(function(row) {
            var cells      = row.querySelectorAll('td');
            var rowType    = cells[1] ? cells[1].textContent.trim().toLowerCase() : '';
            var rowName    = cells[2] ? cells[2].textContent.trim().toLowerCase() : '';
            var rowCat     = cells[3] ? cells[3].textContent.trim().toLowerCase() : '';

            var match = (!name     || rowName.includes(name))
                     && (!category || rowCat.includes(category))
                     && (!type     || rowType === type);

            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });

        visibleCount.textContent = shown;
        noResultsRow.style.display = shown === 0 ? '' : 'none';
    }

    nameInput.addEventListener('input', filter);
    categoryInput.addEventListener('input', filter);
    typeSelect.addEventListener('change', filter);

    // Init count
    filter();
    visibleCount.textContent = rows.length;
})();
</script>

@endsection