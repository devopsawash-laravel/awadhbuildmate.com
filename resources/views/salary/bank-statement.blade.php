@extends('layouts.app')

@section('title', 'Bank Statement')

@section('content')

<style>
*, *::before, *::after { box-sizing: border-box; }

/* ── Filter bar ── */
.bs-filter {
    background: #fff;
    border: 0.5px solid #E5E7EB;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-end;
    gap: 12px;
    flex-wrap: wrap;
}
.bs-filter-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-width: 250px;
}
.bs-filter-group label {
    font-size: 11px;
    font-weight: 500;
    color: #6B7280;
    text-transform: uppercase;
    letter-spacing: .6px;
}
.bs-filter-group select {
    border: 0.5px solid #D1D5DB;
    border-radius: 8px;
    padding: 7px 10px;
    font-size: 13px;
    background: #fff;
    color: #111827;
    min-width: 140px;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
    accent-color: #D85A30;
}
.bs-filter-group select:focus {
    border-color: #D85A30;
    box-shadow: 0 0 0 3px rgba(216,90,48,.12);
}
.bs-filter-actions {
    display: flex;
    gap: 8px;
    margin-left: auto;
    align-items: flex-end;
}

/* ── Buttons ── */
.bs-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    border: 0.5px solid transparent;
    text-decoration: none;
    white-space: nowrap;
    line-height: 1.4;
    transition: background .15s, filter .1s;
}
.bs-btn:hover  { filter: brightness(0.92); }
.bs-btn:active { filter: brightness(0.85); transform: translateY(1px); }
.bs-btn-teal   { background: #1D9E75; border-color: #0F6E56; color: #fff; }
.bs-btn-orange { background: #D85A30; border-color: #993C1D; color: #fff; }
.bs-btn-green  { background: #639922; border-color: #3B6D11; color: #fff; }

/* ── Company header ── */
.bs-header {
    background: #fff;
    border: 0.5px solid #E5E7EB;
    border-radius: 12px;
    padding: 20px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.bs-header-left { display: flex; align-items: center; gap: 16px; }
.bs-logo {
    width: 54px; height: 54px;
    border-radius: 12px;
    object-fit: contain;
    flex-shrink: 0;
}
.bs-company-name { font-size: 21px; font-weight: 500; color: #111827; letter-spacing: -.3px; }
.bs-company-tag  { font-size: 12px; color: #6B7280; margin-top: 3px; }
.bs-company-sub  {
    font-size: 11px; color: #9CA3AF; margin-top: 4px;
    display: flex; align-items: center; gap: 7px;
}
.bs-dot { width: 3px; height: 3px; border-radius: 50%; background: #D1D5DB; display: inline-block; }
.bs-header-right { text-align: right; }
.bs-doc-label { font-size: 11px; font-weight: 500; color: #9CA3AF; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 4px; }
.bs-doc-title { font-size: 22px; font-weight: 500; color: #111827; letter-spacing: -.4px; }
.bs-doc-month { font-size: 13px; color: #6B7280; margin-top: 3px; }
.bs-doc-badge {
    display: inline-block; margin-top: 6px;
    padding: 3px 10px; border-radius: 20px;
    background: #E1F5EE; color: #085041;
    font-size: 11px; font-weight: 500;
}

/* ── Summary cards ── */
.bs-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}
.bs-summary-card {
    background: #fff;
    border: 0.5px solid #E5E7EB;
    border-radius: 12px;
    padding: 16px 18px;
    position: relative;
    overflow: hidden;
}
.bs-summary-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 3px; height: 100%;
    background: var(--accent);
    border-radius: 3px 0 0 3px;
}
.bs-sc-label { font-size: 11px; font-weight: 500; color: #6B7280; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px; }
.bs-sc-value { font-size: 22px; font-weight: 500; color: #111827; }
.bs-sc-sub   { font-size: 12px; color: #9CA3AF; margin-top: 3px; }

/* ── Table card ── */
.bs-card {
    background: #fff;
    border: 0.5px solid #E5E7EB;
    border-radius: 12px;
    overflow: hidden;
}
.bs-card-header {
    padding: 14px 20px;
    border-bottom: 0.5px solid #E5E7EB;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.bs-card-header-left { display: flex; align-items: center; gap: 10px; }
.bs-card-title { font-size: 14px; font-weight: 500; color: #111827; }
.bs-card-count {
    font-size: 12px; color: #6B7280;
    background: #F3F4F6;
    padding: 2px 9px; border-radius: 20px;
}
.bs-card-period { font-size: 12px; color: #9CA3AF; }

/* ── Search bar ── */
.bs-search-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-bottom: 0.5px solid #E5E7EB;
    flex-wrap: wrap;
    background: #FAFAFA;
}
.bs-search-field {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.bs-search-field label {
    font-size: 10px;
    font-weight: 500;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.bs-search-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.bs-search-input-wrap i {
    position: absolute;
    left: 9px;
    font-size: 12px;
    color: #9CA3AF;
    pointer-events: none;
}
.bs-search-input {
    height: 34px;
    border: 0.5px solid #D1D5DB;
    border-radius: 7px;
    padding: 0 10px 0 30px;
    font-size: 13px;
    color: #111827;
    background: #fff;
    outline: none;
    min-width: 200px;
    transition: border-color .15s, box-shadow .15s;
}
.bs-search-input:focus {
    border-color: #D85A30;
    box-shadow: 0 0 0 3px rgba(216,90,48,.1);
}
.bs-search-select {
    height: 34px;
    border: 0.5px solid #D1D5DB;
    border-radius: 7px;
    padding: 0 10px;
    font-size: 13px;
    color: #111827;
    background: #fff;
    outline: none;
    min-width: 140px;
    accent-color: #D85A30;
    transition: border-color .15s, box-shadow .15s;
}
.bs-search-select:focus {
    border-color: #D85A30;
    box-shadow: 0 0 0 3px rgba(216,90,48,.1);
}
.bs-search-count {
    margin-left: auto;
    font-size: 12px;
    color: #6B7280;
    white-space: nowrap;
}
.bs-search-count span { font-weight: 600; color: #D85A30; }

/* ── Table ── */
.bs-table-wrap { overflow-x: auto; }
.bs-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.bs-table thead th {
    padding: 11px 16px;
    text-align: left;
    font-size: 11px; font-weight: 500;
    color: #6B7280;
    text-transform: uppercase;
    letter-spacing: .5px;
    border-bottom: 0.5px solid #E5E7EB;
    white-space: nowrap;
    background: #F9FAFB;
}
.bs-table thead th:last-child { text-align: right; }
.bs-table tbody td {
    padding: 13px 16px;
    border-bottom: 0.5px solid #F3F4F6;
    color: #111827;
    vertical-align: middle;
}
.bs-table tbody tr:last-child td { border-bottom: none; }
.bs-table tbody tr:hover td { background: #F9FAFB; }
.bs-table tfoot td {
    padding: 14px 16px;
    background: #F9FAFB;
    border-top: 0.5px solid #E5E7EB;
}

/* ── Cell styles ── */
.bs-sr { font-size: 12px; color: #9CA3AF; font-weight: 500; font-variant-numeric: tabular-nums; }
.bs-type-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 20px;
    background: #E1F5EE; color: #085041;
    font-size: 11px; font-weight: 500;
}
.bs-emp-name { font-weight: 500; color: #111827; }
.bs-emp-type {
    display: inline-block;
    padding: 2px 9px; border-radius: 12px;
    font-size: 11px; font-weight: 500;
}
.bs-type-labour { background: #E6F1FB; color: #185FA5; }
.bs-type-staff  { background: #FAEEDA; color: #854F0B; }
.bs-mono { font-family: ui-monospace, monospace; font-size: 12px; color: #6B7280; }
.bs-amount { font-size: 14px; font-weight: 500; color: #111827; font-variant-numeric: tabular-nums; }
.bs-total-label { font-size: 12px; font-weight: 500; color: #6B7280; text-transform: uppercase; letter-spacing: .5px; text-align: right; }
.bs-total-amt   { font-size: 18px; font-weight: 500; color: #0F6E56; text-align: right; font-variant-numeric: tabular-nums; }

/* ── Print ── */
@media print {
    .no-print    { display: none !important; }
    .bs-summary  { display: none !important; }
    .bs-search-bar { display: none !important; }
    .bs-card, .bs-header { border: 0.5px solid #E5E7EB !important; }
    .bs-table thead th {
        background: #F9FAFB !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .bs-print-ts {
        display: block !important;
        position: fixed; bottom: 12px; right: 16px;
        font-size: 10px; color: #9CA3AF; text-align: right;
    }
}
@media screen { .bs-print-ts { display: none; } }
</style>

{{-- ── Filter bar (hidden on print) ── --}}
<div class="bs-filter no-print">
    <form method="GET" style="display: contents;">
        <div class="bs-filter-group">
            <label>Site</label>
            <select name="site_id" id="site_id" style="width: 250px;">
                <option value="">All Sites</option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="bs-filter-group">
            <label>Month</label>
            <select name="month" id="month">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="bs-filter-group">
            <label>Year</label>
            <select name="year" id="year">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="bs-filter-actions">
            <button type="submit" class="bs-btn bs-btn-teal">
                <i class="fas fa-search"></i> View
            </button>
            <button type="button" onclick="window.print()" class="bs-btn bs-btn-orange">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="{{ route('salary.bankstatement.export', [
                    'site_id' => request('site_id'),
                    'month'   => $month,
                    'year'    => $year
                ]) }}" class="bs-btn bs-btn-green">
                <i class="fas fa-file-excel"></i> Export {{ date('F', mktime(0,0,0,$month,1)) }}
            </a>
        </div>
    </form>
</div>

{{-- ── Company header ── --}}
<div class="bs-header">
    <div class="bs-header-left">
        <img src="{{ asset('images/projects/logo.png') }}" alt="Awadh Buildmate" class="bs-logo" style="object-fit: contain; padding: 4px;">
        <div>
            <div class="bs-company-name">Awadh Buildmate</div>
            <div class="bs-company-tag">Made for Quality and Trust</div>
            <div class="bs-company-sub">
                Fabrication
                <span class="bs-dot"></span>
                Erection
                <span class="bs-dot"></span>
                Structural Work
            </div>
        </div>
    </div>
    <div class="bs-header-right">
        <div class="bs-doc-label">Document</div>
        <div class="bs-doc-title">Bank Statement</div>
        <div class="bs-doc-month">
            {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
        </div>
        <div class="bs-doc-badge">NEFT Transfer</div>
    </div>
</div>

{{-- ── Summary cards ── --}}
@php
    $labourCount = collect($statement)->where('employee_type', 'Labour')->count();
    $staffCount  = collect($statement)->where('employee_type', 'Staff')->count();
    $totalCount  = count($statement);
    $avgSalary   = $totalCount > 0 ? $totalAmount / $totalCount : 0;
@endphp
<div class="bs-summary">
    <div class="bs-summary-card" style="--accent: #1D9E75;">
        <div class="bs-sc-label">Total Payable</div>
        <div class="bs-sc-value">&#8377;{{ number_format($totalAmount, 2) }}</div>
        <div class="bs-sc-sub">{{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}</div>
    </div>
    <div class="bs-summary-card" style="--accent: #185FA5;">
        <div class="bs-sc-label">Employees</div>
        <div class="bs-sc-value">{{ $totalCount }}</div>
        <div class="bs-sc-sub">Labour {{ $labourCount }} &middot; Staff {{ $staffCount }}</div>
    </div>
    <div class="bs-summary-card" style="--accent: #854F0B;">
        <div class="bs-sc-label">Avg. Salary</div>
        <div class="bs-sc-value">&#8377;{{ number_format($avgSalary, 0) }}</div>
        <div class="bs-sc-sub">per employee</div>
    </div>
</div>

{{-- ── Statement table ── --}}
<div class="bs-card">
    <div class="bs-card-header">
        <div class="bs-card-header-left">
            <i class="fas fa-university" style="font-size:16px;color:#9CA3AF;"></i>
            <span class="bs-card-title">Salary Bank Statement</span>
            <span class="bs-card-count" id="bs-entry-count">{{ $totalCount }} entries</span>
        </div>
        <span class="bs-card-period">
            {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
        </span>
    </div>

    {{-- ── Search bar (hidden on print) ── --}}
    <div class="bs-search-bar no-print">
        <div class="bs-search-field">
            <label>Search by name</label>
            <div class="bs-search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="bs-name-search" class="bs-search-input" placeholder="Employee name...">
            </div>
        </div>
        <div class="bs-search-field">
            <label>Employee type</label>
            <select id="bs-type-filter" class="bs-search-select">
                <option value="">All types</option>
                <option value="labour">Labour</option>
                <option value="staff">Staff</option>
            </select>
        </div>
        <div class="bs-search-count">
            Showing <span id="bs-visible-count">{{ $totalCount }}</span> of <span id="bs-total-count">{{ $totalCount }}</span> entries
        </div>
    </div>

    <div class="bs-table-wrap">
        <table class="bs-table" id="bs-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Account number</th>
                    <th>Employee</th>
                    <th>Category</th>
                    <th>IFSC</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody id="bs-tbody">
                @foreach($statement as $i => $item)
                <tr
                    data-name="{{ strtolower($item['name'] ?? '') }}"
                    data-type="{{ strtolower($item['employee_type'] ?? '') }}"
                >
                    <td><span class="bs-sr">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span></td>
                    <td>
                        <span class="bs-type-badge">
                            <i class="fas fa-exchange-alt" style="font-size:10px;"></i>
                            NEFT
                        </span>
                    </td>
                    <td><span class="bs-mono">{{ $item['account_number'] ?? '—' }}</span></td>
                    <td><span class="bs-emp-name">{{ $item['name'] ?? '—' }}</span></td>
                    <td>
                        <span class="bs-emp-type {{ strtolower($item['employee_type']) === 'labour' ? 'bs-type-labour' : 'bs-type-staff' }}">
                            {{ $item['employee_type'] }}
                        </span>
                    </td>
                    <td><span class="bs-mono">{{ $item['ifsc'] ?? '—' }}</span></td>
                    <td style="text-align:right;">
                        <span class="bs-amount">&#8377;{{ number_format($item['amount'], 2) }}</span>
                    </td>
                </tr>
                @endforeach

                {{-- No results row --}}
                <tr id="bs-no-results" style="display:none;">
                    <td colspan="7" style="text-align:center;padding:28px 16px;font-size:13px;color:#9CA3AF;">
                        <i class="fas fa-search" style="margin-right:6px;"></i> No employees match your search.
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="bs-total-label">Total payable</td>
                    <td class="bs-total-amt">&#8377;{{ number_format($totalAmount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="bs-print-ts">
        Printed on: <span id="bs-print-time"></span>
    </div>
</div>

<script>
    document.getElementById('bs-print-time').textContent = new Date().toLocaleString('en-IN', {
        day: '2-digit', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit', hour12: true
    });

    (function () {
        var nameInput    = document.getElementById('bs-name-search');
        var typeSelect   = document.getElementById('bs-type-filter');
        var visibleCount = document.getElementById('bs-visible-count');
        var totalCount   = document.getElementById('bs-total-count');
        var noResults    = document.getElementById('bs-no-results');
        var entryCount   = document.getElementById('bs-entry-count');

        var rows = Array.from(document.querySelectorAll('#bs-tbody tr')).filter(function(r) {
            return r.id !== 'bs-no-results';
        });

        var total = rows.length;
        totalCount.textContent = total;

        function filter() {
            var name = nameInput.value.trim().toLowerCase();
            var type = typeSelect.value.toLowerCase();
            var shown = 0;

            rows.forEach(function(row) {
                var rowName = (row.dataset.name || '').toLowerCase();
                var rowType = (row.dataset.type || '').toLowerCase();

                var match = (!name || rowName.includes(name))
                         && (!type || rowType === type);

                row.style.display = match ? '' : 'none';
                if (match) shown++;
            });

            visibleCount.textContent = shown;
            entryCount.textContent   = shown + ' entries';
            noResults.style.display  = shown === 0 ? '' : 'none';
        }

        nameInput.addEventListener('input', filter);
        typeSelect.addEventListener('change', filter);
    })();
</script>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#site_id').select2({ placeholder: "Select Site",  allowClear: true, width: 'resolve' });
        $('#month').select2({   placeholder: "Select Month", allowClear: true, width: 'resolve' });
        $('#year').select2({    placeholder: "Select Year",  allowClear: true, width: 'resolve' });
    });
</script>
@endpush

@endsection