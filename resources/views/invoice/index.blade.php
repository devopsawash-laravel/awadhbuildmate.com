@extends('layouts.app')

@section('title', 'Invoices — Awadh Buildmate')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --brand:         #C2410C;
  --brand-mid:     #EA580C;
  --brand-light:   #FFF7ED;
  --brand-border:  #FDBA74;

  --surface:       #FFFFFF;
  --surface-2:     #FAFAF9;
  --surface-3:     #F5F0EB;
  --border:        #E7E3DC;
  --border-md:     #D6CFC5;

  --text-1:        #111827;
  --text-2:        #4B5563;
  --text-3:        #9CA3AF;

  --green:         #065F46;
  --green-bg:      #D1FAE5;
  --amber:         #92400E;
  --amber-bg:      #FEF3C7;
  --red:           #991B1B;
  --red-bg:        #FEE2E2;

  --radius-sm:     5px;
  --radius-md:     8px;
  --radius-lg:     12px;
  --shadow-xs:     0 1px 2px rgba(0,0,0,0.05);
  --shadow-sm:     0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
  --shadow-md:     0 4px 12px rgba(0,0,0,0.07), 0 1px 3px rgba(0,0,0,0.05);
}

body {
  font-family: 'Inter', sans-serif;
  background: var(--surface-2);
  color: var(--text-1);
  min-height: 100vh;
  font-size: 13.5px;
  line-height: 1.55;
  -webkit-font-smoothing: antialiased;
}

/* ═══ TOPBAR ═══ */
.topbar {
  position: sticky; top: 0; z-index: 200;
  background: var(--surface);
  height: 60px;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 32px;
  border-bottom: 1px solid var(--border);
  box-shadow: var(--shadow-xs);
}
.topbar-left { display: flex; align-items: center; gap: 12px; }
.topbar-logo {
  width: 44px; height: 44px; border-radius: 10px;
  overflow: hidden; flex-shrink: 0;
  border: 1px solid var(--border);
}
.topbar-logo img { width: 100%; height: 100%; object-fit: cover; }
.topbar-name { font-size: 15px; font-weight: 700; color: var(--text-1); letter-spacing: -0.01em; }
.topbar-sub  { font-size: 11px; color: var(--text-3); margin-top: 1px; }
.topbar-divider { display: none; }
.topbar-nav     { display: none; }

.btn {
  display: inline-flex; align-items: center; gap: 6px;
  border: none; border-radius: var(--radius-md);
  padding: 8px 16px; font-size: 12.5px; font-weight: 600;
  cursor: pointer; font-family: 'Inter', sans-serif;
  text-decoration: none; letter-spacing: 0.01em;
  transition: all 0.15s;
}
.btn-white {
  background: #fff; color: var(--brand);
  box-shadow: 0 1px 4px rgba(0,0,0,0.12);
}
.btn-white:hover { background: var(--brand-light); color: var(--brand); }
.btn-primary {
  background: var(--brand-mid); color: #fff;
  box-shadow: 0 2px 8px rgba(234,88,12,0.35);
}
.btn-primary:hover { background: var(--brand); }

/* ═══ PAGE LAYOUT ═══ */
.page-wrap { max-width: 1180px; margin: 0 auto; padding: 28px 24px 48px; }

/* ═══ BREADCRUMB + HEADER ═══ */
.breadcrumb {
  display: flex; align-items: center; gap: 6px;
  font-size: 11.5px; color: var(--text-3); margin-bottom: 16px;
}
.breadcrumb i { font-size: 12px; }
.breadcrumb a { color: var(--text-3); text-decoration: none; }
.breadcrumb a:hover { color: var(--brand-mid); }
.breadcrumb span { color: var(--text-2); font-weight: 500; }

.page-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 24px; gap: 16px; flex-wrap: wrap;
}
.page-title {
  font-size: 22px; font-weight: 700; color: var(--text-1);
  letter-spacing: -0.03em; line-height: 1.2;
}
.page-subtitle {
  font-size: 12.5px; color: var(--text-3); margin-top: 4px; font-weight: 400;
}
.page-header-right { display: flex; align-items: center; gap: 10px; }

/* ═══ STATS ═══ */
.stats-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 14px; margin-bottom: 24px;
}
.stat-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--radius-lg); padding: 18px 20px;
  box-shadow: var(--shadow-xs);
  position: relative; overflow: hidden;
}
.stat-card::before {
  content: ''; position: absolute; top: 0; left: 0;
  width: 3px; height: 100%;
  border-radius: var(--radius-lg) 0 0 var(--radius-lg);
}
.stat-card.blue::before  { background: var(--brand-mid); }
.stat-card.gold::before  { background: var(--gold); }
.stat-card.green::before { background: #10B981; }
.stat-card.red::before   { background: #EF4444; }

.stat-inner { display: flex; align-items: flex-start; justify-content: space-between; }
.stat-icon {
  width: 36px; height: 36px; border-radius: var(--radius-md);
  display: flex; align-items: center; justify-content: center; font-size: 17px;
}
.stat-card.blue  .stat-icon { background: var(--brand-light); color: var(--brand-mid); }
.stat-card.gold  .stat-icon { background: var(--gold-bg);     color: var(--gold); }
.stat-card.green .stat-icon { background: #D1FAE5;             color: #059669; }
.stat-card.red   .stat-icon { background: #FEE2E2;             color: #EF4444; }
.stat-label { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.7px; margin-bottom: 5px; }
.stat-val { font-family: 'JetBrains Mono', monospace; font-size: 20px; font-weight: 600; color: var(--text-1); letter-spacing: -0.02em; }
.stat-meta { font-size: 11px; color: var(--text-3); margin-top: 3px; }

/* ═══ TOOLBAR ═══ */
.toolbar {
  display: flex; align-items: center; gap: 10px;
  margin-bottom: 12px; flex-wrap: wrap;
}
.search-wrap { position: relative; flex: 1; min-width: 240px; max-width: 380px; }
.search-wrap i {
  position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
  color: var(--text-3); font-size: 14px; pointer-events: none;
}
.search-wrap input {
  width: 100%; height: 36px;
  border: 1px solid var(--border-md); border-radius: var(--radius-md);
  padding: 0 10px 0 34px; font-size: 13px;
  font-family: 'Inter', sans-serif; color: var(--text-1);
  background: var(--surface);
  transition: border-color 0.15s, box-shadow 0.15s;
}
.search-wrap input:focus {
  outline: none; border-color: var(--brand-mid);
  box-shadow: 0 0 0 3px rgba(234,88,12,0.12);
}
.search-wrap input::placeholder { color: var(--text-3); }
.toolbar-right { display: flex; align-items: center; gap: 8px; margin-left: auto; }
.toolbar-count {
  font-size: 12px; color: var(--text-3);
  background: var(--surface-3); border: 1px solid var(--border);
  border-radius: 999px; padding: 4px 12px; white-space: nowrap; font-weight: 500;
}

/* ═══ TABLE CARD ═══ */
.table-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--radius-lg); overflow: hidden;
  box-shadow: var(--shadow-sm);
}

.inv-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.inv-table thead tr {
  background: var(--surface-2);
  border-bottom: 1px solid var(--border);
}
.inv-table thead th {
  padding: 10px 16px; font-size: 10.5px; font-weight: 700;
  color: var(--text-3); text-transform: uppercase; letter-spacing: 0.8px;
  text-align: left; white-space: nowrap;
}
.inv-table thead th.r { text-align: center; }

.inv-table tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background 0.1s;
}
.inv-table tbody tr:last-child { border-bottom: none; }
.inv-table tbody tr:hover { background: #FAFBFF; }
.inv-table tbody td { padding: 13px 16px; vertical-align: middle; }
.inv-table tbody td.r { text-align: right; }

/* Cell styles */
.cell-billno {
  font-family: 'JetBrains Mono', monospace; font-size: 11.5px; font-weight: 600;
  color: var(--brand); background: var(--brand-light);
  border: 1px solid var(--brand-border);
  border-radius: 4px; padding: 3px 8px; display: inline-block; letter-spacing: 0.01em;
}
.cell-date { font-family: 'JetBrains Mono', monospace; font-size: 11.5px; color: var(--text-3); }
.cell-party-name { font-weight: 600; font-size: 13px; color: var(--text-1); }
.cell-party-co   { font-size: 11.5px; color: var(--text-3); margin-top: 1px; }
.cell-grand {
  font-family: 'JetBrains Mono', monospace; font-size: 13px;
  font-weight: 600; color: var(--text-1);
}
.cell-pending {
  font-family: 'JetBrains Mono', monospace; font-size: 12.5px;
  font-weight: 600; color: var(--red);
}

/* Received form inline */
.received-form { display: flex; align-items: center; gap: 7px; justify-content: flex-end; }
.received-input {
  width: 110px; height: 32px;
  padding: 0 10px;
  border: 1px solid var(--border-md); border-radius: var(--radius-sm);
  font-size: 12.5px; font-family: 'JetBrains Mono', monospace;
  color: var(--text-1); background: var(--surface);
  transition: border-color 0.15s, box-shadow 0.15s;
  text-align: right;
}
.received-input:focus {
  outline: none; border-color: var(--brand-mid);
  box-shadow: 0 0 0 3px rgba(234,88,12,0.1);
}
.save-btn {
  height: 32px; padding: 0 12px;
  border: 1px solid var(--border-md); border-radius: var(--radius-sm);
  background: var(--surface-3); color: var(--text-2);
  font-size: 11.5px; font-weight: 600; font-family: 'Inter', sans-serif;
  cursor: pointer; transition: background 0.15s, color 0.15s, border-color 0.15s;
  white-space: nowrap;
}
.save-btn:hover {
  background: var(--brand); color: #fff; border-color: var(--brand);
}

/* Badge */
.badge {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 3px 10px; border-radius: 999px;
  font-size: 11px; font-weight: 600; letter-spacing: 0.3px;
}
.badge-dot {
  width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0;
}
.badge-success { background: var(--green-bg); color: var(--green); }
.badge-success .badge-dot { background: #10B981; }
.badge-warning { background: var(--amber-bg); color: var(--amber); }
.badge-warning .badge-dot { background: #F59E0B; }
.badge-danger  { background: var(--red-bg);   color: var(--red); }
.badge-danger .badge-dot  { background: #EF4444; }

/* Action buttons */
.actions { display: flex; gap: 5px; justify-content: flex-end; align-items: center; }
.act-btn {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 5px 10px; height: 30px;
  border-radius: var(--radius-sm); font-size: 11.5px; font-weight: 600;
  cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none;
  border: 1px solid var(--border-md);
  background: var(--surface-3); color: var(--text-2);
  transition: all 0.15s; white-space: nowrap;
}
.act-btn:hover { background: var(--surface); color: var(--text-1); border-color: var(--border-md); }
.act-btn.view {
  background: var(--brand-light); color: var(--brand);
  border-color: var(--brand-border);
}
.act-btn.view:hover { background: var(--brand); color: #fff; border-color: var(--brand); }
.act-btn.del {
  color: var(--red); border-color: #FECACA; background: var(--red-bg);
  padding: 5px 8px;
}
.act-btn.del:hover { background: #FCA5A5; color: var(--red); }

/* ═══ EMPTY ═══ */
.empty-state {
  display: flex; flex-direction: column; align-items: center;
  justify-content: center; padding: 80px 24px; text-align: center;
}
.empty-icon {
  width: 60px; height: 60px; background: var(--surface-3); border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 26px; margin-bottom: 14px; color: var(--text-3);
}
.empty-title { font-size: 15px; font-weight: 700; color: var(--text-2); margin-bottom: 5px; }
.empty-sub   { font-size: 13px; color: var(--text-3); margin-bottom: 18px; }

.no-results {
  padding: 40px 24px; text-align: center;
  font-size: 13px; color: var(--text-3); display: none;
}
.no-results i { font-size: 26px; margin-bottom: 8px; display: block; opacity: 0.35; }

/* ═══ PAGINATION ═══ */
.pagination-wrap {
  display: flex; align-items: center; justify-content: space-between;
  padding: 12px 20px; border-top: 1px solid var(--border);
  background: var(--surface-2); font-size: 12px; color: var(--text-3);
  flex-wrap: wrap; gap: 10px;
}
.pagination-wrap nav { display: flex; }
.pagination-wrap .pagination { display: flex; gap: 3px; list-style: none; margin: 0; }
.pagination-wrap .pagination li > a,
.pagination-wrap .pagination li > span {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 30px; height: 30px; padding: 0 8px;
  border: 1px solid var(--border-md); border-radius: var(--radius-sm);
  font-size: 12px; font-weight: 600; text-decoration: none;
  color: var(--text-2); background: var(--surface);
  transition: background 0.15s, color 0.15s;
}
.pagination-wrap .pagination li > a:hover {
  background: var(--brand-light); color: var(--brand); border-color: var(--brand-border);
}
.pagination-wrap .pagination li.active > span {
  background: var(--brand); color: #fff; border-color: var(--brand);
}
.pagination-wrap .pagination li.disabled > span { opacity: 0.4; }

/* ═══ TOAST ═══ */
.toast {
  position: fixed; bottom: 28px; right: 28px; z-index: 9999;
  display: flex; align-items: flex-start; gap: 12px;
  background: #fff; border: 1px solid #A7F3D0;
  border-left: 4px solid #10B981;
  border-radius: var(--radius-lg);
  padding: 14px 16px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.1), 0 2px 8px rgba(0,0,0,0.05);
  min-width: 300px; max-width: 400px;
  animation: slideIn 0.3s cubic-bezier(.21,1.02,.73,1) forwards;
  overflow: hidden;
}
.toast.hide { animation: slideOut 0.25s ease forwards; }
.toast-icon {
  width: 34px; height: 34px; flex-shrink: 0;
  background: #D1FAE5; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 17px; color: #065F46;
}
.toast-title { font-size: 13px; font-weight: 700; color: var(--text-1); margin-bottom: 2px; }
.toast-sub   { font-size: 11.5px; color: var(--text-3); }
.toast-close {
  margin-left: auto; background: none; border: none;
  cursor: pointer; color: var(--text-3); font-size: 16px;
  padding: 2px; line-height: 1; flex-shrink: 0;
}
.toast-close:hover { color: var(--text-1); }
.toast-progress {
  position: absolute; bottom: 0; left: 0;
  height: 2px; background: #10B981;
  animation: progress 4s linear forwards;
}
@keyframes slideIn {
  from { opacity: 0; transform: translateX(16px); }
  to   { opacity: 1; transform: translateX(0); }
}
@keyframes slideOut {
  from { opacity: 1; transform: translateX(0); }
  to   { opacity: 0; transform: translateX(16px); }
}
@keyframes progress {
  from { width: 100%; } to { width: 0%; }
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 768px) {
  .topbar { padding: 0 16px; }
  .topbar-nav { display: none; }
  .page-wrap { padding: 20px 14px 40px; }
  .stats-row { grid-template-columns: 1fr 1fr; }
  .inv-table { font-size: 12px; }
  .inv-table thead th:nth-child(2),
  .inv-table tbody td:nth-child(2) { display: none; }
  .received-input { width: 80px; }
}
</style>
@endpush

@section('content')

<header class="topbar">
  <div class="topbar-left">
    <div class="topbar-logo">
      <img src="/images/projects/logo.png" alt="Awadh Buildmate">
    </div>
    <div>
      <div class="topbar-name">Awadh Buildmate</div>
      <div class="topbar-sub">Made For Quality and Trust</div>
    </div>
  </div>
  <a href="{{ route('invoices.create') }}" class="btn btn-primary">
    <i class="ti ti-plus" style="font-size:14px;"></i> New Invoice
  </a>
</header>

<div class="page-wrap">



  {{-- Stats --}}
  @php
    $allInvoices     = \App\Models\Invoice::all();
    $totalBill       = $allInvoices->sum('grand_total');
    $totalReceived   = $allInvoices->sum('received_amount');
    $totalReceivable = $allInvoices->sum(fn($i) => max(0, $i->grand_total - $i->received_amount));
    $paidCount       = $allInvoices->where('payment_status', 'Received')->count();
  @endphp

  <div class="stats-row">
    <div class="stat-card blue">
      <div class="stat-inner">
        <div>
          <div class="stat-label">Total Invoices</div>
          <div class="stat-val">{{ $invoices->total() }}</div>
          <div class="stat-meta">{{ $paidCount }} fully paid</div>
        </div>
        <div class="stat-icon"><i class="ti ti-file-invoice"></i></div>
      </div>
    </div>
    <div class="stat-card gold">
      <div class="stat-inner">
        <div>
          <div class="stat-label">Total Billed</div>
          <div class="stat-val">₹{{ number_format($totalBill, 0) }}</div>
          <div class="stat-meta">across all invoices</div>
        </div>
        <div class="stat-icon"><i class="ti ti-report-money"></i></div>
      </div>
    </div>
    <div class="stat-card green">
      <div class="stat-inner">
        <div>
          <div class="stat-label">Received</div>
          <div class="stat-val">₹{{ number_format($totalReceived, 0) }}</div>
          <div class="stat-meta">payments collected</div>
        </div>
        <div class="stat-icon"><i class="ti ti-circle-check"></i></div>
      </div>
    </div>
    <div class="stat-card red">
      <div class="stat-inner">
        <div>
          <div class="stat-label">Outstanding</div>
          <div class="stat-val">₹{{ number_format($totalReceivable, 0) }}</div>
          <div class="stat-meta">yet to collect</div>
        </div>
        <div class="stat-icon"><i class="ti ti-clock-dollar"></i></div>
      </div>
    </div>
  </div>

  {{-- Toolbar --}}
  <div class="toolbar">
    <div class="search-wrap">
      <i class="ti ti-search"></i>
      <input type="text" id="searchInput" placeholder="Search by bill no., client name…" oninput="filterTable(this.value)">
    </div>
    <div class="toolbar-right">
      <span class="toolbar-count" id="visibleCount">
        {{ $invoices->count() }} of {{ $invoices->total() }} invoices
      </span>
    </div>
  </div>

  {{-- Table --}}
  <div class="table-card">
    @if($invoices->count())

    <table class="inv-table" id="invoiceTable">
      <thead>
        <tr>
          <th>Bill No.</th>
          <th>Date</th>
          <th>Client</th>
          <th class="r">Grand Total</th>
          <th class="r">Received</th>
          <th class="r">Outstanding</th>
          <th>Status</th>
          <th class="r">Actions</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @foreach($invoices as $invoice)
        <tr data-search="{{ strtolower($invoice->bill_no . ' ' . $invoice->to_name . ' ' . ($invoice->to_co ?? '')) }}">

          <td><span class="cell-billno">#{{ $invoice->bill_no }}</span></td>

          <td><span class="cell-date">{{ \Carbon\Carbon::parse($invoice->bill_date)->format('d M Y') }}</span></td>

          <td>
            <div class="cell-party-name">{{ $invoice->to_name }}</div>
            @if($invoice->to_co)
              <div class="cell-party-co">{{ $invoice->to_co }}</div>
            @endif
          </td>

          <td class="r">
            <span class="cell-grand">₹{{ number_format($invoice->grand_total, 0) }}</span>
          </td>

          <td class="r">
            <form action="{{ route('invoice.update-payment', $invoice->id) }}" method="POST" class="received-form">
              @csrf
              <input
                type="number"
                name="received_amount"
                value="{{ $invoice->received_amount }}"
                min="0"
                max="{{ $invoice->grand_total }}"
                step="0.01"
                class="received-input"
              >
              <button type="submit" class="save-btn">Save</button>
            </form>
          </td>

          <td class="r">
            @php $pending = max(0, $invoice->grand_total - $invoice->received_amount); @endphp
            @if($pending > 0)
              <span class="cell-pending">₹{{ number_format($pending, 0) }}</span>
            @else
              <span style="font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--text-3);">—</span>
            @endif
          </td>

          <td>
            @if($invoice->payment_status == 'Received')
              <span class="badge badge-success"><span class="badge-dot"></span> Received</span>
            @elseif($invoice->payment_status == 'Partial')
              <span class="badge badge-warning"><span class="badge-dot"></span> Partial</span>
            @else
              <span class="badge badge-danger"><span class="badge-dot"></span> Pending</span>
            @endif
          </td>

          <td class="r">
            <div class="actions">
              <a href="{{ route('invoice.show', $invoice->id) }}" class="act-btn view">
                <i class="ti ti-eye" style="font-size:13px;"></i> View
              </a>
              <a href="{{ route('invoice.edit', $invoice->id) }}" class="act-btn view">
                <i class="ti ti-pen" style="font-size:13px;"></i> Edit
              </a>
              <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST"
                    onsubmit="return confirm('Delete invoice #{{ $invoice->bill_no }}? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit" class="act-btn del" title="Delete invoice">
                  <i class="ti ti-trash" style="font-size:13px;"></i>
                </button>
              </form>
            </div>
          </td>

        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="no-results" id="noResults">
      <i class="ti ti-search-off"></i>
      No invoices match your search.
    </div>

    <div class="pagination-wrap">
      <span>Page {{ $invoices->currentPage() }} of {{ $invoices->lastPage() }}</span>
      {{ $invoices->links() }}
    </div>

    @else
    <div class="empty-state">
      <div class="empty-icon"><i class="ti ti-file-off"></i></div>
      <div class="empty-title">No invoices yet</div>
      <div class="empty-sub">Create your first invoice to start tracking payments.</div>
      <a href="{{ route('invoices.create') }}" class="btn btn-primary">
        <i class="ti ti-plus" style="font-size:14px;"></i> Create Invoice
      </a>
    </div>
    @endif
  </div>

</div>

@if(session('success'))
<div class="toast" id="toast">
  <div class="toast-icon"><i class="ti ti-circle-check"></i></div>
  <div>
    <div class="toast-title">Invoice Saved</div>
    <div class="toast-sub">{{ session('success') }}</div>
  </div>
  <button class="toast-close" onclick="dismissToast()" aria-label="Close">
    <i class="ti ti-x"></i>
  </button>
  <div class="toast-progress"></div>
</div>
@endif

@endsection

@push('scripts')
<script>
function filterTable(q) {
  const term  = q.toLowerCase().trim();
  const rows  = document.querySelectorAll('#tableBody tr');
  let visible = 0;

  rows.forEach(row => {
    const match = !term || (row.dataset.search || '').includes(term);
    row.style.display = match ? '' : 'none';
    if (match) visible++;
  });

  document.getElementById('noResults').style.display =
    (visible === 0 && term) ? 'block' : 'none';

  document.getElementById('visibleCount').textContent = term
    ? `${visible} result${visible !== 1 ? 's' : ''} found`
    : `{{ $invoices->count() }} of {{ $invoices->total() }} invoices`;
}

function dismissToast() {
  const t = document.getElementById('toast');
  if (!t) return;
  t.classList.add('hide');
  setTimeout(() => t.remove(), 250);
}

@if(session('success'))
  setTimeout(dismissToast, 4000);
@endif
</script>
@endpush