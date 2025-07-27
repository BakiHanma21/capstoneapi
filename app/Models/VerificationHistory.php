<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationHistory extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'experience',
        'skills',
        'role',
        'location',
        'purok',
        'street',
        'image',
        'valid_id',
        'status',
        'approved_at',
        'denied_at',
        'work_examples',
    ];

    protected $casts = [
        'work_examples' => 'array',
        'approved_at' => 'datetime',
        'denied_at' => 'datetime',
    ];
}
