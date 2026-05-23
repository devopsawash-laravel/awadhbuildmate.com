<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['labour_id', 'date', 'status', 'overtime_hours', 'remarks','site_id'];

    protected $casts = [
        'date' => 'date',
        'overtime_hours' => 'decimal:2',
    ];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }
}