<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDisabled extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct($user, $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Account Disabled')
                    ->html(
                        '<html>
                            <head>
                                <title>Account Disabled</title>
                            </head>
                            <body>
                                <h1>Hello ' . $this->user->name . ',</h1>
                                <p><b>Warning!!!</b></p>
                                <p>'. $this->reason . '</p>
                                <p>Your account has been disabled. Please visit or proceed directly to the barangay hall for assistance.</p>
                                <p>Thank you!</p>
                            </body>
                        </html>'
                    );
    }
}
