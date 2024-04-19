@extends('layout.userDash')
@section('title', 'Upload Note')

@section('content')
<h1>Favorite Notes</h1>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Subject</th>
            <th scope="col">Faculty</th>
            <th scope="col">Date added</th>
            <!-- <th scope="col">Image</th> -->
            <th scope="col">Action</th>

        </tr>
    </thead>
    @foreach ($favoriteNotes as $favoriteNote)
    <tbody>
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{ $favoriteNote->note->title }}</td>
            <td>{{ $favoriteNote->note->subject->subject_name }}</td>
            <td>{{ $favoriteNote->note->faculty->faculty_name }}</td>
            <td>{{ $favoriteNote->created_at }}</td>




            <td class="d-flex p-2">
                <form action="{{route('viewNote',['note' => $favoriteNote->note->id])}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success ">
                        View
                    </button>
                </form>



                <form method="POST" action="{{route('deleteFavorite',$favoriteNote->id)}}" class="d-inline" onclick="return confirm('Are you sure you want to delete this data?')">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>

        </tr>


    </tbody>
    @endforeach
</table>
{{ $favoriteNotes->links() }}


<!-- Display your favorite note details here -->



@endsection