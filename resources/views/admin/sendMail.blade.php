@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')
@include('sweetalert::alert')
<h1>Email to {{$data->name}}</h1>
<form action="{{ route('send.email',$data->id) }}" method="post">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter your title here">
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Enter message</label>
        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-danger">Send mail</button>
</form>





@endsection