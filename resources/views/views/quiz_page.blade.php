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
        <a href="/quiz/view/{{ $slug }}/{{ $i }}" class="btn btn-default col">{{ $i }}</a>
    @endfor
@endsection

@section('container')
    <div class="content-wrapper d-flex justify-content-center align-items-center">
        <div class="content">
            <div class="container">
                <div class="row ">
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
                                <form>
                                    @if ($que->question_type == 'multiple_choice' || $que->question_type == 'weighted_multiple')
                                        <div class="card-body">
                                            <div class="form-group">
                                                <p>{{ $que->question }}</p>
                                            </div>
                                            @foreach ($que->choices as $index => $choice)
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="question1"
                                                            id="radio{{ $index + 1 }}">
                                                        <label class="form-check-label"
                                                            for="radio{{ $index + 1 }}">{{ $choice->choice }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <p class="text-sm text-muted float-right">{{ $que->question_type }}</p>
                                        </div>
                                        <!-- /.card-body -->
                                    @elseif ($que->question_type == 'essay')
                                        <div class="card-body">
                                            <div class="form-group">
                                                <p>{{ $que->question }}</p>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                            </div>
                                            <p class="text-sm text-muted float-right">{{ $que->question_type }}</p>
                                        </div>
                                        <!-- /.card-body -->
                                    @endif
                                    <div class="card-footer">
                                        @if ($que->number != 1)
                                            <a type="submit" href="/quiz/view/{{ $slug }}/{{ $que->number - 1 }}"
                                                class="btn btn-default"><i class="fas fa-angle-left"></i>
                                                Back</a>
                                        @endif
                                        @if ($que->number != $lastQuestionNumber)
                                            <a type="submit" href="/quiz/view/{{ $slug }}/{{ $que->number + 1 }}"
                                                class="btn btn-primary float-right">Next <i
                                                    class="fas fa-angle-right"></i></a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endforeach
                    <!-- Essay Form -->

                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
    <script src="{{ URL::asset('/dist/js/countdown.js') }}"></script>
    <script>
        CountdownTimer.init("countdownTimer2");
        CountdownTimer.init("countdownTimer3");
    </script>
    </script>
@endsection
