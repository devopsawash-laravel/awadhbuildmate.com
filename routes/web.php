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
use App\Http\Controllers\Admin\LoginControllerController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\InvoiceController;

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

//-------------------WEBSITE ROUTES-------------------------//
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('website.home');
Route::get('/testservices', [App\Http\Controllers\HomeController::class, 'test'])->name('website.services');
Route::get('/testprojects', [App\Http\Controllers\HomeController::class, 'testproject'])->name('website.projects');
Route::get('/testcontact', [App\Http\Controllers\HomeController::class, 'testcontact'])->name('website.contact');
Route::get('/testabout', [App\Http\Controllers\HomeController::class, 'testabout'])->name('website.about');

//-------------------ADMIN PANEL ROUTES WITH MIDDLEWARE-------------------------//
Route::get('/admin/login', [App\Http\Controllers\Admin\LoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Admin\LoginController::class, 'index1'])->name('admin.login.post');
// Route::post('/admin/logout',[App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');

Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/verify-pin', function () {
    return view('auth.pin');
})->name('pin.form');

Route::post('/verify-pin', function (Illuminate\Http\Request $request) {

    if ($request->pin === env('ADMIN_PIN')) {

        session(['pin_verified' => true]);

        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'pin' => 'Invalid PIN'
    ]);

})->name('pin.verify');

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('admin/login');

})->name('logout');

//------------------Middleware------------------------------------------------//
Route::middleware(['auth', 'pin'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home1');

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

//-----Laboour Salary Bulk PDF Generation Route------//
Route::get('/bulkpdf', [SalaryController::class, 'bulkPdf'])->name('salary.bulkpdf');
Route::get('/bulkpdfstaff', [SalaryController::class, 'bulkPdfstaff'])->name('staff-salary.bulkpdfstaff');


//------------------------STAFF SALARY MODULE------------------------------------------------------------------//

Route::get('/staff-salary', [StaffController::class, 'generateStaffSalary'])->name('salary.staff-salary.index');
Route::get('/getdashboard', [StaffSalaryController::class, 'getsalarydashboard'])->name('salarydashboard');
Route::resource('staff-salary', StaffSalaryController::class);
Route::post('staff-salary/generate',[StaffSalaryController::class, 'generate'])->name('staff-salary.generate');
Route::get('staff-salary/{salary}/payslip',[StaffSalaryController::class, 'payslip'])->name('staff-salary.payslip');
Route::delete('/staff-salary/{id}',[StaffSalaryController::class, 'destroy'])->name('staff-salary.destroy');
Route::put('/staff-salary/{salary}/update-deductions', [StaffSalaryController::class, 'updateDeductions'])->name('staff-salary.updateDeductions');


// -------------------------------ADVANCE----------------------------------------------------------------------------//
Route::post('/advances', [AdvanceController::class, 'store'])->name('advances.store');
Route::delete('/advances/{advance}', [AdvanceController::class, 'destroy'])->name('advances.destroy');
Route::put('/advances/{advance}',[AdvanceController::class, 'update'])->name('advances.update');
Route::delete('/advances/{advance}',[AdvanceController::class, 'destroy'])->name('advances.destroy');

// Auth::routes();

//Admin Login Route
// Route::get('/admin/login', [App\Http\Controllers\Admin\LoginControllerController::class, 'index'])->name('admin.login');
// Route::post('/admin/login', [LoginController::class, 'index1'])->name('admin.login.post');
// Route::post('/admin/logout',[LoginController::class, 'logout'])->name('admin.logout');

//Testing route

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
// Route::post('/magic-link',          [LoginController::class, 'sendMagicLink'  ])->name('magic.login');
// Route::get( '/magic-link/{token}',  [LoginController::class, 'verifyMagicLink'])->name('magic.login');


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
Route::get('/wages-sheet/export', [SalaryController::class, 'exportReport'])->name('wages.export');
Route::resource('sites', SiteController::class);
Route::get(
    '/sites/{site}',
    [SiteController::class, 'show']
)->name('sites.show');

Route::get(
    '/bank-statement/export',
    [SalaryController::class, 'exportBankStatement']
)->name('salary.bankstatement.export');

// Testing route for sending email notifications
Route::get('/test-mail', function () {

    Mail::raw('Laravel Gmail Test', function ($message) {
        $message->to('awadhbuildmate@gmail.com')
                ->subject('Mail Test');
    });

    return 'Mail Sent';
});
// web.php
Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');

Route::post('/invoice/store', [InvoiceController::class, 'store'])->name('invoice.store');

Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');

Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
Route::get('/invoice/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
Route::delete('/invoice/{invoice}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
Route::post('/invoice/{invoice}/payment', [InvoiceController::class, 'updatePayment'])->name('invoice.update-payment');
});


// Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');