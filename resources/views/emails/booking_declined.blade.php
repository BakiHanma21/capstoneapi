<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Request Declined</title>
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
            background-color: #dc3545;
            color: white;
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
        .status-declined {
            background-color: #f8d7da;
            color: #721c24;
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
        }
        .alternatives {
            margin-top: 30px;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 6px;
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
            <h1>Booking Request Declined</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $customer_name }},</p>
            
            <p>We regret to inform you that your booking request with <strong>{{ $worker_name }}</strong> has been <span class="status-declined">DECLINED</span>.</p>
            
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
            </div>
            
            <p>This could be due to one of the following reasons:</p>
            <ul>
                <li>The worker has a scheduling conflict during your requested time</li>
                <li>The worker is unable to provide the service you requested</li>
                <li>The worker is not available in your location</li>
            </ul>
            
            <div class="alternatives">
                <p><strong>What's next?</strong></p>
                <p>You can browse other skilled workers in our platform and submit a new booking request:</p>
                <a href="{{ url('/') }}" class="button">Find Other Workers</a>
            </div>
            
            <p>Thank you for your understanding!</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Barangay Service Xpress. All rights reserved.</p>
            <p>If you need assistance, please contact our support team.</p>
        </div>
    </div>
</body>
</html> 