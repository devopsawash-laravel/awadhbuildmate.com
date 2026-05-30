@extends('layouts.app')

@section('title', 'Bank Statement')

@section('content')

<style>
/* ── Orange theme variables ── */
:root {
    --oa: #FFF7F0;
    --ob: #FFF0E0;
    --oc: #FFE4C8;
    --od: #F97316;
    --oe: #EA6000;
    --o-text: #7C2D00;
    --o-muted: #A84500;
    --o-border: #FDDBB4;
}

/* ── Filter bar ── */
.bs-filter {
    background: var(--oa);
    border: 1px solid var(--oc);
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 16px;
    display: flex;
    gap: 12px;
    align-items: flex-end;
    flex-wrap: wrap;
    justify-content: flex-end;
}
.bs-filter label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    color: var(--o-muted);
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-bottom: 4px;
}
.bs-filter select {
    border: 1px solid var(--oc);
    border-radius: 7px;
    padding: 7px 10px;
    font-size: 13px;
    background: #fff;
    color: #333;
    outline: none;
    min-width: 130px;
}
.bs-filter select:focus { border-color: var(--od); }
.bs-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    white-space: nowrap;
}
.bs-btn-primary   { background: var(--od); color: #fff; }
.bs-btn-primary:hover { background: var(--oe); color: #fff; }
.bs-btn-outline   { background: #fff; border: 1.5px solid var(--od); color: var(--od); }
.bs-btn-outline:hover { background: var(--ob); }
.bs-btn-green     { background: #fff; border: 1.5px solid #16A34A; color: #16A34A; }
.bs-btn-green:hover { background: #F0FDF4; }

/* ── Company header ── */
.bs-company {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 16px;
    margin-bottom: 16px;
    border-bottom: 1px solid var(--oc);
}
.bs-company-left  { display: flex; align-items: center; gap: 14px; }
.bs-company-logo  { width: 68px; height: 68px; object-fit: contain; }
.bs-company-name  { font-size: 24px; font-weight: 800; color: var(--od); line-height: 1; }
.bs-company-tag   { font-size: 12px; color: #374151; font-weight: 600; margin-top: 5px; }
.bs-company-sub   { font-size: 11px; color: #6B7280; margin-top: 3px; }
.bs-company-right { text-align: right; }
.bs-sheet-title   { font-size: 20px; font-weight: 700; color: #111827; }
.bs-sheet-month   { font-size: 13px; color: var(--o-muted); margin-top: 3px; }

/* ── Card ── */
.bs-card {
    background: #fff;
    border: 1px solid var(--o-border);
    border-radius: 10px;
    overflow: hidden;
}
.bs-card-header {
    background: var(--ob);
    padding: 10px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--oc);
}
.bs-card-header h2 { font-size: 14px; font-weight: 700; color: var(--o-text); margin: 0; }
.bs-card-header span { font-size: 12px; color: var(--o-muted); }

/* ── Table ── */
.bs-table-wrap { overflow-x: auto; }
.bs-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.bs-table thead th {
    background: var(--ob);
    border: 1px solid var(--oc);
    padding: 9px 12px;
    color: var(--o-text);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    white-space: nowrap;
}
.bs-table tbody td {
    border: 1px solid #F3E8DC;
    padding: 9px 12px;
    color: #111827;
}
.bs-table tbody tr:hover td { background: var(--oa); }
.bs-table tbody tr:last-child td {
    background: #F0FDF4;
    font-weight: 700;
    border-top: 2px solid #BBF7D0;
}
.bs-table tfoot td {
    border: 1px solid #F3E8DC;
    padding: 11px 12px;
    background: #F0FDF4;
    font-weight: 700;
    border-top: 2px solid #BBF7D0;
}
.bs-total-amt { color: #16A34A; font-size: 15px; }

/* ── Print styles ── */
@media print {
    .no-print { display: none !important; }
    .bs-card  { border: none; border-radius: 0; }
    .bs-table thead th { background: #f3f4f6 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .bs-company { border-bottom: 1px solid #ddd; }
}

@media screen {
    .print-timestamp { display: none; }
}

@media print {
    .print-timestamp {
        display: block;
        position: fixed;
        bottom: 10px;
        right: 15px;
        font-size: 11px;
        color: #6B7280;
        text-align: right;
    }
}
</style>

{{-- Filter bar (hidden on print) --}}
<div class="bs-filter no-print">
    <form method="GET" style="display:contents;">
        <div>
            <label>Site</label>
            <select name="site_id" style="min-width:200px;">
                <option value="">All Sites</option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Month</label>
            <select name="month">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endfor
            </select>
        </div>
        <div>
            <label>Year</label>
            <select name="year">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="bs-btn bs-btn-primary">
            <i class="fas fa-search"></i> View
        </button>
        <button type="button" onclick="window.print()" class="bs-btn bs-btn-outline">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="{{ route('salary.bankstatement.export', [
                'site_id' => request('site_id'),
                'month'   => $month,
                'year'    => $year
            ]) }}" class="bs-btn bs-btn-green">
            <i class="fas fa-file-excel"></i> Export {{ date('F', mktime(0,0,0,$month,1)) }}
        </a>
    </form>
</div>

{{-- Company header (shows on print) --}}
<div class="bs-company">
    <div class="bs-company-left">
        <img src="{{ asset('images/projects/logo.png') }}" alt="Logo" class="bs-company-logo">
        <div>
          
            <div class="bs-company-name">AWADH BUILDMATE</div>
            <div class="bs-company-tag">Made For Quality and Trust</div>
            <div class="bs-company-sub">Fabrication | Erection | Structural Work</div>
        </div>
    </div>
    <div class="bs-company-right">
        <div class="bs-sheet-title">BANK STATEMENT</div>
        <div class="bs-sheet-month">
            {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
        </div>
    </div>
</div>

{{-- Table card --}}
<div class="bs-card">
    <div class="bs-card-header">
        <h2>Salary Bank Statement</h2>
        <span>{{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}</span>
    </div>
    <div class="bs-table-wrap">
        <table class="bs-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Type</th>
                    <th>Account Number</th>
                    <th>Employee Name</th>
                    <th>Employee Type</th>
                    <th>IFSC</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statement as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>NEFT</td>
                    <td style="font-family:monospace;">{{ $item['account_number'] ?? '—' }}</td>
                    <td>{{ $item['name'] ?? '—' }}</td>
                    <td>{{ $item['employee_type'] }}</td>
                    <td style="font-family:monospace;font-size:12px;">{{ $item['ifsc'] ?? '—' }}</td>
                    <td style="text-align:right;">₹{{ number_format($item['amount'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align:right;text-transform:uppercase;font-size:12px;letter-spacing:.4px;color:#374151;">
                        Total Payable
                    </td>
                    <td class="bs-total-amt" style="text-align:right;">
                        ₹{{ number_format($totalAmount, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="print-timestamp">
    Printed on: <span id="print-time"></span>
</div>
</div>
<script>
    // Set print timestamp
    document.getElementById('print-time').textContent = new Date().toLocaleString('en-IN', {
        day: '2-digit', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
</script>
@endsection