<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    public $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        // For API-based applications, you'll need a frontend URL where users can reset their password
        $frontendUrl = 'http://localhost:4200'; // Change this to your Angular app URL
        
        $this->url = $frontendUrl . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);
        
        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->view('emails.reset-password', ['url' => $this->url]);
    }
} 