<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use Illuminate\Http\Request;

class LabourController extends Controller
{
    public function index(Request $request)
    {
        $query = Labour::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('employee_id', 'like', '%' . $request->search . '%');
            });
        }

        $labours = $query->orderBy('name')->paginate(15);
        return view('labours.index', compact('labours'));
    }

    public function create()
    {
        return view('labours.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'employee_id'   => 'required|string|unique:labours',
            'category'      => 'required|in:Welder,Fitter,Helper,Rigger',
            'phone'         => 'nullable|string|max:15',
            'address'       => 'nullable|string',
            'daily_wage'    => 'required|numeric|min:0',
            'overtime_rate' => 'required|numeric|min:0',
            'pf_percentage' => 'required|numeric|min:0|max:100',
            'joining_date'  => 'required|date',
            'status'        => 'required|in:active,inactive',
        ]);

        Labour::create($validated);
        return redirect()->route('labours.index')->with('success', 'Labour added successfully.');
    }

    public function show(Labour $labour)
    {
        $advances = $labour->advances()->orderByDesc('given_date')->get();
        $salarySlips = $labour->salarySlips()->orderByDesc('year')->orderByDesc('month')->get();
        return view('labours.show', compact('labour', 'advances', 'salarySlips'));
    }

    public function edit(Labour $labour)
    {
        return view('labours.edit', compact('labour'));
    }

    public function update(Request $request, Labour $labour)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'employee_id'   => 'required|string|unique:labours,employee_id,' . $labour->id,
            'category'      => 'required|in:Welder,Fitter,Helper,Rigger',
            'phone'         => 'nullable|string|max:15',
            'address'       => 'nullable|string',
            'daily_wage'    => 'required|numeric|min:0',
            'overtime_rate' => 'required|numeric|min:0',
            'pf_percentage' => 'required|numeric|min:0|max:100',
            'joining_date'  => 'required|date',
            'status'        => 'required|in:active,inactive',
        ]);

        $labour->update($validated);
        return redirect()->route('labours.show', $labour)->with('success', 'Labour updated successfully.');
    }

    public function destroy(Labour $labour)
    {
        $labour->delete();
        return redirect()->route('labours.index')->with('success', 'Labour deleted successfully.');
    }
}