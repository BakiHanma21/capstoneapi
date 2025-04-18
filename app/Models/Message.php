<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 *
 * @property $message_id
 * @property $sender_id
 * @property $receiver_id
 * @property $message
 * @property $proposed_cost
 * @property $additional_details
 * @property $typed_message
 * @property $is_agreed
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Message extends Model
{
    protected $primaryKey = 'message_id'; // Explicitly set the primary key to message_id
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['message_id', 'sender_id', 'receiver_id', 'message', 'proposed_cost', 'additional_details', 'typed_message', 'is_agreed'];


}
