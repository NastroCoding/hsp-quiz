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
            <button class="btn btn-sm btn-default mb-1" data-toggle="modal" data-target="#modal-filter"><i class="fas fa-sliders"></i></button>
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0">Quiz 1</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Special title treatment</h6>

                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <button href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Continue</button>
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
                            <button class="btn btn-success disabled" href="/quiz">Finished</button>
                            <p class="float-right ">50/100</p>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enter Quiz</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">

                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter quiz code</label>
                            <input type="text" name="token" class="form-control" id="exampleInputEmail1" placeholder="XXXXXX">
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" value="Go">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection