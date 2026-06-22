<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use App\Models\Attendance;
use App\Models\SalarySlip;
use App\Models\Advance;
use App\Models\Enquiry;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalLabours    = Labour::where('status', 'active')->count();
        $presentToday    = Attendance::where('date', $today)->where('status', 'present')->count();
        $absentToday     = Attendance::where('date', $today)->where('status', 'absent')->count();
        $pendingAdvances = Advance::where('is_deducted', false)->sum('amount');

        $categoryStats = Labour::where('status', 'active')
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        $currentMonthSalary = SalarySlip::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->sum('net_salary');

        $recentAttendance = Attendance::with('labour')
            ->where('date', $today)
            ->orderBy('created_at', 'desc')
            ->take(10)->get();

        $newEnquiries = Enquiry::count();
        
        $recentEnquiries = Enquiry::latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalLabours',
            'totalStaff',
            'presentToday',
            'absentToday',
            'pendingAdvances',
            'categoryStats',
            'staffCategoryStats',
            'recentAttendance',
            'newEnquiries',
            'recentEnquiries'
        ));
    }
}