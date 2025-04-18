<!DOCTYPE html>
<html>
<head>
    <title>Account Denied</title>
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
            background-color: #f44336;
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
        <h1>Account Registration Denied</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $userName }},</p>
        
        <p>We regret to inform you that your account registration has been denied.</p>
        
        <p>This could be due to one of the following reasons:</p>
        <ul>
            <li>You may not have provided the necessary requirements to be qualified</li>
            <li>Information provided might be incomplete or inaccurate</li>
            <li>Documentation issues with your submitted materials</li>
        </ul>
        
        <p>For more information about the specific reason for the denial, please visit the barangay hall or contact our support team.</p>
        
        <div style="text-align: center;">
            <a href="http://localhost:4200/contact" class="button">Contact Support</a>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2025 User Management System. All rights reserved.</p>
    </div>
</body>
</html>