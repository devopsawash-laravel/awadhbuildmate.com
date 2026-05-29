<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Staff;
use App\Models\StaffSalarySlip;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class StaffSalaryController extends Controller
{

    public function getsalarydashboard()
    {
        return view('salary.salarydashboard');
    }
    public function index(Request $request)
    {
    $month = $request->get('month', now()->month);
    $year = $request->get('year', now()->year);
    // $siteId = $request->get('site_id');
    $siteId = $request->filled('site_id') ? $request->site_id : null;
    /*
    |--------------------------------------------------------------------------
    | Salary Slips
    |--------------------------------------------------------------------------
    */
    $salarySlips = StaffSalarySlip::with(['staff.site'])->when($siteId, function ($query) use ($siteId) 
        {
            $query->whereHas('staff', function ($q) use ($siteId) {
                $q->where('site_id', $siteId);
            });
        })->where('month', $month)->where('year', $year)->latest()->get();

     $staffs = Staff::where('status', 'active')->when($siteId, function ($query) use ($siteId) 
        {
            $query->where('site_id', $siteId);
        })->whereNotIn('id', StaffSalarySlip::where('month', $month)->where('year', $year)->pluck('staff_id'))->orderBy('name')->get();
    // dd($staffs);
    /*
    |--------------------------------------------------------------------------
    | Sites
    |--------------------------------------------------------------------------
    */

    $sites = Site::orderBy('name')->get();

    return view(
        'salary.staff-salary.index',
        compact(
            'salarySlips',
            'staffs',
            'sites',
            'month',
            'year',
            'siteId'
        )
    );
}
    public function generate(Request $request)
    {
        $request->validate([

            'staff_id' => 'required|exists:staff,id',

            'month' => 'required|integer|between:1,12',

            'year' => 'required|integer|min:2000',

            'present_days' => 'required|numeric|min:0|max:31',

            'week_off' => 'nullable|numeric|min:0|max:10',

        ]);

    /*
    |--------------------------------------------------------------------------
    | Staff Details
    |--------------------------------------------------------------------------
    */

    $staff = Staff::findOrFail($request->staff_id);
    $month = $request->month;
    $year = $request->year;
    $presentDays = $request->present_days;
    // dd($presentDays);

    /*
    |--------------------------------------------------------------------------
    | Existing Salary Check
    |--------------------------------------------------------------------------
    */

    $existing = StaffSalarySlip::where('staff_id', $staff->id)->where('month', $month)->where('year', $year)->first();
    if ($existing) {
        return redirect()->route('staff-salary.show', $existing)->with('info','Salary slip already exists.');
    }

    /*
    |--------------------------------------------------------------------------
    | Salary Components
    |--------------------------------------------------------------------------
    */

    $basicSalary =
        $staff->basic_salary ?? 0;

    $hra =
        $staff->hra ?? 0;

    $otherAllowance =
        $staff->other_allowance ?? 0;

    /*
    |--------------------------------------------------------------------------
    | Monthly Salary
    |--------------------------------------------------------------------------
    */

    $monthlySalary =
        $staff->total_salary ?? (
            $basicSalary +
            $hra +
            $otherAllowance
        );

    /*
    |--------------------------------------------------------------------------
    | Total Days In Selected Month
    |--------------------------------------------------------------------------
    */

    $totalDaysInMonth = Carbon::create($year,$month,1)->daysInMonth;

    $dailyWage = round($monthlySalary / $totalDaysInMonth,2);

    $weekOff = $request->week_off ?? 0;

    $presentSalary = round($presentDays * $dailyWage,2);

    $weekOffSalary = round($weekOff * $dailyWage,2);

    $grossSalary = round($presentSalary + $weekOffSalary,2);

    $earnedBasic = round((($staff->basic_salary ?? 0) / $totalDaysInMonth) * ($presentDays + $weekOff),2);

    $earnedHra = round((($staff->hra ?? 0) / $totalDaysInMonth) * ($presentDays + $weekOff),2);

    $earnedOtherAllowance = round((($staff->other_allowance ?? 0) / $totalDaysInMonth) * ($presentDays + $weekOff),2);

    $pfDeduction =
        round(
            ($basicSalary * ($staff->pf_percentage ?? 0)) / 100,
            2
        );

    /*
    |--------------------------------------------------------------------------
    | Other Deductions
    |--------------------------------------------------------------------------
    */

    $advanceDeduction = 0;

    $otherDeduction = 0;

    $totalDeduction =
    ($salary->pf_deduction ?? 0) +
    ($salary->esic_deduction ?? 0) +
    ($salary->advance_deduction ?? 0) +
    ($salary->pt_deduction ?? 0) +
    ($salary->lwf_deduction ?? 0) +
    ($salary->other_deduction ?? 0);

    /*
    |--------------------------------------------------------------------------
    | Net Salary
    |--------------------------------------------------------------------------
    */

    $netSalary =
        round(
            $grossSalary - $totalDeduction,
            2
        );
        

    $slip = StaffSalarySlip::create([
        'staff_id' => $staff->id,
        'site_id' => $staff->site_id,
        'month' => $month,
        'year' => $year,
        'working_days' => $totalDaysInMonth,
        'paid_days' => $presentDays,
        // 'daily_wage' => $dailyWage,
        'basic_salary' => $basicSalary,
        'hra' => $hra,
        'other_allowance' => $otherAllowance,
        'gross_salary' => $grossSalary,
        'pf_deduction' => $pfDeduction,
        'advance_deduction' => $advanceDeduction,
        'other_deduction' => $otherDeduction,
        'total_deduction' => $totalDeduction,
        'net_salary' => $netSalary,
        'week_off' => $weekOff,
        'daily_wage' => $dailyWage,
        'earned_basic' => $earnedBasic,
        'earned_hra' => $earnedHra,
        'earned_other_allowance' => $earnedOtherAllowance,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    return redirect()->route('staff-salary.show', $slip)->with('success','Staff salary generated successfully.');
}

    public function show(int $id)
    {
       $salary = StaffSalarySlip::with('staff.site')->findOrFail($id);
    //    dd($salary);
       return view('salary.staff-salary.show', compact('salary'));
    }
    public function pdf(StaffSalarySlip $salary)
    {
        $salary->load("staff");
        // $pdf = PDF::loadView('salary.pdf', compact('salary'));
        // return $pdf->download('salary-slip-' . $salary->staff->name . '-' . $salary->month . '-' . $salary->year . '.pdf');
    }

   public function destroy(int $id)
{
    $salary = StaffSalarySlip::findOrFail($id);

    $salary->delete();

    return redirect()
        ->route('staff-salary.index')
        ->with(
            'success',
            'Salary slip deleted successfully.'
        );
}


    public function payslip(StaffSalarySlip $salary)
    {
        $salary->load("staff");

        return view("salary.payslip", compact("salary"));
    }
    
    public function updateDeductions(Request $request, StaffSalarySlip $salary)
    {
        // dd($request->all());
        // Manual deductions
        $salary->pf_deduction = $request->pf_deduction ?? 0;
        $salary->esic_deduction = $request->esic_deduction ?? 0;
        $salary->advance_deduction = $request->advance_deduction ?? 0;
        $salary->pt_deduction = $request->pt_deduction ?? 0;
        $salary->lwf_deduction = $request->lwf_deduction ?? 0;
        $salary->other_deduction = $request->other_deduction ?? 0;

        $salary->total_deduction =
            $salary->pf_deduction +
            $salary->esic_deduction +
            $salary->advance_deduction +
            $salary->pt_deduction +
            $salary->lwf_deduction +
            $salary->other_deduction;

        $grossEarned =
            ($salary->earned_basic ?? 0) +
            ($salary->earned_hra ?? 0) +
            ($salary->earned_other_allowance ?? 0);

        $salary->net_salary = $grossEarned - $salary->total_deduction;

        $salary->save();

return back()->with('success','Deductions updated successfully.');

        return redirect()
            ->route("staff-salary.show", $salary->id)
            ->with("success", "Deductions updated successfully.");
    }

    public function bankStatement(Request $request)
    {
        //  $month = $request->month ?? now()->month;

        //  $year = $request->year ?? now()->year;

        // $salaries = SalarySlip::with('staff')
        // ->where('month', $month)
        // ->where('year', $year)
        // ->get();

        // $totalAmount = $salaries->sum('net_salary');

        // return view( 'salary.bank-statement', compact('salaries','totalAmount','month','year'));
        dd("shiva");
    }

    public function test(Request $request)
    {
        $month = $request->month ?? now()->month;

        $year = $request->year ?? now()->year;

        // Sites
        $sites = Site::orderBy("name")->get();

        // Salary Query
        $salaryQuery = StaffSalarySlip::with(["staff.site"])
            ->where("month", $month)
            ->where("year", $year);

        // Site Filter
        if ($request->filled("site_id")) {
            $salaryQuery->whereHas("staff", function ($q) use ($request) {
                $q->where("site_id", $request->site_id);
            });
        }

        $salarySlips = $salaryQuery->orderBy("created_at", "desc")->get();

        $statement = [];

        $totalAmount = 0;

        foreach ($salarySlips as $salary) {
            $statement[] = [
                "account_number" => $salary->staff->Account_Number,

                "name" => $salary->staff->name,
                "ifsc" => $salary->staff->IFSC,

                "site" => $salary->staff->site->name ?? "-",
                "amount" => round($salary->net_salary, 2),
            ];

            $totalAmount += $salary->net_salary;
        }

        return view(
            "salary.bank-statement",
            compact(
                "statement",
                "totalAmount",
                "month",
                "year",
                "sites",
                "salarySlips"
            )
        );
    }

    public function exportBankStatement(Request $request)
    {
        $month = $request->month ?? now()->month;

        $year = $request->year ?? now()->year;

        $salaryQuery = StaffSalarySlip::with(["staff.site"])
            ->where("month", $month)
            ->where("year", $year);

        // Site Filter
        if ($request->filled("site_id")) {
            $salaryQuery->whereHas("staff", function ($q) use ($request) {
                $q->where("site_id", $request->site_id);
            });
        }

        $salarySlips = $salaryQuery->get();

        $filename = "bank_statement_" . $month . "_" . $year . ".csv";

        $headers = [
            "Content-Type" => "text/csv",

            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($salarySlips) {
            $file = fopen("php://output", "w");

            // Heading
            fputcsv($file, [
                "Sr No",

                "Type",

                "Account Number",

                "Employee Name",

                "Site",

                "IFSC",

                "Amount",
            ]);

            $total = 0;

            foreach ($salarySlips as $i => $salary) {
                fputcsv($file, [
                    $i + 1,

                    "NEFT",

                    $salary->staff->Account_Number,

                    $salary->staff->name,

                    $salary->staff->site->name ?? "-",

                    $salary->staff->IFSC,

                    round($salary->net_salary, 2),
                ]);

                $total += $salary->net_salary;
            }

            // Total Row
            fputcsv($file, ["", "", "", "", "", "TOTAL", round($total, 2)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function testwages(Request $request)
    {
        $month = $request->month ?? now()->month;

        $year = $request->year ?? now()->year;

        // Sites
        $sites = Site::orderBy("name")->get();

        // Salary Query
        $salaryQuery = StaffSalarySlip::with(["staff.site"])
            ->where("month", $month)
            ->where("year", $year);

        // Site Filter
        if ($request->filled("site_id")) {
            $salaryQuery->whereHas("staff", function ($q) use ($request) {
                $q->where("site_id", $request->site_id);
            });
        }

        $salarySlips = $salaryQuery->orderBy("created_at", "desc")->get();

        return view(
            "salary.wages-sheet",
            compact("salarySlips", "month", "year", "sites")
        );
    }
}
