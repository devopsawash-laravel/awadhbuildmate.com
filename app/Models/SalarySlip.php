<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'labour_id', 'site_id','month', 'year', 'total_days', 'present_days', 'absent_days',
        'half_days', 'daily_wage', 'basic_salary', 'overtime_hours', 'overtime_rate',
        'overtime_amount', 'gross_salary', 'pf_percentage', 'pf_deduction',
        'advance_deduction', 'other_deduction', 'total_deduction', 'net_salary', 'remarks',
        'earned_basic',  'earned_hra', 'earned_other_allowance', 'earned_salary', 'esic_deduction','pt_deduction','lwf_deduction','other_deduction',
        'week_off_days','salary_paid'
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'pf_deduction' => 'decimal:2',
        'advance_deduction' => 'decimal:2',
        'overtime_amount' => 'decimal:2',
    ];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }

    public function getMonthName()
    {
        return date('F', mktime(0, 0, 0, $this->month, 1));
    }
    // SalarySlip.php
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}