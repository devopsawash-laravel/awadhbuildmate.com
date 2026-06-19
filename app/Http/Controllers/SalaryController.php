<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Attendance;
use App\Models\Labour;
use App\Models\SalarySlip;
use App\Models\StaffSalarySlip;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get("month", Carbon::now()->month);

        $year = $request->get("year", Carbon::now()->year);

        // Fetch Sites
        $sites = Site::orderBy("name")->get();

        // Salary Slip Query
        $salaryQuery = SalarySlip::with(["labour.site"])
            ->where("month", $month)
            ->where("year", $year);

        // Site Filter
        if ($request->filled("site_id")) {
            $salaryQuery->whereHas("labour", function ($q) use ($request) {
                $q->where("site_id", $request->site_id);
            });
        }

        $salarySlips = $salaryQuery->orderBy("created_at", "desc")->get();

        // Active Labour Query
        $labourQuery = Labour::where("status", "active");

        // Site Filter for Labour List
        if ($request->filled("site_id")) {
            $labourQuery->where("site_id", $request->site_id);
        }
        $attendanceLabourIds = Attendance::whereMonth("date", $month)
            ->whereYear("date", $year)
            ->pluck("labour_id")
            ->unique();
        $labours = Labour::with("site")
            ->where("status", "active")
            ->whereIn("id", $attendanceLabourIds)
            ->when($request->site_id, function ($q) use ($request) {
                $q->where("site_id", $request->site_id);
            })
            ->orderBy("name")
            ->get();

        return view(
            "salary.index",
            compact("salarySlips", "labours", "month", "year", "sites")
        );
    }

    public function generate(Request $request)
    {
        $request->validate([
            "labour_id" => "required|exists:labours,id",
            "month" => "required|integer|between:1,12",
            "year" => "required|integer|min:2000",
        ]);

        $labour = Labour::findOrFail($request->labour_id);
        // $sites = Site::orderBy("name")->get();
        $month = $request->month;
        $year = $request->year;

        // Already generated check
        $existing = SalarySlip::where("labour_id", $labour->id)
            ->where("month", $month)
            ->where("year", $year)
            ->first();

        if ($existing) {
            return redirect()
                ->route("salary.show", $existing)
                ->with("info", "Salary slip already exists.");
        }
        

        // Attendance
        // $attendances = Attendance::where('labour_id', $labour->id)
        //     ->whereMonth('date', $month)
        //     ->whereYear('date', $year)
        //     ->get();
        $attendances = Attendance::where("labour_id", $labour->id)
            ->whereMonth("date", $request->month)
            ->whereYear("date", $request->year)
            ->when($request->site_id, function ($q) use ($request) {
                $q->where(function ($qq) use ($request) {
                    $qq->where("site_id", $request->site_id)
                    ->orWhereNull("site_id");
                });
            })
            ->get();

        $presentDays = $attendances->where("status", "present")->count();

        $halfDays = $attendances->where("status", "half_day")->count();

        $absentDays = $attendances->where("status", "absent")->count();

        $weekOffDays = $attendances->where("status", "week_off")->count();

        $total_sal = $labour->total_salary;
        $totalworkingdays = $labour->working_days;
        // dd($total_sal);

        // dd( "{{$weekOffDays}} ");

        $paidDays = $presentDays + $halfDays * 0.5 + $weekOffDays;

        // $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        $daysInMonth = $labour->working_days;
        // dd($presentDays);

        // Overtime
        $totalOvertimeHours = $attendances->sum("overtime_hours");

        $overtimeRate = $labour->overtime_rate ?? 0;

        $overtimeAmount = $overtimeRate * $totalOvertimeHours;

        // Salary components
        $basicSalary = $labour->basic_salary ?? 0;

        $hra = $labour->hra ?? 0;

        $otherAllowance = $labour->other_allowance ?? 0;

        // Earned salary calculations
        $earnedBasic = ($basicSalary / $daysInMonth) * $paidDays;
        // $earnedBasic = ($total_sal / $totalworkingdays ) * $paidDays;

        // Grossincome =  total_salary/working_days in month
        $earnedHra = ($hra / $daysInMonth) * $paidDays;

        $earnedOtherAllowance = ($otherAllowance / $daysInMonth) * $paidDays;

        $earnedSalary = $earnedBasic + $earnedHra + $earnedOtherAllowance;
        // dd($earnedSalary);

        // Gross salary
        $grossSalary = $earnedSalary + $overtimeAmount;
        // dd($grossSalary);
        // PF deduction
        // $pfDeduction =
        //     ($earnedBasic * ($labour->pf_percentage ?? 0)) / 100;
        $pfDeduction = 0;

        // Advance deduction
        $pendingAdvances = Advance::where("labour_id", $labour->id)
            ->where("is_deducted", false)
            ->get();

        $advanceDeduction = $pendingAdvances->sum("amount");

        // Total deduction
        $totalDeduction = $pfDeduction + $advanceDeduction;

        // Net salary
        $netSalary = round($grossSalary - $totalDeduction);

        // Create Salary Slip
        $slip = SalarySlip::create([
            "labour_id" => $labour->id,

            "month" => $month,
            "year" => $year,

            "total_days" => $daysInMonth,

            "present_days" => $presentDays,
            "half_days" => $halfDays,
            "absent_days" => $absentDays,
            "week_off_days" => $weekOffDays,

            "daily_wage" => $labour->daily_wage,

            "basic_salary" => $basicSalary,

            "overtime_hours" => $totalOvertimeHours,
            "overtime_rate" => $overtimeRate,
            "overtime_amount" => $overtimeAmount,

            "gross_salary" => $grossSalary,

            "pf_percentage" => $labour->pf_percentage,
            "pf_deduction" => $pfDeduction,

            "advance_deduction" => $advanceDeduction,

            "other_deduction" => 0,

            "total_deduction" => $totalDeduction,

            "net_salary" => $netSalary,

            // Earned fields
            "earned_basic" => $earnedBasic,

            "earned_hra" => $earnedHra,

            "earned_other_allowance" => $earnedOtherAllowance,

            "earned_salary" => $earnedSalary,

            'site_id' => $labour->site_id,

            // 'week_off_days' => $labour->
        ]);

        // Mark advances deducted
        Advance::where("labour_id", $labour->id)
            ->where("is_deducted", false)
            ->update([
                "is_deducted" => true,
            ]);

        return redirect()
            ->route("salary.show", $slip)
            ->with("success", "Salary slip generated successfully.");
    }

    public function show(SalarySlip $salary)
    {
        $salary->load("labour");

        return view("salary.show", compact("salary"));
    }

    public function pdf(SalarySlip $salary)
    {
        $salary->load("labour");
        // $pdf = PDF::loadView('salary.pdf', compact('salary'));
        // return $pdf->download('salary-slip-' . $salary->labour->name . '-' . $salary->month . '-' . $salary->year . '.pdf');
    }

    public function destroy(SalarySlip $salary)
    {
        // Unmark advances
        Advance::where("labour_id", $salary->labour_id)
            ->whereMonth("updated_at", $salary->month)
            ->whereYear("updated_at", $salary->year)
            ->update(["is_deducted" => false]);

        $salary->delete();

        return redirect()
            ->route("salary.index")
            ->with("success", "Salary slip deleted.");
    }

    public function payslip(SalarySlip $salary)
    {
        $salary->load("labour");

        return view("salary.payslip", compact("salary"));
    }

    public function updateDeductions(Request $request, SalarySlip $salary)
    {
        // Manual deductions
        $salary->pf_deduction = $request->pf_deduction ?? 0;

        $salary->esic_deduction = $request->esic_deduction ?? 0;

        $salary->advance_deduction = $request->advance_deduction ?? 0;

        $salary->pt_deduction = $request->pt_deduction ?? 0;

        $salary->lwf_deduction = $request->lwf_deduction ?? 0;

        $salary->other_deduction = $request->other_deduction ?? 0;

        // Total deduction
        $salary->total_deduction =
            ($salary->pf_deduction ?? 0) +
            ($salary->esic_deduction ?? 0) +
            ($salary->advance_deduction ?? 0) +
            ($salary->pt_deduction ?? 0) +
            ($salary->lwf_deduction ?? 0) +
            ($salary->other_deduction ?? 0);

        // Net salary
        $salary->net_salary =
            ($salary->gross_salary ?? 0) - ($salary->total_deduction ?? 0);

        $salary->save();

        return redirect()
            ->route("salary.show", $salary->id)
            ->with("success", "Deductions updated successfully.");
    }

    public function bankStatement(Request $request)
    {
        //  $month = $request->month ?? now()->month;

        //  $year = $request->year ?? now()->year;

        // $salaries = SalarySlip::with('labour')
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

        $sites = Site::orderBy('name')->get();

        // Labour Salaries
        $salaryQuery = SalarySlip::with(['labour.site'])
            ->where('month', $month)
            ->where('year', $year);

        if ($request->filled('site_id')) {
            $salaryQuery->where('site_id', $request->site_id);
        }

        $salarySlips = $salaryQuery->get();

        // Staff Salaries
        $staffQuery = StaffSalarySlip::with(['staff.site'])
            ->where('month', $month)
            ->where('year', $year);

        if ($request->filled('site_id')) {
            $staffQuery->where('site_id', $request->site_id);
        }

        $staffSalaries = $staffQuery->get();

        $statement = [];
        $totalAmount = 0;

        // Labour Records
        foreach ($salarySlips as $salary) {
            $statement[] = [
                'employee_type' => 'Labour',
                'account_number' => $salary->labour->Account_Number,
                'name' => $salary->labour->name,
                'ifsc' => $salary->labour->IFSC,
                'site' => $salary->labour->site->name ?? '-',
                'amount' => round($salary->net_salary, 2),
            ];

            $totalAmount += $salary->net_salary;
        }

        // Staff Records
        foreach ($staffSalaries as $salary) {
            $statement[] = [
                'employee_type' => 'Staff',
                'account_number' => $salary->staff->Account_Number,
                'name' => $salary->staff->name,
                'ifsc' => $salary->staff->IFSC,
                'site' => $salary->staff->site->name ?? '-',
                'amount' => round($salary->net_salary, 2),
            ];

            $totalAmount += $salary->net_salary;
        }

        return view(
            'salary.bank-statement',
            compact(
                'statement',
                'totalAmount',
                'month',
                'year',
                'sites'
            )
        );
    }
    public function exportBankStatement(Request $request)
{
    $month = $request->month ?? now()->month;
    $year  = $request->year ?? now()->year;

    // Labour Salaries
    $salaryQuery = SalarySlip::with(['labour.site'])
        ->where('month', $month)
        ->where('year', $year);

    if ($request->filled('site_id')) {
        $salaryQuery->where('site_id', $request->site_id);
    }

    $salarySlips = $salaryQuery->get();

    // Staff Salaries
    $staffQuery = StaffSalarySlip::with(['staff.site'])
        ->where('month', $month)
        ->where('year', $year);

        if ($request->filled('site_id')) {
        $staffQuery->where('site_id', $request->site_id);
    }

    $staffSalaries = $staffQuery->get();

    $filename = "bank_statement_{$month}_{$year}.csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function () use ($salarySlips, $staffSalaries) {

        $file = fopen("php://output", "w");

        fputcsv($file, [
            "Sr No",
            "Type",
            "Account Number",
            "Employee Name",
            "Employee Type",
            "Site",
            "IFSC",
            "Amount"
        ]);

        $total = 0;
        $srNo = 1;

        // Labour Records
        foreach ($salarySlips as $salary) {

            fputcsv($file, [
                $srNo++,
                "NEFT",
                $salary->labour->Account_Number,
                $salary->labour->name,
                "Labour",
                $salary->labour->site->name ?? "-",
                $salary->labour->IFSC,
                round($salary->net_salary, 2),
            ]);

            $total += $salary->net_salary;
        }
        
        // Staff Records
        foreach ($staffSalaries as $salary) {

            fputcsv($file, [
                $srNo++,
                "NEFT",
                $salary->staff->Account_Number,
                $salary->staff->name,
                "Staff",
                $salary->staff->site->name ?? "-",
                $salary->staff->IFSC,
                round($salary->net_salary, 2),
            ]);

            $total += $salary->net_salary;
        }

        // Total Row
        fputcsv($file, [
            '',
            '',
            '',
            '',
            '',
            '',
            'TOTAL',
            round($total, 2)
        ]);

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
    public function testwages(Request $request)
{
    $month = $request->month ?? now()->month;
    $year = $request->year ?? now()->year;

    $sites = Site::orderBy("name")->get();

    // Labour Salaries
    $salaryQuery = SalarySlip::with(["labour.site"])
        ->where("month", $month)
        ->where("year", $year);

     if ($request->filled('site_id')) {
        $salaryQuery->where('site_id', $request->site_id);
    }

    $salarySlips = $salaryQuery
        ->orderBy("created_at", "desc")
        ->get();

    // Staff Salaries
    $staffSalarySlips = StaffSalarySlip::with(["staff.site"])
    ->where("month", $month)
    ->where("year", $year);

    if ($request->filled('site_id')) {
        $staffSalarySlips->where('site_id', $request->site_id);
    }
    $staffSalarySlips = $staffSalarySlips
        ->orderBy("created_at", "desc")
        ->get();

    $combinedSlips = collect();

    foreach ($salarySlips as $salary) {
        $salary->employee_type = 'Labour';
        $salary->employee = $salary->labour;
        $combinedSlips->push($salary);
        // dd($salarySlips);
    }

    foreach ($staffSalarySlips as $salary) {
        $salary->employee_type = 'Staff';
        $salary->employee = $salary->staff;
        // $salary->working_days = $salary->paid_days ?? 0;
        $combinedSlips->push($salary);
    } 
    
    //dd($salary);
    // dd($staffSalarySlips);
    // dd($combinedSlips);
    return view(
        "salary.wages-sheet",
        compact(
            "combinedSlips",
            "month",
            "year",
            "sites"
        )
    );
 }
 public function exportReport(Request $request)
{
    $month = $request->month ?? now()->month;
    $year  = $request->year ?? now()->year;

    // Labour
    $salaryQuery = SalarySlip::with(['labour.site'])
        ->where('month', $month)
        ->where('year', $year);

    if ($request->filled('site_id')) {
        $salaryQuery->whereHas('labour', function ($q) use ($request) {
            $q->where('site_id', $request->site_id);
        });
    }

    $salarySlips = $salaryQuery->get();

    // Staff
    $staffSalaryQuery = StaffSalarySlip::with(['staff.site'])
        ->where('month', $month)
        ->where('year', $year);

    if ($request->filled('site_id')) {
        $staffSalaryQuery->whereHas('staff', function ($q) use ($request) {
            $q->where('site_id', $request->site_id);
        });
    }

    $staffSalarySlips = $staffSalaryQuery->get();

    $combinedSlips = collect();

    foreach ($salarySlips as $salary) {
        $salary->employee_type = 'Labour';
        $salary->employee = $salary->labour;
        $combinedSlips->push($salary);
    }

    foreach ($staffSalarySlips as $salary) {
        $salary->employee_type = 'Staff';
        $salary->employee = $salary->staff;
        $combinedSlips->push($salary);
    }

    $filename = "Wages_Sheet_{$month}_{$year}.csv";

    return response()->streamDownload(function () use ($combinedSlips) {

        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Sr',
            'Type',
            'Name of Workman',
            'Designation',
            'Present Days',
            'OT Hours',

            'Actual Basic',
            'Actual HRA',
            'Actual Allowance',
            'Actual Gross',

            'Earned Basic',
            'Earned HRA',
            'Earned Allowance',
            'OT Amount',
            'Earned Gross',

            'PF',
            'ESIC',
            'PT',
            'ADV',
            'LWF',
            'Others',
            'Total Deduction',

            'Total Payable'
        ]);

        // Totals
        $totalPaidDays = 0;
        $totalOtHours = 0;
        $totalActualBasic = 0;
        $totalActualHra = 0;
        $totalActualAllowance = 0;
        $totalActualGross = 0;
        $totalEarnedBasic = 0;
        $totalEarnedHra = 0;
        $totalEarnedAllowance = 0;
        $totalOtAmount = 0;
        $totalEarnedGross = 0;
        $totalPf = 0;
        $totalEsic = 0;
        $totalPt = 0;
        $totalAdv = 0;
        $totalLWF = 0;
        $totalOther = 0;
        $grandTotalDeduction = 0;
        $grandTotalPayable = 0;

        foreach ($combinedSlips as $i => $salary) {

    $employee = $salary->employee;

    $workingHoursPerDay = $employee->working_hours_per_day ?? 8;
    $otMultiplier       = $employee->ot_rate_multiplier ?? 1;

    // OT Calculation
    $effectiveOtHours = ($salary->overtime_hours ?? 0) * $otMultiplier;
    $otDays = round($effectiveOtHours / $workingHoursPerDay, 2);
    $finalOtHours       = ($salary->overtime_hours ?? 0) * ($salary->ot_rate_multiplier ?? 1);
    $totalOTHours       = ($finalOtHours) * 2;

    // Present Days
    if ($salary->employee_type == 'Staff') {

        $presentDays = ($salary->paid_days ?? 0)
                     + ($salary->week_off ?? 0);

    } else {

        $paidDays = ($salary->present_days ?? 0)
                  + (($salary->half_days ?? 0) * 0.5)
                  + ($salary->week_off_days ?? 0);

        $presentDays = round(($paidDays + $otDays) * 10) / 10;
    }

    $actualGross =
        ($employee->basic_salary ?? 0)
        + ($employee->hra ?? 0)
        + ($employee->other_allowance ?? 0);

    $earnedGross =
        ($salary->earned_basic ?? 0)
        + ($salary->earned_hra ?? 0)
        + ($salary->earned_other_allowance ?? 0)
        + ($salary->overtime_amount ?? 0);

    // Totals
    $totalPaidDays += $presentDays;

    // IMPORTANT: Use actual OT hours, not multiplied hours
    $totalOtHours += $totalOTHours;

    $totalActualBasic += ($employee->basic_salary ?? 0);
    $totalActualHra += ($employee->hra ?? 0);
    $totalActualAllowance += ($employee->other_allowance ?? 0);
    $totalActualGross += $actualGross;

    $totalEarnedBasic += ($salary->earned_basic ?? 0);
    $totalEarnedHra += ($salary->earned_hra ?? 0);
    $totalEarnedAllowance += ($salary->earned_other_allowance ?? 0);
    $totalOtAmount += ($salary->overtime_amount ?? 0);
    $totalEarnedGross += $earnedGross;

    $totalPf += ($salary->pf_deduction ?? 0);
    $totalEsic += ($salary->esic_deduction ?? 0);
    $totalPt += ($salary->pt_deduction ?? 0);
    $totalAdv += ($salary->advance_deduction ?? 0);
    $totalLWF += ($salary->lwf_deduction ?? 0);
    $totalOther += ($salary->other_deduction ?? 0);

    $grandTotalDeduction += ($salary->total_deduction ?? 0);
    $grandTotalPayable += ($salary->net_salary ?? 0);

    fputcsv($file, [
        $i + 1,
        $salary->employee_type,
        $employee->name,
        $employee->category ?? $employee->designation,
        $presentDays,
        // $salary->overtime_hours ?? 0,
        number_format($effectiveOtHours, 1, '.', ''),

        $employee->basic_salary ?? 0,
        $employee->hra ?? 0,
        $employee->other_allowance ?? 0,
        $actualGross,

        $salary->earned_basic ?? 0,
        $salary->earned_hra ?? 0,
        $salary->earned_other_allowance ?? 0,
        $salary->overtime_amount ?? 0,
        $earnedGross,

        $salary->pf_deduction ?? 0,
        $salary->esic_deduction ?? 0,
        $salary->pt_deduction ?? 0,
        $salary->advance_deduction ?? 0,
        $salary->lwf_deduction ?? 0,
        $salary->other_deduction ?? 0,
        $salary->total_deduction ?? 0,

        $salary->net_salary ?? 0,
    ]);
}
        // TOTAL ROW
        fputcsv($file, []);

        fputcsv($file, [
            'TOTAL',
            '',
            '',
            '',
            number_format($totalPaidDays, 1, '.', ''),
            number_format($totalOtHours, 1, '.', ''),

            round($totalActualBasic),
            round($totalActualHra),
            round($totalActualAllowance),
            round($totalActualGross),

            round($totalEarnedBasic),
            round($totalEarnedHra),
            round($totalEarnedAllowance),
            round($totalOtAmount),
            round($totalEarnedGross),

            round($totalPf),
            round($totalEsic),
            round($totalPt),
            round($totalAdv),
            round($totalLWF),
            round($totalOther),
            round($grandTotalDeduction),

            round($grandTotalPayable),
        ]);

        fclose($file);

    }, $filename);
}


public function bulkPdf(Request $request)
{
    $salarySlips = SalarySlip::with([
        'labour.site',
        'labour.bank'
    ])
    ->where('month', $request->month)
    ->where('year', $request->year)
    ->get();

    $pdf = Pdf::loadView('salary.bulkpdf', compact('salarySlips'))
        ->setPaper('a4', 'portrait');

    return $pdf->download(
        'Salary-Slips-'.$request->month.'-'.$request->year.'.pdf'
    );
}
public function bulkPdfstaff(Request $request)
{
    $salarySlips = StaffSalarySlip::with([
        'staff.site',
        'staff.bank'
    ])
    ->where('month', $request->month)
    ->where('year', $request->year);

    // Filter by site if selected
    if ($request->filled('site_id')) {
        $salarySlips->whereHas('staff', function ($q) use ($request) {
            $q->where('site_id', $request->site_id);
        });
    }

    $salarySlips = $salarySlips->get();
    // dd($salarySlips->count());
    $pdf = Pdf::loadView(
        'salary.staff-salary.bulkpdf',
        compact('salarySlips')
    )->setPaper('a4', 'portrait');

    return $pdf->download(
        'Staff-Salary-Slips-'.$request->month.'-'.$request->year.'.pdf'
    );
}
// Function for marking toggle [ Paid or not ]
public function markPaid(SalarySlip $salary, Request $request)
{
    $salary->update([
        'salary_paid' => $request->boolean('salary_paid')
    ]);

    return response()->json(['success' => true]);
}
}
