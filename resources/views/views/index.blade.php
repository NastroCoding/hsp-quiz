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
                                <img class="card-img-top" src="{{ asset('storage/' . $quiz->thumbnail) }}"
                                    alt="Card image cap" style="width:100%; height:180px;">
                                    <div class="card-header">
                                    <h5 class="card-title m-0">{{ $quiz->title }}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"> {{ $quiz->description }}</p>
                                    <a class="btn btn-primary" href="{{ route('quiz.thumbnail', ['id' => $quiz->id]) }}"
                                        data-toggle="modal" data-target="#modal-quiz">
                                        Continue
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- /.col-lg-4 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
