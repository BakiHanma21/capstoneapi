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
        $userName = $this->user->name;
        $reason = $this->reason;
        $year = date('Y');
        
        return $this->subject('Account Disabled')
                    ->html(
                        '<!DOCTYPE html>
<html>
<head>
    <title>Account Disabled</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #cd1c18, #e55451);
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border-left: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
        }
        .footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e0e0e0;
        }
        h1 {
            color: #d32f2f;
            margin-top: 0;
        }
        .warning {
            background-color: #fff8e1;
            padding: 15px;
            border-left: 4px solid #ff9800;
            margin: 20px 0;
        }
        .reason {
            background-color: #fafafa;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            margin: 20px 0;
        }
        .contact-info {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
        </div>
        <div class="content">
            <h1>Account Temporarily Disabled</h1>
            
            <p>Hello ' . $userName . ',</p>
            
            <div class="warning">
                <p><strong>Important Notice:</strong> Your account has been temporarily disabled.</p>
            </div>
            
            <p>We regret to inform you that your account has been disabled due to the following reason:</p>
            
            <div class="reason">
                <p>' . $reason . '</p>
            </div>
            
            <p>To resolve this issue and reactivate your account:</p>
            <ol>
                <li>Visit the barangay office in person for assistance</li>
                <li>Bring any relevant documentation related to your account</li>
                <li>Speak with our support staff who will assist with your case</li>
            </ol>
            
            <p>Once the issue is resolved, your account will be reactivated and you\'ll regain access to all platform features.</p>
            
            <div class="contact-info">
                <p>If you have any questions or need assistance, please don\'t hesitate to reach out:</p>
                <p>📞 Contact: +63 9123456789<br>
                ✉️ Email: matain.serbis.konek.mailer@gmail.com<br>
                🏢 Brgy. Office: Municipal Hall Building, Matain, Subic, Zambales<br>
                ⏰ Office hours: Monday-Friday, 8:00 AM - 5:00 PM</p>
            </div>
        </div>
        <div class="footer">
            <p>Thank you for your understanding and cooperation.</p>
            <p>&copy; ' . $year . ' Matain Services. All rights reserved.</p>
        </div>
    </div>
</body>
</html>'
                    );
    }
}
