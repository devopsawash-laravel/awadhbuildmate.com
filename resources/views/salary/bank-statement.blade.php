@extends('layouts.app')

@section('title', 'Bank Statement')

@section('content')

{{-- ───────── TOOLBAR (no-print) ───────── --}}
<div class="bs-toolbar no-print">

    <div class="bs-toolbar-left"></div>

    <form method="GET" class="bs-toolbar-form">

        {{-- Site --}}
        <div class="bs-filter-group">
            <label class="bs-filter-label">Site</label>
            <select name="site_id" class="bs-select">
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
        <div class="bs-filter-group">
            <label class="bs-filter-label">Month</label>
            <select name="month" class="bs-select">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- Year --}}
        <div class="bs-filter-group">
            <label class="bs-filter-label">Year</label>
            <select name="year" class="bs-select">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- Actions --}}
        <div class="bs-toolbar-actions">
            <button type="submit" class="bs-btn bs-btn-default">
                <i class="fas fa-search"></i> View
            </button>
            <button type="button" onclick="window.print()" class="bs-btn bs-btn-dark">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="{{ route('salary.bankstatement.export', [
                    'site_id' => request('site_id'),
                    'month'   => $month,
                    'year'    => $year,
                ]) }}"
               class="bs-btn bs-btn-success">
                <i class="fas fa-file-excel"></i>
                Export {{ date('F', mktime(0,0,0,$month,1)) }}
            </a>
        </div>

    </form>

</div>


{{-- ───────── DOCUMENT CARD ───────── --}}
<div class="bs-document">

    {{-- Header --}}
    <div class="bs-doc-header">

        <div class="bs-brand">
            <img src="{{ asset('images/projects/logo.png') }}"
                 alt="Awadh Buildmate Logo"
                 class="bs-logo">
            <div class="bs-brand-text">
                <div class="bs-company-name">AWADH BUILDMATE</div>
                <div class="bs-company-tag">Build with Quality and Trust</div>
                <div class="bs-company-sub">Fabrication &nbsp;|&nbsp; Erection &nbsp;|&nbsp; Structural Work</div>
            </div>
        </div>

        <div class="bs-doc-meta">
            <div class="bs-doc-title">BANK STATEMENT</div>
            <div class="bs-doc-period">
                {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
            </div>
        </div>

    </div>

    {{-- Sub-header --}}
    <div class="bs-subheader">
        <span class="bs-subheader-title">Salary Disbursement</span>
        <span class="bs-subheader-period">
            {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
        </span>
    </div>

    {{-- Table --}}
    <div class="bs-table-wrap">
        <table class="bs-table">
            <thead>
                <tr>
                    <th class="col-sr">Sr No</th>
                    <th class="col-type">Type</th>
                    <th class="col-account">Account Number</th>
                    <th class="col-name">Employee Name</th>
                    <th class="col-ifsc">IFSC</th>
                    <th class="col-amount">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statement as $i => $item)
                <tr>
                    <td class="td-sr">{{ $i + 1 }}</td>
                    <td><span class="bs-badge">NEFT</span></td>
                    <td class="td-mono">{{ $item['account_number'] ?? '—' }}</td>
                    <td class="td-name">{{ $item['name'] ?? '—' }}</td>
                    <td class="td-mono">{{ $item['ifsc'] ?? '—' }}</td>
                    <td class="td-amount">₹{{ number_format($item['amount']) }}</td>
                </tr>
                @endforeach

                {{-- Total row --}}
                <tr class="bs-total-row">
                    <td colspan="5" class="td-total-label">Total Payable</td>
                    <td class="td-total-amount">₹{{ number_format($totalAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="bs-doc-footer">
        <span>Generated on {{ now()->format('d M Y') }}</span>
        <span>Awadh Buildmate &mdash; Confidential</span>
    </div>

</div>

@endsection


@push('styles')
<style>

/* ═══════════════════════════════════════
   RESET / BASE
═══════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }

/* ═══════════════════════════════════════
   TOOLBAR
═══════════════════════════════════════ */
.bs-toolbar {
    display: flex;
    justify-content: flex-end;
    align-items: flex-end;
    gap: 16px;
    flex-wrap: wrap;
    padding-bottom: 20px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e5e7eb;
}

.bs-toolbar-form {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.bs-filter-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.bs-filter-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #6b7280;
}

.bs-select {
    padding: 8px 10px;
    font-size: 13px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: #fff;
    color: #111827;
    min-width: 150px;
    height: 36px;
    outline: none;
    transition: border-color 0.15s;
}
.bs-select:focus { border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,.1); }

.bs-toolbar-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.bs-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0 16px;
    height: 36px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.15s, border-color 0.15s;
}

.bs-btn-default {
    background: #fff;
    color: #374151;
}
.bs-btn-default:hover { background: #f9fafb; border-color: #9ca3af; }

.bs-btn-dark {
    background: #1f2937;
    color: #fff;
    border-color: #1f2937;
}
.bs-btn-dark:hover { background: #111827; }

.bs-btn-success {
    background: #0f6e56;
    color: #fff;
    border-color: #0f6e56;
}
.bs-btn-success:hover { background: #085041; }

/* ═══════════════════════════════════════
   DOCUMENT CARD
═══════════════════════════════════════ */
.bs-document {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
}

/* ── Doc Header ── */
.bs-doc-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 28px;
    border-bottom: 3px solid #ea580c;
}

.bs-brand {
    display: flex;
    align-items: center;
    gap: 14px;
}

.bs-logo {
    width: 64px;
    height: 64px;
    object-fit: contain;
    flex-shrink: 0;
}

.bs-brand-text { line-height: 1; }

.bs-company-name {
    font-size: 22px;
    font-weight: 800;
    color: #ea580c;
    letter-spacing: 0.01em;
}

.bs-company-tag {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-top: 5px;
}

.bs-company-sub {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 3px;
}

.bs-doc-meta { text-align: right; }

.bs-doc-title {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    letter-spacing: 0.05em;
}

.bs-doc-period {
    font-size: 13px;
    color: #6b7280;
    margin-top: 4px;
}

/* ── Sub-header ── */
.bs-subheader {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 28px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.bs-subheader-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #6b7280;
}

.bs-subheader-period {
    font-size: 11px;
    color: #9ca3af;
}

/* ── Table ── */
.bs-table-wrap { overflow-x: auto; }

.bs-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.bs-table thead th {
    padding: 11px 16px;
    background: #f3f4f6;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #6b7280;
    text-align: left;
    border: 1px solid #d1d5db;
    white-space: nowrap;
}

.bs-table thead th.col-amount { text-align: right; padding-right: 28px; }
.bs-table thead th.col-sr     { padding-left: 28px; width: 72px; }
.bs-table thead th.col-type   { width: 90px; }
.bs-table thead th.col-account{ width: 200px; }
.bs-table thead th.col-ifsc   { width: 160px; }
.bs-table thead th.col-amount { width: 130px; }

.bs-table tbody td {
    padding: 13px 16px;
    font-size: 13px;
    color: #111827;
    border: 1px solid #d1d5db;
    vertical-align: middle;
}

.bs-table tbody tr:hover td { background: #fafafa; }

.td-sr    { padding-left: 28px !important; font-size: 12px; color: #9ca3af; }
.td-mono  { font-family: 'Courier New', Courier, monospace; font-size: 12px; color: #6b7280; }
.td-name  { font-weight: 500; }
.td-amount{ text-align: right; padding-right: 28px !important; font-weight: 600; color: #111827; }

.bs-badge {
    display: inline-block;
    padding: 3px 9px;
    background: #e1f5ee;
    color: #0f6e56;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.04em;
}

/* ── Total Row ── */
.bs-total-row td {
    padding: 14px 16px !important;
    background: #f0fdf4 !important;
    border-top: 2px solid #d1fae5 !important;
}

.td-total-label {
    text-align: right;
    padding-right: 16px !important;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #374151 !important;
}

.td-total-amount {
    text-align: right;
    padding-right: 28px !important;
    font-size: 16px;
    font-weight: 700;
    color: #0f6e56 !important;
}

/* ── Doc Footer ── */
.bs-doc-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 28px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    font-size: 11px;
    color: #9ca3af;
}

/* ═══════════════════════════════════════
   PRINT
═══════════════════════════════════════ */
@media print {
    .no-print { display: none !important; }

    body { background: #fff !important; }

    .bs-document {
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }

    .bs-doc-header { padding: 16px 0; }
    .bs-subheader  { padding: 8px 0; }

    .bs-table thead th,
    .bs-table tbody td { padding: 9px 12px; }

    .td-sr    { padding-left: 0 !important; }
    .td-amount{ padding-right: 0 !important; }
    .td-total-amount { padding-right: 0 !important; }
    .td-total-label  { padding-right: 12px !important; }

    .bs-doc-footer { padding: 8px 0; }
}

</style>
@endpush