<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Return the full data object
        $notificationData = [
            'title' => $this->data->title,
            'body' => $this->data->body,
            'notification_type' => $this->data->notification_type,
        ];
        
        // Include timestamp if it exists
        if (isset($this->data->timestamp)) {
            $notificationData['timestamp'] = $this->data->timestamp;
        }
        
        // Include worker_name if it exists
        if (isset($this->data->worker_name)) {
            $notificationData['worker_name'] = $this->data->worker_name;
        }
        
        // Include persistence flags for worker booking notifications
        if (isset($this->data->persistent)) {
            $notificationData['persistent'] = $this->data->persistent;
        }
        
        if (isset($this->data->for_worker)) {
            $notificationData['for_worker'] = $this->data->for_worker;
        }
        
        if (isset($this->data->persist_for_worker)) {
            $notificationData['persist_for_worker'] = $this->data->persist_for_worker;
        }
        
        // Check if this is a worker booking notification and explicitly set persistence flags
        if (property_exists($this->data, 'notification_type') && 
            in_array($this->data->notification_type, ['booking_approved', 'booking_declined']) &&
            property_exists($notifiable, 'role') && $notifiable->role === 'WORKER') {
            
            $notificationData['persistent'] = true;
            $notificationData['for_worker'] = true;
            $notificationData['persist_for_worker'] = true;
        }
        
        // Include any additional data if it exists
        if (isset($this->data->data)) {
            $notificationData = array_merge($notificationData, (array)$this->data->data);
        }
        
        return $notificationData;
    }
} 