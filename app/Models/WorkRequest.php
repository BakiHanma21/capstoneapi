<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkRequest
 *
 * @property $request_id
 * @property $customer_id
 * @property $worker_id
 * @property $service
 * @property $status
 * @property $proposed_cost
 * @property $description
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkRequest extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['request_id', 'customer_id', 'worker_id', 'service', 'status', 'proposed_cost', 'description'];


}
