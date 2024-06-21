@extends('layouts.quiz')

@section('number')
    <style>
        #responsive {
            min-width: 350px;
            max-width: 90%;
        }

        @media only screen and (min-width: 768px) {
            #responsive {
                min-width: 600px;
                max-width: 100%;
            }
        }

        @media only screen and (max-width: 280px) {
            #responsive {
                min-width: 250px;
                max-width: 100%;
            }
        }
    </style>

    @php
        $answeredQuestionIds = $userAnswers->pluck('question_id')->toArray();
    @endphp

    @foreach ($questions as $question)
        <a href="/quiz/view/{{ $slug }}/{{ $question->number }}"
            class="btn {{ in_array($question->id, $answeredQuestionIds) ? 'btn-success text-white' : 'btn-default' }} col {{ $question_number == $question->number ? 'active' : '' }}"
            style="margin: 1px;">
            {{ $question->number }}
        </a>
    @endforeach
@endsection

@section('container')
    <div class="content-wrapper d-flex justify-content-center align-items-center">
        <div class="content">
            <div class="container">
                <div class="row mt-3">
                    @foreach ($questions as $que)
                        @if ($que->number == $question_number)
                            <div class="card card-default col-8" id="responsive">
                                <div class="card-header">
                                    <h3 class="card-title">Number {{ $que->number }}</h3>
                                </div>
                                <form action="/quiz/{{ $que->quiz_id }}/answer" method="POST" id="quiz-form">
                                    @csrf
                                    @if ($data)
                                        <input type="hidden" name="quiz_id" value="{{ $data->id }}">
                                        <input type="hidden" name="slug" value="{{ $data->slug }}">
                                    @endif
                                    <input type="hidden" name="question_id" value="{{ $que->id }}">
                                    <div class="card-body">
                                        <div class="form-group">
                                            @if ($que->images)
                                                <img src="{{ asset($que->images) }}" alt="Question Image"
                                                    style="max-width: 300px;" class="rounded">
                                            @endif
                                            <p>{{ $que->question }}</p>
                                        </div>
                                        @if ($que->question_type == 'multiple_choice' || $que->question_type == 'weighted_multiple')
                                            @php
                                                $userAnswer = $userAnswers->firstWhere('question_id', $que->id);
                                            @endphp
                                            @foreach ($que->choices as $index => $choice)
                                                <div class="form-group m-0">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="choosen_choice_id" value="{{ $choice->id }}"
                                                            id="radio{{ $index + 1 }}"
                                                            @if (isset($userAnswer) && $userAnswer->choosen_choice_id == $choice->id) checked @endif>
                                                        <label class="form-check-label" for="radio{{ $index + 1 }}">
                                                            @if ($choice->image_choice)
                                                                <img src="{{ asset('storage/' . $choice->image_choice) }}"
                                                                    alt="Choice Image" style="max-width: 200px;"
                                                                    class="rounded">
                                                            @endif
                                                            <p>{{ $choice->choice }}</p>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <a href="#" id="reset-button">Clear my selection</a>
                                        @elseif ($que->question_type == 'essay')
                                            @php
                                                $userEssay = $userEssays->firstWhere('question_id', $que->id);
                                            @endphp
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" placeholder="Enter ..." name="essay_answer" id="essay_answer">{{ $userEssay->answer ?? '' }}</textarea>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        @if ($que->number != 1)
                                            <button class="btn btn-default" type="button" id="back-button">
                                                <i class="fas fa-angle-left"></i> Back
                                            </button>
                                        @endif
                                        @if ($que->number != $lastQuestionNumber)
                                            <button type="button" class="btn btn-primary float-right" id="next-button">Next
                                                <i class="fas fa-angle-right"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-primary float-right"
                                                id="submit-button">Submit</button>
                                        @endif
                                    </div>
                                </form>

                                <script>
                                    function navigateQuestion(event, offset, isSubmit = false) {
                                        event.preventDefault(); // Prevent default form submission

                                        const radios = document.querySelectorAll('input[type="radio"]');
                                        let isChecked = false;
                                        let chosenChoiceId = null;

                                        radios.forEach(radio => {
                                            if (radio.checked) {
                                                isChecked = true;
                                                chosenChoiceId = radio.value; // Assume radio value is choice ID
                                            }
                                        });

                                        if (isChecked) {
                                            // Serialize form data
                                            const formData = new FormData(document.getElementById("quiz-form"));
                                            formData.append('choosen_choice_id', chosenChoiceId);

                                            // Determine the URL based on the question type
                                            const questionType = "{{ $que->question_type }}";
                                            let url = "/quiz/{{ $que->quiz_id }}/answer"; // Default URL for multiple choice and weighted multiple
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
                                                        console.log("Form submitted successfully");

                                                        if (isSubmit) {
                                                            document.getElementById("quiz-form").submit();
                                                            window.location.replace("/quiz");
                                                        } else {
                                                            const currentQuestionNumber = parseInt("{{ $que->number }}");
                                                            const nextQuestionNumber = currentQuestionNumber + offset;
                                                            if (nextQuestionNumber >= 1 && nextQuestionNumber <= {{ $lastQuestionNumber }}) {
                                                                window.location.href = "/quiz/view/{{ $slug }}/" + nextQuestionNumber;
                                                            } else {
                                                                console.log("Invalid question number");
                                                            }
                                                        }
                                                    } else {
                                                        console.error("Form submission failed");
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error("Network error:", error);
                                                });
                                        } else {
                                            // Handle deselection case
                                            const formData = new FormData(document.getElementById("quiz-form"));
                                            fetch("/quiz/{{ $que->quiz_id }}/deleteAnswer", {
                                                    method: "POST",
                                                    body: formData
                                                })
                                                .then(response => {
                                                    if (response.ok) {
                                                        console.log("Answer deleted successfully");
                                                        const currentQuestionNumber = parseInt("{{ $que->number }}");
                                                        const nextQuestionNumber = currentQuestionNumber + offset;
                                                        if (nextQuestionNumber >= 1 && nextQuestionNumber <= {{ $lastQuestionNumber }}) {
                                                            window.location.href = "/quiz/view/{{ $slug }}/" + nextQuestionNumber;
                                                        } else {
                                                            console.log("Invalid question number");
                                                        }
                                                    } else {
                                                        console.error("Failed to delete answer");
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error("Network error:", error);
                                                });
                                        }
                                    }

                                    function checkUnansweredQuestions() {
                                        const questions = document.querySelectorAll('.card-body');
                                        let allAnswered = true;
                                        questions.forEach((question, index) => {
                                            const radios = question.querySelectorAll('input[type="radio"]');
                                            let isAnswered = false;
                                            radios.forEach(radio => {
                                                if (radio.checked) {
                                                    isAnswered = true;
                                                }
                                            });
                                            if (radios.length > 0 && !isAnswered) {
                                                allAnswered = false;
                                            }
                                        });
                                        return allAnswered;
                                    }

                                    window.addEventListener('load', (event) => {
                                        const nextButton = document.getElementById("next-button");
                                        const backButton = document.getElementById("back-button");
                                        const submitButton = document.getElementById("submit-button");

                                        if (nextButton) {
                                            nextButton.addEventListener("click", function(event) {
                                                navigateQuestion(event, 1);
                                            });
                                        }

                                        if (backButton) {
                                            backButton.addEventListener("click", function(event) {
                                                navigateQuestion(event, -1);
                                            });
                                        }

                                        if (submitButton) {
                                            submitButton.addEventListener("click", function(event) {
                                                if (checkUnansweredQuestions()) {
                                                    navigateQuestion(event, 0, true);
                                                } else {
                                                    alert("Ada soal yang belum terjawab, harap jawab semua soal!");
                                                    event.preventDefault();
                                                }
                                            });
                                        }

                                        // Reset button logic
                                        const resetButton = document.getElementById('reset-button');
                                        if (resetButton) {
                                            resetButton.addEventListener('click', function() {
                                                const radios = document.querySelectorAll('input[type="radio"]');
                                                radios.forEach(radio => {
                                                    radio.checked = false;
                                                });
                                            });
                                        }
                                    });
                                </script>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
