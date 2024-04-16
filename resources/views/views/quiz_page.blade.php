@extends('layouts.quiz')

@section('number')
    @for ($i = 1; $i <= $lastQuestionNumber; $i++)
        <a href="/quiz/view/{{ $slug }}/{{ $i }}" class="btn btn-default col">{{ $i }}</a>
    @endfor
@endsection

@section('container')
    <div class="content-wrapper d-flex justify-content-center align-items-center">
        <div class="content">
            <div class="container">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <!-- Multiple Choice Form -->
                    @foreach ($questions as $que)
                        @if ($que->number == $question_number)
                            <div class="card card-default" style="max-width: 500px;">
                                <!-- Limiting the width to 500px -->
                                <div class="card-header">
                                    <h3 class="card-title">{{ $que->question_type }}</h3>
                                    <h3 class="card-title text-muted float-right">Time Remaining: <span
                                            id="countdownTimer2"></span></h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form>
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
                                    <div class="card-footer">
                                        <a type="submit" class="btn btn-default"><i class="fas fa-angle-left"></i> Back</a>
                                        <a type="submit" class="btn btn-primary float-right">Next <i
                                                class="fas fa-angle-right"></i></a>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endforeach
                    <!-- Essay Form -->
                        <div class="card card-default" style="max-width: 500px;">
                            <!-- Limiting the width to 500px -->
                            <div class="card-header">
                                <h3 class="card-title">Question 1</h3>
                                <h3 class="card-title text-muted float-right">Time Remaining: <span id="countdownTimer3"></span>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <div class="form-group">
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus ea at,
                                            consequatur earum iure ab totam quibusdam corporis quasi, magni voluptatem quis
                                            aperiam aut maiores doloribus! Earum molestiae odio et!</p>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                    </div>
                                    <p class="text-sm text-muted float-right">Essay</p>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="submit" class="btn btn-default"><i class="fas fa-angle-left"></i> Back</a>
                                    <a type="submit" class="btn btn-primary float-right">Next <i
                                            class="fas fa-angle-right"></i></a>
                                </div>
                            </form>
                        </div>
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
@endsection
