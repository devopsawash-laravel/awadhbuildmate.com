<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
