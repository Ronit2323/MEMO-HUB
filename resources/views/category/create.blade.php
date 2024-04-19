@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

<div class="container">
    <form method="post" action="{{ route('categorys.store') }}" class="form-container">
        @csrf

        <div class="form-group">
            <label for="type" class="label">Add Note Category</label>
            <input type="text" class="form-control input-field" id="category_name" name="category_name">
        </div>

        <button type="submit" class="btn btn-dark submit-btn">Add Note Category</button>
    </form>
</div>
@endsection