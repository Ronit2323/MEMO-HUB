@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

<!-- Your HTML file -->
@include('sweetalert::alert')
<form action="{{ route('subjects.index') }}" method="GET">
    <div class="row">
        <div class="col-md-6 mx-auto"> <!-- Adjust the column width as needed -->
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search Subject" name="first_letter">
               
            </div>
        </div>
    </div>
</form>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Subject Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        @foreach($subjects as $row)
        <tbody>
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$row->subject_name}}</td>
                <td>
                    <a href="{{route('subjects.edit',$row->id)}}" class="btn btn-primary">Edit</a>



                    <form method="POST" action="{{route('subjects.destroy',$row->id)}}" class="d-inline" onclick="return confirm('Are you sure you want to delete this data?')">
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
        {{$subjects->links()}}
    </div>
</div>

@endsection