<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerService extends Model
{
    protected $fillable = [
        'worker_id',
        'name',
        'price'
    ];

    public function worker()
    {
        return $this->belongsTo(SkilledWorker::class, 'worker_id');
    }
} 