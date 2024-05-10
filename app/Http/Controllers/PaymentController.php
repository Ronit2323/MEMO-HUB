<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Payment;
use App\Models\Subscription;
use App\Mail\PaymentSuccessNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{


    public function checkPayment(Request $request)
    {
        $encodedData = $request->query('data');
        $decodedData = base64_decode($encodedData);
        $paymentData = json_decode($decodedData, true);
        if (!isset($paymentData['transaction_code'], $paymentData['status'], $paymentData['total_amount'])) {
            return response()->json(['error' => 'Missing required keys in payment data'], 400);
        }
        $transactionCode = $paymentData['transaction_code'];
        $status = $paymentData['status'];
        $totalAmount = $paymentData['total_amount'];
        $userId = auth()->id();
        $subscription = Subscription::where('user_id', $userId)->latest()->first();
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'subscription_id' => $subscription ? $subscription->id : null,
            'amount' => $totalAmount,
            'payment_method' => 'esewa',
            'transaction_id' => $transactionCode,
            'status' => 'success',
        ]);

        Mail::to(auth()->user())->send(new PaymentSuccessNotification($payment));
        return view('success', compact('paymentData'));
    }


    public function showPaymentForm()
    {
        $userId = Auth::id();
        $subscription = Subscription::where('user_id', $userId)->latest()->first();
        $amount = "100";
        $failure_url = 'https://google.com';
        $product_service_charge = 0;
        $product_delivery_charge = 0;
        $tax_amount = "10"; 
        $total_amount = $amount + $tax_amount;
        $transaction_uuid = uniqid();
        $product_code = 'EPAYTEST';
        $success_url = route('paymentcheck');
        $signed_field_names = 'total_amount,transaction_uuid,product_code';
        $data = "total_amount=$total_amount,transaction_uuid=$transaction_uuid,product_code=$product_code";
        $secret_key = '8gBm/:&EnhH.1/q';
        $signature = base64_encode(hash_hmac('sha256', $data, $secret_key, true));

        return view('payment', compact('amount', 'tax_amount', 'total_amount', 'transaction_uuid', 'product_code', 'success_url', 'failure_url', 'signed_field_names', 'signature', 'product_service_charge', 'product_delivery_charge', 'subscription'));
    }


    public function submitPayment(Request $request)
    {
        // Process the payment submission here
        $amount = $request->input('amount');
        $tax_amount = $request->input('tax_amount');
        $total_amount = $request->input('total_amount');
        $transaction_uuid = $request->input('transaction_uuid');
        $product_code = $request->input('product_code');
        $product_service_charge = $request->input('product_service_charge');
        $product_delivery_charge = $request->input('product_delivery_charge');
        $success_url = $request->input('success_url');
        $failure_url = $request->input('failure_url');
        $signed_field_names = $request->input('signed_field_names');
        $signature = $request->input('signature');
        $subscriptionId = $request->input('subscription_id');

        // Make the payment request to eSewa
        $response = Http::post('https://rc-epay.esewa.com.np/api/epay/main/v2/form', [
            'amount' => $amount,
            'tax_amount' => $tax_amount,
            'total_amount' => $total_amount,
            'transaction_uuid' => $transaction_uuid,
            'product_code' => $product_code,
            'product_service_charge' => $product_service_charge,
            'product_delivery_charge' => $product_delivery_charge,
            'success_url' => $success_url,
            'failure_url' => $failure_url,
            'signed_field_names' => $signed_field_names,
            'signature' => $signature,
        ]);

      
        try {
            if ($response->successful()) {
                // Populate Payment model and save to database
                $payment = Payment::create([
                    'user_id' => auth()->id(), // Assuming you're storing the user ID
                    'subscription_id' => $subscriptionId, // Assigning the ID of the subscription
                    'amount' => $total_amount, // Assuming you have $total_amount variable
                    'payment_method' => 'eSewa', // Assuming the payment method is eSewa
                    'transaction_id' => $transaction_uuid, // Assuming eSewa API response contains transaction ID
                    'status' => 'success', // Assuming the payment status is success
                ]);
                Log::info('Payment details saved:', [
                    'user_id' => $payment->user_id,
                    'subscription_id' => $payment->subscription_id,
                    'amount' => $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'transaction_id' => $payment->transaction_id,
                    'status' => $payment->status,
                ]);

                // Redirect the user back to the home page with success message
                Alert::success('The payment was successful!');
                return redirect()->route('home')->with('success', 'Payment successful!');
            } else {
                // Log the error and redirect the user to an error page
                Log::error('Payment request failed: ' . $response->body());
                return redirect()->route('payment.error');
            }
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error saving payment: ' . $e->getMessage());

            // Redirect the user to an error page
            return redirect()->route('payment.error')->with('error', 'An error occurred while processing your payment. Please try again later.');
        }
    }
    public function storePaymentData(Request $request)
    {
        // Validate incoming data...
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string',
            'status' => 'required|string',
            // Add more validation rules for other fields as needed...
        ]);

        // Save payment data to the database
        $payment = Payment::create($validatedData);

        // Redirect to another page or display confirmation
        return redirect()->route('confirmation')->with('payment', $payment);
    }
    public function confirmation()
    {
        // Retrieve the payment data from the session
        $payment = session('payment');

        // Pass the payment data to the confirmation view
        return view('confirmation', compact('payment'));
    }

    public function paymentDetail()
    {
        $payments = Payment::all(); // Retrieve all payment records from the database
        return view('admin.payment_detail', ['payments' => $payments]); // Pass the payments to the view

    }
    public function userPaymentDetail()
    {
        $userId = auth()->id(); // Get the authenticated user's ID
        $payments = Payment::where('user_id', $userId)->get();

        if ($payments->isEmpty()) {
            $message = 'You have not made any payments yet.';
            return view('user.payment_detail', compact('message'));
        }

        return view('user.payment_detail', compact('payments'));
    }
}
