@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

<div class="container">
    <form method="post" action="{{ route('facultys.update', $faculty->id) }}" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type" class="label">Edit Faculty</label>
            <input type="text" class="form-control input-field" id="faculty_name" value="{{ $faculty->faculty_name }}" name="faculty_name">
        </div>

        <button type="submit" class="btn btn-dark submit-btn">Update faculty</button>
    </form>
</div>
@endsection