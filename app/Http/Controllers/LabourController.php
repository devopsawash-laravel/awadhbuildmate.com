<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Site;


class LabourController extends Controller
{
    public function index(Request $request)
{
    $sites = Site::where('status', 'active')
        ->get();

    $query = Labour::with('site');

    // Search
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where(
                'name',
                'like',
                '%' . $request->search . '%'
            )

            ->orWhere(
                'employee_id',
                'like',
                '%' . $request->search . '%'
            );
        });
    }

    // Category Filter
    if ($request->filled('category')) {

        $query->where(
            'category',
            $request->category
        );
    }

    // Status Filter
    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }

    // Site Filter
    if ($request->filled('site_id')) {
        $query->where('site_id', $request->site_id);
    }

    $labours = $query
        ->orderBy('created_at', 'asc')
        ->paginate(60);

    return view(
        'labours.index',
        compact('labours', 'sites')
    );
}
    public function create()
    {
        // Fetch banks
        $banks = Bank::orderBy('name')->get();

        // Last labour
        $lastLabour = Labour::latest('id')->first();

        $nextNumber = 1;
        if ($lastLabour && $lastLabour->employee_id) {
            $number = (int) str_replace('EMP-', '', $lastLabour->employee_id);
            $nextNumber = $number + 1;
        }
        // Generate Employee ID
        $employeeId = 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // $sites = Site::latest()->get();
        // $sites = Site::where('status', 'active')->get();
        $sites = Site::orderBy('name')->get();
        // dd('$sites');

        // Send to blade
        return view('labours.create', compact('banks', 'employeeId','sites'));

    }

    public function store(Request $request)
    {
       $validated = $request->validate([

        'name' => 'required|string|max:255',
        'employee_id' => 'required|string|unique:labours',
        'category' => 'required|in:Welder,IBR Welder,Electrician,Fitter,Helper,Rigger,Assistant Fitter,Grinder,Taker Welder,Gas Cutter,Khallasi Helper,Visual Grinder,Structure Fitter',
        'phone' => 'nullable|required|regex:/^[6-9]\d{9}$/',
        'address' => 'nullable|string',
        'total_salary' => 'nullable|numeric|min:0',
        'daily_wage' => 'required|numeric|min:0',
        'basic_salary' => 'nullable|numeric|min:0',
        'hra' => 'nullable|numeric|min:0',
        'other_allowance' => 'nullable|numeric|min:0',
        'overtime_rate' => 'required|numeric|min:0',
        'ot_rate_multiplier' => 'nullable|in:1.5,2.0',
        'joining_date' => 'required|date',
        'status' => 'required|in:active,inactive',
        'Account_Number' => 'nullable|string|max:50',
        'Nominee_details' => 'nullable|string|max:255',
        // 'relation' => 'nullable|in:Father,Mother,Spouse,Son,Daughter,Brother,Sister,Guardian',
        'relation' => 'nullable|in:Father,Mother,Wife,Husband,Son,Daughter,Brother,Sister,Guardian',
        'Aadhar_Number' => 'nullable|digits:12',
        'IFSC' => 'nullable|string|max:50',
        // 'Pan_Card' => 'nullable|string|max:50',
        'Pan_Card' => ['nullable','regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
        'ESIC_Number' => 'nullable|string|max:50',
        'UAN' => 'nullable|string|max:50',
        'bank_id' => 'nullable|exists:banks,id',
        'working_hours_per_day' => 'nullable|numeric|in:8,9,10,11,12,13',
        'site_id' => 'required|exists:sites,id',
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
            // return view('labours.edit', compact('labour'));
            $banks = Bank::orderBy('name')->get();
            $sites = Site::orderBy('name')->get();

            return view('labours.edit', compact(
                'labour',
                'banks',
                'sites'
            ));
        }

        public function update(Request $request, Labour $labour)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'employee_id' => 'required|string|unique:labours,employee_id,' . $labour->id,

        'category' => 'required|in:Welder,IBR Welder,Electrician,Fitter,Helper,Rigger,Assistant Fitter,Grinder,Taker Welder,Gas Cutter,Khallasi Helper,Visual Grinder,Structure Fitter',

        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string',

        'total_salary' => 'nullable|numeric|min:0',
        'working_days' => 'nullable|integer|min:0',
        'daily_wage' => 'nullable|numeric|min:0',

        'basic_salary' => 'nullable|numeric|min:0',
        'hra' => 'nullable|numeric|min:0',
        'other_allowance' => 'nullable|numeric|min:0',

        'working_hours_per_day' => 'nullable|integer|min:0',
        'ot_rate_multiplier' => 'nullable|numeric|min:0',
        'overtime_rate' => 'nullable|numeric|min:0',

        'pf_percentage' => 'nullable|numeric|min:0|max:100',

        'joining_date' => 'required|date',
        'status' => 'required|in:active,inactive',

        'Account_Number' => 'nullable|string|max:50',
        'IFSC' => 'nullable|string|max:50',

        'Pan_Card' => [
            'nullable',
            'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'
        ],

        'Aadhar_Number' => 'nullable|string|max:50',

        'Nominee_details' => 'nullable|string|max:255',

        'relation' => 'nullable|in:Father,Mother,Wife,Husband,Son,Daughter,Brother,Sister,Guardian',

        'ESIC_Number' => 'nullable|string|max:50',
        'UAN' => 'nullable|string|max:50',

        'bank_id' => 'nullable|exists:banks,id',
        'site_id' => 'nullable|exists:sites,id',
    ]);

    $labour->update($validated);

    return redirect()
        ->route('labours.show', $labour)
        ->with('success', 'Labour updated successfully.');
}

    public function destroy(Labour $labour)
    {
        $labour->delete();
        return redirect()->route('labours.index')->with('success', 'Labour deleted successfully.');
    }

    public function toggleStatus(Labour $labour)
    {
        $labour->status =
            $labour->status === 'active'
                ? 'inactive'
                : 'active';

        $labour->save();

        return back()->with(
            'success',
            'Labour status updated successfully.'
        );
    }
    //For site wise labour adding
}