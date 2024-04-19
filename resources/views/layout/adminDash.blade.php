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


</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="orange">

            <div class="logo">

                <a href="#" class="simple-text logo-normal">
                    {{ Auth::user()->name }}
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li class="{{ request()->routeIs('adminDash') ? 'active' : '' }}">
                        <a href="{{ route('adminDash') }}">
                            <i class="now-ui-icons design_app"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('viewUser') ? 'active' : '' }}">
                        <a href="{{ route('viewUser') }}">
                            <i class="now-ui-icons design_app"></i>
                            <p>Assign moderator role</p>
                        </a>
                    </li>

                    <li class="nav-item dropdown {{ request()->routeIs('facultys.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="facultyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="now-ui-icons education_atom"></i>
                            <p>ADD FACULTY</p>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="facultyDropdown">
                            <a class="dropdown-item" href="{{ route('facultys.create') }}">Add faculty</a>
                            <a class="dropdown-item" href="{{ route('facultys.index') }}">view all faculty</a>
                            <!-- Add more dropdown items as needed -->
                        </div>
                    </li>

                    <li class="nav-item dropdown {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="subjectDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="now-ui-icons education_atom"></i>
                            <p>ADD SUBJECT</p>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="subjectDropdown">
                            <a class="dropdown-item" href="{{ route('subjects.create') }}">Add subject</a>
                            <a class="dropdown-item" href="{{ route('subjects.index') }}">view all subject</a>
                            <!-- Add more dropdown items as needed -->
                        </div>
                    </li>

                    <li class="nav-item dropdown {{ request()->routeIs('categorys.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="now-ui-icons education_atom"></i>
                            <p>ADD NOTE CATEOGORY</p>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <a class="dropdown-item" href="{{ route('categorys.create') }}">Add note categories</a>
                            <a class="dropdown-item" href="{{ route('categorys.index') }}">view all note types</a>
                            <!-- Add more dropdown items as needed -->
                        </div>
                    </li>

                    <li class="nav-item dropdown {{ request()->routeIs('associate-form') || request()->routeIs('association') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="associationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="now-ui-icons education_atom"></i>
                            <p>Asscicate subject and faculty</p>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="associationDropdown">
                            <a class="dropdown-item" href="{{ route('associate-form') }}">Asscociate faculty and subject</a>
                            <a class="dropdown-item" href="{{ route('association') }}">view association</a>
                            <!-- Add more dropdown items as needed -->
                        </div>
                    </li>
                    <li class="{{ request()->routeIs('paymentDetail') ? 'active' : '' }}">
                        <a href="{{ route('paymentDetail') }}">
                            <i class="now-ui-icons design_app"></i>
                            <p>View payment details</p>
                        </a>
                    </li>
















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