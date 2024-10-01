<!DOCTYPE html>
<html>
<head>
    <title>Submission Confirmation</title>
</head>
<body>
    <h1>Submission Received</h1>
    <p>Dear {{ $submission->name }},</p>

    <p>We have received your submission. Our team will review it shortly. Here are the details:</p>

    <ul>
        <li><strong>Name:</strong> {{ $submission->name }}</li>
        <li><strong>Email:</strong> {{ $submission->email }}</li>
        <li><strong>File Uploaded:</strong> {{ $submission->cv_path }}</li>
    </ul>

    <p>Thank you for your submission!</p>

    <p>Best regards,<br>The Quiz Management Team</p>
</body>
</html>
