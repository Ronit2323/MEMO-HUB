@extends('layout.moderatorDash')
@section('title')

@endsection


@section('content')
@push('scripts')
@include('sweetalert::alert')

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('1e60c60ba7233b9c827a', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('popup-channel');
    channel.bind('mod-notify', function(data) {
        var moderatorSubjectId = '{{ $moderator->subject_id }}';
        var moderatorFacultyId = '{{ $moderator->faculty_id }}';

        // Check if the event is for the current moderator
        if (data.subject === moderatorSubjectId && data.faculty === moderatorFacultyId) {
            toastr.info(JSON.stringify(data.name) + ' sent subject: ' + JSON.stringify(data.subject) + 'faculty:' + JSON.stringify(data.faculty));
        }
    });
</script>
<div>
    <h2 class="text-uppercase"> <strong>{{$moderator->user->name}}</strong> you have been assigned moderator on :</h2>
    <ul>
        <li><strong>Faulty name:</strong> {{ $moderator->faculty->faculty_name }} </li>
        <li>
            <strong>Subject name:</strong> {{ $moderator->subject->subject_name }}

        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text">{{ $userCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Moderators</h5>
                <p class="card-text">{{ $moderatorCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Subjects</h5>
                <p class="card-text">{{ $subjectCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Faculties</h5>
                <p class="card-text">{{ $facultyCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                @if($users->isNotEmpty())
                <div>
                    <h3>Users assigned to the same faculty and subject as the you:</h3>
                    <ul>
                        @foreach($users as $user)
                        <li>{{ $user->name }} ({{ $user->email }})</li>
                        @endforeach
                    </ul>
                </div>
                @else
                <p>No users assigned to the same faculty and subject as the moderator.</p>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- In your HTML head section -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="subjectChart" class="p-2" style="width: 100%; height: 350px;"></div>

<!-- Display Top Faculties Chart -->
<div id="facultyChart" class="p-2" style="width: 100%; height: 350px;"></div>

<!-- Script to Load Google Charts and Draw Charts -->
<script>
    google.charts.load('current', { packages: ['bar'] });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        drawSubjectChart();
        drawFacultyChart();
    }

    function drawSubjectChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Subject');
        data.addColumn('number', 'Count');
        data.addRows([
            @foreach ($topSubjectCounts as $subjectCount)
                ['{{ $subjectCount->subject->subject_name }}', {{ $subjectCount->count }}],
            @endforeach
        ]);

        var options = {
            chart: {
                title: 'Top Subjects',
                subtitle: 'Based on the number of uploads'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('subjectChart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawFacultyChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Faculty');
        data.addColumn('number', 'Count');
        data.addRows([
            @foreach ($topFacultyCounts as $facultyCount)
                ['{{ $facultyCount->faculty->faculty_name }}', {{ $facultyCount->count }}],
            @endforeach
        ]);

        var options = {
            chart: {
                title: 'Top Faculties',
                subtitle: 'Based on the number of uploads'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('facultyChart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>











@endsection



@section('title')

@endsection