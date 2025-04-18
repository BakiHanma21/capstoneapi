<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CommentSent extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $comment)
    {
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Comment on Your Account Application')
            ->view('emails.comment-sent')
            ->with([
                'userName' => $this->user->name,
                'comment' => $this->comment
            ]);
    }
}
