<!DOCTYPE html>
<html>
<head>
    <title>Account Accepted</title>
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
            background-color: #28a745;
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
            background-color: #e6f3ff;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin-bottom: 20px;
        }
        .footer {
            background-color: #28a745;
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
            <h1>Account Accepted</h1>
        </div>
        <div class="content">
            <div class="message">
                <p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>
            </div>
            <p>We are pleased to inform you that your account has been successfully accepted on {{ now()->toFormattedDateString() }}.</p>
            <p><strong>USERNAME:</strong> {{ $user->user_name }}</p>
            <p><strong>CONTACT NUMBER:</strong> {{ $user->contact }}</p>
            <p>If you have any questions or need further assistance, please don't hesitate to contact us.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} CrimeGuard. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
