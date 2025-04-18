<!DOCTYPE html>
<html>
<head>
    <title>Comment on Your Application</title>
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
        .comment {
            background-color: #f1f1f1;
            padding: 15px;
            border-left: 5px solid #2196F3;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Comment on Your Application</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $userName }},</p>
        
        <p>The administrator has left a comment regarding your account application:</p>
        
        <div class="comment">
            <p>{{ $comment }}</p>
        </div>
        
        <p>Please review this comment and take appropriate action if necessary.</p>
        
        <p>If you have any questions or need further clarification, please don't hesitate to contact our support team.</p>
    </div>
    
    <div class="footer">
        <p>&copy; 2025 User Management System. All rights reserved.</p>
    </div>
</body>
</html>