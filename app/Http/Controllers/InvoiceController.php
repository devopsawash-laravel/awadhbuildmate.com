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
        $invoices = Invoice::latest()->get();

        return view('invoice.index', compact('invoices'));
    }
   // InvoiceController@create
    public function create() {  
        return view('invoice.create');
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

    return redirect()
        ->route('invoices.create')
        ->with('success', 'Invoice stored successfully!');
}
    }
