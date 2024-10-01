<!DOCTYPE html>
<html>
<head>
    <title>Submission Status</title>
</head>
<body>
    <h1>Dear {{ $submission->name }},</h1>
    <p>Your submission has been reviewed. The status of your submission is: <strong>{{ $submission->status }}</strong>.</p>
    <p>Thank you for your submission.</p>
</body>
</html>
