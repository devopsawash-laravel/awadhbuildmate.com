<?php

namespace App\Http\Controllers;

    use App\Models\Advance;
    use App\Models\Labour;
    use App\Models\SalarySlip;
    use App\Models\Attendance;
    use Illuminate\Http\Request;
    use Carbon\Carbon;
    use App\Models\Site;
    use PDF;

    class SalaryController extends Controller
    {
        public function index(Request $request)
{
    $month = $request->get(
        'month',
        Carbon::now()->month
    );

    $year = $request->get(
        'year',
        Carbon::now()->year
    );

    // Fetch Sites
    $sites = Site::orderBy('name')->get();

    // Salary Slip Query
    $salaryQuery = SalarySlip::with([
        'labour.site'
    ])
    ->where('month', $month)
    ->where('year', $year);

    // Site Filter
    if ($request->filled('site_id')) {

        $salaryQuery->whereHas(
            'labour',
            function ($q) use ($request) {

                $q->where(
                    'site_id',
                    $request->site_id
                );
            }
        );
    }

    $salarySlips = $salaryQuery
        ->orderBy('created_at', 'desc')
        ->get();

    // Active Labour Query
    $labourQuery = Labour::where(
        'status',
        'active'
    );

    // Site Filter for Labour List
    if ($request->filled('site_id')) {

        $labourQuery->where(
            'site_id',
            $request->site_id
        );
    }

    $labours = $labourQuery
        ->whereNotIn(
            'id',
            $salarySlips->pluck('labour_id')
        )
        ->orderBy('name')
        ->get();

    return view(
        'salary.index',
        compact(
            'salarySlips',
            'labours',
            'month',
            'year',
            'sites'
        )
    );
}

        public function generate(Request $request)
        {
        $request->validate([
            'labour_id' => 'required|exists:labours,id',
            'month'     => 'required|integer|between:1,12',
            'year'      => 'required|integer|min:2000',
        ]);

        $labour = Labour::findOrFail($request->labour_id);

        $month = $request->month;
        $year  = $request->year;

        // Already generated check
        $existing = SalarySlip::where('labour_id', $labour->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($existing) {
            return redirect()
                ->route('salary.show', $existing)
                ->with('info', 'Salary slip already exists.');
        }

        // Attendance
        $attendances = Attendance::where('labour_id', $labour->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $presentDays = $attendances->where('status', 'present')->count();

        $halfDays = $attendances->where('status', 'half_day')->count();

        $absentDays = $attendances->where('status', 'absent')->count();

        $paidDays = $presentDays + ($halfDays * 0.5);

        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        // Overtime
        $totalOvertimeHours = $attendances->sum('overtime_hours');

        $overtimeRate = $labour->overtime_rate ?? 0;

        $overtimeAmount = $overtimeRate * $totalOvertimeHours;

        // Salary components
        $basicSalary = $labour->basic_salary ?? 0;

        $hra = $labour->hra ?? 0;

        $otherAllowance = $labour->other_allowance ?? 0;

        // Earned salary calculations
        $earnedBasic = ($basicSalary / $daysInMonth) * $paidDays;

        $earnedHra = ($hra / $daysInMonth) * $paidDays;

        $earnedOtherAllowance = ($otherAllowance / $daysInMonth) * $paidDays;

        $earnedSalary =
            $earnedBasic +
            $earnedHra +
            $earnedOtherAllowance;

        // Gross salary
        $grossSalary = $earnedSalary + $overtimeAmount;

        // PF deduction
        // $pfDeduction =
        //     ($earnedBasic * ($labour->pf_percentage ?? 0)) / 100; 
        $pfDeduction = 0;

        // Advance deduction
        $pendingAdvances = Advance::where('labour_id', $labour->id)
            ->where('is_deducted', false)
            ->get();

        $advanceDeduction = $pendingAdvances->sum('amount');

        // Total deduction
        $totalDeduction =
            $pfDeduction +
            $advanceDeduction;

        // Net salary
        $netSalary =
            $grossSalary -
            $totalDeduction;

        // Create Salary Slip
        $slip = SalarySlip::create([

            'labour_id' => $labour->id,

            'month' => $month,
            'year'  => $year,

            'total_days' => $daysInMonth,

            'present_days' => $presentDays,
            'half_days'    => $halfDays,
            'absent_days'  => $absentDays,

            'daily_wage' => $labour->daily_wage,

            'basic_salary' => $basicSalary,

            'overtime_hours'  => $totalOvertimeHours,
            'overtime_rate'   => $overtimeRate,
            'overtime_amount' => $overtimeAmount,

            'gross_salary' => $grossSalary,

            'pf_percentage' => $labour->pf_percentage,
            'pf_deduction' => $pfDeduction,

            'advance_deduction' => $advanceDeduction,

            'other_deduction' => 0,

            'total_deduction' => $totalDeduction,

            'net_salary' => $netSalary,

            // Earned fields
            'earned_basic' => $earnedBasic,

            'earned_hra' => $earnedHra,

            'earned_other_allowance' => $earnedOtherAllowance,

            'earned_salary' => $earnedSalary,
        ]);

        // Mark advances deducted
        Advance::where('labour_id', $labour->id)
            ->where('is_deducted', false)
            ->update([
                'is_deducted' => true
            ]);

        return redirect()
            ->route('salary.show', $slip)
            ->with('success', 'Salary slip generated successfully.');
        }

        public function show(SalarySlip $salary)
        {
            
            $salary->load('labour');
            return view('salary.show', compact('salary'));
        }

        public function pdf(SalarySlip $salary)
        {
            $salary->load('labour');
            // $pdf = PDF::loadView('salary.pdf', compact('salary'));
            // return $pdf->download('salary-slip-' . $salary->labour->name . '-' . $salary->month . '-' . $salary->year . '.pdf');

        }

        public function destroy(SalarySlip $salary)
        {
            // Unmark advances
            Advance::where('labour_id', $salary->labour_id)
                ->whereMonth('updated_at', $salary->month)
                ->whereYear('updated_at', $salary->year)
                ->update(['is_deducted' => false]);

            $salary->delete();
            return redirect()->route('salary.index')->with('success', 'Salary slip deleted.');
        }

        public function payslip(SalarySlip $salary)
        {
            $salary->load('labour');

            return view('salary.payslip', compact('salary'));
        }
       public function updateDeductions(Request $request, SalarySlip $salary)
    {
    // Manual deductions
            $salary->pf_deduction =
                $request->pf_deduction ?? 0;

            $salary->esic_deduction =
                $request->esic_deduction ?? 0;

            $salary->advance_deduction =
                $request->advance_deduction ?? 0;

            $salary->pt_deduction =
                $request->pt_deduction ?? 0;

            $salary->lwf_deduction =
                $request->lwf_deduction ?? 0;

            $salary->other_deduction =
                $request->other_deduction ?? 0;

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

                ($salary->gross_salary ?? 0)

                - ($salary->total_deduction ?? 0);

                $salary->save();

                return redirect()
                ->route('salary.show', $salary->id)
                ->with(
                    'success',
                    'Deductions updated successfully.'
                );
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
        dd('shiva');
    }
    public function test(Request $request)
        {
            $month = $request->month ?? now()->month;

            $year = $request->year ?? now()->year;

            // Get labour IDs having attendance
            $labourIds = Attendance::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->pluck('labour_id')
                ->unique();

            // Fetch labours
            $labours = Labour::whereIn('id', $labourIds)
                ->get();

            $statement = [];

            $totalAmount = 0;

            foreach ($labours as $labour) {

                // Attendance
                $attendances = Attendance::where('labour_id', $labour->id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->get();

                $presentDays =
                    $attendances->where('status', 'present')->count();

                $halfDays =
                    $attendances->where('status', 'half_day')->count();

                $paidDays =
                    $presentDays + ($halfDays * 0.5);

                            // Fetch generated salary slip
                $salarySlip = SalarySlip::where('labour_id', $labour->id)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->first();

                // Net payable salary
                $salary = $salarySlip->net_salary ?? 0;
                 
                $statement[] = [

                    'account_number' =>
                        $labour->Account_Number,

                    'name' =>
                        $labour->name,

                    'ifsc' =>
                        $labour->IFSC,

                    'amount' =>
                        round($salary, 2),
                ];

                $totalAmount += $salary;
            }

            return view(
                'salary.bank-statement',
                compact(
                    'statement',
                    'totalAmount',
                    'month',
                    'year'
                )
            );
        }

        // Wages sheet controller
        public function testwages(Request $request)
        {
            $month = $request->month ?? now()->month;

            $year = $request->year ?? now()->year;

            $salaries = SalarySlip::with('labour')
                ->where('month', $month)
                ->where('year', $year)
                ->get();

            return view(
                'salary.wages-sheet',
                compact(
                    'salaries',
                    'month',
                    'year'
                )
            );
        }

}