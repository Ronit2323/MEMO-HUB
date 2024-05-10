@extends('layout.userDash')
@section('title', 'view added books')

@section('content')
@include('sweetalert::alert')
<form action="{{ route('notes.index') }}" method="GET">
    <div class="row">
        <div class="col-md-6 mx-auto"> <!-- Adjust the column width as needed -->
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search Notes" name="search">
                
            </div>
        </div>
    </div>
</form>



<div class="container" style="margin-top: 70px;"> <!-- Adjust the margin-top value according to your needs -->
    <h2>Uploaded Notes</h2>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Subject</th>
                <th scope="col">Faculty</th>
                <th scope="col">Status</th>
                <th scope="col">file</th>
                <!-- <th scope="col">Image</th> -->
                <th scope="col">Action</th>

            </tr>
        </thead>
        @foreach($notes as $note)
        <tbody>
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{ $note->title }}</td>
                <td>{{$note->subject->subject_name}}</td>
                <td>{{$note->faculty->faculty_name}}</td>
                <td style="{{ $note->status === 'approved' ? 'color: green;' : '' }}">{{ $note->status }}</td>
                <td><a href="{{ asset('storage/note/' . $note->file) }}">
            {{ $note->file }}</td>
        </a>


                <td>
                    <a href="{{route('notes.edit',$note->id)}}" class="btn btn-primary ">Edit</a>



                    <form method="POST" action="{{route('notes.destroy',$note->id)}}" class="d-inline" onclick="return confirm('Are you sure you want to delete this data?')">
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
        {{$notes->links()}}
    </div>


</div>
@endsection