@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

<div class="container">
    <form method="post" action="{{ route('facultys.store') }}" class="form-container">
        @csrf

        <div class="form-group">
            <label for="type" class="label">Add faculty</label>
            <input type="text" class="form-control input-field" id="faculty_name" name="faculty_name">
        </div>

        <button type="submit" class="btn btn-dark submit-btn">Add faculty</button>
    </form>
</div>
@endsection