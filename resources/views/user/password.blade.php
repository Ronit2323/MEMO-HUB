@extends('layout.userDash')
@section('title', 'Upload Note')

@section('content')
@include('sweetalert::alert')
<h1>Change user's password</h1>
<form method="POST" action="{{ route('Userpassword.update', ['userId' => auth()->user()->id]) }}" class="form-horizontal">
    @csrf

    <div class="form-group">
        <label for="current_password" class="col-sm-2 control-label">Current Password</label>
        <div class="col-sm-10">
            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password">
        </div>
    </div>

    <div class="form-group">
        <label for="new_password" class="col-sm-2 control-label">New Password</label>
        <div class="col-sm-10">
            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">
        </div>
    </div>

    <div class="form-group">
        <label for="new_password_confirmation" class="col-sm-2 control-label">Confirm New Password</label>
        <div class="col-sm-10">
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Confirm New Password">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
    </div>
</form>





<!-- Display your favorite note details here -->



@endsection