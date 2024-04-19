@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

<div class="container">
    <form method="post" action="{{ route('subjects.update', $subject->id) }}" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type" class="label">Edit subject</label>
            <input type="text" class="form-control input-field" id="subject_name" value="{{ $subject->subject_name }}" name="subject_name">
        </div>

        <button type="submit" class="btn btn-dark submit-btn">Update Note Category</button>
    </form>
</div>
@endsection