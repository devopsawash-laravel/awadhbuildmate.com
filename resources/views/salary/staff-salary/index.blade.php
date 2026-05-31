@extends('layouts.app')

@section('title', 'Generate Staff Salary Slip')
@section('page-title', 'Generate Staff Salary Slip')

@section('content')

{{-- ───────── PAGE HEADER ───────── --}}
<div class="ss-page-header">
    <div>
        <div class="ss-page-subtitle">Staff Payroll</div>
        <div class="ss-page-title">GENERATE <span class="ss-accent">STAFF SALARY SLIP</span></div>
    </div>
    <div class="ss-header-date">
        <i class="fas fa-calendar-alt"></i>
        {{ now()->format('d M Y') }}
    </div>
</div>

{{-- ───────── COMBINED FILTER + GENERATE BAR ───────── --}}
<div class="ss-bar-card">
    <form method="GET" action="{{ route('staff-salary.index') }}" class="ss-bar-form" id="filterForm">

        
        {{-- SITE --}}
        <div class="ss-bar-group">
            <label class="ss-bar-label">SITE</label>
            <select name="site_id" class="ss-bar-select">
                <option value="">All Sites</option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}"
                        {{ request('site_id') == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ss-bar-divider"></div>

        {{-- MONTH --}}
        <div class="ss-bar-group">
            <label class="ss-bar-label">MONTH</label>
            <select name="month" class="ss-bar-select">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}"
                        {{ request('month', now()->month) == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="ss-bar-divider"></div>

        {{-- YEAR --}}
        <div class="ss-bar-group">
            <label class="ss-bar-label">YEAR</label>
            <select name="year" class="ss-bar-select">
                @for($y = now()->year; $y >= 2024; $y--)
                    <option value="{{ $y }}"
                        {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="ss-bar-divider"></div>

        {{-- VIEW --}}
        <div class="ss-bar-group ss-bar-group-btn">
            <button type="submit" class="ss-bar-btn ss-bar-btn-view">
                <i class="fas fa-search"></i> View
            </button>
        </div>

    </form>

    <div class="ss-bar-separator"></div>

    {{-- GENERATE SLIP (separate POST form, inline) --}}
    <form action="{{ route('staff-salary.generate') }}" method="POST" class="ss-bar-form ss-gen-form">
        @csrf
        <input type="hidden" name="month" value="{{ request('month', now()->month) }}">
        <input type="hidden" name="year"  value="{{ request('year',  now()->year)  }}">

        {{-- STAFF --}}
{{-- STAFF --}}
<div class="ss-bar-group ss-bar-staff">

    <label class="ss-bar-label">
        SELECT STAFF
    </label>

    <select name="staff_id"
            id="staff_id"
            class="ss-bar-select"
            required>

            
        <option value="">
            — Choose Staff —
        </option>

        @foreach($staffs as $staff)

            <option value="{{ $staff->id }}"
                    data-working-days="{{ $staff->working_days ?? 30 }}"
                    data-total-salary="{{ $staff->total_salary ?? 0 }}">

                {{ $staff->name }}
                ({{ $staff->employee_id }})

            </option>

        @endforeach

    </select>

</div>

<div class="ss-bar-divider"></div>

{{-- TOTAL SALARY --}}
<div class="ss-bar-group">

    <label class="ss-bar-label">
        TOTAL SALARY
    </label>

    <input type="number"
           name="total_salary"
           id="total_salary"
           class="ss-days-input"
           min="0"
           placeholder="Salary"
           required>

</div>

<div class="ss-bar-divider"></div>

{{-- DAILY WAGE --}}
<div class="ss-bar-group">

    <label class="ss-bar-label">
        DAILY WAGE
    </label>

    <input type="text"
           id="daily_wage"
           class="ss-days-input ss-readonly"
           readonly>

</div>

<div class="ss-bar-divider"></div>

{{-- PRESENT DAYS --}}
<div class="ss-bar-group">

    <label class="ss-bar-label">
        PRESENT DAYS
    </label>

    <input type="number"
           name="present_days"
           id="present_days"
           class="ss-days-input"
           min="0"
           max="31"
           placeholder="Days"
           required>

</div>

<div class="ss-bar-divider"></div>

{{-- WEEK OFF --}}
<div class="ss-bar-group">

    <label class="ss-bar-label">
        WEEK OFF
    </label>

    <input type="number"
           name="week_off"
           id="week_off"
           class="ss-days-input"
           min="0"
           value="0"
           placeholder="Week Off">

</div>

<div class="ss-bar-divider"></div>

{{-- ESTIMATED SALARY --}}
<div class="ss-bar-group">

    <label class="ss-bar-label">
        ESTIMATED SALARY
    </label>

    <input type="text"
           id="estimated_salary"
           class="ss-days-input ss-readonly"
           readonly>

</div>
        {{-- GENERATE --}}
        <div class="ss-bar-group ss-bar-group-btn">
            <button type="submit" class="ss-bar-btn ss-bar-btn-generate">
                <i class="fas fa-file-signature"></i> Generate Salary Slip
            </button>
        </div>

    </form>
</div>

{{-- FORMULA NOTE --}}
<div class="ss-formula-box">
    <i class="fas fa-info-circle"></i>
    Salary = (Present Days &times; Daily Wage) + (OT Hours &times; OT Rate &times; Multiplier) &minus; PF &minus; Pending Advances
</div>

{{-- ───────── SALARY SLIPS TABLE ───────── --}}
<div class="ss-card">

    <div class="ss-slips-header">
        <div class="ss-slips-title-wrap">
            <div class="ss-card-icon">
                <i class="fas fa-list-alt"></i>
            </div>
            <div class="ss-slips-title">
                SALARY SLIPS &mdash;
                {{ \Carbon\Carbon::create()->month(request('month', now()->month))->format('F') }}
                {{ request('year', now()->year) }}
            </div>
        </div>
        <div class="ss-total-net">
            TOTAL NET: ₹{{ number_format($salarySlips->sum('net_salary'), 0) }}
        </div>
    </div>

    <div class="ss-table-wrap">
        <table class="ss-table">
            <thead>
                <tr>
                    <th>STAFF</th>
                    <th>SITE</th>
                    <th>DEPARTMENT</th>
                    <th class="col-center">DAYS WORKED</th>
                    <th class="col-num">GROSS</th>
                    <th class="col-num">PF</th>
                    <th class="col-num">ADVANCE</th>
                    <th class="col-num">NET SALARY</th>
                    <th class="col-actions">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salarySlips as $salary)
                <tr>

                    <td>
                        <div class="ss-emp-name">{{ $salary->staff->name }}</div>
                        <div class="ss-emp-id">{{ $salary->staff->employee_id }}</div>
                    </td>

                    <td>{{ $salary->staff->site->site_name ?? '—' }}</td>

                    <td>{{ $salary->staff->department ?? '—' }}</td>

                    <td class="col-center">{{  $salary->paid_days }} </td>

                    <td class="col-num">₹{{ number_format($salary->gross_salary, 2) }}</td>

                    <td class="col-num ss-deduction">-₹{{ number_format($salary->pf_deduction, 2) }}</td>

                    <td class="col-num ss-deduction">-₹{{ number_format($salary->advance_deduction, 2) }}</td>

                    <td class="col-num">
                        <span class="ss-net-badge">₹{{ number_format($salary->net_salary, 2) }}</span>
                    </td>

                    <td>
                        <div class="ss-actions">

                            <a href="{{ route('staff-salary.show', $salary->id) }}"
                               class="ss-action-btn ss-btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('staff-salary.payslip', $salary->id) }}"
                               class="ss-action-btn ss-btn-pdf" title="Download PDF" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>

                            {{-- <form action="{{ route('staff-salary.destroy', $salary->id) }}" --}}
                                <form action="{{ route('staff-salary.destroy', $salary->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="ss-action-btn ss-btn-delete"
                                        title="Delete"
                                        onclick="return confirm('Delete this salary slip?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9" class="ss-empty">
                        <i class="fas fa-inbox"></i>
                        No salary slips generated yet for this period.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection


@push('styles')
<style>

*, *::before, *::after { box-sizing: border-box; }

/* ─── PAGE HEADER ─── */
.ss-page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
}

.ss-page-subtitle {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 4px;
}

.ss-page-title {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
}

.ss-accent { color: #2563eb; }

.ss-header-date {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 13px;
    color: #64748b;
}

/* ─── COMBINED BAR CARD ─── */
.ss-bar-card {
    display: flex;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 12px;              /* ← change from 0 to 12px */
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.04);
}

.ss-bar-form {
    display: flex;
    align-items: flex-end;
    gap: 0;
    flex-wrap: wrap;
}

.ss-gen-form {
    display: flex;
    align-items: flex-end;
    flex-wrap: nowrap;
    gap: 0;
    width: 100%;
}

.ss-bar-group-btn {
    justify-content: flex-end;
    padding-right: 0;
    align-self: flex-end;  /* ← add this */
    padding-bottom: 0;
}
/* vertical separator between the two forms */
.ss-bar-separator {
    width: 1px;
    height: 48px;
    background: #e2e8f0;
    margin: 0 16px;
    flex-shrink: 0;
    align-self: flex-end;
}

.ss-bar-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: 0 14px;
    position: relative;
}

/* first group in each form — no left padding */
.ss-bar-form .ss-bar-group:first-child,
.ss-gen-form .ss-bar-group:first-child {
    padding-left: 0;
}

.ss-bar-group-btn {
    justify-content: flex-end;
    padding-right: 0;
}

.ss-bar-label {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.09em;
    color: #94a3b8;
    white-space: nowrap;
}

.ss-bar-select {
    height: 36px;
    padding: 0 10px;
    font-size: 13px;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    background: #f8fafc;
    color: #0f172a;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    min-width: 0;
    width: auto;
}
.ss-bar-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    background: #fff;
}

/* site dropdown slightly wider since site names can be long */
.ss-bar-staff .ss-bar-select { min-width: 200px; }

.ss-bar-divider {
    width: 1px;
    height: 36px;
    background: #e2e8f0;
    align-self: flex-end;
    flex-shrink: 0;
    margin-bottom: 0;
}

/* ─── BAR BUTTONS ─── */
.ss-bar-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    height: 36px;
    padding: 0 16px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 7px;
    border: 1px solid;
    cursor: pointer;
    white-space: nowrap;
    text-decoration: none;
    transition: all 0.15s;
}
.ss-bar-btn:active { transform: scale(0.97); }

.ss-bar-btn-view {
    background: #fff;
    color: #374151;
    border-color: #d1d5db;
}
.ss-bar-btn-view:hover { background: #f1f5f9; border-color: #94a3b8; }

.ss-bar-btn-generate {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
}
.ss-bar-btn-generate:hover { background: #1d4ed8; border-color: #1d4ed8; }

/* ─── FORMULA BOX ─── */
.ss-formula-box {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-left: 4px solid #2563eb;
    border-radius: 8px;
    font-size: 12px;
    color: #1e40af;
    margin-bottom: 18px;
}
.ss-formula-box i { color: #2563eb; flex-shrink: 0; }

/* ─── CARD ─── */
.ss-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.04);
    margin-bottom: 18px;
}

.ss-card-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #dbeafe;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

/* ─── SLIPS HEADER ─── */
.ss-slips-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
    flex-wrap: wrap;
    gap: 10px;
}

.ss-slips-title-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
}

.ss-slips-title {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: 0.05em;
}

.ss-total-net {
    padding: 6px 14px;
    background: #ecfdf5;
    color: #15803d;
    border: 1px solid #86efac;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
}

/* ─── TABLE ─── */
.ss-table-wrap { overflow-x: auto; }

.ss-table {
    width: 100%;
    border-collapse: collapse;
}

.ss-table thead th {
    padding: 11px 14px;
    background: #f1f5f9;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #64748b;
    text-align: left;
    border: 1px solid #e2e8f0;
    white-space: nowrap;
}

.ss-table tbody td {
    padding: 12px 14px;
    font-size: 13px;
    color: #0f172a;
    border: 1px solid #e2e8f0;
    vertical-align: middle;
}

.ss-table tbody tr:hover td { background: #f8fafc; }

.col-center  { text-align: center; }
.col-num     { text-align: right; font-variant-numeric: tabular-nums; }
.col-actions { text-align: center; width: 110px; }

.ss-emp-name { font-weight: 600; color: #0f172a; }
.ss-emp-id   { font-size: 11px; color: #94a3b8; margin-top: 3px; font-family: monospace; }

.ss-deduction { color: #dc2626; }

.ss-net-badge {
    display: inline-block;
    padding: 4px 11px;
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #86efac;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
}

/* ─── ACTION BUTTONS ─── */
.ss-actions {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}

.ss-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    text-decoration: none;
    border: 1px solid transparent;
    cursor: pointer;
    background: none;
    transition: opacity 0.15s, transform 0.1s;
}
.ss-action-btn:hover  { opacity: 0.75; }
.ss-action-btn:active { transform: scale(0.94); }

.ss-btn-view   { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
.ss-btn-pdf    { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
.ss-btn-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

/* ─── EMPTY STATE ─── */
.ss-empty {
    text-align: center;
    padding: 50px 20px;
    color: #94a3b8;
    font-size: 14px;
}
.ss-empty i { font-size: 28px; margin-bottom: 10px; display: block; }

.ss-days-input{
    height:36px;
    padding:0 10px;
    border:1px solid #e2e8f0;
    border-radius:7px;
    background:#f8fafc;
    font-size:13px;
    color:#0f172a;
    min-width:110px;
}

.ss-readonly{
    background:#eff6ff !important;
    color:#2563eb;
    font-weight:700;
}
</style>
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded',function(){

    const staffSelect=document.getElementById('staff_id');

    const presentDaysInput=document.getElementById('present_days');

    const weekOffInput=document.getElementById('week_off');

    const estimatedSalaryInput=document.getElementById('estimated_salary');

    function calculateSalary(){

    let totalSalary=parseFloat(document.getElementById('total_salary').value || 0);

    let selectedMonth=parseInt(document.querySelector('select[name="month"]').value);

    let selectedYear=parseInt(document.querySelector('select[name="year"]').value);

    let totalDaysInMonth=new Date(selectedYear,selectedMonth,0).getDate();

    let dailyWage=totalDaysInMonth>0 ? totalSalary/totalDaysInMonth : 0;

    document.getElementById('daily_wage').value=dailyWage.toFixed(2);

    let presentDays=parseFloat(document.getElementById('present_days').value || 0);

    let weekOff=parseFloat(document.getElementById('week_off').value || 0);

    let estimatedSalary=(presentDays+weekOff)*dailyWage;

    document.getElementById('estimated_salary').value='₹ '+estimatedSalary.toFixed(2);
}

document.getElementById('total_salary').addEventListener('input',calculateSalary);

document.getElementById('present_days').addEventListener('input',calculateSalary);

document.getElementById('week_off').addEventListener('input',calculateSalary);

document.querySelector('select[name="month"]').addEventListener('change',calculateSalary);

document.querySelector('select[name="year"]').addEventListener('change',calculateSalary);

// Staff's salary will be auto-filled when a staff is selected from dropdown, using data attribute from option tag

staffSelect.addEventListener('change', function(){

    let selectedOption = this.options[this.selectedIndex];

    let salary = selectedOption.dataset.totalSalary || 0;

    document.getElementById('total_salary').value = salary;

    calculateSalary();
});

});
</script>
@endpush
