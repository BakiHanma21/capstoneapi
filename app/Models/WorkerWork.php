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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'worker_works';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'work_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['worker_id', 'title', 'description', 'image'];

    /**
     * Get the skilled worker that owns the work.
     */
    public function worker()
    {
        return $this->belongsTo(SkilledWorker::class, 'worker_id', 'id');
    }

    /**
     * Get the skilled worker that owns the work (alias).
     */
    public function skilledWorker()
    {
        return $this->belongsTo(SkilledWorker::class, 'worker_id', 'id');
    }
}
