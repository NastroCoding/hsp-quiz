@extends('layouts.main')
@section('container')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Recent Quiz</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container">
                <button class="btn btn-sm btn-default mb-1" data-toggle="modal" data-target="#modal-filter">
                    <i class="fas fa-sliders"></i>
                </button>
                <div class="row">
                    @if ($data->isEmpty())
                        <div class="col-12">
                            <p>No quizzes found matching the criteria.</p>
                        </div>
                    @else
                        @foreach ($data as $quiz)
                            <div class="col-lg-4">
                                <div class="card" style="width: 23rem;">
                                    @if ($quiz->thumbnail == null)
                                    @else
                                        <img class="card-img-top" src="{{ asset('storage/' . $quiz->thumbnail) }}"
                                            alt="Card image cap" style="width:100%; height:180px;">
                                    @endif
                                    <div class="card-header">
                                        <h5 class="card-title m-0">{{ $quiz->title }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ $quiz->description }}</p>
                                        @php
                                            $userId = auth()->user()->id;
                                            $quizId = $quiz->id;
                                            $quizQuestions = $quiz->questions->pluck('id');
                                    
                                            $userAnswers = $answers->filter(function ($answer) use ($userId, $quizQuestions) {
                                                return $answer->user_id == $userId && $quizQuestions->contains($answer->question_id);
                                            });
                                    
                                            $userEssays = $essays->filter(function ($essay) use ($userId, $quizQuestions) {
                                                return $essay->user_id == $userId && $quizQuestions->contains($essay->question_id);
                                            });
                                    
                                            $answerCount = $userAnswers->count() + $userEssays->count();
                                            $questionCount = $quizQuestions->count();
                                        @endphp
                                    
                                        <span id="quizContainer_{{ $quizId }}">
                                            <!-- Default state based on answer count -->
                                            <span id="defaultState_{{ $quizId }}">
                                                @if ($questionCount == $answerCount)
                                                    <a class="btn btn-success disabled" style="cursor:not-allowed;">Finished</a>
                                                    <p class="float-right text-muted user-select-none">
                                                        {{ auth()->user()->calculateScoresForQuiz($quiz->id)->userScore }}/{{ $quiz->max_score }}
                                                    </p>
                                                @elseif ($answerCount > 0)
                                                    <a class="btn btn-primary" href="/quiz/view/{{ $quiz->slug }}" data-toggle="modal" data-target="#modal-quiz{{ $quiz->id }}">
                                                        Continue
                                                    </a>
                                                @else
                                                    <a class="btn btn-primary" href="/quiz/view/{{ $quiz->slug }}" data-toggle="modal" data-target="#modal-quiz{{ $quiz->id }}">
                                                        Enter
                                                    </a>
                                                @endif
                                            </span>
                                    
                                            <!-- Finished state when the timer has expired -->
                                            <span id="timerFinished_{{ $quizId }}" style="display: none;">
                                                <a class="btn btn-success disabled" style="cursor:not-allowed;">Time is
                                                    Up!</a>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if ($data->isNotEmpty())
                                <div class="modal fade" id="modal-quiz{{ $quiz->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Enter Quiz</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/quiz/view/{{ $quiz->slug }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Enter quiz code</label>
                                                            <input type="text" name="token" class="form-control"
                                                                id="exampleInputEmail1" placeholder="XXXXXX">
                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Go</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
