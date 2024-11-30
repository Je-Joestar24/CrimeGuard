<!DOCTYPE html>
<html>
<head>
    <title>Incident Assignment Notification</title>
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
            background-color: #0066cc;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
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
            <h1>Incident Assignment Notification</h1>
        </div>
        <div class="content">
            <div class="message">
                <p>Dear {{ $user->first_name }},</p>
                <p>You have been assigned to an incident. Please check the system for more details.</p>
            </div>
            <p><strong>Incident Details:</strong></p>
            <ul>
                <li><strong>Incident ID:</strong> {{ $incident->id }}</li>
                <li><strong>Location:</strong> {{ $incident->location }}</li>
                <li><strong>Date Reported:</strong> {{ $incident->date_reported }}</li>
                <li><strong>Time Reported:</strong> {{ $incident->time_reported }}</li>
            </ul>
            <p>Track the incident: <a href="https://csitcicte.com/crimeguard.com">crimeguard</a></p>
            <p>Please log in to the system to view full details and take necessary actions.</p>
            <p>If you have any questions or concerns, please contact your supervisor.</p>
        </div>
        <div class="footer">
            <p>&copy; 2023 CrimeGuard. All rights reserved.</p>
        </div>
    </div>
</body>
</html>