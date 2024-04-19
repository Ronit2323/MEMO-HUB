<!-- resources/views/notes/for_moderator.blade.php -->
@extends('layout.moderatorDash')

@section('content')
<h1>Notes under-review</h1>

<p>Notes on {{ $moderator->faculty->faculty_name }} - {{ $moderator->subject->subject_name }}</p>



<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Uploader Name</th>
                <th scope="col">Title</th>
                <th scope="col">under-review by</th>
                <th scope="col">Subject</th>
                <th scope="col">Faculty</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
                </th>
            </tr>
        </thead>
        @foreach ($notes as $note)
        <tbody>
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$note->user->name}}</td>
                <td>{{ $note->title }}</td>
                <td>
                    @if($latestModerator = $note->moderators->last())
                    {{ $latestModerator->user->name }}
                    @else
                    Not approved
                    @endif
                </td>
                <td>{{$note->subject->subject_name}}</td>
                <td>{{$note->faculty->faculty_name}}</td>
                <td>{{$note->status}}</td>


                <td>



                    <a href="{{route('reviewNote',$note->id)}}" class="btn btn-primary">Review note</a>
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
    {{ $notes->links() }}
</div>
@endsection