<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
   // InvoiceController@create
public function create() {
    return view('invoice.create');
}

// InvoiceController@store
public function store(Request $request) {
    $invoice = Invoice::create($request->except('items'));
    foreach ($request->items as $item) {
        $invoice->items()->create($item);
    }
    return redirect()->route('invoice.index')->with('success', 'Invoice saved!');
}
}
