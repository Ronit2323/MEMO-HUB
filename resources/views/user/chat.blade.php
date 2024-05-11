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
        .user-message {
            background-color: lightblue !important;
            /* Background color for messages sent by the logged-in user */
            color: white;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: left !important;
        }

        .other-message {
            background-color: lightgray !important;
            /* Background color for messages sent by other users */
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .right-align {
            text-align: right;
            /* Align messages sent by the logged-in user to the right */
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

    <div class="chat-here w-100" style="margin-top: 5rem;">
        <p class="text-center">*PLEASE SELECT THE FACULTY AND SUBJECT TO TAKE PART IN THE DISCUSSION</p>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <label for="faculty_id">Select Faculty:</label>
                    <select id="faculty_id" name="faculty_id" onchange="updateSubjects()" class="form-control mb-3">
                        <option value="">-- Select Faculty --</option> <!-- Placeholder option -->
                        @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <label for="subject_id">Select Subject:</label>
                    <select id="subject_id" name="subject_id" required placeholder="Select Subject" class="form-control">
                        <!-- Options will be dynamically added using JavaScript -->
                    </select>
                </div>
            </div>
        </div>

    </div>


    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Chat area -->
                <div class="card mt-4">
                    <div class="card-body">
                        <!-- Chat messages -->
                        <div class="chat-messages" style="height: 300px; overflow-y: auto;">
                            <!-- Inside the loop that renders chat messages -->


                        </div>
                    </div>

                    <!-- Message input area -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <form id="message-form" action="{{ route('chat.sendMessage') }}" method="post">
                                @csrf
                                <input type="hidden" name="faculty_id" value="{{ $selectedFacultyId }}">
                                <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
                                <div class="form-group">
                                    <textarea name="chat_body" class="form-control" rows="3" required placeholder="WRITE YOUR MESSAGE HERE"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Reset the faculty dropdown to the placeholder option
            var facultyDropdown = document.getElementById('faculty_id');
            facultyDropdown.value = ''; // Reset the value to empty
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // No need to add the placeholder in the JavaScript code
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
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to the faculty dropdown
            document.getElementById('faculty_id').addEventListener('change', function() {
                // Get the selected faculty ID
                var selectedFacultyId = this.value;
                // Update the value of the hidden input field
                document.querySelector('input[name="faculty_id"]').value = selectedFacultyId;
                // Call a function to update the subjects based on the selected faculty (if needed)
                updateSubjects();
            });

            // Add event listener to the subject dropdown
            document.getElementById('subject_id').addEventListener('change', function() {
                // Get the selected subject ID
                var selectedSubjectId = this.value;
                // Update the value of the hidden input field
                document.querySelector('input[name="subject_id"]').value = selectedSubjectId;
            });
        });
    </script>

    <script>
        // Function to update chat messages based on selected faculty and subject
        function updateMessages() {
            var facultyId = document.getElementById('faculty_id').value;
            var subjectId = document.getElementById('subject_id').value;

            // Make an AJAX request to fetch chat messages based on selected faculty and subject
            fetch(`/fetchMessages?faculty_id=${facultyId}&subject_id=${subjectId}`)
                .then(response => response.json())
                .then(messages => {
                    var chatMessages = document.querySelector('.chat-messages');
                    chatMessages.innerHTML = ''; // Clear existing messages

                    messages.forEach(message => {
                        var messageElement = document.createElement('div');
                        messageElement.classList.add('message');

                        var userName = message.user ? message.user.user_name : 'Unknown'; // Get the user's name

                        var messageContent = `
                    <div class="message-content">
                    <p><strong>${message.user.name ? message.user.name : 'Unknown'}:</strong> ${message.chat_body}</p>
                        <span class="message-time">${message.created_at}</span>
                      

                       
                    </div>`;
                        var userId = parseInt('{{ Auth::user()->id }}'); // Get the user ID from PHP
                        if (message.user && message.user.id === userId) {
                            messageContent += `
                        <button class="btn btn-danger btn-sm delete-message" onclick="return confirm('Are you sure you want to delete this message?')" data-message-id="${message.id}">Delete</button>
                    `;
                        }

                        // Add event listener to handle message deletion
                        document.addEventListener('click', function(event) {
                            if (event.target.classList.contains('delete-message')) {
                                var messageId = event.target.dataset.messageId;

                                // Make an AJAX request to delete the message
                                fetch(`/deleteMessage/${messageId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Remove the deleted message element from the UI
                                            event.target.closest('.message').remove();
                                        } else {
                                            console.error('Error deleting message:', data.error);
                                        }
                                    })
                                    .catch(error => console.error('Error deleting message:', error));
                            }
                        });



                        // Check if the message is from the logged-in user
                        var userId = parseInt('{{ Auth::user()->id }}'); // Get the user ID from PHP
                        if (message.user && message.user.id === userId) {
                            messageElement.classList.add('user-message');
                            messageElement.classList.add('right-align'); // Add a class for right alignment
                        } else {
                            messageElement.classList.add('other-message');
                        }

                        messageElement.innerHTML = messageContent;
                        chatMessages.appendChild(messageElement);
                    });
                })
                .catch(error => console.error('Error fetching messages:', error));
        }




        // Function to send message without reloading the page
        function sendMessage(event) {
            event.preventDefault(); // Prevent form submission
            var formData = new FormData(event.target);

            // Make an AJAX request to send the message
            fetch(event.target.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append the newly sent message to the chat-messages section
                        var chatMessages = document.querySelector('.chat-messages');
                        var messageElement = document.createElement('div');
                        messageElement.classList.add('message');
                        var messageContent = `
                    <div class="message-content">
                        <p>${data.message.chat_body}</p>
                        <span class="message-time">${data.message.created_at}</span>
           
                        
                    </div>`;
                        messageElement.innerHTML = messageContent;
                        chatMessages.appendChild(messageElement);

                        // Clear the message input
                        event.target.querySelector('textarea[name="chat_body"]').value = '';
                    } else {
                        console.error('Error sending message:', data.error);
                    }
                })
                .catch(error => console.error('Error sending message:', error));
        }

        // Add event listeners to the dropdowns
        document.getElementById('faculty_id').addEventListener('change', updateMessages);
        document.getElementById('subject_id').addEventListener('change', updateMessages);

        // Add event listener to the message form
        document.getElementById('message-form').addEventListener('submit', sendMessage);
    </script>









</body>

</html>