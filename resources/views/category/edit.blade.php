@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

<div class="container">
    <form method="post" action="{{ route('categorys.update', $category->id) }}" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type" class="label">Edit Note Category</label>
            <input type="text" class="form-control input-field" id="category_name" value="{{ $category->category_name }}" name="category_name">
        </div>

        <button type="submit" class="btn btn-dark submit-btn">Update Note Category</button>
    </form>
</div>
@endsection