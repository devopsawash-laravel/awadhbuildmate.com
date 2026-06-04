<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice Creator — Awadh Buildmate</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --accent:       #D85A30;
  --accent-mid:   #E8714D;
  --accent-light: #FDF0EB;
  --accent-border:#F5C4B3;
  --surface:      #FFFFFF;
  --surface-2:    #F8F7F5;
  --surface-3:    #F1EFE8;
  --border:       rgba(0,0,0,0.08);
  --border-md:    rgba(0,0,0,0.14);
  --text-1:       #1A1A18;
  --text-2:       #5F5E5A;
  --text-3:       #888780;
  --green:        #3B6D11;
  --green-bg:     #EAF3DE;
  --red:          #A32D2D;
  --red-bg:       #FCEBEB;
  --radius-sm:    6px;
  --radius-md:    10px;
  --radius-lg:    14px;
  --shadow-sm:    0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
  --shadow-md:    0 4px 16px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
  --shadow-lg:    0 12px 40px rgba(0,0,0,0.10), 0 2px 8px rgba(0,0,0,0.05);
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
  width: 32px; height: 32px;
  background: var(--accent);
  border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 15px; font-weight: 700;
}
.topbar-name { font-size: 15px; font-weight: 600; color: var(--text-1); }
.topbar-sub { font-size: 11px; color: var(--text-3); margin-top: 1px; }
.topbar-actions { display: flex; gap: 8px; }

/* ─── LAYOUT ─── */
.app-layout {
  display: grid;
  grid-template-columns: 420px 1fr;
  min-height: calc(100vh - 56px);
  gap: 0;
}

/* ─── LEFT PANEL (form) ─── */
.form-panel {
  background: var(--surface);
  border-right: 1px solid var(--border);
  overflow-y: auto;
  height: calc(100vh - 56px);
  position: sticky; top: 56px;
}

.form-section {
  border-bottom: 1px solid var(--border);
  padding: 20px 24px;
}
.form-section:last-child { border-bottom: none; }

.section-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 16px;
}
.section-title {
  font-size: 11px;
  font-weight: 600;
  color: var(--text-3);
  text-transform: uppercase;
  letter-spacing: 0.8px;
}

.field-row { display: flex; gap: 12px; }
.field { flex: 1; margin-bottom: 12px; }
.field:last-child { margin-bottom: 0; }
.field label {
  display: block;
  font-size: 12px;
  font-weight: 500;
  color: var(--text-2);
  margin-bottom: 5px;
}
.field input,
.field textarea,
.field select {
  width: 100%;
  height: 36px;
  border: 1px solid var(--border-md);
  border-radius: var(--radius-sm);
  padding: 0 10px;
  font-size: 13px;
  font-family: 'DM Sans', sans-serif;
  color: var(--text-1);
  font-weight: 500;
  background: var(--surface);
  transition: border-color 0.15s, box-shadow 0.15s;
  -webkit-appearance: none;
}
.field textarea {
  height: auto; padding: 8px 10px; resize: vertical; line-height: 1.5;
}
.field input:focus,
.field textarea:focus {
  outline: none;
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(216,90,48,0.10);
}
.field input::placeholder,
.field textarea::placeholder { color: var(--text-3); font-weight: 400; }

/* item rows */
.items-header {
  display: grid;
  grid-template-columns: 1fr 56px 72px 80px 28px;
  gap: 6px;
  padding: 6px 8px;
  background: var(--accent-light);
  border-radius: var(--radius-sm);
  margin-bottom: 6px;
  font-size: 10px;
  font-weight: 600;
  color: var(--accent);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.item-row {
  display: grid;
  grid-template-columns: 1fr 56px 72px 80px 28px;
  gap: 6px;
  align-items: center;
  margin-bottom: 6px;
  animation: slide-in 0.15s ease;
}
@keyframes slide-in { from { opacity:0; transform: translateY(-4px); } to { opacity:1; transform:none; } }

.item-row input {
  width: 100%; height: 34px;
  border: 1px solid var(--border-md);
  border-radius: var(--radius-sm);
  padding: 0 8px;
  font-size: 12.5px;
  font-family: 'DM Sans', sans-serif;
  color: var(--text-1);
  font-weight: 500;
  background: var(--surface);
  transition: border-color 0.15s, box-shadow 0.15s;
}
.item-row input:focus {
  outline: none;
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(216,90,48,0.10);
}
.item-row input[type="number"] { text-align: right; }

.btn-remove {
  width: 28px; height: 28px;
  border: 1px solid #F7C1C1;
  background: #FCEBEB;
  border-radius: var(--radius-sm);
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: #A32D2D;
  font-size: 13px;
  transition: background 0.15s;
}
.btn-remove:hover { background: #F7C1C1; }

.btn-add {
  display: flex; align-items: center; gap: 6px;
  background: none;
  border: 1.5px dashed var(--accent-border);
  border-radius: var(--radius-sm);
  padding: 7px 12px;
  color: var(--accent);
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  margin-top: 4px;
  font-family: 'DM Sans', sans-serif;
  transition: background 0.15s;
}
.btn-add:hover { background: var(--accent-light); }

/* action buttons */
.form-actions {
  padding: 16px 24px;
  display: flex;
  gap: 8px;
  background: var(--surface);
  border-top: 1px solid var(--border);
  position: sticky; bottom: 0;
}

.btn {
  display: inline-flex; align-items: center; gap: 7px;
  border: none; border-radius: var(--radius-md);
  padding: 10px 18px;
  font-size: 13px; font-weight: 600;
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  transition: transform 0.12s, box-shadow 0.12s;
}
.btn:active { transform: scale(0.98); }
.btn-primary {
  background: var(--accent); color: #fff;
  box-shadow: 0 2px 8px rgba(216,90,48,0.28);
  flex: 1; justify-content: center;
}
.btn-primary:hover { background: #C2410C; box-shadow: 0 4px 12px rgba(216,90,48,0.36); }
.btn-ghost {
  background: var(--surface-3); color: var(--text-2);
  border: 1px solid var(--border-md);
}
.btn-ghost:hover { background: var(--surface); color: var(--text-1); }

/* ─── RIGHT PANEL (preview) ─── */
.preview-panel {
  overflow-y: auto;
  height: calc(100vh - 56px);
  padding: 32px;
  background: var(--surface-2);
}

/* ─── INVOICE DOC ─── */
.invoice-doc {
  background: #fff;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  overflow: hidden;
  max-width: 740px;
  margin: 0 auto;
  font-family: 'DM Sans', sans-serif;
}

.inv-stripe { height: 5px; background: var(--accent); }

.inv-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 28px 32px 22px;
  gap: 24px;
  border-bottom: 1px solid var(--surface-3);
}
.inv-logo-area { flex: 1; }
.inv-co-name {
  font-family: 'Playfair Display', serif;
  font-size: 26px;
  color: var(--accent);
  line-height: 1.1;
  letter-spacing: 0.3px;
}
.inv-co-tagline {
  font-size: 10.5px;
  color: var(--text-3);
  margin-top: 3px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  font-weight: 500;
}
.inv-co-addr {
  font-size: 11px;
  color: var(--text-3);
  margin-top: 8px;
  line-height: 1.7;
  max-width: 300px;
}
.inv-chips { display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap; }
.inv-chip {
  font-size: 10.5px;
  font-family: 'DM Mono', monospace;
  background: var(--surface-3);
  border: 1px solid var(--border);
  border-radius: 4px;
  padding: 3px 8px;
  color: var(--text-2);
}
.inv-chip strong { color: var(--text-1); font-weight: 600; }

.inv-badge-area { text-align: right; }
.inv-tax-badge {
  display: inline-block;
  background: var(--accent-light);
  border: 1px solid var(--accent-border);
  border-radius: var(--radius-sm);
  padding: 3px 10px;
  font-size: 9.5px;
  font-weight: 700;
  color: var(--accent);
  letter-spacing: 2px;
  text-transform: uppercase;
  margin-bottom: 6px;
}
.inv-doc-title {
  font-family: 'Playfair Display', serif;
  font-size: 20px; color: var(--text-1);
}
.inv-meta { margin-top: 10px; }
.inv-meta-row {
  display: flex; justify-content: flex-end; gap: 16px;
  font-size: 12px; color: var(--text-2); padding: 2px 0;
}
.inv-meta-row strong { color: var(--text-1); font-weight: 600; font-family: 'DM Mono', monospace; }

/* billed to row */
.inv-to-strip {
  display: grid;
  grid-template-columns: 1fr 1fr;
  border-bottom: 1px solid var(--surface-3);
}
.inv-to-cell {
  padding: 16px 32px;
}
.inv-to-cell:first-child { border-right: 1px solid var(--surface-3); }
.inv-cell-label {
  font-size: 9px;
  font-weight: 700;
  color: var(--text-3);
  text-transform: uppercase;
  letter-spacing: 1.5px;
  margin-bottom: 6px;
}
.inv-to-name { font-size: 14px; font-weight: 700; color: var(--text-1); }
.inv-to-co { font-size: 12px; color: var(--text-2); margin-top: 2px; }
.inv-contact-name { font-size: 13px; font-weight: 600; color: var(--text-1); }
.inv-contact-phone { font-size: 12px; color: var(--text-2); margin-top: 2px; }

/* items table */
.inv-table-wrap { padding: 0 24px; margin: 20px 0 0; }
.inv-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}
.inv-table thead th {
  padding: 8px 10px;
  font-size: 9.5px;
  font-weight: 700;
  color: var(--accent);
  text-transform: uppercase;
  letter-spacing: 0.8px;
  background: var(--accent-light);
  text-align: left;
}
.inv-table thead th:not(:first-child) { text-align: right; }
.inv-table thead th:first-child { border-radius: var(--radius-sm) 0 0 var(--radius-sm); }
.inv-table thead th:last-child { border-radius: 0 var(--radius-sm) var(--radius-sm) 0; }
.inv-table tbody td {
  padding: 10px 10px;
  color: var(--text-1);
  border-bottom: 1px solid var(--surface-3);
  vertical-align: top;
}
.inv-table tbody tr:last-child td { border-bottom: none; }
.inv-table tbody td:not(:first-child):not(:nth-child(2)) { text-align: right; }
.inv-table tbody td:nth-child(2) { font-weight: 500; }
.inv-table td.cell-num { font-family: 'DM Mono', monospace; font-size: 12px; }
.inv-table td.cell-idx { color: var(--text-3); font-size: 12px; text-align: center !important; }

/* totals */
.inv-totals-wrap {
  display: flex;
  justify-content: flex-end;
  padding: 16px 24px 20px;
}
.inv-totals { width: 280px; }
.inv-total-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 4px 0;
  font-size: 12.5px;
  color: var(--text-2);
}
.inv-total-row .lbl { font-weight: 500; }
.inv-total-row .val { font-family: 'DM Mono', monospace; font-size: 12px; color: var(--text-1); }
.row-bold .lbl,
.row-bold .val { font-weight: 700; color: var(--text-1); font-size: 13px; }
.row-red .lbl,
.row-red .val { color: var(--red); }
.inv-divider { border: none; border-top: 1px dashed var(--border-md); margin: 8px 0; }
.inv-grand-divider { border: none; border-top: 2px solid var(--accent); margin: 10px 0 8px; }
.inv-grand-row {
  display: flex; justify-content: space-between; align-items: baseline;
}
.inv-grand-label { font-size: 14px; font-weight: 700; color: var(--text-1); }
.inv-grand-val {
  font-family: 'DM Mono', monospace;
  font-size: 20px; font-weight: 700; color: var(--accent);
}

/* footer */
.inv-footer {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 40px;
  background: var(--surface-2);
  border-top: 1px solid var(--surface-3);
  padding: 20px 32px 22px;
}
.inv-bank-label { font-size: 9px; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 10px; }
.inv-bank-row { display: flex; gap: 12px; font-size: 12px; margin-bottom: 4px; }
.inv-bank-row .k { color: var(--text-3); min-width: 88px; }
.inv-bank-row .v { font-weight: 600; color: var(--text-1); font-family: 'DM Mono', monospace; }
.inv-note {
  margin-top: 12px;
  padding: 8px 12px;
  background: var(--accent-light);
  border-left: 3px solid var(--accent-border);
  border-radius: 0 4px 4px 0;
  font-size: 11.5px;
  color: #7C3516;
  line-height: 1.5;
}
.inv-sign-block { text-align: right; }
.inv-sign-for { font-size: 11px; color: var(--text-3); margin-bottom: 40px; }
.inv-sign-line {
  border-top: 1.5px solid var(--text-2);
  padding-top: 6px;
  font-size: 13px; font-weight: 700;
  color: var(--text-1);
  min-width: 180px;
  text-align: right;
}
.inv-sign-role { font-size: 11px; color: var(--text-3); margin-top: 3px; text-align: right; }

.inv-bottombar {
  background: var(--accent);
  padding: 9px 32px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 10.5px;
  color: rgba(255,255,255,0.8);
  gap: 16px;
  flex-wrap: wrap;
}
.inv-bottombar span:last-child { font-weight: 600; color: #fff; font-family: 'DM Mono', monospace; }

/* ─── PRINT ─── */
@media print {
  body { background: #fff; }
  .topbar, .form-panel { display: none !important; }
  .app-layout { display: block; }
  .preview-panel {
    height: auto; overflow: visible;
    padding: 0; background: #fff;
  }
  .invoice-doc {
    box-shadow: none; border-radius: 0;
    max-width: 100%;
  }
  @page { size: A4; margin: 8mm; }
  .inv-table { font-size: 11px; }
}

/* ─── SCROLLBAR ─── */
.form-panel::-webkit-scrollbar,
.preview-panel::-webkit-scrollbar { width: 4px; }
.form-panel::-webkit-scrollbar-track,
.preview-panel::-webkit-scrollbar-track { background: transparent; }
.form-panel::-webkit-scrollbar-thumb,
.preview-panel::-webkit-scrollbar-thumb { background: var(--border-md); border-radius: 4px; }

/* status badge in topbar */
.status-pill {
  font-size: 11px; font-weight: 600;
  background: var(--green-bg);
  color: var(--green);
  border: 1px solid #C0DD97;
  border-radius: 20px;
  padding: 3px 10px;
  display: flex; align-items: center; gap: 5px;
}
.status-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--green); }
</style>
</head>
<body>

<!-- TOPBAR -->
<header class="topbar">
  <div class="topbar-brand">
    <div class="topbar-logo">AB</div>
    <div>
      <div class="topbar-name">Awadh Buildmate</div>
      <div class="topbar-sub">Invoice Creator</div>
    </div>
  </div>
  <div style="display:flex;align-items:center;gap:12px;">
    <span class="status-pill"><span class="status-dot"></span>Live Preview</span>
    <div class="topbar-actions">
      <button class="btn btn-ghost" onclick="window.print()">
        <i class="ti ti-printer" aria-hidden="true"></i> Print
      </button>
      <button class="btn btn-primary" onclick="alert('Save action — connect to Laravel backend')">
        <i class="ti ti-device-floppy" aria-hidden="true"></i> Save Invoice
      </button>
    </div>
  </div>
</header>

<div class="app-layout">

  <!-- ══ FORM PANEL ══ -->
  <aside class="form-panel">

    <!-- Bill Info -->
    <div class="form-section">
      <div class="section-header">
        <span class="section-title"><i class="ti ti-receipt" aria-hidden="true"></i> &nbsp;Bill Info</span>
      </div>
      <div class="field-row">
        <div class="field">
          <label>Bill No.</label>
          <input type="text" id="bill_no" placeholder="25-03-2026" oninput="updatePreview()">
        </div>
        <div class="field">
          <label>Bill Date</label>
          <input type="date" id="bill_date" oninput="updatePreview()">
        </div>
      </div>
    </div>

    <!-- Billed To -->
    <div class="form-section">
      <div class="section-header">
        <span class="section-title"><i class="ti ti-building" aria-hidden="true"></i> &nbsp;Billed To</span>
      </div>
      <div class="field">
        <label>Client / Company Name</label>
        <input type="text" id="to_name" placeholder="e.g. Lakhani Engineering" oninput="updatePreview()">
      </div>
      <div class="field" style="margin-top:10px;">
        <label>C/o or Sub-line</label>
        <input type="text" id="to_co" placeholder="e.g. C/o L&T (Asian Paint)" oninput="updatePreview()">
      </div>
    </div>

    <!-- Contact -->
    <div class="form-section">
      <div class="section-header">
        <span class="section-title"><i class="ti ti-user" aria-hidden="true"></i> &nbsp;Contact</span>
      </div>
      <div class="field-row">
        <div class="field">
          <label>Contact Person</label>
          <input type="text" id="contact_person" placeholder="Name" oninput="updatePreview()">
        </div>
        <div class="field">
          <label>Contact Number</label>
          <input type="text" id="contact_number" placeholder="+91 XXXXX XXXXX" oninput="updatePreview()">
        </div>
      </div>
    </div>

    <!-- From -->
    <div class="form-section">
      <div class="section-header">
        <span class="section-title"><i class="ti ti-id-badge" aria-hidden="true"></i> &nbsp;From (Your Details)</span>
      </div>
      <div class="field">
        <label>Firm Name</label>
        <input type="text" id="from_name" value="Awadh Buildmate" oninput="updatePreview()">
      </div>
      <div class="field" style="margin-top:10px;">
        <label>Address</label>
        <textarea id="from_address" rows="2" oninput="updatePreview()">Floor No.: 1st, Building No.: C-101, Building: Nakshtra Heights, Subhanpura Road, Subhanpura, Vadodara, Gujarat - 390023.</textarea>
      </div>
      <div class="field-row" style="margin-top:10px;">
        <div class="field">
          <label>PAN</label>
          <input type="text" id="from_pan" value="GTBPM0457F" oninput="updatePreview()">
        </div>
        <div class="field">
          <label>GST No.</label>
          <input type="text" id="from_gst" value="24GTBPM0457F1ZW" oninput="updatePreview()">
        </div>
      </div>
    </div>

    <!-- Bank -->
    <div class="form-section">
      <div class="section-header">
        <span class="section-title"><i class="ti ti-building-bank" aria-hidden="true"></i> &nbsp;Bank Details</span>
      </div>
      <div class="field">
        <label>Bank Name</label>
        <input type="text" id="bank_name" value="Indian Overseas Bank" oninput="updatePreview()">
      </div>
      <div class="field-row" style="margin-top:10px;">
        <div class="field">
          <label>Account No.</label>
          <input type="text" id="account_no" placeholder="Account number" oninput="updatePreview()">
        </div>
        <div class="field">
          <label>IFSC Code</label>
          <input type="text" id="ifsc_code" placeholder="IOBA0001234" oninput="updatePreview()">
        </div>
      </div>
      <div class="field" style="margin-top:10px;">
        <label>Proprietor Name</label>
        <input type="text" id="proprietor" value="Harsh Raj Maurya" oninput="updatePreview()">
      </div>
    </div>

    <!-- Work Items -->
    <div class="form-section">
      <div class="section-header">
        <span class="section-title"><i class="ti ti-list-details" aria-hidden="true"></i> &nbsp;Work Items</span>
      </div>
      <div class="items-header">
        <span>Particulars</span>
        <span style="text-align:center">QTY</span>
        <span style="text-align:right">Rate (₹)</span>
        <span style="text-align:right">Amt (₹)</span>
        <span></span>
      </div>
      <div id="itemsContainer"></div>
      <button type="button" class="btn-add" onclick="addItem()">
        <i class="ti ti-plus" aria-hidden="true"></i> Add Item
      </button>
    </div>

    <!-- Tax & Deductions -->
    <div class="form-section">
      <div class="section-header">
        <span class="section-title"><i class="ti ti-percentage" aria-hidden="true"></i> &nbsp;Tax &amp; Deductions</span>
      </div>
      <div class="field-row">
        <div class="field">
          <label>GST Rate (%)</label>
          <input type="number" id="gst_rate" value="18" min="0" oninput="updatePreview()">
        </div>
        <div class="field">
          <label>TDS Rate (%)</label>
          <input type="number" id="tds_rate" value="5" min="0" oninput="updatePreview()">
        </div>
      </div>
      <div class="field" style="margin-top:10px;">
        <label>Deposit / Advance Deduction (₹)</label>
        <input type="number" id="deposit" value="0" min="0" oninput="updatePreview()">
      </div>
    </div>

    <!-- Note -->
    <div class="form-section">
      <div class="section-header">
        <span class="section-title"><i class="ti ti-notes" aria-hidden="true"></i> &nbsp;Note (Optional)</span>
      </div>
      <div class="field">
        <textarea id="note" rows="3" placeholder="Any additional notes…" oninput="updatePreview()"></textarea>
      </div>
    </div>

    <!-- actions sticky bottom -->
    <div class="form-actions">
      <button class="btn btn-ghost" onclick="window.print()">
        <i class="ti ti-printer" aria-hidden="true"></i> Print
      </button>
      <button class="btn btn-primary" onclick="alert('Save invoice — connect to backend')">
        <i class="ti ti-device-floppy" aria-hidden="true"></i> Save Invoice
      </button>
    </div>

  </aside>

  <!-- ══ PREVIEW PANEL ══ -->
  <main class="preview-panel">
    <div class="invoice-doc" id="invoicePreview">

      <div class="inv-stripe"></div>

      <!-- Head -->
      <div class="inv-head">
        <div class="inv-logo-area">
          <div class="inv-co-name" id="prev_from_name">AWADH BUILDMATE</div>
          <div class="inv-co-tagline">Made For Quality and Trust</div>
          <div class="inv-co-tagline">Fabrication &nbsp;·&nbsp; Erection &nbsp;·&nbsp; Structural Work</div>
          <div class="inv-co-addr" id="prev_from_address">Floor No.: 1st, Building No.: C-101, Building: Nakshtra Heights, Subhanpura Road, Subhanpura, Vadodara, Gujarat - 390023.</div>
          <div class="inv-chips">
            <span class="inv-chip">PAN: <strong id="prev_from_pan">GTBPM0457F</strong></span>
            <span class="inv-chip">GST: <strong id="prev_from_gst">24GTBPM0457F1ZW</strong></span>
          </div>
        </div>
        <div class="inv-badge-area">
          <div class="inv-tax-badge">Tax Invoice</div>
          <div class="inv-doc-title">Invoice</div>
          <div class="inv-meta">
            <div class="inv-meta-row"><span>Bill No.</span><strong id="prev_bill_no">—</strong></div>
            <div class="inv-meta-row"><span>Date</span><strong id="prev_bill_date">—</strong></div>
          </div>
        </div>
      </div>

      <!-- Billed To / Contact -->
      <div class="inv-to-strip">
        <div class="inv-to-cell">
          <div class="inv-cell-label">Billed To</div>
          <div class="inv-to-name" id="prev_to_name">—</div>
          <div class="inv-to-co" id="prev_to_co"></div>
        </div>
        <div class="inv-to-cell">
          <div class="inv-cell-label">Contact</div>
          <div class="inv-contact-name" id="prev_contact_person"></div>
          <div class="inv-contact-phone" id="prev_contact_number"></div>
        </div>
      </div>

      <!-- Items Table -->
      <div class="inv-table-wrap">
        <table class="inv-table">
          <thead>
            <tr>
              <th style="width:32px;text-align:center">#</th>
              <th>Particulars</th>
              <th style="width:64px">QTY</th>
              <th style="width:96px">Rate (₹)</th>
              <th style="width:110px">Amount (₹)</th>
            </tr>
          </thead>
          <tbody id="prev_items_body">
            <tr>
              <td colspan="5" style="text-align:center;color:var(--text-3);padding:24px;font-size:13px;">
                Fill in the items on the left to preview…
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Totals -->
      <div class="inv-totals-wrap">
        <div class="inv-totals">
          <div class="inv-total-row">
            <span class="lbl">Subtotal</span>
            <span class="val">₹ <span id="prev_total">0</span></span>
          </div>
          <div class="inv-total-row">
            <span class="lbl">GST @ <span id="prev_gst_rate_lbl">18</span>%</span>
            <span class="val">₹ <span id="prev_gst_amt">0</span></span>
          </div>
          <div class="inv-total-row row-bold">
            <span class="lbl">Bill Amount</span>
            <span class="val">₹ <span id="prev_bill_amt">0</span></span>
          </div>
          <hr class="inv-divider">
          <div class="inv-total-row row-red">
            <span class="lbl">Deposit as per L&amp;T</span>
            <span class="val">− ₹ <span id="prev_deposit">0</span></span>
          </div>
          <div class="inv-total-row row-red">
            <span class="lbl">TDS @ <span id="prev_tds_rate_lbl">5</span>%</span>
            <span class="val">− ₹ <span id="prev_tds_amt">0</span></span>
          </div>
          <div class="inv-total-row row-red">
            <span class="lbl" style="font-weight:600">Total Deduction</span>
            <span class="val">₹ <span id="prev_total_ded">0</span></span>
          </div>
          <hr class="inv-grand-divider">
          <div class="inv-grand-row">
            <span class="inv-grand-label">Grand Total</span>
            <span class="inv-grand-val">₹ <span id="prev_grand_total">0</span></span>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="inv-footer">
        <div>
          <div class="inv-bank-label">Bank Details</div>
          <div class="inv-bank-row"><span class="k">Bank Name</span><span class="v" id="prev_bank_name">—</span></div>
          <div class="inv-bank-row"><span class="k">Account No.</span><span class="v" id="prev_account_no">—</span></div>
          <div class="inv-bank-row"><span class="k">IFSC Code</span><span class="v" id="prev_ifsc_code">—</span></div>
          <div class="inv-note" id="prev_note_box" style="display:none;">
            <strong>Note:</strong> <span id="prev_note"></span>
          </div>
        </div>
        <div class="inv-sign-block">
          <div class="inv-sign-for">For, <span id="prev_from_name2">Awadh Buildmate</span></div>
          <div class="inv-sign-line" id="prev_proprietor">Harsh Raj Maurya</div>
          <div class="inv-sign-role">Proprietor</div>
        </div>
      </div>

      <!-- Bottom bar -->
      <div class="inv-bottombar">
        <span>Vadodara, Gujarat 390022</span>
        <span id="prev_from_gst2">24GTBPM0457F1ZW</span>
      </div>

    </div>
  </main>

</div>

<script>
let itemCount = 0;

function fmtINR(n) {
  return Math.round(n).toLocaleString('en-IN');
}

function fmtDate(val) {
  if (!val) return '—';
  const d = new Date(val);
  if (isNaN(d)) return val;
  return d.toLocaleDateString('en-IN', { day: '2-digit', month: 'long', year: 'numeric' });
}

function addItem() {
  const idx = itemCount++;
  const row = document.createElement('div');
  row.className = 'item-row';
  row.id = 'item_' + idx;
  row.innerHTML = `
    <input type="text"   name="items[${idx}][particulars]" placeholder="Work description" oninput="updatePreview()">
    <input type="number" name="items[${idx}][qty]"         placeholder="0"   oninput="calcRow(${idx});updatePreview()">
    <input type="number" name="items[${idx}][rate]"        placeholder="0"   oninput="calcRow(${idx});updatePreview()">
    <input type="number" name="items[${idx}][amount]"      id="amount_${idx}" placeholder="0" oninput="updatePreview()">
    <button type="button" class="btn-remove" onclick="removeItem(${idx})" title="Remove">
      <i class="ti ti-x" aria-hidden="true"></i>
    </button>`;
  document.getElementById('itemsContainer').appendChild(row);
}

function removeItem(idx) {
  const el = document.getElementById('item_' + idx);
  if (el && document.querySelectorAll('.item-row').length > 1) {
    el.remove();
    updatePreview();
  }
}

function calcRow(idx) {
  const row = document.getElementById('item_' + idx);
  if (!row) return;
  const qty  = parseFloat(row.querySelector('[name$="[qty]"]')?.value)  || 0;
  const rate = parseFloat(row.querySelector('[name$="[rate]"]')?.value) || 0;
  const amtEl = document.getElementById('amount_' + idx);
  if (amtEl) amtEl.value = Math.round(qty * rate);
}

function setText(id, val) {
  const el = document.getElementById(id);
  if (el) el.textContent = val || '—';
}

function updatePreview() {
  // Basic text fields
  const map = [
    ['from_name','prev_from_name'],['from_address','prev_from_address'],
    ['from_pan','prev_from_pan'],['from_gst','prev_from_gst'],
    ['bill_no','prev_bill_no'],['to_name','prev_to_name'],
    ['to_co','prev_to_co'],['contact_person','prev_contact_person'],
    ['contact_number','prev_contact_number'],
    ['bank_name','prev_bank_name'],['account_no','prev_account_no'],
    ['ifsc_code','prev_ifsc_code'],['proprietor','prev_proprietor']
  ];
  map.forEach(([src, dst]) => {
    const v = document.getElementById(src)?.value || '';
    const el = document.getElementById(dst);
    if (el) el.textContent = v || '—';
  });

  // Extra targets
  const fn2 = document.getElementById('prev_from_name2');
  if (fn2) fn2.textContent = document.getElementById('from_name')?.value || '';
  const gst2 = document.getElementById('prev_from_gst2');
  if (gst2) gst2.textContent = document.getElementById('from_gst')?.value || '';

  // Date
  const bdEl = document.getElementById('bill_date');
  const bdPrev = document.getElementById('prev_bill_date');
  if (bdEl && bdPrev) bdPrev.textContent = fmtDate(bdEl.value);

  // Note
  const note = document.getElementById('note')?.value?.trim();
  const noteBox = document.getElementById('prev_note_box');
  const noteSpan = document.getElementById('prev_note');
  if (noteSpan) noteSpan.textContent = note;
  if (noteBox) noteBox.style.display = note ? 'block' : 'none';

  // Items
  const rows = document.querySelectorAll('.item-row');
  let total = 0;
  let tbody = '';
  rows.forEach((row, i) => {
    const part   = row.querySelector('[name$="[particulars]"]')?.value?.trim();
    const qty    = row.querySelector('[name$="[qty]"]')?.value;
    const rate   = row.querySelector('[name$="[rate]"]')?.value;
    const amount = parseFloat(row.querySelector('[name$="[amount]"]')?.value) || 0;
    total += amount;
    tbody += `<tr>
      <td class="cell-idx">${i+1}</td>
      <td>${part || '<em style="color:var(--text-3)">—</em>'}</td>
      <td class="cell-num" style="text-align:right">${qty || '—'}</td>
      <td class="cell-num" style="text-align:right">${qty && rate ? fmtINR(parseFloat(rate)) : '—'}</td>
      <td class="cell-num" style="text-align:right;font-weight:600">${fmtINR(amount)}</td>
    </tr>`;
  });

  document.getElementById('prev_items_body').innerHTML = tbody ||
    '<tr><td colspan="5" style="text-align:center;color:var(--text-3);padding:24px;font-size:13px;">Add items on the left…</td></tr>';

  // Calculations
  const gstRate = parseFloat(document.getElementById('gst_rate')?.value) || 0;
  const tdsRate = parseFloat(document.getElementById('tds_rate')?.value) || 0;
  const deposit = parseFloat(document.getElementById('deposit')?.value)  || 0;
  const gst     = Math.round(total * gstRate / 100);
  const billAmt = total + gst;
  const tds     = Math.round(total * tdsRate / 100);
  const totalDed = deposit + tds;
  const grand   = billAmt - totalDed;

  document.getElementById('prev_total').textContent         = fmtINR(total);
  document.getElementById('prev_gst_rate_lbl').textContent  = gstRate;
  document.getElementById('prev_gst_amt').textContent       = fmtINR(gst);
  document.getElementById('prev_bill_amt').textContent      = fmtINR(billAmt);
  document.getElementById('prev_deposit').textContent       = fmtINR(deposit);
  document.getElementById('prev_tds_rate_lbl').textContent  = tdsRate;
  document.getElementById('prev_tds_amt').textContent       = fmtINR(tds);
  document.getElementById('prev_total_ded').textContent     = fmtINR(totalDed);
  document.getElementById('prev_grand_total').textContent   = fmtINR(grand);
}

// Init
document.addEventListener('DOMContentLoaded', () => {
  // Set today's date
  document.getElementById('bill_date').value = new Date().toISOString().split('T')[0];
  addItem();
  updatePreview();
});
</script>
</body>
</html>