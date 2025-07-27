<!DOCTYPE html>
<html>
<head>
    <title>Account Enabled</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            background: linear-gradient(to right, #228b22, #32cd32);
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header img {
            max-width: 150px;
            height: auto;
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
            color: #4e4e4e;
            margin-top: 0;
        }
        .highlight {
            background-color: #f2f9ff;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: #4e4e4e;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
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
            <h1>Account Successfully Enabled</h1>
            
            <p>Hello {{ $name }},</p>
            
            <div class="highlight">
                <p>Good news! Your account has been <strong>enabled</strong> and you now have full access to all platform features.</p>
            </div>
            
            <p>You can now access the following services:</p>
            <ul>
                <li>Browse and book skilled worker services</li>
                <li>Communicate with service providers</li>
                <li>Make secure payments</li>
                <li>Rate and review services</li>
            </ul>
            
            <p>Please remember to follow all platform rules and policies to avoid future disruptions to your account.</p>
            
            <a href="http://localhost:4200/login" class="button">Login to Your Account</a>
            
            <div class="contact-info">
                <p>If you have any questions or need assistance, please don't hesitate to reach out:</p>
                <p>📞 Contact: +63 9123456789<br>
                ✉️ Email: matain.serbis.konek.mailer@gmail.com<br>
                🏢 Brgy. Office: Municipal Hall Building, Matain, Subic, Zambales</p>
            </div>
        </div>
        <div class="footer">
            <p>Thank you for using Matain Services.</p>
            <p>&copy; {{ date('Y') }} Matain Services. All rights reserved.</p>
        </div>
    </div>
</body>
</html>