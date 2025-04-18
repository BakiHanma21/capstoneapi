<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'file_path',
        'file_name',
        'file_type',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['file_url'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Check if the message is unread
    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset($this->file_path);
        }
        return null;
    }
}