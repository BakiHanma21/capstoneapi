<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SkilledWorker
 *
 * @property $worker_id
 * @property $user_id
 * @property $job
 * @property $location
 * @property $experience
 * @property $availability
 * @property $work_done
 * @property $work_image
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SkilledWorker extends Model
{
    
    use HasFactory;

    protected $perPage = 20;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['worker_id', 'user_id', 'job', 'location', 'experience', 'availability', 'work_done', 'work_image'];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'worker_id');
    }

    public function works()
    {
        return $this->hasMany(WorkerWork::class, 'worker_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'worker_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'request_id', 'user_id')->whereNotNull('review2');
    }
}
    