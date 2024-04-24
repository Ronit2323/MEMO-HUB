<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Memo Hub</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #my-div {
            width: 90%;
            height: 350px;
            overflow: hidden;
            position: relative;
            top: 160px;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #my-iframe {
            position: absolute;
            top: -100px;
            left: -100px;
            width: 1280px;
            height: 1200px;
        }
    </style>



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
                        <a class="nav-link" href="#">SELL NOTES</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="{{route('about')}}">ABOUT US</a>
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
    <div class="m-5 p-3">
        <div class="card mt-4 p-3 w-75 m-auto mb-4">
            <div class="card-header">
                Note Details
            </div>
            <div class="card-body">
                <!-- Details of the note -->
                <h5 class="card-title"><strong class="text-danger">{{ $note->title }}</strong></h5>
                <p class="card-text text-danger">Uploaded by: {{ $note->user->name }}</p>
                <p class="card-text">Summary: {{ $note->summary }}</p>
                <p class="card-text">Tags: {{ $note->tags }}</p>
                <p class="card-text text-danger">Uploaded date: {{ $note->updated_at }}</p>
            </div>
            <div class="d-flex justify-content-between m-2">
                @auth
                @if(!$note->favoritedByUser(auth()->user()))
                <form action="{{ route('notes.toggleFavorite', ['note' => $note]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <p><i class="fa fa-plus"></i> Add to favorites</p>
                    </button>
                </form>
                @else
                <button class="btn btn-primary" disabled>
                    <p><i class="fa fa-plus"></i> Already in favorites</p>
                </button>
                @endif
                @else

                @endauth
            </div>
        </div>


        @if ($paymentDone)
        <div class="pdf-container d-flex align-items-center justify-content-center">
            <iframe src="{{ $filePath }}" width="70%" height="700"></iframe>
        </div>
        @else

        <!-- Show limited slides -->
        <div id="my-div">

            <iframe src="{{ $filePath }}" id="my-iframe" scrolling="no" width="70%" height="700" style="overflow: hidden;"></iframe>
            <!-- Apply CSS to iframe content -->


        </div>
        <div class="card mt-4 w-75 m-auto">
            <div class="card-header">
                Unlock Premium Features To Enjoy Full Documentation
            </div>
            <div class="card-body">

                <h5 class="card-title">Explore Our Range of Subscription Plans for Diverse Needs</h5>
                <p class="card-text">At reasonable price view our plans</p>
                @auth
                <a class="btn btn-danger" href="{{ route('subscriptions.create') }}?userId={{ Auth::id() }}">Get started</a>
                @else
                <a class="btn btn-danger" href="{{ route('login') }}">Log in to subscribe</a>
                @endauth
            </div>
        </div>
        @endif

    </div>
    <div class="comment-area mt-4 p-3 w-75 m-auto">
        @if(Session('message'))
        <h6 class="alert alert-warning mb-3">{{Session('message')}}</h6>
        @endif
        <div class="card card-body">
            <h5 class="card-title">Leave a comment</h5>
            @if(Auth::check())
            <form action="{{ route('comment.store') }}" method="post">
                @csrf
                <input type="hidden" name="note_id" value="{{ $note->id }}">
                <textarea name="comment_body" class="form-control" rows="3" required></textarea>
                <button type="submit" class="btn btn-danger mt-3">Submit</button>
            </form>
            @else
            <p>Please <a href="{{ route('login') }}">login</a> to leave a comment.</p>
            @endif
        </div>
        @foreach ($comments as $comment)
        <div class="card card-body shadow-sm mt-3">
            <div class="detail-area">
                <form id="editForm{{ $comment->id }}" action="{{ route('comment.update', ['comment' => $comment->id]) }}" method="post" style="display: none;">
                    @csrf
                    @method('PUT')
                    <textarea name="comment_body" class="form-control mb-1" rows="3">{{ $comment->comment_body }}</textarea>
                    <button type="submit" class="btn btn-primary">Update</button>

                </form>
                <h6 class="user-name mb-1">
                    {{ $comment->user->name }} <!-- Accessing user's name -->
                    <small class="ms-3 text-primary">Commented on: {{ $comment->created_at }}</small>
                </h6>
                <div class="d-flex align-items-center"> <!-- Wrap edit and delete buttons in a flex container -->
                    <p class="user-comment mb-1">
                        <span id="commentBody{{ $comment->id }}">{{ $comment->comment_body }}</span>
                    </p>
                    @if(Auth::check() && Auth::id() == $comment->user->id)
                    <div id="editButtons{{ $comment->id }}" class="p-3"> <!-- Container for edit and delete buttons -->
                        <button type="button" class="btn btn-primary me-2 ml-4" onclick="showEditForm('{{ $comment->id }}')">Edit</button>
                        <form action="{{ route('comment.destroy', ['comment' => $comment->id]) }}" method="post" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach



        <script>
            function showEditForm(commentId) {
                // Hide the comment body and show the edit form
                document.getElementById('commentBody' + commentId).style.display = 'none';
                document.getElementById('editForm' + commentId).style.display = 'block';

                // Hide the edit and delete buttons container
                document.getElementById('editButtons' + commentId).style.display = 'none';
            }

            function cancelEdit(commentId) {
                // Show the comment body and hide the edit form
                document.getElementById('commentBody' + commentId).style.display = 'block';
                document.getElementById('editForm' + commentId).style.display = 'none';
            }
        </script>


    </div>
    <footer style=" background-color: whitesmoke;">
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
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.worker.js"></script>
</body>