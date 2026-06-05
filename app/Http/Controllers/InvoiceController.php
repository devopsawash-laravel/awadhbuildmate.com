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
        // $invoices = Invoice::latest()->paginate(10)->orderby('created_at', 'asc')->get();
        $invoices = Invoice::orderBy('created_at', 'asc')->paginate(10);
        // $invoices = Invoice::latest()->get();
        return view('invoice.index', compact('invoices'));
    }
   // InvoiceController@create
    public function create() {
    $invoices = Invoice::latest()->get();
    return view('invoice.create', compact('invoices'));
}

// InvoiceController@store
    public function store(Request $request)
{
    // dd($request->all());
    $totalAmount = collect($request->items)->sum('amount');

    $gstAmount = $totalAmount * (($request->gst_rate ?? 18) / 100);

    $billAmount = $totalAmount + $gstAmount;

    $tdsAmount = $totalAmount * (($request->tds_rate ?? 5) / 100);

    $totalDeduction = $tdsAmount + ($request->deposit ?? 0);

    $grandTotal = $billAmount - $totalDeduction;

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
    //    return redirect()->route('invoices.create')->with('success', 'Invoice stored successfully!');
}
    public function show(Invoice $invoice)
    {
        $invoice->load('items');

        return view('invoice.show', compact('invoice'));
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
