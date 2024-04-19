@extends('layout.userDash')
@section('title', 'Upload Note')

@section('content')
<h1>Review made by moderator</h1>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Status</th>
            <th scope="col">Review</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    @foreach($user->notes as $note)
    <tbody>
        <tr id="row_{{ $note->id }}"> <!-- Add the id attribute here -->
            <td>{{ $loop->iteration }}</td>
            <td>Note: {{ $note->title }}</td>
            <td>Status: {{ $note->status }}</td>
            <td id="review_{{ $note->id }}">
                @if($note->moderators->isEmpty())
                No review made
                @else
                @foreach($note->moderators->reverse() as $moderator)
                @if($moderator->pivot->review != 'Put your default review here')
                {{ $moderator->name }}: {{ $moderator->pivot->review }}<br>
                @endif
                @endforeach
                @endif
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="deleteReview('{{ $note->id }}')">Delete Review</button>
            </td>
        </tr>
    </tbody>
    @endforeach
</table>
<div>
    {{$notes->links()}}
</div>
<script>
    function deleteReview(noteId) {
        // Find and remove the corresponding table row on the user's screen
        var rowElement = document.getElementById('row_' + noteId);
        if (rowElement) {
            rowElement.remove();
        }

        // Optionally, you can show a confirmation message
        alert('Review deleted successfully');
    }
</script>
@endsection