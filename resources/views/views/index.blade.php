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
                <button class="btn btn-sm btn-default mb-1" data-toggle="modal" data-target="#modal-filter"><i
                        class="fas fa-sliders"></i></button>
                <div class="row">
                    <!-- /.col-lg-4 -->
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
                                        $userScore = $scores->first(function ($score) use ($userId, $quiz) {
                                            return $score->user_id == $userId && $score->quiz_id == $quiz->id;
                                        });

                                        $userAnswers = $answers->filter(function ($answer) use ($userId, $quiz) {
                                            return $answer->user_id == $userId && $answer->question_id == $quiz->id;
                                        });
                                        $userEssays = $essays->filter(function ($essay) use ($userId, $quiz) {
                                            return $essay->user_id == $userId && $essay->question_id == $quiz->id;
                                        });
                                    @endphp
                                    @dd($userScore)
                                    @if ($userScore)
                                        <a class="btn btn-success disabled" style="cursor:not-allowed;">Finished</a>
                                        <p class="float-right text-muted user-select-none">
                                            /{{ $quiz->max_score }}</p>
                                    @elseif ($userAnswers->isNotEmpty() || $userEssays->isNotEmpty())
                                        <a class="btn btn-primary" href="/admin/quiz/edit/{{ $quiz->id }}"
                                            data-toggle="modal" data-target="#modal-quiz">
                                            Continue
                                        </a>
                                    @else
                                        <a class="btn btn-primary" href="/admin/quiz/edit/{{ $quiz->id }}"
                                            data-toggle="modal" data-target="#modal-quiz">
                                            Enter
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
