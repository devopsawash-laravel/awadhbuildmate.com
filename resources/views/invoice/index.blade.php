@extends('layouts.app')

@section('title', 'Saved Invoices — Awadh Buildmate')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --accent:        #D85A30;
  --accent-light:  #FDF0EB;
  --accent-border: #F5C4B3;
  --surface:       #FFFFFF;
  --surface-2:     #F8F7F5;
  --surface-3:     #F1EFE8;
  --border:        rgba(0,0,0,0.08);
  --border-md:     rgba(0,0,0,0.14);
  --text-1:        #1A1A18;
  --text-2:        #5F5E5A;
  --text-3:        #888780;
  --green:         #3B6D11;
  --green-bg:      #EAF3DE;
  --red:           #A32D2D;
  --red-bg:        #FCEBEB;
  --radius-sm:     6px;
  --radius-md:     10px;
  --radius-lg:     14px;
  --shadow-sm:     0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
}

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--surface-2);
  color: var(--text-1);
  min-height: 100vh;
  font-size: 14px;
  line-height: 1.5;
}

/* ─── TOPBAR ─── */
.topbar {
  position: sticky; top: 0; z-index: 100;
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  padding: 0 32px;
  display: flex; align-items: center; justify-content: space-between;
  height: 56px;
  box-shadow: var(--shadow-sm);
}
.topbar-brand { display: flex; align-items: center; gap: 10px; }
 .topbar-logo {
  width: auto;
  height: 32px;
  background: transparent;
  border-radius: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}
.topbar-name { font-size: 15px; font-weight: 600; color: var(--text-1); }
.topbar-sub  { font-size: 11px; color: var(--text-3); margin-top: 1px; }

/* ─── PAGE ─── */
.page-wrap { max-width: 1100px; margin: 0 auto; padding: 32px 24px; }

/* ─── PAGE HEADER ─── */
.page-header {
  display: flex; align-items: flex-end; justify-content: space-between;
  margin-bottom: 24px; gap: 16px; flex-wrap: wrap;
}
.page-eyebrow {
  font-size: 10.5px; font-weight: 700; letter-spacing: 1.5px;
  text-transform: uppercase; color: var(--accent); margin-bottom: 4px;
}
.page-title {
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 700; color: var(--text-1); line-height: 1.15;
}
.page-count {
  display: inline-flex; align-items: center; gap: 5px;
  margin-top: 6px; font-size: 12px; color: var(--text-3);
}
.page-count strong { color: var(--text-2); font-weight: 600; }

.btn {
  display: inline-flex; align-items: center; gap: 7px;
  border: none; border-radius: var(--radius-md);
  padding: 10px 18px; font-size: 13px; font-weight: 600;
  cursor: pointer; font-family: 'DM Sans', sans-serif;
  text-decoration: none;
  transition: transform 0.12s, background 0.15s;
}
.btn:active { transform: scale(0.98); }
.btn-primary {
  background: var(--accent); color: #fff;
  box-shadow: 0 2px 8px rgba(216,90,48,0.28);
}
.btn-primary:hover { background: #C2410C; }

/* ─── STATS ─── */
.stats-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 12px; margin-bottom: 24px;
}
.stat-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--radius-md); padding: 16px 18px;
  display: flex; align-items: center; gap: 14px;
}
.stat-icon {
  width: 38px; height: 38px; flex-shrink: 0;
  border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
}
.stat-icon.orange { background: var(--accent-light); color: var(--accent); }
.stat-icon.green  { background: var(--green-bg);     color: var(--green); }
.stat-icon.gray   { background: var(--surface-3);    color: var(--text-2); }
.stat-label { font-size: 11px; color: var(--text-3); font-weight: 500; margin-bottom: 3px; }
.stat-val   { font-family: 'DM Mono', monospace; font-size: 16px; font-weight: 700; color: var(--text-1); }

/* ─── TOOLBAR ─── */
.toolbar {
  display: flex; align-items: center; gap: 10px;
  margin-bottom: 14px; flex-wrap: wrap;
}
.search-wrap { position: relative; flex: 1; min-width: 220px; }
.search-wrap i {
  position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
  color: var(--text-3); font-size: 15px; pointer-events: none;
}
.search-wrap input {
  width: 100%; height: 36px;
  border: 1px solid var(--border-md); border-radius: var(--radius-sm);
  padding: 0 10px 0 34px; font-size: 13px;
  font-family: 'DM Sans', sans-serif; color: var(--text-1);
  background: var(--surface);
  transition: border-color 0.15s, box-shadow 0.15s;
}
.search-wrap input:focus {
  outline: none; border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(216,90,48,0.10);
}
.toolbar-count { font-size: 12px; color: var(--text-3); white-space: nowrap; }

/* ─── TABLE ─── */
.table-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--radius-lg); overflow: hidden;
  box-shadow: var(--shadow-sm);
}
.inv-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.inv-table thead th {
  padding: 11px 16px; font-size: 10px; font-weight: 700;
  color: var(--text-3); text-transform: uppercase; letter-spacing: 0.8px;
  background: var(--surface-2); border-bottom: 1px solid var(--border);
  text-align: left; white-space: nowrap;
}
.inv-table thead th.r { text-align: right; }
.inv-table tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background 0.12s;
}
.inv-table tbody tr:last-child { border-bottom: none; }
.inv-table tbody tr:hover { background: var(--accent-light); }
.inv-table tbody td { padding: 13px 16px; vertical-align: middle; }
.inv-table tbody td.r { text-align: right; }

.cell-billno {
  font-family: 'DM Mono', monospace; font-size: 11.5px; font-weight: 600;
  color: var(--accent); background: var(--accent-light);
  border: 1px solid var(--accent-border);
  border-radius: 4px; padding: 2px 8px; display: inline-block;
}
.cell-date  { font-family: 'DM Mono', monospace; font-size: 12px; color: var(--text-3); }
.cell-party-name { font-weight: 600; font-size: 13px; color: var(--text-1); }
.cell-party-co   { font-size: 11.5px; color: var(--text-3); margin-top: 1px; }
.cell-amount { font-family: 'DM Mono', monospace; font-size: 13px; font-weight: 500; color: var(--text-1); }
.cell-grand  { font-family: 'DM Mono', monospace; font-size: 13.5px; font-weight: 700; color: var(--accent); }

.actions { display: flex; gap: 6px; justify-content: flex-end; }
.act-btn {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 5px 10px; border-radius: var(--radius-sm);
  font-size: 12px; font-weight: 600; cursor: pointer;
  font-family: 'DM Sans', sans-serif; text-decoration: none;
  border: 1px solid var(--border-md);
  background: var(--surface-3); color: var(--text-2);
  transition: background 0.15s, color 0.15s;
}
.act-btn:hover { background: var(--surface); color: var(--text-1); }
.act-btn.view  { background: var(--accent-light); color: var(--accent); border-color: var(--accent-border); }
.act-btn.view:hover { background: var(--accent); color: #fff; }
.act-btn.del   { color: var(--red); border-color: #F7C1C1; background: var(--red-bg); }
.act-btn.del:hover { background: #F7C1C1; }

/* ─── EMPTY ─── */
.empty-state {
  display: flex; flex-direction: column; align-items: center;
  justify-content: center; padding: 72px 24px; text-align: center;
}
.empty-icon {
  width: 64px; height: 64px; background: var(--surface-3); border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 28px; margin-bottom: 16px; color: var(--text-3);
}
.empty-title { font-size: 16px; font-weight: 700; color: var(--text-2); margin-bottom: 6px; }
.empty-sub   { font-size: 13px; color: var(--text-3); margin-bottom: 20px; }

.no-results {
  padding: 40px 24px; text-align: center;
  font-size: 13px; color: var(--text-3); display: none;
}
.no-results i { font-size: 28px; margin-bottom: 8px; display: block; opacity: 0.4; }

/* ─── PAGINATION ─── */
.pagination-wrap {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 20px; border-top: 1px solid var(--border);
  background: var(--surface-2); font-size: 12px; color: var(--text-3);
  flex-wrap: wrap; gap: 10px;
}
.pagination-wrap nav { display: flex; }
.pagination-wrap .pagination { display: flex; gap: 4px; list-style: none; margin: 0; }
.pagination-wrap .pagination li > a,
.pagination-wrap .pagination li > span {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 32px; height: 32px; padding: 0 8px;
  border: 1px solid var(--border-md); border-radius: var(--radius-sm);
  font-size: 12px; font-weight: 600; text-decoration: none;
  color: var(--text-2); background: var(--surface);
  transition: background 0.15s, color 0.15s;
}
.pagination-wrap .pagination li > a:hover {
  background: var(--accent-light); color: var(--accent); border-color: var(--accent-border);
}
.pagination-wrap .pagination li.active > span {
  background: var(--accent); color: #fff; border-color: var(--accent);
}
.pagination-wrap .pagination li.disabled > span { opacity: 0.4; }

/* logo */
.topbar-logo img {
    height: 45px;
    width: 45px;
    border-radius: 50%;
    object-fit: cover;
}
/* Success */
/* ─── SUCCESS TOAST ─── */
.toast {
  position: fixed; bottom: 32px; right: 32px; z-index: 9999;
  display: flex; align-items: center; gap: 14px;
  background: #fff; border: 1px solid #C6E6C3;
  border-left: 5px solid #3B6D11;
  border-radius: var(--radius-md);
  padding: 16px 20px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.12);
  min-width: 320px; max-width: 420px;
  overflow: hidden;
  animation: slideIn 0.35s cubic-bezier(.21,1.02,.73,1) forwards;
}
.toast.hide { animation: slideOut 0.3s ease forwards; }
.toast-icon {
  width: 38px; height: 38px; flex-shrink: 0;
  background: var(--green-bg); border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px; color: var(--green);
}
.toast-title { font-size: 13.5px; font-weight: 700; color: var(--text-1); margin-bottom: 2px; }
.toast-sub   { font-size: 12px; color: var(--text-3); }
.toast-close {
  margin-left: auto; background: none; border: none;
  cursor: pointer; color: var(--text-3); font-size: 18px;
  padding: 4px; line-height: 1;
}
.toast-close:hover { color: var(--text-1); }
.toast-progress {
  position: absolute; bottom: 0; left: 0;
  height: 3px; background: var(--green);
  width: 100%;
  animation: progress 4s linear forwards;
}
@keyframes slideIn {
  from { opacity: 0; transform: translateY(20px) scale(0.97); }
  to   { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes slideOut {
  from { opacity: 1; transform: translateY(0); }
  to   { opacity: 0; transform: translateY(16px); }
}
@keyframes progress {
  from { width: 100%; }
  to   { width: 0%; }
}
{{-- Status/Pending/Successs --}}
.badge-success{
    background:#dcfce7;
    color:#166534;
    padding:5px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-warning{
    background:#fef3c7;
    color:#92400e;
    padding:5px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-danger{
    background:#fee2e2;
    color:#991b1b;
    padding:5px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}
</style>

@endpush

@section('content')

<header class="topbar">
  <div class="topbar-brand">
   <div class="topbar-logo">
        <img src="/images/projects/logo.png" alt="AB Logo">
   </div>
    <div>
      <div class="topbar-name">Awadh Buildmate</div>
      <div class="topbar-sub">Made For Quality and Trust</div>
    </div>
  </div>
  <a href="{{ route('invoices.create') }}" class="btn btn-primary">
    <i class="ti ti-plus" aria-hidden="true"></i> New Invoice
  </a>
</header>

<div class="page-wrap">

  <div class="page-header">
    <div>
      <div class="page-eyebrow">Awadh Buildmate</div>
      <div class="page-title">Made For Quality and Trust</div>
      <div class="page-count">
        <i class="ti ti-file-invoice" style="font-size:13px;" aria-hidden="true"></i>
        <strong>{{ $invoices->total() }}</strong> invoice{{ $invoices->total() !== 1 ? 's' : '' }} total
      </div>
    </div>
    {{-- <a href="{{ route('invoices.create') }}" class="btn btn-primary">
      <i class="ti ti-plus" aria-hidden="true"></i> New Invoice
    </a> --}}
  </div>

  {{-- STATS --}}
  @php
    $allInvoices = \App\Models\Invoice::all();
    $totalBill   = $allInvoices->sum('bill_amount');
    $totalGrand  = $allInvoices->sum('grand_total');
    // $totalReceivable = $allInvoices->sum(function ($invoice) {
    //     return max(0, $invoice->grand_total - $invoice->received_amount);
    // });
  @endphp
  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-icon orange"><i class="ti ti-receipt-2" aria-hidden="true"></i></div>
      <div>
        <div class="stat-label">Total Invoices</div>
        <div class="stat-val">{{ $invoices->total() }}</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon gray"><i class="ti ti-report-money" aria-hidden="true"></i></div>
      <div>
        <div class="stat-label">Total Bill Amount</div>
        <div class="stat-val">₹ {{ number_format($totalBill, 0, '.', ',') }}</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green"><i class="ti ti-cash" aria-hidden="true"></i></div>
      <div>
        <div class="stat-label">Total Receivable</div>
        <div class="stat-val">₹ {{ number_format($totalGrand, 0, '.', ',') }}</div>
        {{-- <div class="stat-val">₹ {{ number_format($totalReceivable, 0, '.', ',') }}</div> --}}
      </div>
    </div>
  </div>

  {{-- TOOLBAR --}}
  <div class="toolbar">
    <div class="search-wrap">
      <i class="ti ti-search" aria-hidden="true"></i>
      <input type="text" id="searchInput" placeholder="Search by bill no, party name…" oninput="filterTable(this.value)">
    </div>
    <span class="toolbar-count" id="visibleCount">
      Showing {{ $invoices->count() }} of {{ $invoices->total() }}
    </span>
  </div>

  {{-- TABLE --}}
  <div class="table-card">
    @if($invoices->count())

    <table class="inv-table" id="invoiceTable">
      <thead>
        <tr>
          <th>Bill No.</th>
          <th>Date</th>
          <th>Client</th>
          {{-- <th class="r">Bill Amount</th> --}}
          <th class="r">Bill Amount</th>
          <th class="r">Received</th>
          <th class="r">Pending</th>
          <th>Status</th>
          <th class="r">Actions</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @foreach($invoices as $invoice)
        <tr data-search="{{ strtolower($invoice->bill_no . ' ' . $invoice->to_name . ' ' . ($invoice->to_co ?? '')) }}">
          <td><span class="cell-billno"># {{ $invoice->bill_no }}</span></td>
          <td><span class="cell-date">{{ \Carbon\Carbon::parse($invoice->bill_date)->format('d M Y') }}</span></td>
          <td>
            <div class="cell-party-name">{{ $invoice->to_name }}</div>
            @if($invoice->to_co)
            <div class="cell-party-co">{{ $invoice->to_co }}</div>
            @endif
          </td>
          {{-- <td class="r"><span class="cell-amount">₹ {{ number_format($invoice->bill_amount, 0, '.', ',') }}</span></td> --}}
          <td class="r"><span class="cell-grand">₹ {{ number_format($invoice->grand_total, 0, '.', ',') }}</span></td>
          <td class="r">
        <form action="{{ route('invoice.update-payment', $invoice->id) }}" method="POST" style="display:flex; gap:8px;">
        @csrf

        <input
            type="number"
            name="received_amount"
            value="{{ $invoice->received_amount }}"
            min="0"
            max="{{ $invoice->grand_total }}"
            step="0.01"
            style="
                width:120px;
                padding:6px 10px;
                border:1px solid #ddd;
                border-radius:8px;
            "
        >

        <button type="submit" class="act-btn">
            Save
        </button>
    </form>
</td>

    <td class="r">
        ₹ {{ number_format(max(0, $invoice->grand_total - $invoice->received_amount), 0, '.', ',') }}
    </td>
    <td>
        @if($invoice->payment_status == 'Received')
            <span class="badge-success">Received</span>
        @elseif($invoice->payment_status == 'Partial')
            <span class="badge-warning">Partial</span>
        @else
            <span class="badge-danger">Pending</span>
        @endif
    </td>
          <td class="r">
            <div class="actions">
              <a href="{{ route('invoice.show', $invoice->id) }}" class="act-btn view">
                <i class="ti ti-eye" aria-hidden="true"></i> View
              </a>
              {{-- <a href="{{ route('invoice.edit', $invoice->id) }}" class="act-btn">
                <i class="ti ti-edit" aria-hidden="true"></i> Edit
              </a> --}}
              <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST"
                    onsubmit="return confirm('Delete invoice #{{ $invoice->bill_no }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="act-btn del" title="Delete">
                  <i class="ti ti-trash" aria-hidden="true"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="no-results" id="noResults">
      <i class="ti ti-search-off" aria-hidden="true"></i>
      No invoices match your search.
    </div>

    <div class="pagination-wrap">
      <span>Page {{ $invoices->currentPage() }} of {{ $invoices->lastPage() }}</span>
      {{ $invoices->links() }}
    </div>

    @else
    <div class="empty-state">
      <div class="empty-icon"><i class="ti ti-receipt-off" aria-hidden="true"></i></div>
      <div class="empty-title">No invoices yet</div>
      <div class="empty-sub">Create your first invoice to get started.</div>
      <a href="{{ route('invoices.create') }}" class="btn btn-primary">
        <i class="ti ti-plus" aria-hidden="true"></i> Create Invoice
      </a>
    </div>
    @endif
  </div>

</div>
@if(session('success'))
<div class="toast" id="toast">
  <div class="toast-icon"><i class="ti ti-circle-check"></i></div>
  <div>
    <div class="toast-title">Invoice Saved!</div>
    <div class="toast-sub">{{ session('success') }}</div>
  </div>
  <button class="toast-close" onclick="dismissToast()">
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
    ? `Showing ${visible} result${visible !== 1 ? 's' : ''}`
    : `Showing {{ $invoices->count() }} of {{ $invoices->total() }}`;
} 
function dismissToast() {
  const t = document.getElementById('toast');
  if (!t) return;
  t.classList.add('hide');
  setTimeout(() => t.remove(), 300);
}
@if(session('success'))
  setTimeout(dismissToast, 4000);
@endif
</script>
@endpush