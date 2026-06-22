<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;

class Enquirycontroller extends Controller
{

    public function index()
    {
        // $enquiries = Enquiry::orderBy('created_at', 'desc')->paginate(20);
    $enquiries = Enquiry::orderBy('created_at', 'asc')->paginate(20);
    // dd($enquiries);
    return view('admin.enquiries', compact('enquiries'));
    }

}
    