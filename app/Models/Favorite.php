<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Favorite
 *
 * @property $favorite_id
 * @property $customer_id
 * @property $worker_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Favorite extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['favorite_id', 'customer_id', 'worker_id'];

    public function skilledWorker()
    {
        return $this->belongsTo(SkilledWorker::class, 'worker_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

}
