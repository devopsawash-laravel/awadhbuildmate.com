<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Bank;
use App\Models\Site;
use App\Models\StaffSalarySlip as Salary;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
{
    $q = Staff::with('site');

    if ($request->filled('category')) {
        $q->where('category', $request->category);
    }

    if ($request->filled('status')) {
        $q->where('status', $request->status);
    }

    if ($request->filled('site_id')) {
        $q->where('site_id', $request->site_id);
    }

    if ($request->filled('search')) {
        $q->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('employee_id', 'like', '%' . $request->search . '%');
        });
    }

    // $staff = $q->orderBy('name')->paginate(15);
    $staff = $q->orderBy('employee_id', 'asc')->paginate(15);

    $sites = Site::orderBy('name')->get();

    return view('staff.index', compact('staff', 'sites'));
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // Fetch banks
        $banks = Bank::orderBy('name')->get();

        // Last labour
        $lastLabour = Staff::latest('id')->first();

        $nextNumber = 1;

        if ($lastLabour && $lastLabour->employee_id) {

            $number = (int) str_replace('EMP-', '', $lastLabour->employee_id);

            $nextNumber = $number + 1;
        }

        // Generate Employee ID
        $employeeId = 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $sites = Site::orderby('name')->get();

        // Send to blade
        return view('staff.create', compact('banks', 'employeeId', 'sites'));
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
        // 'relation' => 'nullable|in:Father,Mother,Spouse,Son,Daughter,Brother,Sister,Guardian',
        'relation' => 'nullable|in:Father,Mother,Wife,Husband,Son,Daughter,Brother,Sister,Guardian',
        'ESIC_Number' => 'nullable|string|max:50',
        'UAN' => 'nullable|string|max:50',
        'bank_id' => 'nullable|exists:banks,id', 
        'education' => 'nullable|string|max:255',
        // 'experience' => 'nullable|string|max:255',
        'experience' => 'nullable|numeric|min:0|max:50',
        'site_id' => 'nullable|exists:sites,id',
    ]);

    Staff::create($validated);

    return redirect()->route('staff.index')->with('success', 'Staff added successfully.');
        }

    public function show(Staff $staff)
    {
        $salarySlips = $staff->salarySlips()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('staff.show', compact(
            'staff',
            'salarySlips'
        ));
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
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }

    public function generateStaffSalary()
    {
        return view('salary.staff-salary.index');
    }

    public function salarydashboard()
    {
        return view('salary.salarydashboard');
    }
}
