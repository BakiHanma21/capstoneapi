<!DOCTYPE html>
<html>
<head>
    <title>Account Approved</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
            padding: 20px;
            background-color: #f5f5f5;
            border-top: 1px solid #eeeeee;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 25px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .button:hover {
            background-color: #388E3C;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 20px;
        }
        .highlight {
            background-color: #e8f5e9;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-icon">✓</div>
            <h1>Account Approved!</h1>
        </div>
        
        <div class="content">
            <p class="greeting">Dear {{ $userName }},</p>
            
            <p class="message">We are pleased to inform you that your account registration has been <strong>approved</strong>. You can now access all features of our platform.</p>
            
            <div class="highlight">
                <p>Your account has been verified and is now active. You can log in using your registered email address and password.</p>
            </div>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team or simply go to the barangay hall for assistance.</p>
            
            <div style="text-align: center;">
                <a href="http://localhost:4200/login" class="button">Login Now</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; 2025 User Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>