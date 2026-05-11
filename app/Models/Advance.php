<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    protected $fillable = ['labour_id', 'amount', 'given_date', 'remarks', 'is_deducted'];

    protected $casts = [
        'given_date' => 'date',
        'amount' => 'decimal:2',
        'is_deducted' => 'boolean',
    ];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }
}