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
            <div class="container-fluid">
                <button class="btn btn-sm btn-default mb-1" data-toggle="modal" data-target="#modal-filter"><i
                        class="fas fa-sliders"></i></button>
                <div class="row">
                    <div class="col-sm-5 col-md-6">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="{{ URL::asset('dist/img/thumbnail-logo.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Quiz 1</h5>
                                <p class="card-text"> With supporting text below as a natural lead-in to
                                    additional content.</p>
                                <a href="#" class="btn btn-primary">Continue</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-md-6">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="{{ URL::asset('dist/img/thumbnail-logo.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Quiz 2</h5>
                                <p class="card-text"> With supporting text below as a natural lead-in to
                                    additional content.</p>
                                <a href="#" class="btn btn-primary">Continue</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-md-6">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="{{ URL::asset('dist/img/thumbnail-logo.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Quiz 3</h5>
                                <p class="card-text"> With supporting text below as a natural lead-in to
                                    additional content.</p>
                                <a href="#" class="btn btn-primary">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                <input type="text" name="token" class="form-control" id="exampleInputEmail1"
                                    placeholder="XXXXXX">
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
