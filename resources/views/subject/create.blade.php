@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

<div class="container">
    <form method="post" action="{{ route('subjects.store') }}" class="form-container">
        @csrf

        <div class="form-group">
            <label for="type" class="label">Add subject</label>
            <input type="text" class="form-control input-field" id="subject_name" name="subject_name">
        </div>

        <button type="submit" class="btn btn-dark submit-btn">Add subject</button>
    </form>
</div>
@endsection