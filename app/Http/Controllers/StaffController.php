<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Bank;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = staff::query();
        if ($request->filled('category')) {
            $q->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $q->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('employee_id', 'like', '%' . $request->search . '%');
            });
        }

        $staff = $q->orderBy('name')->paginate(15);
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // Fetch banks
        $banks = Bank::orderBy('bank_name')->get();

        // Last labour
        $lastLabour = Staff::latest('id')->first();

        $nextNumber = 1;

        if ($lastLabour && $lastLabour->employee_id) {

            $number = (int) str_replace('EMP-', '', $lastLabour->employee_id);

            $nextNumber = $number + 1;
        }

        // Generate Employee ID
        $employeeId = 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Send to blade
        return view('staff.create', compact('banks', 'employeeId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'employee_id' => 'required|string|unique:staff',
        'category' => 'required|in:Site Incharge,QC-Quality,Safety Supervisor,Planning,Execution,Admin,Supervisor',
        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string',
        'total_salary' => 'nullable|numeric|min:0',
        'working_days' => 'nullable|integer|min:0',
        'daily_wage' => 'nullable|numeric|min:0',
        'basic_salary' => 'nullable|numeric|min:0',
        'hra' => 'nullable|numeric|min:0',
        'other_allowance' => 'nullable|numeric|min:0',
        'pf_percentage' => 'nullable|numeric|min:0|max:100',
        'joining_date' => 'required|date',
        'status' => 'required|in:active,inactive',
        'Account_Number' => 'nullable|string|max:50',
        'IFSC' => 'nullable|string|max:50',
        'Pan_Card' => 'nullable|string|max:50',
        'Aadhar_Number' => 'nullable|string|max:50',
        'Nominee_details' => 'nullable|string|max:255',
        'relation' => 'nullable|in:Father,Mother,Spouse,Son,Daughter,Brother,Sister,Guardian',
        'ESIC_Number' => 'nullable|string|max:50',
        'UAN' => 'nullable|string|max:50',
        'bank_id' => 'nullable|exists:banks,id', 
    ]);

    Staff::create($validated);

    return redirect()->route('staff.index')->with('success', 'Staff added successfully.');
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
