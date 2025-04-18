<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 *
 * @property $review_id
 * @property $worker_id
 * @property $customer_id
 * @property $rating
 * @property $text
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Review extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    
    protected $fillable = ['worker_id', 'name', 'rating', 'text'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function skilledWorker()
    {
        return $this->belongsTo(SkilledWorker::class);
    }

    public function worker()
    {
        return $this->belongsTo(SkilledWorker::class);
    }

}
