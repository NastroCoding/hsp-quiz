<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page }} | HSPnet</title>
    <link rel="shortcut icon" href="{{ URL::asset('dist/img/favicon.ico') }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/adminlte.min.css') }}" />
    {{-- Animate.css --}}
    <link rel="stylesheet" href="{{ URL::asset('dist/css/animate.css') }}">
</head>

<body class="hold-transition sidebar-collapse m-0 p-0">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                    <p class="nav-link" style="color: #000">Time Remaining: <span id="countdownTimer"></span></p>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="{{ URL::asset('dist/img/logo.png') }}" alt="HSP Logo" class="brand-image"
                    style="opacity: 0.8" />
                <span class="brand-text font-weight-light">HSPnet</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-3">
                    <div class="row row-cols-5 m-1">
                        @yield('number')
                    </div>
                    <div></div>
                    <div class="row m-1">
                        <button class="btn btn-primary btn-sm">Finish Attempt</button>
                    </div>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        @yield('container')
    </div>
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ URL::asset('dist/js/adminlte.js') }}"></script>

    {{-- CUSTOM SCRIPT --}}
    <script src="{{ URL::asset('/dist/js/hspsite.js') }}"></script>

    {{-- JQuery  --}}
    <script src="{{ URL::asset('/dist/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            var data = @json($data);
            console.log(data['time']);

            var countdownMinutes = data['time']; // Assuming $data->time is in minutes
            var countDownDate;

            // Check if countdown end time is already stored in localStorage
            var storedCountdownTime = localStorage.getItem(`countdownEndTime_${data['id']}`);

            if (storedCountdownTime) {
                countDownDate = new Date(storedCountdownTime).getTime();
            } else {
                // Calculate countdown end time
                countDownDate = new Date().getTime() + (countdownMinutes * 60 * 1000);
                localStorage.setItem(`countdownEndTime_${data['id']}`, new Date(countDownDate));
            }

            function updateCountdown() {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdownTimer").innerHTML = "EXPIRED";
                    localStorage.removeItem('countdownEndTime');
                    const formData = new FormData(document.getElementById("quiz-form"));

                    // Determine the URL based on the question type
                    const questionType = "{{ $que->question_type }}";
                    let url =
                    "/quiz/{{ $que->quiz_id }}/answer"; // Default URL for multiple choice and weighted multiple
                    if (questionType === 'essay') {
                        url = "/quiz/{{ $que->quiz_id }}/essayAnswer";
                    }

                    // Send form data asynchronously
                    fetch(url, {
                            method: "POST",
                            body: formData
                        })
                        .then(response => {
                            if (response.ok) {
                                // Optionally handle successful submission
                                console.log("Form submitted successfully");
                                isSubmit = true;
                                if (isSubmit) {
                                    // If it's the final question, submit the form
                                    document.getElementById("quiz-form").submit();
                                    window.location.replace("/quiz");
                                } else {
                                    // Redirect to the next or previous question page
                                    const currentQuestionNumber = parseInt("{{ $que->number }}");
                                    const nextQuestionNumber = currentQuestionNumber + offset;
                                    if (nextQuestionNumber >= 1 && nextQuestionNumber <=
                                        {{ $lastQuestionNumber }}) {
                                        window.location.href = "/quiz/view/{{ $slug }}/" +
                                            nextQuestionNumber;
                                    } else {
                                        console.log("Invalid question number");
                                    }
                                }
                            } else {
                                // Optionally handle errors
                                console.error("Form submission failed");

                            }
                        })
                        .catch(error => {
                            // Handle network errors
                            console.error("Network error:", error);
                        });
                } else {
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("countdownTimer").innerHTML = hours + "h " +
                        minutes + "m " + seconds + "s ";
                }
            }

            updateCountdown(); // Call it immediately on page load  
            var x = setInterval(updateCountdown, 1000); // Update every second
        });
    </script>
</body>

</html>
