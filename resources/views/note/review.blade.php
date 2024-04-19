@extends('layout.moderatorDash')

@section('content')
<div class="container">
    <h1 class="mb-4">Review Note</h1>

    <form method="POST" action="{{ route('updateNote', ['note' => $note->id]) }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="uploader_name">Uploader Name:</label>
            <p id="uploader_name">{{ $note->user->name }}</p>
        </div>

        <div class="form-group">
            <label for="title">Title:</label>
            <p id="title">{{ $note->title }}</p>
        </div>

        <div class="form-group">
            <label for="summary">Summary:</label>
            <p id="summary">{{ $note->summary }}</p>
        </div>

        <div class="form-group">
            <label for="faculty">Faculty:</label>
            <p id="faculty">{{ $note->faculty->faculty_name }}</p>
        </div>

        <div class="form-group">
            <label for="subject">Subject:</label>
            <p id="subject">{{ $note->subject->subject_name }}</p>
        </div>
        <div class="form-group">
            <label for="review">Review:</label>
            <textarea name="review" id="review" class="form-control" rows="4"></textarea>
        </div>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="under-review" {{ $status === 'under-review' ? 'selected' : '' }}>Under Review</option>
        </select>
        <td>
            <!-- Display the file link or download button -->
            <a href="{{ asset('storage/note/' . $note->file) }}">
                {{ $note->file }}
            </a>
        </td>

        <button type="submit" class="btn btn-primary">Submit Review</button>

        <!-- Add your review input fields here -->


    </form>
</div>
@endsection