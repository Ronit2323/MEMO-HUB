@extends('layout.userDash')
@section('title', 'Upload Note')

@section('content')
@include('sweetalert::alert')
<h1>Payment detail of {{ auth()->user()->name }}</h1>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">Transaction id</th>
                <th scope="col">Subscription plan</th>
                <th scope="col">start date</th>
                <th scope="col">End date</th>
                <th scope="col">Payment method</th>
                <th scope="col">Status</th>

            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <th>{{ $payment->user->name }}</th>
                <th>{{ $payment->transaction_id }}</th>
                <th>{{ $payment->subscription->plan_name }}</th>
                <th>{{ $payment->subscription->start_date }}</th>
                <th>{{ $payment->subscription->end_date }}</th>
                <th>{{ $payment->payment_method }}</th>
                <th>{{ $payment->status }}</th>



                <!-- Add more fields as needed -->
            </tr>
            @endforeach
        </tbody>

    </table>

</div>







<!-- Display your favorite note details here -->



@endsection