@extends('layouts.app')

@section('title', 'Invoice #' . $invoice->bill_no)

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<style>
    .inv-wrap {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        color: #1a1a1a;
        max-width: 860px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .inv-card {
        background: #ffffff;
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    /* ── Header ── */
    .inv-header {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: flex-start;
        padding: 2rem 2rem 1.5rem;
        border-bottom: 1px solid #efefef;
    }

    .from-name {
        font-family: 'DM Serif Display', serif;
        font-size: 24px;
        font-weight: 400;
        margin: 0 0 8px;
        color: #111;
    }

    .from-addr {
        font-size: 12px;
        color: #6b6b6b;
        line-height: 1.8;
        margin: 0 0 10px;
    }

    .from-meta {
        font-size: 11px;
        color: #9a9a9a;
        line-height: 1.8;
    }

    .inv-meta-right {
        text-align: right;
    }

    .inv-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #185FA5;
        background: #E6F1FB;
        padding: 4px 10px;
        border-radius: 4px;
        margin-bottom: 12px;
    }

    .inv-no {
        font-family: 'DM Serif Display', serif;
        font-size: 30px;
        font-weight: 400;
        color: #111;
        line-height: 1;
        margin-bottom: 8px;
    }

    .inv-date {
        font-size: 12px;
        color: #6b6b6b;
    }

    /* ── Billing addresses ── */
    .inv-bill {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #efefef;
        gap: 2rem;
        background: #fafafa;
    }

    .sec-label {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #b0b0b0;
        margin: 0 0 6px;
    }

    .billed-name {
        font-size: 14px;
        font-weight: 500;
        color: #111;
        margin: 0 0 2px;
    }

    .billed-co {
        font-size: 12px;
        color: #6b6b6b;
        margin: 0;
    }

    /* ── Line items table ── */
    .inv-table-wrap {
        padding: 1.5rem 2rem;
    }

    table.items {
        width: 100%;
        border-collapse: collapse;
    }

    table.items thead tr {
        border-bottom: 1px solid #e0e0e0;
    }

    table.items th {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #b0b0b0;
        padding: 0 0 10px;
        text-align: left;
    }

    table.items th.r { text-align: right; }

    table.items td {
        padding: 12px 0;
        font-size: 13px;
        color: #1a1a1a;
        border-bottom: 1px solid #f2f2f2;
    }

    table.items td.r {
        text-align: right;
        color: #6b6b6b;
        font-variant-numeric: tabular-nums;
    }

    table.items td.sr {
        color: #c0c0c0;
        width: 28px;
    }

    /* ── Totals ── */
    .totals-row {
        display: flex;
        justify-content: flex-end;
        padding: 0 2rem 1.5rem;
    }

    .totals-box { width: 280px; }

    .totals-line {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 13px;
        color: #6b6b6b;
        border-bottom: 1px solid #f2f2f2;
    }

    .totals-line:last-child { border-bottom: none; }

    .totals-line.grand {
        font-size: 15px;
        font-weight: 500;
        color: #111;
        margin-top: 4px;
    }

    .totals-line.grand .grand-val {
        color: #185FA5;
        font-variant-numeric: tabular-nums;
    }

    /* ── Footer ── */
    .inv-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding: 1.25rem 2rem;
        border-top: 1px solid #efefef;
        background: #fafafa;
    }

    .footer-note {
        font-size: 11px;
        color: #b0b0b0;
        line-height: 1.7;
    }

    .sig-line {
        font-size: 11px;
        color: #6b6b6b;
        text-align: right;
    }

    .sig-name {
        font-family: 'DM Serif Display', serif;
        font-size: 18px;
        font-weight: 400;
        color: #111;
        margin-top: 4px;
    }

    /* ── Action bar ── */
    .inv-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 1.5rem;
        justify-content: space-between;
        align-items: center;
    }

    .inv-actions h3 {
        font-family: 'DM Serif Display', serif;
        font-size: 20px;
        font-weight: 400;
        margin: 0;
        color: #111;
    }

    /* ── Print ── */
    @media print {
        .inv-actions { display: none; }
        .inv-wrap { padding: 0; }
        .inv-card { box-shadow: none; border: none; }
    }
</style>
@endpush

@section('content')

<div class="inv-wrap">

    <div class="inv-actions">
        <h3>Invoice</h3>
        <div>
            <a href="{{ route('invoices.create') }}" class="btn btn-outline-secondary btn-sm">
                New Invoice
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm ms-2">
                Print Invoice
            </button>
        </div>
    </div>

    <div class="inv-card">

        {{-- Header: sender info + invoice number --}}
        <div class="inv-header">
            <div>
                <p class="from-name">{{ $invoice->from_name }}</p>
                <p class="from-addr">{!! nl2br(e($invoice->from_address)) !!}</p>
                <p class="from-meta">
                    PAN &nbsp;{{ $invoice->from_pan }}<br>
                    GST &nbsp;{{ $invoice->from_gst }}
                </p>
            </div>

            <div class="inv-meta-right">
                <div class="inv-badge">Tax Invoice</div>
                <div class="inv-no">#{{ $invoice->bill_no }}</div>
                <div class="inv-date">
                    {{ \Carbon\Carbon::parse($invoice->bill_date)->format('d F Y') }}
                </div>
            </div>
        </div>

        {{-- Billing addresses --}}
        <div class="inv-bill">
            <div>
                <p class="sec-label">Billed from</p>
                <p class="billed-name">{{ $invoice->from_name }}</p>
            </div>
            <div>
                <p class="sec-label">Billed to</p>
                <p class="billed-name">{{ $invoice->to_name }}</p>
                <p class="billed-co">{{ $invoice->to_co }}</p>
            </div>
        </div>

        {{-- Line items --}}
        <div class="inv-table-wrap">
            <table class="items">
                <thead>
                    <tr>
                        <th style="width:28px">#</th>
                        <th>Particulars</th>
                        <th class="r" style="width:60px">Qty</th>
                        <th class="r" style="width:100px">Rate</th>
                        <th class="r" style="width:110px">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td class="sr">{{ $loop->iteration }}</td>
                        <td>{{ $item->particulars }}</td>
                        <td class="r">{{ $item->qty }}</td>
                        <td class="r">₹ {{ number_format($item->rate, 2) }}</td>
                        <td class="r">₹ {{ number_format($item->amount, 2) }}</td>
                    </tr>
                    @endforeach
                 
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="totals-row">
            <div class="totals-box">
                <div class="totals-line">
                    <span>Total Amount</span>
                    <span>₹ {{ number_format($invoice->total_amount, 2) }}</span>
                </div>
                <div class="totals-line">
                    <span>GST Amount</span>
                    <span>₹ {{ number_format($invoice->gst_amount, 2) }}</span>
                </div>
                <div class="totals-line">
                    <span>Bill Amount</span>
                    <span>₹ {{ number_format($invoice->bill_amount, 2) }}</span>
                </div>
                <div class="totals-line">
                    <span>Total Deduction</span>
                    <span>– ₹ {{ number_format($invoice->total_deduction, 2) }}</span>
                </div>
                <div class="totals-line grand">
                    <span>Grand Total</span>
                    <span class="grand-val">₹ {{ number_format($invoice->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="inv-footer">
            <p class="footer-note">
                Thank you for your business.<br>
                Payment due within 30 days of invoice date.
            </p>
            <div class="sig-line">
                Authorised Signatory
                <div class="sig-name">{{ $invoice->from_name }}</div>
            </div>
        </div>

    </div>

</div>
   @if(request('print') == '1')
                    <script>
                    window.onload = function () {
                        window.print();
                    };
                    </script>
                    @endif
@endsection