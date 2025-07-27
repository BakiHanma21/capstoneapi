<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Booking Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #ffc475;
            color: #2c3e50;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
        }
        .content {
            padding: 20px;
        }
        .booking-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .detail-row {
            margin-bottom: 10px;
            display: flex;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
        }
        .detail-value {
            flex: 1;
        }
        .button {
            display: inline-block;
            background-color: #ffc475;
            color: #2c3e50;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Booking Request</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $worker_name }},</p>
            
            <p>You have received a new booking request from <strong>{{ $customer_name }}</strong>.</p>
            
            <div class="booking-details">
                <div class="detail-row">
                    <div class="detail-label">Service:</div>
                    <div class="detail-value">{{ $booking_title }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Date:</div>
                    <div class="detail-value">{{ $booking_start }} to {{ $booking_end }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Time:</div>
                    <div class="detail-value">{{ $booking_time }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Proposed Cost:</div>
                    <div class="detail-value">₱{{ $booking_amount }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Description:</div>
                    <div class="detail-value">{{ $booking_description }}</div>
                </div>
            </div>
            
            <p>Please login to your account to approve or decline this booking request.</p>
            
            <a href="{{ url('/') }}" class="button">View Request</a>
            
            <p>Thank you for using our service!</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Barangay Service Xpress. All rights reserved.</p>
            <p>If you need assistance, please contact our support team.</p>
        </div>
    </div>
</body>
</html> 