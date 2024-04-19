@extends('admin.dashboard')

@section('title', 'Your Page Title')

@section('content')
@include('sweetalert::alert')
<h2>Subject-faculty-association </h2>

<form method="post" action="{{ route('associate') }}">
    @csrf

    <label for="subject_id">Select Subject:</label>
    <select id="subject_id" name="subject_id" required>
        @foreach ($subjects as $subject)
        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
        @endforeach
    </select>

    <label for="faculty_id">Select Faculty:</label>
    <select id="faculty_id" name="faculty_id" required>
        @foreach ($faculties as $faculty)
        <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
        @endforeach
    </select>

    <button type="submit">Associate Subject with Faculty</button>
</form>

<!-- Display a list of subjects and faculties -->
<div>
    <h3>Subjects</h3>
    <ul>
        @foreach ($subjects as $subject)
        <li>{{ $subject->subject_name }}</li>
        @endforeach
    </ul>
</div>

<div>
    <h3>Faculties</h3>
    <ul>
        @foreach ($faculties as $faculty)
        <li>{{ $faculty->faculty_name }}</li>
        @endforeach
    </ul>
</div>

@endsection