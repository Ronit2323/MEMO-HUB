@extends('layout.adminDash')
@section('title')

@endsection


@section('content')
@if(request()->is('admin*'))
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Moderators</h5>
                <p class="card-text">{{ $totalModerators }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Subjects</h5>
                <p class="card-text">{{ $totalSubjects }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Notes Uploaded</h5>
                <p class="card-text">{{ $totalNotesUploaded }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Subjects</h5>
                <p class="card-text">{{ $totalSubjects }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Faculties</h5>
                <p class="card-text">{{ $totalFaculties }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Comments</h5>
                <p class="card-text">{{ $totalComments }}</p>
            </div>
        </div>
    </div>
</div>

@endif












@endsection



@section('title')

@endsection