<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Labour;
use Illuminate\Http\Request;    
use Carbon\Carbon;
use App\Models\Site;

class AttendanceController extends Controller
{
           public function index(Request $request)
{
    $month = $request->month ?? now()->month;

    $year = $request->year ?? now()->year;

    $date = $request->date ?? now()->toDateString();

    // Sites
    $sites = Site::orderBy('name')->get();

    // Labour Query
    $query = Labour::where('status', 'active');

    // Site Filter
    if ($request->filled('site_id')) {

        $query->where(
            'site_id',
            $request->site_id
        );
    }

    $labours = $query
        ->orderBy('name')
        ->get();

    // Existing Attendance
    $attendances = Attendance::where('date', $date)
        ->pluck('status', 'labour_id');

    // Existing OT
    $overtimes = Attendance::where('date', $date)
        ->pluck('overtime_hours', 'labour_id');

    return view(
        'attendance.index',
        compact(
            'labours',
            'sites',
            'month',
            'year',
            'date',
            'attendances',
            'overtimes'
        )
    );
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

    [
        'labour_id' => $labourId,
        'date' => $request->date
    ],

    [
        'site_id' => Labour::find($labourId)->site_id,

        'status' => $status,

        'overtime_hours' => $overtimeHours,
    ]
);
        }

        return redirect()->back()->with('success', 'Attendance saved for ' . Carbon::parse($request->date)->format('d M Y'));
    }

    public function monthlyReport(Request $request)
{
    $month = $request->month ?? now()->month;

    $year = $request->year ?? now()->year;

    // Sites
    $sites = Site::orderBy('name')->get();

    // Labour Query
    $query = Labour::where('status', 'active');

    // Site Filter
    if ($request->filled('site_id')) {

        $query->where(
            'site_id',
            $request->site_id
        );
    }

    // Attendance Relation
    $labours = $query
        ->with([
            'attendances' => function ($q) use ($month, $year) {

                $q->whereMonth('date', $month)
                  ->whereYear('date', $year);
            }
        ])
        ->orderBy('name')
        ->get();

    $daysInMonth = Carbon::createFromDate(
        $year,
        $month,
        1
    )->daysInMonth;

    return view(
        'attendance.monthly',
        compact('labours','month','year','daysInMonth','sites'
        )
    );
}
}