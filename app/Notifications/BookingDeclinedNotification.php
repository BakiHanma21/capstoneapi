<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class BookingDeclinedNotification extends Notification
{
    use Queueable;

    protected $booking;
    protected $worker;
    protected $customer;
    protected $timestamp;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, User $worker, User $customer)
    {
        $this->booking = $booking;
        $this->worker = $worker;
        $this->customer = $customer;
        
        // Capture the exact time of decline
        $this->timestamp = now();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('❌ Booking Declined')
                    ->line("Your booking request for {$this->booking->title} has been declined by {$this->worker->name}.")
                    ->line("Date: {$this->booking->start}")
                    ->line("Time: {$this->booking->start_time}")
                    ->action('View Booking', url('/transaction'))
                    ->line('Thank you for using our service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Use the exact decline timestamp captured when notification was created
        return [
            'booking_id' => $this->booking->booking_id,
            'title' => "Your booking request for {$this->booking->title} has been declined",
            'body' => "Your booking request for {$this->booking->title} has been declined by {$this->worker->name}.",
            'notification_type' => 'booking_declined',
            'worker_id' => $this->worker->id,
            'worker_name' => $this->worker->name,
            'timestamp' => $this->timestamp->toIso8601String() // Exact decline time
        ];
    }
}
