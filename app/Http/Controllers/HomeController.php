<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home1');
    }

    public function test()
    {
        return view('website.services');
    }

    public function testproject()
    {
        // dd("This is testing route for projects page");
        return view('website.projects');
    }
    public function testcontact()
    {
        return view('website.contact');
        // dd('Shivani');
    }
    public function testabout()
    {
        return view('website.about');
    }
    public function testdashboard()
    {
        return view('admin.dashboard');
    }

    public function indexE()
    {
        $enquiries = Enquiry::orderBy('created_at', 'asec')->paginate(20);

        $newEnquiries = Enquiry::count();

        $recentEnquiries = Enquiry::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'enquiries',
            'newEnquiries',
            'recentEnquiries'
        ));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);

        Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'subject' => $request->subject,
            'service_type' => $request->service_type,
            'message' => $request->message,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting Awadh Buildmate!!'
            ]);
        }

        return back()->with('success', 'Thank you for contacting Awadh Buildmate!!');
    }
}
