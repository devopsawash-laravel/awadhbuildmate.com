<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Staff;

class StaffSalarySlip extends Model
{
    // protected $table = 'staff_salary_slips';
    use HasFactory;
    protected $fillable = ['name', 'employee_id', 'category', 'phone', 'working_days', 'total_salary', 'address', 'daily_wage', 
    'basic_salary', 'hra', 'other_allowance', 'pf_percentage','joining_date', 'status', 'Account_Number', 'Aadhar_Number', 
    'Pan_Card', 'IFSC', 'UAN', 'ESIC_Number','Nominee_details', 'relation','bank_id','site_id','education','experience','staff_id',
    'month','year','week_off','paid_days' ,'earned_basic','earned_hra','earned_other_allowance','daily_wage','pf_deduction',
    'esic_deduction','advance_deduction','pt_deduction','lwf_deduction','other_deduction','total_deduction','net_salary','salary_paid'];

    public function staff()
    {
        // return $this->belongsTo(Staff::class);
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function getMonthName()
    {
        return \Carbon\Carbon::create()
            ->month($this->month)
            ->format('F');
    }
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
