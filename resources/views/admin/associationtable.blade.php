@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

<!-- Your HTML file -->
@include('sweetalert::alert')
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Faculty Name</th>
                <th scope="col">Subject Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($association as $row)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$row->faculty->faculty_name}}</td>
                <td>{{$row->subject->subject_name}}</td>
                <td>
                    <a href="#" class="btn btn-primary">Edit</a>

                    <form method="POST" action="#" class="d-inline" onclick="return confirm('Are you sure you want to delete this data?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{$association->links()}}
    </div>
</div>

@endsection