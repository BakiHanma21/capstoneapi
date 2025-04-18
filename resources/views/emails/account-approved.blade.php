<!DOCTYPE html>
<html>
<head>
    <title>Account Approved</title>
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
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Account Approved!</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $userName }},</p>
        
        <p>Great news! Your account has been approved. You can now login and use your account.</p>
        
        <p>Your account type: <strong>{{ $userRole }}</strong></p>
        
        <p>You can now access all features of our platform. If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
        
        <div style="text-align: center;">
            <a href="http://localhost:4200/login" class="button">Login Now</a>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2025 User Management System. All rights reserved.</p>
    </div>
</body>
</html>