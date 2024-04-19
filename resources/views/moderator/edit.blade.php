@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')

@include('sweetalert::alert')
<div class="container">
    <form action="{{ route('moderatorUpdate', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- <label for="faculty_id">Select Faculty:</label>
        <select id="faculty_id" name="faculty_id" required onchange="updateSubjects()">
            @foreach ($faculties as $faculty)
            <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
            @endforeach
        </select> -->
        <label for="user_name">User Name:</label>
        <p id="user_name" name="name">{{ $user->name }}</p>
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

        <!-- User Type Dropdown -->
    
        <label for="user_type">Change User Type:</label>
        <select name="user_type" id="user_type" required>
            <option value="moderator">moderator</option>
            <option value="Null">Null</option>
            <!-- Add other user types as needed -->
        </select>


        <button type="submit">Update</button>
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