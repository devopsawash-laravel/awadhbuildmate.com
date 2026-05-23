<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Advance;
use App\Models\Attendance;
use App\Models\Labour;
use App\Models\Staff;
use App\Models\SalarySlip;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sites = Site::latest()->get();
        $sites = Site::orderBy("name")->get();

        return view("sites.index", compact("sites"));
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

        // Month-wise Active Labours
        $labours = Labour::where("site_id", $site->id)
            ->whereIn("id", $attendanceLabourIds)
            ->get();

        // Staff
        $staffs = Staff::where("site_id", $site->id)->get();

        // Salary Slips
        // $salarySlips = SalarySlip::whereHas("labour", function ($q) use (
        //     $site
        // ) {
        //     $q->where("site_id", $site->id);
        // })->get();
        $selectedMonth = request("month", now()->month);

        $selectedYear = request("year", now()->year);

        // Salary Slips
        $salarySlips = SalarySlip::whereHas("labour", function ($q) use (
            $site
        ) {
            $q->where("site_id", $site->id);
        })
            ->where("month", $selectedMonth)
            ->where("year", $selectedYear)
            ->get();

        // Advances
        $advances = Advance::whereHas("labour", function ($q) use ($site) {
            $q->where("site_id", $site->id);
        })->get();

        // $selectedMonth = request("month", now()->month);
        //
        // $selectedYear = request("year", now()->year);

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
                "advances",
                "attendanceCount",
                "attendanceRecords",
                "selectedMonth",
                "selectedYear","attendanceLabourIds"
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
