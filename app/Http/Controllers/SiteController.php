<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Advance;
use App\Models\Attendance;
use App\Models\Labour;
use App\Models\Staff;
use App\Models\SalarySlip;
use App\Models\StaffSalarySlip;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
        */
   public function index()
{
    $sites = Site::orderBy('name')->get();

    foreach ($sites as $site) {

        // Labour Count
        $site->worked_labours = Attendance::whereHas('labour', function ($q) use ($site) {
                $q->where('site_id', $site->id);
            })
            ->distinct('labour_id')
            ->count('labour_id');

        // Progress Calculation
        if ($site->start_date && $site->expected_end_date) {

            $start = \Carbon\Carbon::parse($site->start_date);
            $end   = \Carbon\Carbon::parse($site->expected_end_date);
            $today = now();

            if ($site->status == 'Completed') {

                $site->progress = 100;

            } elseif ($today->lt($start)) {

                $site->progress = 0;

            } elseif ($today->gte($end)) {

                $site->progress = 100;

            } else {

                $totalDays = max($start->diffInDays($end), 1);
                $elapsedDays = $start->diffInDays($today);

                $site->progress = round(($elapsedDays / $totalDays) * 100);
            }

        } else {

            $site->progress = 0;
        }

        // Ongoing Projects
        $site->ongoing_projects = strtolower($site->status) == 'active' ? 1 : 0;

        // Total Projects
        $site->projects_count = 1;
    }

    return view('sites.index', compact('sites'));
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("sites.create");
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
            "name" => "required",

            "slug" => "required|unique:sites",

            "location" => "required",

            "status" => "required",
        ]);

        Site::create($request->all());

        return redirect()
            ->route("sites.index")
            ->with("success", "Site added successfully.");
    }
    public function show(Site $site)
    {
        // Labours
        $selectedMonth = request("month", now()->month);

        $selectedYear = request("year", now()->year);

        // Attendance Labour IDs
        $attendanceLabourIds = Attendance::whereMonth("date", $selectedMonth)
            ->whereYear("date", $selectedYear)
            ->whereHas("labour", function ($q) use ($site) {
                $q->where("site_id", $site->id);
            })
            ->pluck("labour_id")
            ->unique();
      
           // Salary Slips Labour's
            $salarySlips = SalarySlip::where('site_id', $site->id)
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->get();

        //-----Staff's----------//
            $staffSalarySlips = StaffSalarySlip::where('site_id', $site->id)
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->get();

        $labours = Labour::whereIn('id',$salarySlips->pluck('labour_id')->unique())->get()->map(function ($labour) {
        $labour->type = 'Labour';
        return $labour;
    });
              // Staff
        $staffs = Staff::whereIn('id',$staffSalarySlips->pluck('staff_id')->unique())->get()->map(function ($staff) use ($staffSalarySlips) {

            $staff->type = 'Staff';

            $staff->daily_wage = $staffSalarySlips
                ->firstWhere('staff_id', $staff->id)
                ?->daily_wage ?? 0;

            return $staff;
        });
        
        // dd($staffs);
        $countLS= $staffs->count() + $labours->count();

        // Advances
        $advances = Advance::whereHas("labour", function ($q) use ($site) {
            $q->where("site_id", $site->id);
        })->get();
        

        $totalSalary = $salarySlips->sum('net_salary') + $staffSalarySlips->sum('net_salary');
        // dd($totalSalary);
        // $employees = $labours->concat($staffs);
        $employees = $labours->concat($staffs)->map(function ($employee) use ($salarySlips, $staffSalarySlips) {

            if ($employee->type === 'Labour') {

                $employee->salarySlip = $salarySlips
                    ->firstWhere('labour_id', $employee->id);

            } else {

                $employee->salarySlip = $staffSalarySlips
                    ->firstWhere('staff_id', $employee->id);
            }

            return $employee;
        });

        $attendanceRecords = Attendance::with("labour")
            ->whereHas("labour", function ($q) use ($site) {
                $q->where("site_id", $site->id);
            })
            ->whereMonth("date", $selectedMonth)
            ->whereYear("date", $selectedYear)
            ->latest()
            ->get();

        $attendanceCount = $attendanceRecords->count();
        return view(
            "sites.show",
            compact(
                "site",
                "labours",
                "staffs",
                "salarySlips",
                "staffSalarySlips",
                "advances",
                "attendanceCount",
                "attendanceRecords",
                "selectedMonth",
                "selectedYear","attendanceLabourIds",
                "totalSalary",
                "countLS",
                "employees"
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function edit($id)
    {
        $site = Site::findOrFail($id);

        return view('sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'name'              => 'required',
            'slug'              => 'required|unique:sites,slug,' . $site->id,
            'location'          => 'required',
            'status'            => 'required',
            'start_date'        => 'nullable',
            'expected_end_date' => 'nullable',
        ]);
        
        $site->update($validated);

        return redirect()
            ->route('sites.index')
            ->with('success', 'Site updated successfully.');
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
