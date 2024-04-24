@extends('layout.userDash')
@section('title', 'Upload Note')

@section('content')
@include('sweetalert::alert')
@if(session('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif

<div class="container" style="margin-top: 70px;"> <!-- Adjust the margin-top value according to your needs -->
    <h2>Upload your notes here</h2>
    <form method="post" action="{{ route('notes.store') }}" enctype="multipart/form-data">
        @csrf


        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <label for="faculty_id">Select Faculty:</label>
        <select id="faculty_id" name="faculty_id" required onchange="updateSubjects()">
            <option value="" selected disabled>Select Faculty</option>
            @foreach ($faculties as $faculty)
            <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
            @endforeach
        </select>


        <!-- Subject Dropdown -->
        <label for="subject_id">Select Subject:</label>
        <select id="subject_id" name="subject_id" required>
            <!-- Options will be dynamically added using JavaScript -->
        </select>
        <label for="category_id">Select Note Type:</label>
        <select id="category_id" name="category_id" ">
            <option value="" selected disabled>Select Note Type:</option>
            @foreach ($categories as $note)
            <option value=" {{ $note->id }}">{{ $note->category_name }}</option>
            @endforeach
        </select>


        <div class="form-group">
            <label for="file">File:</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" name="file" accept=".pdf, .doc, .docx">
                    <label class="custom-file-label" for="file">Choose file (PDF, Word)</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Summary:</label>
            <textarea class="form-control" id="summary" name="summary"></textarea>
        </div>





        <div class="form-group">
            <label for="image">Tag:</label>
            <input type="text" class="form-control" id="tags" name="tags">
        </div>
        <!-- <label for="status">Status:</label> -->
        <!-- <select name="status" disabled id="status" class="form-control" required>
            <option value="pending" selected>Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select> -->





        <button type="submit" class="btn btn-dark">Upload notes</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // No need to add the placeholder in the JavaScript code
    });

    function updateSubjects() {
        var facultyDropdown = document.getElementById('faculty_id');
        var facultyId = facultyDropdown.value;

        // Make an AJAX request to fetch subjects based on the selected faculty
        fetch(`/getSubjects/${facultyId}`)
            .then(response => response.json())
            .then(subjects => {
                var subjectDropdown = document.getElementById('subject_id');
                subjectDropdown.innerHTML = ''; // Clear existing options

                // Add 'Select Subject' as the default option for subjects
                var selectSubjectOption = document.createElement('option');
                selectSubjectOption.value = '';
                selectSubjectOption.text = 'Select Subject';
                subjectDropdown.add(selectSubjectOption);

                subjects.forEach(subject => {
                    var subjectOption = document.createElement('option');
                    subjectOption.value = subject.id;
                    subjectOption.text = subject.subject_name;
                    subjectDropdown.add(subjectOption);
                });
            })
            .catch(error => console.error('Error fetching subjects:', error));

        // Set the selected faculty as the default selected option
        facultyDropdown.value = facultyId;
    }
</script>
@endsection