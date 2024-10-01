<!DOCTYPE html>
<html>
<head>
    <title>Submission Confirmation</title>
</head>
<body>
    <h1>Submission Confirmation</h1>
    <p>Dear {{ $submission->name }},</p>

    <p>We have received your submission successfully. Here are the details:</p>

    <ul>
        <li><strong>Name:</strong> {{ $submission->name }}</li>
        <li><strong>Email:</strong> {{ $submission->email }}</li>
        <li><strong>CV:</strong> {{ $submission->cv_path }}</li>
    </ul>

    <p>Thank you for submitting!</p>

    <p>Best regards,<br/>The Team</p>
</body>
</html>
