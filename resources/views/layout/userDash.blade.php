<!--

=========================================================
* Now UI Dashboard - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        @yield('title')
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/now-ui-dashboard.css?v=1.5.0') }}" rel="stylesheet" />
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
        channel.bind('user-status', function(data) {
            var authenticatedUserName = '{{ Auth::user()->name }}';

            if (data.name === authenticatedUserName) {
                toastr.info(JSON.stringify(data.name) + ' your note has been ' + JSON.stringify(data.status));
            }

        });
    </script>


</head>

<body class="">
    <div class="wrapper ">
        @include('sweetalert::alert')
        <div class="sidebar" data-color="orange">

            <div class="logo">

                <a href="#" class="simple-text logo-normal">
                    welcome, {{ Auth::user()->name }}
                </a>

            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{route('home')}}">
                            <i class="now-ui-icons design_app"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>




                    <li class="{{ request()->routeIs('notes.create') ? 'active' : '' }}">
                        <a href="{{ route('notes.create') }}">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>Upload Notes</p>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('notes.index') ? 'active' : '' }}">
                        <a href="{{ route('notes.index') }}">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>View Uploaded Notes</p>
                        </a>
                    </li>

                    <!-- See Favorites -->
                    <li class="{{ request()->routeIs('fav') ? 'active' : '' }}">
                        <a href="{{ route('fav') }}">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>See Favorites</p>
                        </a>
                    </li>

                    <!-- See Reviews by Moderator -->
                    <li class="{{ request()->routeIs('user.notes') ? 'active' : '' }}">
                        <a href="{{ route('user.notes', ['userId' => auth()->user()->id]) }}">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>See Reviews by the Moderator</p>
                        </a>
                    </li>

                    <!-- Change Password -->
                    <li class="{{ request()->routeIs('user.show') ? 'active' : '' }}">
                        <a href="{{ route('user.show') }}">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>Change Password</p>
                        </a>
                    </li>

                    <!-- Edit Profile -->
                    <li class="{{ request()->routeIs('user.edit') ? 'active' : '' }}">
                        <a href="{{ route('user.edit', ['userId' => auth()->user()->id]) }}">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>Edit Profile</p>
                        </a>
                    </li>

                    @auth
                    @if(auth()->user()->payments->isNotEmpty())
                    <li class="{{ request()->routeIs('UserPaymentDetail') ? 'active' : '' }}">
                        <a href="{{ route('UserPaymentDetail') }}">
                            <i class="now-ui-icons design_app"></i>
                            <p>View payment details</p>
                        </a>
                    </li>
                    @endif
                    @endauth



                </ul>
            </div>
        </div>
        <div class="main-panel" id="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">

                        <ul class="navbar-nav">

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="now-ui-icons users_single-02"></i>
                                    {{ Auth::user()->name }}
                                    <p>
                                        <span class="d-lg-none d-md-block">Some Actions</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>
                                @if(request()->is('home'))
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">Notification <span class="caret"></span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if($notes->isNotEmpty())
                                    @foreach ($notes as $note)
                                    @php
                                    $statusClass = '';
                                    switch($note->status) {
                                    case 'pending':
                                    $statusClass = 'text-warning'; // Set class to text-warning for pending status
                                    break;
                                    case 'approved':
                                    $statusClass = 'text-success'; // Set class to text-success for approved status
                                    break;
                                    case 'rejected':
                                    $statusClass = 'text-danger'; // Set class to text-danger for rejected status
                                    break;
                                    case 'under-review':
                                    $statusClass = 'text-primary'; // Set class to text-primary for under-review status
                                    break;
                                    default:
                                    $statusClass = 'text-muted'; // Set class to text-muted for other statuses
                                    break;
                                    }
                                    @endphp
                                    <a class="dropdown-item {{ $statusClass }}" href="{{ route('user.notes', $note->user->id) }}">
                                        Hey! your note {{ $note->title }} is {{ $note->status }}. Click to view moderator's review.
                                    </a>
                                    @endforeach
                                    @else
                                    <a class="dropdown-item">No records found</a>
                                    @endif
                                </div>
                            </li>
                            @endif

                            </li>


                        </ul>

                    </div>
                </div>
            </nav>
            <!-- End Navbar -->





            <div class="panel-header panel-header-sm">
            </div>
            <div class="content" style="margin-top: 70px;">
                @yield('content')
                @if(request()->is('home'))
                <div class="row">
                    <div class="col-md-3">
                        <div class="card h-200">
                            <div class="card-body">
                                <h5 class="card-title">Total Notes Uploaded</h5>
                                <p class="card-text">{{ $totalNotes }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card  h-200">
                            <div class="card-body">
                                <h5 class="card-title">Total Approved Notes</h5>
                                <p class="card-text">{{ $approvedNotesCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card  h-200">
                            <div class="card-body">
                                <h5 class="card-title">Total Pending Notes</h5>
                                <p class="card-text">{{ $pendingNotesCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card  h-200">
                            <div class="card-body">
                                <h5 class="card-title">Total Rejected Notes</h5>
                                <p class="card-text">{{ $rejectedNotesCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card  h-200">
                            <div class="card-body">
                                <h5 class="card-title">Total underReview Notes</h5>
                                <p class="card-text">{{ $underReviewNotesCount }}</p>
                            </div>
                        </div>
                    </div>




                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card  h-200">
                            <div class="card-body">
                                @if($paymentData)
                                <p>Your subscription plan:{{$paymentData->subscription->plan_name }}</p>
                                <p>You have made a payment on {{ $paymentData->created_at }}.</p>
                                <p>Plan Start date:{{$paymentData->subscription->start_date }}</p>
                                <p>Plan End date:{{$paymentData->subscription->end_date }}</p>
                                <!-- Display other payment information here -->
                                @else
                                <p  href="{{ route('subscriptions.create') }}?userId={{ Auth::id() }}">Join our subscription plan to enjoy unlimited access to notes</p>
                               

                                @endif
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="card h-200">
                            <div class="card-body">
                                <h5 class="card-title">Recently uploaded</h5>
                                @foreach ($notes as $note)
                                <p class="card-text">{{ $note['title'] }} - {{ $note['status'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                @if (session('paymentData'))
                <form action="{{ route('payment.store') }}" method="post">
                    @csrf
                    <!-- Include payment data as hidden fields -->
                    <input type="hidden" name="user_id" value="{{ session('paymentData')['user_id'] }}">
                    <input type="hidden" name="subscription_id" value="{{ session('paymentData')['subscription_id'] }}">
                    <input type="hidden" name="amount" value="{{ session('paymentData')['amount'] }}">
                    <input type="hidden" name="payment_method" value="{{ session('paymentData')['payment_method'] }}">
                    <input type="hidden" name="transaction_id" value="{{ session('paymentData')['transaction_id'] }}">
                    <input type="hidden" name="status" value="{{ session('paymentData')['status'] }}">
                    <!-- Add more fields as needed -->

                    <button type="submit">Save Payment Data</button>
                </form>
                @endif

                <!-- Load Google Charts -->







                @endif



            </div>
            <footer class="footer">
                <div class=" container-fluid ">
                    <nav>
                        <ul>
                            <li>
                                <a href="https://www.creative-tim.com">
                                    Creative Tim
                                </a>
                            </li>
                            <li>
                                <a href="http://presentation.creative-tim.com">
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="http://blog.creative-tim.com">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright" id="copyright">
                        &copy; <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('assets/js/now-ui-dashboard.min.js?v=1.5.0') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/demo.js') }}"></script>
    @yield('scripts')
</body>

</html>