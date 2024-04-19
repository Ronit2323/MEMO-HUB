@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')
@include('sweetalert::alert')
<h1>Email to user</h1>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user as $user)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                <a href="{{url('send_mail',$user->id)}}" class="btn btn-primary">Send mail</a>


            </td>
        </tr>
        @endforeach
    </tbody>

</table>




@endsection