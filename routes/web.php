<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabourController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffSalaryController;
use App\Http\Controllers\AdvanceController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\admin\Logincontroller;
use App\Http\Controllers\SiteController;


// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/test', [App\Http\Controllers\HomeController::class, 'index'])->name('home1');


// Labours
Route::resource('labours', LabourController::class);

Route::put('/labours/{labour}/toggle-status',
    [LabourController::class, 'toggleStatus'])
    ->name('labours.toggleStatus');

// Attendance
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance/monthly', [AttendanceController::class, 'monthlyReport'])->name('attendance.monthly');

//-------------------------lABOUR SALARY MODULE---------------------------------------------------------------//

Route::get('/salary', [SalaryController::class, 'index'])->name('salary.index');
Route::post('/salary/generate', [SalaryController::class, 'generate'])->name('salary.generate');
Route::get('/salary/{salary}', [SalaryController::class, 'show'])->name('salary.show');
Route::get('/salary/{salary}/pdf', [SalaryController::class, 'pdf'])->name('salary.pdf');
Route::delete('/salary/{salary}', [SalaryController::class, 'destroy'])->name('salary.destroy');

//------------------------STAFF SALARY MODULE------------------------------------------------------------------//

Route::get('/staff-salary', [StaffController::class, 'generateStaffSalary'])->name('salary.staff-salary.index');
Route::get('/getdashboard', [StaffSalaryController::class, 'getsalarydashboard'])->name('salarydashboard');
Route::resource('staff-salary', StaffSalaryController::class);
Route::post('staff-salary/generate',[StaffSalaryController::class, 'generate'])->name('staff-salary.generate');
Route::get('staff-salary/{salary}/payslip',[StaffSalaryController::class, 'payslip'])->name('staff-salary.payslip');



// -------------------------------ADVANCE----------------------------------------------------------------------------//
Route::post('/advances', [AdvanceController::class, 'store'])->name('advances.store');
Route::delete('/advances/{advance}', [AdvanceController::class, 'destroy'])->name('advances.destroy');
Route::put('/advances/{advance}',[AdvanceController::class, 'update'])->name('advances.update');
Route::delete('/advances/{advance}',[AdvanceController::class, 'destroy'])->name('advances.destroy');

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
// Route::get('/testdashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');

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

//Site module route testing
// Route::post('/admin/sites', [App\Http\Controllers\Admin\SiteController::class, 'index'])->name('admin.sites.index');
// Route::get('/admin/sites', [App\Http\Controllers\Admin\SiteController::class, 'index'])->name('admin.sites.index');
// Route::get('/admin/sites/{site}', [App\Http\Controllers\Admin\SiteController::class, 'show'])->name('admin.sites.show');

// Staff module route testing
// Route::POST('/admin/staff/create', [App\Http\Controllers\StaffController::class, 'create'])->name('Staff.create');
Route::Resource('staff', App\Http\Controllers\StaffController::class);

//Payslip modules
Route::put('/salary/{salary}/deductions',
    [SalaryController::class, 'updateDeductions'])
    ->name('salary.updateDeductions');

//Generating PaySlip in PDF
Route::get('/salary/{salary}/payslip',
    [SalaryController::class, 'payslip'])
    ->name('salary.payslip');

// Bank Statement
// Route::get('/salary/bank-statement', [SalaryController::class, 'bankStatement'])->name('salary.bankStatement');
Route::get('/testbankstatment', [SalaryController::class, 'test'])->name('salary.bankstatement');
Route::get('/testwages',[SalaryController::class, 'testwages'])->name('salary.wages-sheet');

Route::resource('sites', SiteController::class);
Route::get(
    '/sites/{site}',
    [SiteController::class, 'show']
)->name('sites.show');

Route::get(
    '/bank-statement/export',
    [SalaryController::class, 'exportBankStatement']
)->name('salary.bankstatement.export');
