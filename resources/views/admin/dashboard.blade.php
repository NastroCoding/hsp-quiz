@extends('layouts.admin')
@section('container')
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Welcome Admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active"></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<h4 class="col-sm-6 m-1">Recent Quiz</h4>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Quiz 1</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit quas suscipit tempora illum omnis repellat numquam nostrum, mollitia reprehenderit doloremque cum vero earum dolore sequi neque id. Laboriosam, nam neque.</p>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#edit-quiz">Edit</button>
                        <button type="submit" class="btn btn-info">Manage</button>
                        <button type="submit" class="btn btn-warning">Review</button>
                        <button type="submit" class="btn btn-danger float-right">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Quiz 2</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam, voluptate. Deleniti architecto quasi corporis, facilis sit cumque distinctio consequatur, debitis blanditiis asperiores mollitia a magni temporibus ea non molestiae. Voluptatibus?</p>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#edit-quiz">Edit</button>
                        <button type="submit" class="btn btn-info">Manage</button>
                        <button type="submit" class="btn btn-warning">Review</button>
                        <button type="submit" class="btn btn-danger float-right">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Quiz 3</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit quas suscipit tempora illum omnis repellat numquam nostrum, mollitia reprehenderit doloremque cum vero earum dolore sequi neque id. Laboriosam, nam neque.</p>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#edit-quiz">Edit</button>
                        <button type="submit" class="btn btn-info">Manage</button>
                        <button type="submit" class="btn btn-warning">Review</button>
                        <button type="submit" class="btn btn-danger float-right">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- edit user modal -->
<div class="modal fade" id="edit-quiz">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Quiz</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/quiz/create" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputTitle">Quiz Title</label>
                            <input type="text" name="title" class="form-control" id="exampleInputTitle" placeholder="Enter title" value="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDescription">Description</label>
                            <textarea class="form-control" name="description" rows="3" id="exampleInputDescription" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDescription">Token</label>
                            <input type="text" name="token" class="form-control" id="exampleInputTitle" placeholder="Enter token" value="">
                        </div>
                        <div class="form-group">
                            <label for="">Time</label>
                            <div class="input-group mb-3">
                                <input type="number" name="time" class="form-control" placeholder="Minutes" value="">
                                <div class="input-group-append">
                                    <span class="input-group-text">min</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- select -->
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">nigga
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Education</label>
                                        <select class="form-control" name="education_id">
                                            <option value="">
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-success" value="Edit Quiz">
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.content -->
@endsection