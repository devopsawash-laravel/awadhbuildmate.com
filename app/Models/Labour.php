<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labour extends Model
{
    use HasFactory;

   protected $fillable = ['name', 'employee_id', 'category', 'phone', 'address', 'total_salary', 'daily_wage', 
   'basic_salary', 'hra', 'other_allowance', 'working_days', 'working_hours_per_day', 'overtime_hours', 'overtime_rate', 
   'joining_date', 'status', 'bank_id', 'Account_Number', 'IFSC', 'Pan_Card', 'ESIC_Number', 'UAN','Aadhar_Number','Nominee_details',
   'relation','ot_rate_multiplier','site_id'];

    protected $casts = [
        'joining_date' => 'date',
        'daily_wage' => 'decimal:2',
        'overtime_rate' => 'decimal:2',
        'pf_percentage' => 'decimal:2',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function advances()
    {
        return $this->hasMany(Advance::class);
    }

    public function salarySlips()
    {
        return $this->hasMany(SalarySlip::class);
    }

    public function getAttendanceForMonth(int $month, int $year): \Illuminate\Database\Eloquent\Collection
    {
        return $this->attendances()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();
    }

    public function getPendingAdvances()
    {
        return $this->advances()->where('is_deducted', false)->sum('amount');
    }

    public function getCategoryBadgeColor()
    {
        return match($this->category) {
            'Welder'  => 'badge-welder',
            'Fitter'  => 'badge-fitter',
            'Helper'  => 'badge-helper',
            'Rigger'  => 'badge-rigger',
            'Assistant'  => 'badge-info',
            default   => 'badge-secondary',
        };
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function site()
    {
         return $this->belongsTo(Site::class);
    }
}