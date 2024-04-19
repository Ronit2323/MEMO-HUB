<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
</head>
<body>
    <h1>Payment Successful</h1>
    <p>Dear {{ Auth::user()->name }},</p>
    <p>Your payment has been successfully processed. Details:</p>
    <ul>
        
        <li>Transaction ID: {{ $payment->transaction_id }}</li>
        <li>Amount: {{ $payment->amount }}</li>
        <!-- Add more payment details here -->
    </ul>
</body>
</html>
