@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')
@include('sweetalert::alert')

<!-- Your HTML file -->
<form action="{{ route('viewUser') }}" method="GET">
    <div class="row">
        <div class="col-md-6 mx-auto"> <!-- Adjust the column width as needed -->
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search User" name="first_letter">
               
            </div>
        </div>
    </div>
</form>


<h1>Assign role</h1>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">User Type</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        @foreach($users as $row)
        <tbody>
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$row->name}}</td>
                <td>{{$row->userType}}</td>

                <td>
                    <a href="{{route('moderatorEdit',$row->id)}}" class="btn btn-primary">Edit</a>



                    <form method="POST" action="#" class="d-inline" onclick="return confirm('Are you sure you want to delete this data?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>

            </tr>


        </tbody>
        @endforeach
    </table>
    <div>
        {{$users->links()}}
    </div>
</div>

@endsection