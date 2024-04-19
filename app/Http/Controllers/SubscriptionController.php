<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subscription.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'plan' => 'required|in:monthly,yearly', // Ensure the plan is either 'monthly' or 'yearly'
        ]);

        // Determine the duration of the subscription (in months)
        $duration = ($validatedData['plan'] === 'monthly') ? 1 : 12;

        // Calculate the end date based on the start date and duration
        $startDate = now();
        $endDate = Carbon::parse($startDate)->addMonths($duration);

        // Create a new subscription record
        $subscription = new Subscription();
        $subscription->user_id = auth()->id(); // Assuming you're storing the user's ID
        $subscription->plan_name = $validatedData['plan'];
        $subscription->start_date = $startDate;
        $subscription->end_date = $endDate;
        $subscription->status = 'expired'; // Assuming newly created subscriptions are active
        $subscription->save();

        // Optionally, you may redirect the user to a success page or return a response
        $data = [
            'plan' => $validatedData['plan'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user' => auth()->user(), // Assuming you have a User model and you're using authentication
        ];

        // Return the subscription payment page view with the additional data
        return view('subscription.payment', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
