<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'employee_id', 'category', 'phone', 'working_days', 'total_salary', 'address', 'daily_wage', 
    'basic_salary', 'hra', 'other_allowance', 'pf_percentage','joining_date', 'status', 'Account_Number', 'Aadhar_Number', 
    'Pan_Card', 'IFSC', 'UAN', 'ESIC_Number','Nominee_details', 'relation','bank_id'];
    
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
