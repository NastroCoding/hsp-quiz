@extends('layouts.quiz')

@section('number')
    <style>
        #responsive {
            min-width: 350px;
            max-width: 90%;
        }

        @media only screen and (min-width:768px) {
            #responsive {
                min-width: 600px;
                max-width: 100%;
            }
        }

        @media only screen and (max-width:280px) {
            #responsive {
                min-width: 250px;
                max-width: 100%;
            }
        }
    </style>
    @for ($i = 1; $i <= $lastQuestionNumber; $i++)
        @php
            $answered = false;
            foreach ($userAnswers as $userAnswer) {
                if ($userAnswer->question_id == $i) {
                    $answered = true;
                    break; // Exit the loop once an answer is found
                }
            }
        @endphp
        <a href="/quiz/view/{{ $slug }}/{{ $i }}"
            class="btn {{ $answered ? 'btn-success text-white' : 'btn-default' }} col {{ $question_number == $i ? 'active' : '' }}"
            style="margin: 1px;">{{ $i }}</a>
    @endfor
@endsection

@section('container')
    <div class="content-wrapper d-flex justify-content-center align-items-center">
        <div class="content">
            <div class="container">
                <div class="row mt-3">
                    <!-- /.col-md-6 -->
                    <!-- Multiple Choice Form -->
                    @foreach ($questions as $que)
                        @if ($que->number == $question_number)
                            <div class="card card-default col-8" id="responsive">
                                <!-- Setting a minimum width of 300px and a maximum width of 90% -->
                                <div class="card-header">
                                    <h3 class="card-title">Number {{ $que->number }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="/quiz/answer" method="POST">
                                    @csrf
                                    <input type="hidden" name="question_id" value="{{ $que->id }}">
                                    <div class="card-body">
                                        <div class="form-group">
                                            @if ($que->images)
                                                <img src="{{ asset('' . $que->images) }}" alt="Question Image"
                                                    style="max-width: 300px;">
                                            @endif
                                            <p>{{ $que->question }}</p>
                                        </div>

                                        @if ($que->question_type == 'multiple_choice' || $que->question_type == 'weighted_multiple')
                                            @foreach ($que->choices as $index => $choice)
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="choosen_choice_id" value="{{ $choice->id }}"
                                                            id="radio{{ $index + 1 }}">
                                                        <label class="form-check-label" for="radio{{ $index + 1 }}">
                                                            @if ($choice->image_choice)
                                                                <img src="{{ asset('storage/' . $choice->image_choice) }}"
                                                                    alt="Choice Image" style="max-width: 100px;">
                                                            @endif
                                                            <p>{{ $choice->choice }}</p>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @elseif ($que->question_type == 'essay')
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        @if ($que->number != 1)
                                            <a href="javascript:void(0)"
                                                onclick="submitForm('/quiz/view/{{ $slug }}/{{ $que->number - 1 }}')"
                                                class="btn btn-default"><i class="fas fa-angle-left"></i> Back</a>
                                        @endif
                                        @if ($que->number != $lastQuestionNumber)
                                            <a href="javascript:void(0)"
                                                onclick="submitForm('/quiz/view/{{ $slug }}/{{ $que->number + 1 }}')"
                                                class="btn btn-primary float-right">Next <i
                                                    class="fas fa-angle-right"></i></a>
                                        @else
                                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        @endif
                        <script>
                            var CountdownTimer = {
                                resetCountdown: function() {
                                    var countDownDate = new Date().getTime() + {{ $quiz->time }} * 60 * 1000;
                                    localStorage.setItem("countdownDate", countDownDate.toString());
                                    location.reload();
                                },

                                init: function(timerId) {
                                    var x = setInterval(function() {
                                        var now = new Date().getTime();
                                        var storedCountdownDate = localStorage.getItem("countdownDate");
                                        var countDownDate = storedCountdownDate ?
                                            parseInt(storedCountdownDate) :
                                            new Date().getTime() + {{ $quiz->time }} * 60 * 1000;

                                        var distance = countDownDate - now;
                                        var hours = Math.floor(
                                            (distance % (1000 * 60 * 60 * 24)) /
                                            (1000 * 60 * 60)
                                        );
                                        var minutes = Math.floor(
                                            (distance % (1000 * 60 * 60)) / (1000 * 60)
                                        );
                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                        var timerElement = document.getElementById(timerId);
                                        if (timerElement) {
                                            timerElement.innerHTML =
                                                hours + "h " + minutes + "m " + seconds + "s ";
                                        }

                                        if (distance < 0) {
                                            clearInterval(x);
                                            if (timerElement) {
                                                timerElement.innerHTML = "EXPIRED";
                                            }
                                        }
                                    }, 1000);
                                },
                            };

                            // Initialize countdown timer when the page loads
                            window.addEventListener("load", function() {
                                CountdownTimer.init("countdownTimer1");
                            });

                            // Add event listener to reset button
                            document.getElementById("resetButton").addEventListener("click", function() {
                                CountdownTimer.resetCountdown();
                            });
                            CountdownTimer.init("countdownTimer2");
                            CountdownTimer.init("countdownTimer3");
                        </script>
                    @endforeach
                    <!-- /.col-md-6 -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

@endsection
