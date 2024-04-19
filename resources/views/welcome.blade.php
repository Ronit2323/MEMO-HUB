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
    @include('sweetalert::alert')
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
    <div class="page1">


        <div class="motto">
            <p>"Elevate Ideas,Share Notes:Empowering Minds,One Note at a Time"</p>

        </div>


        <div class="intro container-fluid">





            <div class="header container-fluid circular-header">


                <h1>MEMO</h1>
                <h1>HUB</h1>
                <p>A NOTE <span class="text-danger">SHARING</span> PLATFORM</p>
            </div>

            <!-- <div class="about-us container-fluid">
                <p>Tech Memo Hub is a note sharing platform with a moto "Connect, create, elevate". The aim of this
                    platform is to make sharing notes easy. Access it anytime anywhere! Whether you're a student, a
                    professional, or a lifelong learner our note sharing platform is your go-to hub for unlocking new
                    ideas and knowledge.</p>

            </div> -->


        </div>






    </div>
    <div class="about-memoHub">
        <div class="about-container">
            <div class="about-column">
                <div class="content">
                    <div class="img-container">
                        <img class="img-property" src="https://images.unsplash.com/photo-1605918321412-d6504db4748e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">

                    </div>
                    <div class="about-title">
                        <h2>Access easily!</h2>
                        <p>Explore the world of notes and materials shared</p>

                    </div>

                </div>


                <div class="content">
                    <div class="img-container">
                        <img class="img-property" src="https://images.unsplash.com/photo-1600267165477-6d4cc741b379?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">

                    </div>
                    <div class="about-title">
                        <h2>Upload Notes</h2>
                        <p>Share your notes and ideas with other fellows!</p>

                    </div>

                </div>


                <div class="content">
                    <div class="img-container">
                        <img class="img-property" src="https://images.unsplash.com/photo-1490127252417-7c393f993ee4?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">

                    </div>
                    <div class="about-title">
                        <h2>Search Notes</h2>
                        <p>Memo hub makes it easy for you to search notes for you according to the subject and faculties</p>

                    </div>

                </div>
                <div class="content">
                    <div class="img-container">
                        <img class="img-property" src="https://images.unsplash.com/photo-1607863680198-23d4b2565df0?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">

                    </div>
                    <div class="about-title">
                        <h2>Pro Access</h2>
                        <p>Pay for lifetime unlock of all the notes</p>

                    </div>

                </div>


            </div>

        </div>

    </div>

    <div class="hero">
        <h1>Shaping the future of note sharing</h1>
        <h4>Access Notes</h4>
        <h3>कुनै पनि समयमा कुनै पनि ठाउँमा</h3>

    </div>
    <div class="page3">
        <h1>Sparkling Brilliance through<span class="text-danger">shared Notes</span> </h1>

    </div>


    <div class="cover d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="{{ asset('img/unlock.png') }}" alt="" class="img-fluid" style="height: 80vh; width: 100%; object-fit: cover;">
                </div>

                <div class="col-md-6">
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 p-5">
                        <h1>Unlock Your <span class="text-danger">Potential </span></h1>
                        <h5>Come be part of the <span class="text-danger">MEMO HUB</span> Family</h5>
                        <button class="btn btn-danger mt-4">Start your journey</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="page5">
        <h1>Can't find your answer?</h1>
        <h2>We are Here to Help</h2>
        <button class="btn btn-danger">search notes</button>

    </div>
    <div class="premium-feature-content">
        <h1>Discover <span class="text-danger">Premium</span> Benefits</h1>



        <p>Premium users gets unlimited access to notes</p>
        <div class="card h-50 d-flex align-items-center justify-content-center">
            <p>Different premium subscription plans just for you</p>
            <p>Unlock Full Access with Premium!</p>
            <h5 class="mb-4"> Get started</h5>
            @auth
            <a class="btn btn-danger" href="{{ route('subscriptions.create') }}?userId={{ Auth::id() }}">Get started</a>
            @else
            <a class="btn btn-danger" href="{{ route('login') }}">Log in to subscribe</a>
            @endauth
        </div>


    </div>
    <div class="faq">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        What is Memo Hub?
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Memo Hub is an online platform designed to provide a centralized hub for educational resources, including notes, study materials, and tutorials, to aid students and educators in their academic endeavors.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Is Memo Hub free to use?
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Yes, Memo Hub offers a free basic membership that allows users to access a wide range of educational resources. However, premium membership options with additional features may be available for purchase.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        How can I upload my notes to Memo Hub?
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">To upload your notes to Memo Hub, simply create an account, log in, and navigate to the upload section. From there, you can upload your notes in various formats such as PDF, DOC, or image files.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                        How can I search for specific notes or topics on Memo Hub?
                    </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Memo Hub provides a search feature that allows users to search for specific notes or topics by keywords, subjects, or categories. Simply enter your search query in the search bar to find relevant resources.</div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                        How can I contact Memo Hub for support or inquiries?
                    </button>
                </h2>
                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">For support or inquiries, you can reach out to the Memo Hub team through the contact form on the website or by sending an email to memohubmemohub@gmail.com. We strive to respond to all inquiries promptly.</div>
                </div>
            </div>
        </div>

    </div>
    <footer>
        <div class="footer-section">
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