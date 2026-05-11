<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Labour;
use App\Models\SalarySlip;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year', Carbon::now()->year);

        $salarySlips = SalarySlip::with('labour')
            ->where('month', $month)
            ->where('year', $year)
            ->orderBy('created_at', 'desc')
            ->get();

        $labours = Labour::where('status', 'active')
            ->whereNotIn('id', $salarySlips->pluck('labour_id'))
            ->orderBy('name')
            ->get();

        return view('salary.index', compact('salarySlips', 'labours', 'month', 'year'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'labour_id' => 'required|exists:labours,id',
            'month'     => 'required|integer|between:1,12',
            'year'      => 'required|integer|min:2000',
        ]);

        $labour = Labour::findOrFail($request->labour_id);
        $month  = $request->month;
        $year   = $request->year;

        // Check if already generated
        $existing = SalarySlip::where('labour_id', $labour->id)
            ->where('month', $month)->where('year', $year)->first();
        if ($existing) {
            return redirect()->route('salary.show', $existing)->with('info', 'Salary slip already exists.');
        }

        // Attendance data
        $attendances = Attendance::where('labour_id', $labour->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $presentDays  = $attendances->where('status', 'present')->count();
        $halfDays     = $attendances->where('status', 'half_day')->count();
        $absentDays   = $attendances->where('status', 'absent')->count();
        $totalWorking = $presentDays + ($halfDays * 0.5); // half day = 0.5

        $totalOvertimeHours = $attendances->sum('overtime_hours');

        // Salary calculations
        $basicSalary     = $totalWorking * $labour->daily_wage;
        $overtimeAmount  = $totalOvertimeHours * $labour->overtime_rate * 2; // Double rate
        $grossSalary     = $basicSalary + $overtimeAmount;

        // PF is on basic salary only (based on working days)
        $pfDeduction     = ($basicSalary * $labour->pf_percentage) / 100;

        // Pending advances
        $pendingAdvances = Advance::where('labour_id', $labour->id)
            ->where('is_deducted', false)->get();
        $advanceDeduction = $pendingAdvances->sum('amount');

        $totalDeduction  = $pfDeduction + $advanceDeduction;
        $netSalary       = $grossSalary - $totalDeduction;

        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        $slip = SalarySlip::create([
            'labour_id'        => $labour->id,
            'month'            => $month,
            'year'             => $year,
            'total_days'       => $daysInMonth,
            'present_days'     => $presentDays,
            'absent_days'      => $absentDays,
            'half_days'        => $halfDays,
            'daily_wage'       => $labour->daily_wage,
            'basic_salary'     => $basicSalary,
            'overtime_hours'   => $totalOvertimeHours,
            'overtime_rate'    => $labour->overtime_rate,
            'overtime_amount'  => $overtimeAmount,
            'gross_salary'     => $grossSalary,
            'pf_percentage'    => $labour->pf_percentage,
            'pf_deduction'     => $pfDeduction,
            'advance_deduction'=> $advanceDeduction,
            'other_deduction'  => 0,
            'total_deduction'  => $totalDeduction,
            'net_salary'       => $netSalary,
        ]);

        // Mark advances as deducted
        Advance::where('labour_id', $labour->id)
            ->where('is_deducted', false)
            ->update(['is_deducted' => true]);

        return redirect()->route('salary.show', $slip)->with('success', 'Salary slip generated successfully.');
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
}