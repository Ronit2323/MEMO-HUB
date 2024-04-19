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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>



    <style>
        #img-div {
            width: 90%;
            height: 300px;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #pdfViewer{
            position: absolute;
            top: -100px;
            left: -500px;
            width: 1000px;
            height: 1000px;
            overflow: hidden;

        }


        /* Hide scrollbars for webkit browsers */
        
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

    <div class="notes" style="margin-top: 5rem;">
        <div class="row justify-content-center">
            <form action="{{ route('searchNote') }}" class="col-5 d-flex" method="GET">
                <div class="form-group d-flex w-100 m-auto">
                    <input type="search" name="search" style="border-radius: 20px; overflow: hidden;" class="form-control me-3 mb-5" placeholder="Search notes" aria-describedby="helpId" value="{{ $search }}" />
                    <button type="submit" class=" search btn btn-danger ">Search</button>
                </div>
            </form>
        </div>

        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-md-3"> <!-- Adjust the column size based on your design -->
                    <label for="faculty_id">Select Faculty:</label>
                    <select id="faculty_id" name="faculty_id" required onchange="updateSubjects()" class="form-control">
                        <option value="" selected disabled>Select Faculty</option>
                        @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="subject_id">Select Subject:</label>
                    <select id="subject_id" name="subject_id" required placeholder="Select Subject" class="form-control">
                        <!-- Options will be dynamically added using JavaScript -->
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="category_id" class="pl-5">Select Category:</label>
                    <select id="category_id" name="category_id" required class="form-control">
                        <option value="" selected disabled>Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4 w-75 m-auto pt-5">
            <div class="book-item row">
                @foreach ($approvedNotes as $note)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-small border-1 p-3 shadow-md rounded" style="max-width: 300px;">
                        <div id="img-div">
                            <iframe id="pdfViewer" src="{{ asset('storage/note/' . $note->file)}}" frameborder="0" scrolling="no"></iframe>

                        </div>

                      







                        <div class="card-body">
                            <p class="card-title"><strong class="text-success">Faculty:{{ $note->faculty->faculty_name }}</strong></p>
                            <p class="card-title"><strong class="text-success">Subject:{{ $note->subject->subject_name }}</strong></p>
                            <p class="card-title">{{ $note->title }}</p>

                            <!-- Other note details -->
                            <!-- Like and dislike buttons -->
                            <form action="{{route('viewNote',['note' => $note->id])}}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 view-note-button">
                                    View note
                                </button>
                            </form>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mt-3">
                                        @auth
                                        <form action="{{ route('like', ['note' => $note->id]) }}" method="POST" class="like-form">
                                            @csrf
                                            <input type="hidden" name="liked" value="{{ $note->isLikedByUser(auth()->user()) ? '1' : '0' }}">
                                            <button type="submit" class="btn btn-link like-btn">
                                                <i class="fa fa-thumbs-up like-icon" style="font-size: 20px;"></i>
                                                <p class="likes-count">{{ $note->likesCount() }}</p>
                                            </button>
                                        </form>
                                        @else
                                        <p class="text-warning">Please <a href="{{ route('login') }}">login</a> to like and comment note.</p>
                                        @endauth
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end mt-3">
                                        @auth
                                        @if(!$note->favoritedByUser(auth()->user()))
                                        <form action="{{ route('notes.toggleFavorite', ['note' => $note]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-dark">
                                                <i class="fa fa-bookmark"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-warning" disabled>
                                            <i class="fa fa-bookmark"></i>
                                        </button>
                                        @endif
                                        @else
                                        <!-- Display message for unauthenticated users -->
                                        @endauth
                                    </div>
                                </div>
                            </div>








                        </div>
                    </div>

                </div>

                @endforeach
            </div>


        </div>
        <div class="m-5 d-flex justify-content-center">
            {{ $approvedNotes->links() }}
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

        <script src="{{ asset('js/script.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Like button click event
                $('.like-form').on('submit', function(event) {
                    event.preventDefault();
                    var form = $(this);

                    $.ajax({
                        type: form.attr('method'),
                        url: form.attr('action') + '?t=' + new Date().getTime(),
                        data: form.serialize(),
                        success: function(response) {
                            // Update likes count
                            form.find('.likes-count').text(response.likesCount);

                            // Toggle color and liked state only for the current user
                            var currentUserLiked = response.currentUserLiked;
                            form.find('.like-btn i').toggleClass('selected', currentUserLiked);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error in AJAX request:', status, error);
                        }
                    });
                });

                // Set initial liked state on page load for the current user
                $('.like-form').each(function() {
                    var form = $(this);
                    var currentUserLiked = form.find('input[name="currentUserLiked"]').val() === '1';
                    form.find('.like-btn i').toggleClass('selected', currentUserLiked);
                });
            });
        </script>






        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Explicitly set the initial value of faculty_id
                var facultyDropdown = document.getElementById('faculty_id');
                facultyDropdown.value = ''; // Set it to an empty string or the default value if needed
                updateSubjects(); // Call the updateSubjects function when the page loads

                // Add event listeners to faculty, subject, and category dropdowns
                facultyDropdown.addEventListener('change', function() {
                    updateSubjects();
                    updateNotes();
                });
                document.getElementById('subject_id').addEventListener('change', updateNotes);
                document.getElementById('category_id').addEventListener('change', updateNotes);
                document.getElementById('category_id').selectedIndex = 0;
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

                // Trigger updateNotes when faculty is changed
                updateNotes();
            }

            function updateNotes() {
                var facultyDropdown = document.getElementById('faculty_id');
                var subjectDropdown = document.getElementById('subject_id');
                var categoryDropdown = document.getElementById('category_id');

                var facultyId = facultyDropdown.value;
                var subjectId = subjectDropdown.value;
                var categoryId = categoryDropdown.value;

                var url;

                if (!subjectId && !categoryId) {
                    // If neither subject nor category is selected, fetch all notes related to the faculty
                    url = `/getNotesByFaculty/${facultyId}`;
                } else if (!subjectId && categoryId && !facultyId) {
                    // If no subject or faculty is selected but category is selected, fetch notes based on the category
                    url = `/getNotesByCategory/${categoryId}`;
                } else if (!subjectId && categoryId && facultyId) {
                    // If no subject is selected but category and faculty are selected, fetch notes based on both faculty and category
                    url = `/getNotesByFacultyAndCategory?faculty_id=${facultyId}&category_id=${categoryId}`;
                } else if (!categoryId) {
                    // If a subject is selected and no category is selected, fetch notes based on both faculty and subject
                    url = `/getNotesByFacultyAndSubject?faculty_id=${facultyId}&subject_id=${subjectId}`;
                } else {
                    // If a subject is selected, fetch notes based on both faculty, subject, and category
                    url = `/getNotesByFacultyAndSubjectAndCategory?faculty_id=${facultyId}&subject_id=${subjectId}&category_id=${categoryId}`;
                }
                // Make an AJAX request to fetch notes
                fetch(url, {
                        cache: 'no-store'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.notes) {
                            updateNotesUI(data.notes);
                        } else {
                            console.error('Error: No notes found.');
                        }
                    })
                    .catch(error => console.error('Error fetching notes:', error));
            }

            function updateNotesUI(notes) {
                var notesContainer = document.querySelector('.book-item');
                notesContainer.innerHTML = ''; // Clear existing notes

                notes.forEach(note => {
                    // Create HTML elements for each note and append them to the container
                    var noteElement = createNoteElement(note);
                    notesContainer.appendChild(noteElement);
                });
            }

            function createNoteElement(note) {
                var colDiv = document.createElement('div');
                colDiv.className = 'col-md-6 col-lg-4 mb-4';

                var cardDiv = document.createElement('div');
                cardDiv.className = 'card card-small border-1 p-3 shadow-md rounded';
                cardDiv.style.maxWidth = '300px';

                if (note.id) { // Check if note.id is valid
                    cardDiv.innerHTML = `
                    <iframe id="pdfViewer" src="{{ asset('storage/note/' . $note->file)}}" frameborder="0"></iframe>
            <div class="card-body">
            <h5 class="card-title"><strong class="text-success">Faculty: {{ $note->faculty->faculty_name }}</strong></h5>
<h5 class="card-title"><strong class="text-success">Subject: {{ $note->subject->subject_name }}</strong></h5>

                <h5 class="card-title">${note.title}</h5>
                <form action="{{route('viewNote',['note' => $note->id])}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-75% view-note-button">
                                    <p>View note</p>
                                </button>
                            </form>
               

                            <div class="d-flex justify-content-between mt-3">
               
                <div class="d-flex justify-content-between mt-3">
                    <form action="/like" method="POST" class="like-form">
                        <input type="hidden" name="_token" value="your_csrf_token_here">
                        <input type="hidden" name="note" value="${note.id}">
                        <input type="hidden" name="liked" value="${note.liked ? '1' : '0'}">
                        <button type="submit" class="btn btn-link like-btn">
                            <i class="fa fa-thumbs-up like-icon" style="font-size: 20px;"></i>
                            <p class="likes-count">${note.likes_count}</p>
                        </button>
                    </form>
                </div>
                <div class="d-flex justify-content-between">
                    ${note.favoritedByUser ? `
                    <form action="/notes/toggleFavorite" method="POST">
                        <input type="hidden" name="_token" value="your_csrf_token_here">
                        <input type="hidden" name="note" value="${note.id}">
                        <button type="submit" class="btn btn-primary">
                            <p><i class="fa fa-plus"></i> Add to favorites</p>
                        </button>
                    </form>` : `
                    <button class="btn btn-primary" disabled>
                        <p><i class="fa fa-plus"></i> Already in favorites</p>
                    </button>`}
                </div>
            </div>
        `;
                } else {
                    cardDiv.innerHTML = `<p>No valid note found</p>`;
                }

                colDiv.appendChild(cardDiv);

                return colDiv;
            }
        </script>










</body>

</html>