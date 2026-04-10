<!DOCTYPE html>
<html>
<head>
    <title>New Enquiry</title>
</head>
<body>
    <h2>New Enquiry Received</h2>
    <p><strong>Name:</strong> {{ $enquiry->name }}</p>
    <p><strong>Email:</strong> {{ $enquiry->email }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $enquiry->message }}</p>
</body>
</html>
