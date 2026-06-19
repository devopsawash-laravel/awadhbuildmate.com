<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'asc')->paginate(10);
        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        $invoices = Invoice::latest()->get();
        return view('invoice.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $totalAmount    = collect($request->items)->sum('amount');
        $gstAmount      = $totalAmount * (($request->gst_rate ?? 18) / 100);
        $billAmount     = $totalAmount + $gstAmount;
        $tdsAmount      = $totalAmount * (($request->tds_rate ?? 5) / 100);
        $totalDeduction = $tdsAmount + ($request->deposit ?? 0);
        $grandTotal     = $billAmount - $totalDeduction;

        $invoice = Invoice::create([
            ...$request->except('items'),
            'total_amount'    => $totalAmount,
            'gst_amount'      => $gstAmount,
            'bill_amount'     => $billAmount,
            'tds_amount'      => $tdsAmount,
            'total_deduction' => $totalDeduction,
            'grand_total'     => $grandTotal,
        ]);

        foreach ($request->items as $item) {
            $invoice->items()->create($item);
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice saved successfully!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('items');
        return view('invoice.show', compact('invoice'));
    }

    // ─── EDIT: Load invoice + its items into the edit form ───────────────────
    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        return view('invoice.edit', compact('invoice'));
    }

    // ─── UPDATE: Recalculate totals, sync items, save ────────────────────────
    // ─── UPDATE: Replace ...$request->except() with array_merge() ────────────────
public function update(Request $request, Invoice $invoice)
{
    $totalAmount    = collect($request->items)->sum('amount');
    $gstAmount      = $totalAmount * (($request->gst_rate ?? 18) / 100);
    $billAmount     = $totalAmount + $gstAmount;
    $tdsAmount      = $totalAmount * (($request->tds_rate ?? 5) / 100);
    $totalDeduction = $tdsAmount + ($request->deposit ?? 0);
    $grandTotal     = $billAmount - $totalDeduction;

    $invoice->update(array_merge(
        $request->except(['items', '_token', '_method']),
        [
            'total_amount'    => $totalAmount,
            'gst_amount'      => $gstAmount,
            'bill_amount'     => $billAmount,
            'tds_amount'      => $tdsAmount,
            'total_deduction' => $totalDeduction,
            'grand_total'     => $grandTotal,
        ]
    ));

    // Delete old items and re-insert fresh ones
    $invoice->items()->delete();

    foreach ($request->items as $item) {
        $invoice->items()->create($item);
    }

    return redirect()->route('invoice.index')
        ->with('success', 'Invoice #' . $invoice->bill_no . ' updated successfully!');
}

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully!');
    }

    public function updatePayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'received_amount' => 'required|numeric|min:0'
        ]);

        $invoice->received_amount = $request->received_amount;

        if ($invoice->received_amount >= $invoice->grand_total) {
            $invoice->payment_status = 'Received';
        } elseif ($invoice->received_amount > 0) {
            $invoice->payment_status = 'Partial';
        } else {
            $invoice->payment_status = 'Pending';
        }

        $invoice->save();

        return back()->with('success', 'Payment updated successfully.');
    }
}