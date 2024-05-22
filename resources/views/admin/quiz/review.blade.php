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
                <h1>Quiz Review: {{ $quiz->title }}</h1>
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
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <h3>
                User: {{ $quiz->user->name ?? 'Unknown User' }}
            </h3>
        </div>
        @foreach ($quiz->questions as $question)
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <p class="card-title text-muted">{{ $question->type }}</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>{{ $loop->iteration }}. {{ $question->text }}</p>
                        </div>
                        @foreach ($question->options as $option)
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radio{{ $question->id }}" {{ $option->is_correct ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">
                                        {{ $option->text }} <span class="text-muted text-sm">{{ $option->points }} Points</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
