<!DOCTYPE html>
<html>
<head>
    <title>Incident Response Update</title>
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
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        .message {
            background-color: #e6f3ff;
            border-left: 4px solid #0066cc;
            padding: 15px;
            margin-bottom: 20px;
        }
        .footer {
            background-color: #0066cc;
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
            <h1>Incident Response Update</h1>
        </div>
        <div class="content">
            <div class="message">
                <p>{{ $messageContent }}</p>
            </div>
            <p>Dear Citizen,</p>
            <p>We want to assure you that your safety is our top priority. Our team is working diligently to address the reported incident.</p>
            <p>If you have any additional information or concerns, please don't hesitate to contact our emergency hotline at <strong>09305879632</strong>.</p>
            <p>Stay safe and thank you for your cooperation.</p>
        </div>
        <div class="footer">
            <p>&copy; 2023 CrimeGuard. All rights reserved.</p>
        </div>
    </div>
</body>
</html>