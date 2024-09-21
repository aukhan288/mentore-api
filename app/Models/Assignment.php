<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'service',
        'university',
        'referencingStyle',
        'educationLevel',
        'deadline',
        'pages',
        'specificInstruction',
    ];
}
