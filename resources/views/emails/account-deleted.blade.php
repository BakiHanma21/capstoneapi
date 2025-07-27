<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Deleted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #ffc475;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Account Deletion Notification</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $name }},</p>
        
        <p>We're writing to inform you that your account has been permanently deleted from our system as per your request.</p>
        
        <p>All your personal data, profile information, and associated content have been removed from our database.</p>
        
        <p>If you believe this was done in error or have any questions, please contact our support team immediately.</p>
        
        <p>Thank you for being part of our community.</p>
        
        <p>Best regards,<br>
        The Barangay Matain Skilled Workers Platform Team</p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html> 