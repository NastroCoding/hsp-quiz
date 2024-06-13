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
                    <h1>Quiz {{}}</h1>
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
        <div class="row">
            <div class="col-md-6">
                <h3>User</h3>
                @foreach ($answeredQuestions as $userAnswer)
                    <div class="card card-default">
                        <!-- form start -->
                        <div class="card-header">
                            <p class="card-title text-muted">{{ $userAnswer->question->question }}</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <p>{{ $userAnswer->question->description }}</p>
                            </div>
                            <div class="form-group">
                                @foreach ($userAnswer->question->options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="radio{{ $userAnswer->question->id }}"
                                            {{ $option->is_answer ? 'checked' : '' }} disabled>
                                        <label class="form-check-label"> {{ $option->option }} <span
                                                class="text-muted text-sm">{{ $option->is_answer ? '+10 Points' : '' }}</span></label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                @endforeach
            </div>
        </div>
    </section>
@endsection
