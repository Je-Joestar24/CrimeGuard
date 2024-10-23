<!DOCTYPE html>
<html>
<head>
    <title>Account Request Rejected</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #dc3545;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        .message {
            background-color: #ffe6e6;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin-bottom: 20px;
        }
        .footer {
            background-color: #dc3545;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Account Request Rejected</h1>
        </div>
        <div class="content">
            <div class="message">
                <p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>
            </div>
            <p>We regret to inform you that your account request has been rejected. Unfortunately, it seems your account does not comply with our requirements.</p>
            <p>If you believe this is a mistake or you have any further questions, please feel free to reach out to us.</p>
            <p>Thank you for your interest in our platform.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} CrimeGuard. All rights reserved.</p>
        </div>
    </div>
</body>
</html>