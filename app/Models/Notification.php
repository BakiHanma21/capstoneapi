<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Determine if the notification is persistent (should not be auto-deleted)
     * 
     * @return bool
     */
    public function isPersistent()
    {
        // Check if this is a worker booking notification
        $data = $this->data;
        
        if (isset($data['notification_type'])) {
            $notificationType = $data['notification_type'];
            
            // For worker booking notifications, always treat as persistent
            if (in_array($notificationType, ['booking_approved', 'booking_declined'])) {
                // Check if the notification belongs to a worker
                if ($this->notifiable_type === 'App\\Models\\User') {
                    // Get the user to check their role
                    $user = User::find($this->notifiable_id);
                    if ($user && $user->role === 'WORKER') {
                        return true;
                    }
                }
            }
        }
        
        // Explicit persistence flag
        if (isset($data['persistent']) && $data['persistent'] === true) {
            return true;
        }
        
        // For workers, check for booking notifications
        if (isset($data['for_worker']) && $data['for_worker'] === true) {
            if (isset($data['persist_for_worker']) && $data['persist_for_worker'] === true) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get the timestamp from the notification data or use created_at
     *
     * @return \Carbon\Carbon
     */
    public function getTimestampAttribute()
    {
        if (isset($this->data['timestamp'])) {
            return $this->data['timestamp'];
        }
        
        return $this->created_at;
    }
}
