<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #ffde59;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .content {
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 24px;
        }
        p {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .btn {
            background: linear-gradient(135deg, #ffde59, #ffc475);
            color: #2c3e50;
            padding: 12px 25px;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666666;
            border-top: 1px solid #eeeeee;
            margin-top: 20px;
        }
        .signature {
            margin-top: 30px;
            border-top: 1px solid #eeeeee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Matain Serbis-Konek</h1>
        </div>
        <div class="content">
            <h1>Password Reset Request</h1>
            
            <p>Dear Valued User,</p>
            
            <p>We have received a request to reset the password for your Matain Serbis-Konek account. To proceed with resetting your password, please click on the button below:</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="btn">Reset Your Password</a>
            </div>
            
            <p>For security purposes, please note that this password reset link will expire in <strong>{{ config('auth.passwords.users.expire') }} minutes</strong>.</p>
            
            <p>If you did not initiate this password reset request, no further action is required. Your account remains secure.</p>
            
            <div class="signature">
                <p>Best Regards,<br>
                <strong>The Matain Serbis-Konek Team</strong></p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Matain Serbis-Konek. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html> 