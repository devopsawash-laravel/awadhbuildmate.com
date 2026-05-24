<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Project;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'location', 'state', 'client',
        'status', 'start_date', 'expected_end_date',
        'description', 'site_incharge', 'incharge_phone',
    ];

    protected $casts = [
        'start_date'         => 'date',
        'expected_end_date'  => 'date',
    ];

    // ── Relationships ────────────────────────────────────────────────
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function labours()
    {
        return $this->hasMany(Labour::class);
    }

    public function staffs()
    {
            return $this->hasMany(Staff::class);
    }

    // ── Helpers ──────────────────────────────────────────────────────
    public function activeProjects()
    {
        return $this->projects()->where('status', 'ongoing');
    }

    public function totalLabours()
    {
        return $this->labours()->where('status', 'active')->count();
    }

    public function categoryBreakdown()
    {
        return $this->labours()
            ->where('status', 'active')
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');
    }

    public function todayPresent()
    {
        return \App\Models\Attendance::whereIn('labour_id', $this->labours()->pluck('id'))
            ->whereDate('date', today())
            ->where('status', 'present')
            ->count();
    }

    public function monthlySalaryCost($month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year  = $year  ?? now()->year;

        return \App\Models\SalarySlip::whereIn('labour_id', $this->labours()->pluck('id'))
            ->where('month', $month)
            ->where('year',  $year)
            ->sum('net_salary');
    }

    public function getStatusColor()
    {
        return match($this->status) {
            'active'    => '#10B981',
            'inactive'  => '#F59E0B',
            'completed' => '#6B7280',
            default     => '#6B7280',
        };
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'active'    => 'Active',
            'inactive'  => 'On Hold',
            'completed' => 'Completed',
            default     => 'Unknown',
        };
    }

    public function getDaysRunning()
    {
        if (!$this->start_date) return null;
        return $this->start_date->diffInDays(now());
    }

    public function getDaysRemaining()
    {
        if (!$this->expected_end_date) return null;
        if ($this->expected_end_date->isPast()) return 0;
        return now()->diffInDays($this->expected_end_date);
    }

    public function getProgressPercent()
    {
        if (!$this->start_date || !$this->expected_end_date) return 0;
        $total   = $this->start_date->diffInDays($this->expected_end_date);
        $elapsed = $this->start_date->diffInDays(now());
        if ($total <= 0) return 100;
        return min(100, round(($elapsed / $total) * 100));
    }
        
}