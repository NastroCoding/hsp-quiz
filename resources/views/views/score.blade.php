@extends('layouts.main')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Score</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Score</li>
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
                    <!-- /.col-md-6 -->


                    @foreach ($data as $quiz)
                        @php
                            $userId = Auth::user()->id;
                            $userScore = $scores->first(function ($score) use ($userId, $quiz) {
                                return $score->user_id == $userId && $score->quiz_id == $quiz->id;
                            });
                        @endphp
                        @if ($userScore)
                            <div class="col-lg-4">
                                <div class="card" style="width: 23rem;">
                                    <img class="card-img-top" src="{{ asset('storage/' . $quiz->thumbnail) }}"
                                        alt="Card image cap" style="width:100%; height:180px;">
                                    <div class="card-header">
                                        <h5 class="card-title m-0">{{ $quiz->title }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"> {{ $quiz->description }}</p>
                                        <div>
                                            <a class="btn btn-success disabled " style="cursor:not-allowed;">Finished</a>
                                            <p class="float-right text-muted user-select-none">
                                                {{ $userScore->score }}/{{ $quiz->max_score }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- /.col-md-6 -->

                            <div class="col-lg-4">
                                <p>You haven't finished any quiz yet</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
