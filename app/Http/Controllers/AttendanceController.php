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

        $query->where('site_id',$request->site_id);
    }

    // $labours = $query->orderBy('name')->get();
    $labours = $query->whereDate('joining_date', '<=', $date)->orderBy('name')->get();

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
    // $labours = $query->with(['attendances' => function ($q) use ($month, $year) {
    //             $q->whereMonth('date', $month)
    //               ->whereYear('date', $year);
    //         }
    //     ])->orderBy('name')->get();
    
    // Attendance Relation
    $lastDateOfMonth = Carbon::create($year, $month)->endOfMonth();
    $labours = $query->whereDate('joining_date', '<=', $lastDateOfMonth)->with(['attendances' => function ($q) use ($month, $year) {
            $q->whereMonth('date', $month)->whereYear('date', $year);
        }
    ])->orderBy('name')->get();

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
public function exportMonthly(Request $request)
{
    $month = $request->month ?? now()->month;
    $year  = $request->year ?? now()->year;

    $query = Labour::where('status', 'active');

    if ($request->filled('site_id')) {
        $query->where('site_id', $request->site_id);
    }

    $lastDateOfMonth = Carbon::create($year, $month)->endOfMonth();

    $labours = $query
        ->whereDate('joining_date', '<=', $lastDateOfMonth)
        ->with([
            'attendances' => function ($q) use ($month, $year) {
                $q->whereMonth('date', $month)
                  ->whereYear('date', $year);
            }
        ])
        ->orderBy('name')
        ->get();

    $daysInMonth = Carbon::create($year, $month)->daysInMonth;

    $filename = "Attendance_Report_{$month}_{$year}.xls";

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    $siteName = 'All Sites';

if ($request->filled('site_id')) {
    $site = Site::find($request->site_id);
    $siteName = $site ? $site->name : 'All Sites';
}

$monthName = Carbon::create()->month($month)->format('F');

echo "
<table>
    <tr>
        <td style='font-size:18px;font-weight:bold;'>
            AWADH BUILDMATE
        </td>
    </tr>

    <tr>
        <td style='font-size:14px;font-weight:bold;'>
            MONTHLY ATTENDANCE REPORT
        </td>
    </tr>

    <tr><td></td></tr>

    <tr>
        <td><b>Site:</b> {$siteName}</td>
    </tr>

    <tr>
        <td><b>Month:</b> {$monthName} {$year}</td>
    </tr>

    <tr>
        <td><b>Generated:</b> ".now()->format('d-m-Y')."</td>
    </tr>

    <tr><td></td></tr>
</table>";

    echo "<table border='1'>";

    echo "<tr>";
    echo "<th>Labour</th>";
    echo "<th>Category</th>";

    for ($day = 1; $day <= $daysInMonth; $day++) {
        echo "<th>$day</th>";
    }

    echo "<th>P</th>";
    echo "<th>A</th>";
    echo "<th>½</th>";
    echo "<th>W/O</th>";
    echo "<th>OT HRS</th>";
    echo "</tr>";
foreach ($labours as $labour) {

    $present = 0;
    $absent = 0;
    $halfDay = 0;
    $weekOff = 0;
    $otHours = 0;

    echo "<tr>";
    echo "<td>{$labour->name}</td>";
    echo "<td>{$labour->category}</td>";

    for ($day = 1; $day <= $daysInMonth; $day++) {

        $attendance = $labour->attendances
            ->first(function ($att) use ($day) {
                return Carbon::parse($att->date)->day == $day;
            });

        $displayStatus = '-';

        if ($attendance) {

            $status = strtolower(trim($attendance->status));

            switch ($status) {

                case 'present':
                    $displayStatus = 'P';
                    $present++;
                    break;

                case 'absent':
                    $displayStatus = 'A';
                    $absent++;
                    break;

                case 'half_day':
                    $displayStatus = '½';
                    $halfDay++;
                    break;

                case 'week_off':
                    $displayStatus = 'W/O';
                    $weekOff++;
                    break;
            }

            $otHours += (float) ($attendance->overtime_hours ?? 0);
        }

        echo "<td style='text-align:center'>{$displayStatus}</td>";
    }

    // Totals should be OUTSIDE the day loop
    echo "<td style='text-align:center'>{$present}</td>";
    echo "<td style='text-align:center'>{$absent}</td>";
    echo "<td style='text-align:center'>{$halfDay}</td>";
    echo "<td style='text-align:center'>{$weekOff}</td>";
    echo "<td style='text-align:center'>{$otHours}</td>";

    echo "</tr>";
}
    echo "</table>";

    exit;
}
}