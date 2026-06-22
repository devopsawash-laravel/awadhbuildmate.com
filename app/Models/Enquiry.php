<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'name',
    'company',
    'phone',
    'email',
    'service_type',
    'message',
    'is_read'
];
}
