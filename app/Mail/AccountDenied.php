<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AccountDenied extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $denialReason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $denialReason = null)
    {
        $this->user = $user;
        $this->denialReason = $denialReason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Account Registration Has Been Denied')
            ->view('emails.account-denied')
            ->with([
                'userName' => $this->user->name,
                'denialReason' => $this->denialReason
            ]);
    }
}
