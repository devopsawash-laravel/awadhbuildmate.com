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

    {{-- ROW 1: Filter form --}}
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

    {{-- Full-width separator between rows --}}
    <div class="ss-row-separator"></div>

    {{-- ROW 2: Generate form + Download button together --}}
    <form action="{{ route('staff-salary.generate') }}" method="POST" class="ss-bar-form ss-gen-form">
        @csrf
        <input type="hidden" name="month" value="{{ request('month', now()->month) }}">
        <input type="hidden" name="year"  value="{{ request('year',  now()->year)  }}">

        {{-- STAFF --}}
        <div class="ss-bar-group ss-bar-staff">
            <label class="ss-bar-label">SELECT STAFF</label>
            <select name="staff_id" id="staff_id" class="ss-bar-select" required>
                <option value="">— Choose Staff —</option>
                @foreach($staffs as $staff)
                    <option value="{{ $staff->id }}"
                            data-working-days="{{ $staff->working_days ?? 30 }}"
                            data-total-salary="{{ $staff->total_salary ?? 0 }}">
                        {{ $staff->name }} ({{ $staff->employee_id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="ss-bar-divider"></div>

        {{-- TOTAL SALARY --}}
        <div class="ss-bar-group">
            <label class="ss-bar-label">TOTAL SALARY</label>
            <input type="number" name="total_salary" id="total_salary"
                   class="ss-days-input" min="0" placeholder="Salary" required>
        </div>

        <div class="ss-bar-divider"></div>

        {{-- DAILY WAGE --}}
        <div class="ss-bar-group">
            <label class="ss-bar-label">DAILY WAGE</label>
            <input type="text" id="daily_wage" class="ss-days-input ss-readonly" readonly>
        </div>

        <div class="ss-bar-divider"></div>

        {{-- PRESENT DAYS --}}
        <div class="ss-bar-group">
            <label class="ss-bar-label">PRESENT DAYS</label>
            <input type="number" name="present_days" id="present_days"
                   class="ss-days-input" min="0" max="31" placeholder="Days" required>
        </div>

        <div class="ss-bar-divider"></div>

        {{-- WEEK OFF --}}
        <div class="ss-bar-group">
            <label class="ss-bar-label">WEEK OFF</label>
            <input type="number" name="week_off" id="week_off"
                   class="ss-days-input" min="0" value="0" placeholder="Week Off">
        </div>

        <div class="ss-bar-divider"></div>

        {{-- ESTIMATED SALARY --}}
        <div class="ss-bar-group">
            <label class="ss-bar-label">ESTIMATED SALARY</label>
            <input type="text" id="estimated_salary" class="ss-days-input ss-readonly" readonly>
        </div>

        <div class="ss-bar-divider"></div>

        {{-- GENERATE + DOWNLOAD side by side --}}
    
            <a href="{{ route('staff-salary.bulkpdfstaff', [
                    'month'   => $month,
                    'year'    => $year,
                    'site_id' => request('site_id')
                ]) }}"
                class="ss-glossy-btn ss-glossy-btn-blue"
                target="_blank">
                <i class="fas fa-file-pdf"></i>
                <span>Download All Payslips</span>
            </a>
    <div class="ss-bar-group ss-bar-group-btn ss-btn-pair">
            <button type="submit" class="ss-glossy-btn ss-glossy-btn-green">
                <i class="fas fa-file-signature"></i>
                <span>Generate Salary Slip</span>
            </button>
        </div>

    </form>
</div>

{{-- FORMULA NOTE --}}
<div class="ss-formula-box">
    <i class="fas fa-info-circle"></i>
    {{-- Salary = (Present Days &times; Daily Wage) + (OT Hours &times; OT Rate &times; Multiplier) &minus; PF &minus; Pending Advances --}}
    Salary = (Paid Days × Daily Wage) − Deductions
<br>
<small>Paid Days = Present Days + Week Off (as per Joining Date eligibility)</small>
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
                    <th>SR.NO</th>
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
                    <td class="col-center">{{ $loop->iteration }}</td>

                    <td>
                        <div class="ss-emp-name">{{ $salary->staff->name }}</div>
                        <div class="ss-emp-id">{{ $salary->staff->employee_id }}</div>
                    </td>

                    <td>{{ $salary->staff->site->name ?? '—' }}</td>

                    <td>{{ $salary->staff->category ?? '—' }}</td>

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
    gap: 5px;
    height: 36px;
    padding: 0 14px;
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

/* ─── VIEW BUTTON (Glossy Teal) ─── */
.ss-bar-btn-view {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 10px 20px;
    min-height: 38px;
    width: max-content;
    flex-shrink: 0;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #fff !important;
    cursor: pointer;
    border: none;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    letter-spacing: 0.01em;
    white-space: nowrap;
    line-height: 1.3;

    background: linear-gradient(180deg,
        #5eead4 0%,
        #14b8a6 30%,
        #0d9488 60%,
        #0f766e 100%
    );

    box-shadow:
        0 1px 0 rgba(255,255,255,0.45) inset,
        0 -1px 0 rgba(0,0,0,0.3) inset,
        0 0 0 1px #0f6460,
        0 4px 14px rgba(13,148,136,0.55),
        0 1px 3px rgba(0,0,0,0.3);

    transition: box-shadow 0.15s, transform 0.15s, filter 0.15s;
}

.ss-bar-btn-view::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 52%;
    background: linear-gradient(180deg,
        rgba(255,255,255,0.40) 0%,
        rgba(255,255,255,0.05) 100%
    );
    border-radius: 10px 10px 60% 60%;
    pointer-events: none;
}

.ss-bar-btn-view::after {
    content: '';
    position: absolute;
    top: -60%; left: -60%;
    width: 40%; height: 200%;
    background: linear-gradient(105deg,
        transparent 35%,
        rgba(255,255,255,0.26) 50%,
        transparent 65%
    );
    transform: skewX(-15deg);
    animation: gloss-sweep 2.8s ease-in-out infinite;
    pointer-events: none;
}

.ss-bar-btn-view i {
    font-size: 15px;
    filter: drop-shadow(0 1px 1px rgba(0,0,0,0.3));
    position: relative;
    z-index: 1;
}

.ss-bar-btn-view:hover {
    filter: brightness(1.1);
    transform: translateY(-2px);
    color: #fff !important;
    text-decoration: none;
    box-shadow:
        0 1px 0 rgba(255,255,255,0.45) inset,
        0 -1px 0 rgba(0,0,0,0.3) inset,
        0 0 0 1px #0f6460,
        0 8px 24px rgba(13,148,136,0.65),
        0 2px 6px rgba(0,0,0,0.25);
}

.ss-bar-btn-view:active {
    filter: brightness(0.95);
    transform: translateY(1px);
    background: linear-gradient(180deg,
        #0f766e 0%,
        #0d9488 50%,
        #5eead4 100%
    );
    box-shadow:
        0 1px 0 rgba(255,255,255,0.3) inset,
        0 -1px 0 rgba(0,0,0,0.3) inset,
        0 0 0 1px #0f6460,
        0 2px 8px rgba(13,148,136,0.4);
}

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

/* Bulk download CSS */
/* Download All Payslips Button */
.ss-bar-btn-download {
    display: inline-flex;
    align-items: center;
    gap: 10px;

    padding: 12px 22px;
    border-radius: 10px;

    background: linear-gradient(180deg,
        #5b9bff 0%,
        #2563eb 45%,
        #1a4fc7 100%
    );

    color: #fff !important;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;

    position: relative;
    overflow: hidden;

    transition: all 0.3s ease;
    box-shadow:
        0 4px 15px rgba(37, 99, 235, 0.4),
        0 1px 0 rgba(255,255,255,0.15) inset,
        0 -1px 0 rgba(0,0,0,0.2) inset;
}

/* Glossy shine overlay */
.ss-bar-btn-download::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 50%;
    background: linear-gradient(180deg,
        rgba(255,255,255,0.35) 0%,
        rgba(255,255,255,0.08) 100%
    );
    border-radius: 10px 10px 50% 50%;
    pointer-events: none;
}

/* Moving shimmer sweep */
.ss-bar-btn-download::after {
    content: '';
    position: absolute;
    top: -50%; left: -75%;
    width: 50%;
    height: 200%;
    background: linear-gradient(105deg,
        transparent 40%,
        rgba(255,255,255,0.25) 50%,
        transparent 60%
    );
    transform: skewX(-15deg);
    animation: gloss-sweep 3s ease-in-out infinite;
    pointer-events: none;
}

@keyframes gloss-sweep {
    0%   { left: -75%; }
    60%  { left: 125%; }
    100% { left: 125%; }
}

.ss-bar-btn-download i {
    font-size: 16px;
    filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
}

.ss-bar-btn-download:hover {
    background: linear-gradient(180deg,
        #74aeff 0%,
        #2f6ef5 45%,
        #1e50d4 100%
    );
    transform: translateY(-2px);
    box-shadow:
        0 8px 25px rgba(37, 99, 235, 0.5),
        0 1px 0 rgba(255,255,255,0.2) inset,
        0 -1px 0 rgba(0,0,0,0.2) inset;
    color: #fff !important;
    text-decoration: none;
}

.ss-bar-btn-download:active {
    transform: translateY(1px);
    box-shadow:
        0 2px 8px rgba(37, 99, 235, 0.3),
        0 1px 0 rgba(255,255,255,0.1) inset;
    background: linear-gradient(180deg,
        #1a4fc7 0%,
        #2563eb 55%,
        #5b9bff 100%
    );
}
/* ─── ROW SEPARATOR (between filter row and generate row) ─── */
.ss-row-separator {
    width: 100%;
    height: 1px;
    background: #e2e8f0;
    margin: 4px 0;
}

/* ─── BUTTON PAIR ─── */
.ss-btn-pair {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: nowrap;
}

/* ─── GLOSSY BUTTON BASE ─── */
/* ─── GLOSSY BUTTON BASE ─── */
.ss-glossy-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 10px 20px;
    min-height: 38px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #fff !important;
    cursor: pointer;
    border: none;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    letter-spacing: 0.01em;
    white-space: nowrap;
    line-height: 1.3;
    width: max-content;        /* ← KEY FIX: button sizes to its own text */
    flex-shrink: 0;            /* ← never shrink below text width */
    transition: box-shadow 0.15s, transform 0.15s, filter 0.15s;
}

/* Top glass dome */
.ss-glossy-btn::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 52%;
    background: linear-gradient(180deg,
        rgba(255,255,255,0.40) 0%,
        rgba(255,255,255,0.05) 100%
    );
    border-radius: 10px 10px 60% 60%;
    pointer-events: none;
}

/* Sweep shimmer */
.ss-glossy-btn::after {
    content: '';
    position: absolute;
    top: -60%; left: -60%;
    width: 40%; height: 200%;
    background: linear-gradient(105deg,
        transparent 35%,
        rgba(255,255,255,0.26) 50%,
        transparent 65%
    );
    transform: skewX(-15deg);
    animation: gloss-sweep 2.8s ease-in-out infinite;
    pointer-events: none;
}

@keyframes gloss-sweep {
    0%   { left: -60%; }
    55%  { left: 130%; }
    100% { left: 130%; }
}

.ss-glossy-btn i {
    font-size: 15px;
    filter: drop-shadow(0 1px 1px rgba(0,0,0,0.3));
    position: relative; z-index: 1;
}
.ss-glossy-btn span { position: relative; z-index: 1; }

.ss-glossy-btn:hover  { filter: brightness(1.1); transform: translateY(-2px); }
.ss-glossy-btn:active { filter: brightness(0.95); transform: translateY(1px); }

/* ─── BLUE variant (Download) ─── */
.ss-glossy-btn-blue {
    background: linear-gradient(180deg, #6eb0ff 0%, #3b82f6 30%, #2563eb 60%, #1d4ed8 100%);
    box-shadow:
        0 1px 0 rgba(255,255,255,0.45) inset,
        0 -1px 0 rgba(0,0,0,0.3) inset,
        0 0 0 1px #1a40b8,
        0 4px 14px rgba(37,99,235,0.5);
}
.ss-glossy-btn-blue:hover {
    box-shadow:
        0 1px 0 rgba(255,255,255,0.45) inset,
        0 -1px 0 rgba(0,0,0,0.3) inset,
        0 0 0 1px #1a40b8,
        0 8px 24px rgba(37,99,235,0.6);
    color: #fff !important;
    text-decoration: none;
}

/* ─── GREEN variant (Generate) ─── */
.ss-glossy-btn-green {
    background: linear-gradient(180deg, #4ade80 0%, #22c55e 30%, #16a34a 60%, #15803d 100%);
    box-shadow:
        0 1px 0 rgba(255,255,255,0.45) inset,
        0 -1px 0 rgba(0,0,0,0.3) inset,
        0 0 0 1px #166534,
        0 4px 14px rgba(22,163,74,0.5);
}
.ss-glossy-btn-green:hover {
    box-shadow:
        0 1px 0 rgba(255,255,255,0.45) inset,
        0 -1px 0 rgba(0,0,0,0.3) inset,
        0 0 0 1px #166534,
        0 8px 24px rgba(22,163,74,0.6);
    color: #fff !important;
    text-decoration: none;
}
.ss-bar-group-btn {
    display: flex;
    align-items: center;
}

.ss-bar-btn-view {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0.3px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;

    background: linear-gradient(175deg, #fb923c 0%, #ea580c 55%, #c2410c 100%);
    color: #fff;
    box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 0.25);
}

.ss-bar-btn-view::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 50%;
    background: rgba(255, 255, 255, 0.18);
    border-radius: 10px 10px 50% 50% / 10px 10px 6px 6px;
    pointer-events: none;
}

.ss-bar-btn-view:hover {
    transform: translateY(-2px);
    filter: brightness(1.08);
    box-shadow: 0 8px 20px rgba(234, 88, 12, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.25);
    color: #fff;
}

.ss-bar-btn-view:active {
    transform: scale(0.97);
    filter: brightness(0.96);
    box-shadow: 0 2px 6px rgba(234, 88, 12, 0.3);
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
