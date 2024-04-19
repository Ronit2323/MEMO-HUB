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

    <div class="about-us-content">
        <h1>
            "Making <span class="text-danger">learning</span> easy"
        </h1>
        <h4>Your go to platfrom for <span class="text-danger">learning</span> and <span class="text-danger">sharing</span>sharing</h4>
    </div>
    <div class="aim">
        <p class="text-decoration-underline">The aim of “MEMO HUB” is to provide quality notes that will help people to learn easily
            anywhere at any time. </p>

    </div>
    <div class="about-content container-fluid">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="img/about-1.png" class="img-fluid rounded" alt="">
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                    <h5>Story of creating MEMO HUB</h5>
                    <p>The story behind MEMO HUB begins with its creation as a final year project (FYP) during my time as a student. Faced with the challenge of managing and organizing my study materials efficiently, I embarked on the journey of developing MEMO HUB. This platform emerged as a solution to streamline the process of storing, accessing, and sharing notes, documents, and resources among students. Through MEMO HUB, I aimed to provide a centralized hub where students could collaborate, learn, and grow together, making their academic journey smoother and more productive.</p>
                </div>
            </div>

        </div>

        <div class="container mt-5">

            <div class="row align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                    <h5>Our Vision</h5>
                    <p>Driven by the desire to enhance the academic experience for students, MEMO HUB aims to provide a user-friendly and collaborative environment where individuals can easily store, access, and share educational content. Whether it's preparing for exams, collaborating on group projects, or simply staying organized throughout the semester, MEMO HUB serves as a reliable companion for students on their academic journey.

                        Our vision extends beyond just being a platform for file sharing; we aspire to foster a community of learners who support each other's growth and success. By facilitating knowledge exchange and collaboration, MEMO HUB empowers students to maximize their learning potential and achieve academic excellence.</p>
                </div>
                <div class="col-md-6">
                    <img src="img/about-3.png" class="img-fluid rounded" alt="">
                </div>
            </div>

        </div>

        <div class="container mt-5">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="img/about-2.png" class="img-fluid rounded" alt="">
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                    <h5>Features and Benefits</h5>
                    <p>MEMO HUB offers a range of innovative features designed to enhance the learning experience. From a vast repository of study notes and resources to interactive study groups and discussion forums, our platform provides everything students need to succeed academically. With intuitive navigation, personalized recommendations, and seamless integration across devices, MEMO HUB makes learning convenient, enjoyable, and effective.</p>
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