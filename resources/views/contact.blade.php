<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Memo Hub</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->

</head>

<body>
    <nav class="nav navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand px-2" href="#">MEMO-HUB</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item px-3">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">HOME</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="{{route('searchNote')}}">SEARCH NOTES</a>
                    </li>
                    <li class="nav-item px-3">
                        @if(Auth::check())
                        <a class="nav-link" href="{{ route('chat') }}">GROUP DISCUSSION</a>
                        @else
                        <a class="nav-link" href="{{ route('login') }}">GROUP DISCUSIION</a>
                        @endif
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="{{route('about')}}">ABOUT US</a>
                    </li>

                    <li class="nav-item px-3">
                        <a class="nav-link" href="{{route('contact')}}">CONTACT US</a>
                    </li>
                </ul>

                @auth
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                </div>
                @else
                <nav class="navbar navbar-light mx-5 ">
                    <form class="container-fluid justify-content-start">
                        <a href="{{ route('login') }}" class="btn btn-outline-dark me-2">Log in</a>

                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-dark">Sign Up</a>
                        @endif
                    </form>
                </nav>
                @endauth
            </div>
        </div>
    </nav>

    <div class="contact-hero">
        <h1>We'd <span class="text-danger">love</span> to hear from you</h1>
        <p>We're here to <span class="text-danger">answer</span> all your <span class="text-danger">curiosity</span> and <span class="text-danger">question!</span></p>

    </div>
    <div class="contact-container">
        <div class="row align-items-center">

            <div class="col-md-12">
                <div class="container">
                    <div class="text-center">
                        <h2>Get In Touch</h2>
                        <p>What can we do for you?</p>
                    </div>

                    <form action="{{ route('contact.submit') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="Contactmessage" class="form-label">Enter message</label>
                            <textarea class="form-control" id="Contactmessage" name="Contactmessage" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <footer>
        <div class="footer-section mt-4">
            <h2>MEMO HUB</h2>
            <h6>A note sharing platform</h6>
            <!-- <p>Hello we are Memo Hub. A note sharing platform which aims to provide the based quality notes for the development of ones knowledge and gain valuable insights.</p> -->

        </div>
        <div class="footer-bottom">

            <a href="#">Sell Notes</a>
            <a href="#">Search Notes</a>
            <a href="#">About Us</a>



        </div>

        <p>&copy copyrite@2023 Memo Hub</p>

    </footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" integrity="sha512-16esztaSRplJROstbIIdwX3N97V1+pZvV33ABoG1H2OyTttBxEGkTsoIVsiP1iaTtM8b3+hu2kB6pQ4Clr5yug==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js" integrity="sha512-Ic9xkERjyZ1xgJ5svx3y0u3xrvfT/uPkV99LBwe68xjy/mGtO+4eURHZBW2xW4SZbFrF1Tf090XqB+EVgXnVjw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>