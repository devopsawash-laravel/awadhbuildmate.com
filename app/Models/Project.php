<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id', 'name', 'project_code', 'type', 'status',
        'start_date', 'expected_end_date', 'contract_value',
        'progress_percent', 'description',
    ];

    protected $casts = [
        'start_date'        => 'date',
        'expected_end_date' => 'date',
        'contract_value'    => 'decimal:2',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function labours()
    {
        return $this->hasMany(Labour::class);
    }

    public function getStatusColor()
    {
        return match($this->status) {
            'ongoing'   => '#10B981',
            'planning'  => '#3B82F6',
            'on_hold'   => '#F59E0B',
            'completed' => '#6B7280',
            default     => '#6B7280',
        };
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'ongoing'   => 'Ongoing',
            'planning'  => 'Planning',
            'on_hold'   => 'On Hold',
            'completed' => 'Completed',
            default     => 'Unknown',
        };
    }

    public function getTypeIcon()
    {
        return match($this->type) {
            'Fabrication' => 'fa-drafting-compass',
            'Erection'    => 'fa-industry',
            'Civil'       => 'fa-hard-hat',
            'Structural'  => 'fa-building',
            'Maintenance' => 'fa-tools',
            default       => 'fa-cog',
        };
    }
}