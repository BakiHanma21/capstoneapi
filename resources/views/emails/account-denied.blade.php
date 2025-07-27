<!DOCTYPE html>
<html>
<head>
    <title>Account Registration Denied</title>
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
            background: linear-gradient(135deg, #f44336, #c62828);
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
            background-color: #f44336;
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
            background-color: #d32f2f;
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
        .reason-box {
            background-color: #ffebee;
            padding: 15px;
            border-left: 4px solid #f44336;
            margin: 20px 0;
        }
        .reason-heading {
            font-weight: 600;
            margin-bottom: 10px;
            color: #c62828;
        }
        .next-steps {
            background-color: #e8eaf6;
            padding: 15px;
            border-left: 4px solid #3f51b5;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-icon">!</div>
            <h1>Account Registration Denied</h1>
        </div>
        
        <div class="content">
            <p class="greeting">Dear {{ $userName }},</p>
            
            <p class="message">We regret to inform you that your account registration has been denied after careful review.</p>
            
            @if(isset($denialReason) && !empty($denialReason))
            <div class="reason-box">
                <p class="reason-heading">Reason for Denial:</p>
                <p>{{ $denialReason }}</p>
            </div>
            @else
            <div class="reason-box">
                <p class="reason-heading">Common Reasons for Denial:</p>
                <ul>
                    <li>Incomplete or inaccurate information provided</li>
                    <li>Insufficient documentation or verification materials</li>
                    <li>Failure to meet qualification requirements</li>
                    <li>Issues with submitted identification documents</li>
                </ul>
            </div>
            @endif
            
            <div class="next-steps">
                <p><strong>What You Can Do Next:</strong></p>
                <p>You may submit a new application with complete and accurate information. For specific details about your application denial, please contact our support team.</p>
            </div>
            
            <p>If you believe this decision was made in error or if you need further assistance, please don't hesitate to reach out to our support team or simply go to the barangay hall for assistance.</p>
            
            <div style="text-align: center;">
                <a href="http://localhost:4200/contact" class="button">Contact Support</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; 2025 User Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>