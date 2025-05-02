<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkerWork
 *
 * @property $work_id
 * @property $worker_id
 * @property $title
 * @property $description
 * @property $image
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkerWork extends Model
{
    
    protected $perPage = 20;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'work_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['work_id', 'worker_id', 'title', 'description', 'image'];

    public function worker()
    {
        return $this->belongsTo(SkilledWorker::class, 'worker_id');
    }
    public function skilledWorker()
    {
        return $this->belongsTo(SkilledWorker::class, 'worker_id');
    }
}
