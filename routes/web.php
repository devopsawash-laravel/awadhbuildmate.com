<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabourController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\AdvanceController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\admin\Logincontroller;

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/test', [App\Http\Controllers\HomeController::class, 'index'])->name('home1');


// Labours
Route::resource('labours', LabourController::class);

// Attendance
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance/monthly', [AttendanceController::class, 'monthlyReport'])->name('attendance.monthly');

// Salary
Route::get('/salary', [SalaryController::class, 'index'])->name('salary.index');
Route::post('/salary/generate', [SalaryController::class, 'generate'])->name('salary.generate');
Route::get('/salary/{salary}', [SalaryController::class, 'show'])->name('salary.show');
Route::get('/salary/{salary}/pdf', [SalaryController::class, 'pdf'])->name('salary.pdf');
Route::delete('/salary/{salary}', [SalaryController::class, 'destroy'])->name('salary.destroy');

// Advances
Route::post('/advances', [AdvanceController::class, 'store'])->name('advances.store');
Route::delete('/advances/{advance}', [AdvanceController::class, 'destroy'])->name('advances.destroy');
// Auth::routes();

//Admin Login Route
Route::get('/admin/login', [App\Http\Controllers\admin\Logincontroller::class, 'index'])->name('admin.login');
Route::post('/admin/login', [Logincontroller::class, 'index1'])->name('admin.login.post');
Route::post('/admin/logout',[Logincontroller::class, 'logout'])->name('admin.logout');

//Testing route
Route::get('/testservices', [App\Http\Controllers\HomeController::class, 'test'])->name('website.services');
Route::get('/testprojects', [App\Http\Controllers\HomeController::class, 'testproject'])->name('website.projects');
Route::get('/testcontact', [App\Http\Controllers\HomeController::class, 'testcontact'])->name('website.contact');
Route::get('/testabout', [App\Http\Controllers\HomeController::class, 'testabout'])->name('website.about');
Route::get('/testdashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');

// Testing route for dashboard links
Route::get('/admin/labours/create', [LabourController::class, 'create'])->name('admin.labours.create');
Route::get('/admin/labours', [LabourController::class, 'index'])->name('labours.index');
Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/admin/salary', [SalaryController::class, 'index'])->name('salary.index');
Route::get('/admin  attendance/monthly', [AttendanceController::class, 'monthlyReport'])->name('attendance.monthly');
Route::get('/admin/enquiries', function() {
    return "Enquiries Page";
})->name('admin.enquiries');        


//Mail Route for testing email notification
Route::post('/magic-link',          [Logincontroller::class, 'sendMagicLink'  ])->name('magic.login');
Route::get( '/magic-link/{token}',  [Logincontroller::class, 'verifyMagicLink'])->name('magic.login');