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
            <button class="btn btn-sm btn-default mb-1" data-toggle="modal" data-target="#modal-filter"><i class="fas fa-sliders"></i></button>
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0">Quiz 1</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Special title treatment</h6>

                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <button class="btn btn-success disabled" href="/score">Finished</button>
                            <p class="float-right ">90/100</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0">Quiz 2</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Special title treatment</h6>

                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <button class="btn btn-success disabled" href="/score">Finished</button>
                            <p class="float-right">90/100</p>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@endsection