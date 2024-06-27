@php
    $answeredQuestions = $answeredQuestions ?? [];
@endphp

@extends('layouts.admin')
@section('container')
    <section class="content-header">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        @if (session()->has('quiz_success'))
            <div class="alert alert-success animate__animated animate__slideInDown" role="alert">
                {{ session('quiz_success') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $quiz->slug }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/quiz">Quiz</a></li>
                        <li class="breadcrumb-item active">Review</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <h3 class="col-md-6">{{ $user->name }}</h3>
        <div class="row">
            @foreach ($questions as $question)
                @php
                    $answer = $answers->firstWhere('question_id', $question->id);
                    $correctChoice = $question->choices->firstWhere('is_correct', true);
                    $userCorrect = $answer && $correctChoice && $answer->choosen_choice_id == $correctChoice->id;
                @endphp
                <div class="col-md-6">
                    <div class="card card-default">
                        <!-- form start -->
                        <div class="card-header">
                            <p class="card-title text-muted">{{ $question->question_type }}</p>
                            @if ($question->question_type == 'multiple_choice')
                                @if ($userCorrect)
                                    <span class="badge badge-success ml-2">Correct</span>
                                @else
                                    <span class="badge badge-danger ml-2">Wrong</span>
                                @endif
                            @endif
                        </div>
                        <div class="card-body">
                            @if ($question->images)
                                <img src="{{ asset('' . $question->images) }}" alt="Question Image"
                                    style="max-width: 300px;" class="rounded">
                            @endif
                            @if ($question->question_type == 'multiple_choice' || $question->question_type == 'weighted_multiple')
                                <div class="form-group">
                                    <p>{{ $question->number }}. {{ $question->question }}</p>
                                    @foreach ($question->choices as $index => $choice)
                                        <div class="form-check mb-1 mt-1">
                                            <!-- Add 'checked' attribute based on is_correct value -->
                                            @if ($question->question_type == 'weighted_multiple')
                                                <input class="form-check-input" type="radio" disabled
                                                    @if (isset($answer) && $answer->choosen_choice_id == $choice->id) checked @endif>
                                            @else
                                                <input class="form-check-input" type="checkbox" name="checkbox1[]"
                                                    @if (isset($answer) && $answer->choosen_choice_id == $choice->id) checked @endif disabled>
                                            @endif
                                            <label class="form-check-label">
                                                @if ($choice->image_choice)
                                                    <img src="{{ asset('storage/' . $choice->image_choice) }}"
                                                        alt="Choice Image" style="max-width: 200px;" class="rounded"><br>
                                                @endif
                                                {{ $choice->choice }}
                                                <span class="text-muted text-sm">
                                                    @if ($question->question_type == 'weighted_multiple')
                                                        +{{ $choice->point_value }} Points
                                                    @endif
                                                </span>
                                                @if ($question->question_type == 'multiple_choice')
                                                @endif
                                                @if ($choice->is_correct)
                                                    <span class="badge badge-success ml-2">Answer</span>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="form-group">
                                    <p>{{ $question->number }}. {{ $question->question }}</p>
                                    @foreach ($essays as $essay)
                                        <textarea class="form-control disabled" rows="3" placeholder="Enter ..." name="essay_answer" id="essay_answer"
                                            disabled>{{ $essay->answer }}</textarea>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            @endforeach
        </div>
    </section>
@endsection
