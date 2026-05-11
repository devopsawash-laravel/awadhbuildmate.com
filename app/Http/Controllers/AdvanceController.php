<?php

namespace App\Http\Controllers;

use App\Models\Advance;
// use App\Models\Labour;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'labour_id'   => 'required|exists:labours,id',
            'amount'      => 'required|numeric|min:1',
            'given_date'  => 'required|date',
            'remarks'     => 'nullable|string|max:255',
        ]);

        Advance::create($request->only(['labour_id', 'amount', 'given_date', 'remarks']));

        return redirect()->route('labours.show', $request->labour_id)
            ->with('success', 'Advance of ₹' . number_format($request->amount, 2) . ' recorded.');
    }

    public function destroy(Advance $advance)
    {
        $labourId = $advance->labour_id;
        $advance->delete();
        return redirect()->route('labours.show', $labourId)->with('success', 'Advance deleted.');
    }
}