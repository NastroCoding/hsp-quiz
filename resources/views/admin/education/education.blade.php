@extends('layouts.admin')
@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger animate__animated animate__slideInDown" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        @if (session()->has('education_success'))
        <div class="alert alert-success animate__animated animate__slideInDown" role="alert">
            {{ session('education_success') }}
        </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Education</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Education</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#add-user"><i
                        class="fas fa-plus mr-1"></i>Add Education</button>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Education List</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search" />

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Education Name</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $education)
                        <tr>
                            <td>{{ $education->id }}</td>
                            <td>{{ $education->education_name }}</td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="#edit-modal{{ $education->id }}" data-toggle="modal">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $education->id }}" data-toggle="modal" data-target="#delete">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="modal fade" id="add-user">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Education</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/admin/education/create" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputToken">Education Name</label>
                                    <input type="text" name="education_name" class="form-control" id="exampleInputToken"
                                        placeholder="Enter Education Name">
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" class="btn btn-success" value="Add Education">
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> <b>If you delete this, all the data related will be deleted!</b> <br> <br> Are you sure? </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a id="deleteButton" class="btn btn-danger">
                            Delete
                        </a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        @if ($data->isNotEmpty())
            <div class="modal fade" id="edit-modal{{ $education->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Education</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/education/edit/{{ $education->id }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputToken">Education Name</label>
                                        <input type="text" name="education" class="form-control"
                                            id="exampleInputToken" placeholder="Enter Education"
                                            value="{{ $education->education_name }}">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" class="btn btn-success" value="Update Education">
                        </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        @endif
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Capture delete button click event
            $('.delete-btn').click(function() {
                // Get the ID of the user
                var userId = $(this).data('id');
                // Construct the delete URL
                var deleteUrl = '/admin/education/delete/' + userId;
                // Set the delete button href attribute
                $('#deleteButton').attr('href', deleteUrl);
            });
        });
    </script>
@endsection