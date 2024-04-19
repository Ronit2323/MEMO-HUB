@extends('layout.userDash')
@section('title', 'Upload Note')

@section('content')
@include('sweetalert::alert')
<h1>Edit user Profile</h1>
<form method="POST" action="{{ route('user.update', $user->id) }}" class="form-horizontal">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <button type="submit" class="btn btn-dark submit-btn">Update user details</button>

    
</form>





<!-- Display your favorite note details here -->



@endsection