<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'employee_id', 'category', 'phone', 'address',
        'daily_wage', 'overtime_rate', 'pf_percentage', 'joining_date', 'status'
    ];

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
            default   => 'badge-secondary',
        };
    }
}