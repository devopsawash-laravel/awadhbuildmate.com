<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Attendance;
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
        $month = $request->get("month", Carbon::now()->month);

        $year = $request->get("year", Carbon::now()->year);

        // Fetch Sites
        $sites = Site::orderBy("name")->get();
        // dd($sites);

        // Salary Slip Query
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

        // Active staff Query
        $labourQuery = Staff::where("status", "active");

        // Site Filter for staff List
        if ($request->filled("site_id")) {
            $labourQuery->where("site_id", $request->site_id);
        }
        $attendanceLabourIds = Attendance::whereMonth("date", $month)
            ->whereYear("date", $year)
            ->pluck("labour_id")
            ->unique();
        $staffs = Staff::with("site")
            ->where("status", "active")
            ->whereIn("id", $attendanceLabourIds)
            ->when($request->site_id, function ($q) use ($request) {
                $q->where("site_id", $request->site_id);
            })
            ->orderBy("name")
            ->get();

        return view(
            "salary.staff-salary.index",
            compact("salarySlips", "staffs", "month", "year", "sites")
        );
    }

    public function generate(Request $request)
{
    $request->validate([
        'staff_id' => 'required|exists:staff,id',
        'month' => 'required|integer|between:1,12',
        'year' => 'required|integer|min:2000',
    ]);

    $staff = Staff::findOrFail($request->staff_id);
    // dd($staff);

    $month = $request->month;

    $year = $request->year;

    $existing = StaffSalarySlip::where('staff_id', $staff->id)
        ->where('month', $month)
        ->where('year', $year)
        ->first();

    if ($existing) {
        return redirect()
            ->route('staff-salary.show', $existing)
            ->with('info', 'Salary slip already exists.');
    }

    $basicSalary = $staff->basic_salary ?? 0;

    $hra = $staff->hra ?? 0;

    $otherAllowance = $staff->other_allowance ?? 0;

    $grossSalary = $basicSalary + $hra + $otherAllowance;

    $pfDeduction = ($basicSalary * ($staff->pf_percentage ?? 0)) / 100;

    $otherDeduction = 0;

    $totalDeduction = $pfDeduction + $otherDeduction;

    $netSalary = round($grossSalary - $totalDeduction);

    $slip = StaffSalarySlip::create([
        'staff_id' => $staff->id,
        'month' => $month,
        'year' => $year,
        'working_days' => $staff->working_days ?? 26,
        'paid_days' => $staff->working_days ?? 26,
        'basic_salary' => $basicSalary,
        'hra' => $hra,
        'other_allowance' => $otherAllowance,
        'gross_salary' => $grossSalary,
        'pf_deduction' => $pfDeduction,
        'advance_deduction' => 0,
        'other_deduction' => $otherDeduction,
        'total_deduction' => $totalDeduction,
        'net_salary' => $netSalary,
        'site_id' => $staff->site_id,
    ]);

    return redirect()
        ->route('staff-salary.show', $slip)
        ->with('success', 'Staff salary generated successfully.');
}

    public function pdf(StaffSalarySlip $salary)
    {
        $salary->load("staff");
        // $pdf = PDF::loadView('salary.pdf', compact('salary'));
        // return $pdf->download('salary-slip-' . $salary->staff->name . '-' . $salary->month . '-' . $salary->year . '.pdf');
    }

    public function destroy(StaffSalarySlip $salary)
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

    public function payslip(StaffSalarySlip $salary)
    {
        $salary->load("staff");

        return view("salary.payslip", compact("salary"));
    }

    public function updateDeductions(Request $request, StaffSalarySlip $salary)
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
