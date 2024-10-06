<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Report Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #1a56db;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Incident Report Confirmation</h1>
        <p>Dear {{ $user->first_name }},</p>
        <p>We have received your incident report. Thank you for bringing this to our attention.</p>
        <p>Details of your report:</p>
        <ul>
            <li><strong>Incident Type:</strong> {{ $incident->report_type == 1 ? 'Emergency' : 'Non-Emergency' }}</li>
            <li><strong>Date Reported:</strong> {{ $incident->date_reported }}</li>
            <li><strong>Time Reported:</strong> {{ $formattedTime }}</li>
            <li><strong>Location:</strong> {{ $incident->location }}</li>
        </ul>
        <p>We will process your report and take appropriate action. If we need any additional information, we will contact you using the details you provided.</p>
        <p>If you have any questions or need to provide additional information, please don't hesitate to contact us.</p>
        <p>Thank you for your vigilance and cooperation in keeping our community safe.</p>
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>