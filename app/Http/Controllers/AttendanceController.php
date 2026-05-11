<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Labour;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $labours = Labour::where('status', 'active')->orderBy('name')->get();

        $attendances = Attendance::where('date', $date)
            ->pluck('status', 'labour_id');
        $overtimes = Attendance::where('date', $date)
            ->pluck('overtime_hours', 'labour_id');

        return view('attendance.index', compact('labours', 'date', 'attendances', 'overtimes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'         => 'required|date',
            'attendance'   => 'required|array',
        ]);

        foreach ($request->attendance as $labourId => $status) {
            $overtimeHours = $request->overtime[$labourId] ?? 0;
            Attendance::updateOrCreate(
                ['labour_id' => $labourId, 'date' => $request->date],
                ['status' => $status, 'overtime_hours' => $overtimeHours]
            );
        }

        return redirect()->back()->with('success', 'Attendance saved for ' . Carbon::parse($request->date)->format('d M Y'));
    }

    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year', Carbon::now()->year);

        $labours = Labour::where('status', 'active')->with(['attendances' => function ($q) use ($month, $year) {
            $q->whereMonth('date', $month)->whereYear('date', $year);
        }])->orderBy('name')->get();

        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        return view('attendance.monthly', compact('labours', 'month', 'year', 'daysInMonth'));
    }
}