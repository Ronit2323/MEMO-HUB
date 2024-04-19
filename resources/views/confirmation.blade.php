<!-- confirmation.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
</head>
<body>
    <h1>Payment Confirmation</h1>
    <p>Payment Details:</p>
    <ul>
        <li>User ID: {{ $payment->user_id }}</li>
        <li>Subscription ID: {{ $payment->subscription_id }}</li>
        <li>Amount: {{ $payment->amount }}</li>
        <!-- Add more payment details here -->
    </ul>
</body>
</html>
