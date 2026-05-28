<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalarySlip extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'employee_id', 'category', 'phone', 'working_days', 'total_salary', 'address', 'daily_wage', 
    'basic_salary', 'hra', 'other_allowance', 'pf_percentage','joining_date', 'status', 'Account_Number', 'Aadhar_Number', 
    'Pan_Card', 'IFSC', 'UAN', 'ESIC_Number','Nominee_details', 'relation','bank_id','site_id','education','experience','staff_id','month','year'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function getMonthName()
    {
        return \Carbon\Carbon::create()
            ->month($this->month)
            ->format('F');
    }
}
