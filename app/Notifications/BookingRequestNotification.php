<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class BookingRequestNotification extends Notification
{
    use Queueable;

    protected $booking;
    protected $worker;
    protected $customer;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, User $worker, User $customer)
    {
        $this->booking = $booking;
        $this->worker = $worker;
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Only send to database, not via email
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('🛠 New Booking Request')
                    ->line("You have a new booking request from {$this->customer->name} for {$this->booking->title} job.")
                    ->line("Date: {$this->booking->start}")
                    ->line("Description: {$this->booking->description}")
                    ->action('View Request', url('/user_request'))
                    ->line('Thank you for using our service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Use the exact booking creation timestamp
        $exactTimestamp = $this->booking->created_at ?? now();
        
        return [
            'booking_id' => $this->booking->booking_id,
            'title' => "New Booking Request",
            'body' => "You have a new booking request from {$this->customer->name} for {$this->booking->title} job.",
            'notification_type' => 'new_booking_request',
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'timestamp' => $exactTimestamp->toIso8601String() // Exact booking creation time
        ];
    }
}
