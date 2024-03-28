@extends('layouts.admin')
@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @if (session()->has('category_create'))
                <div class="alert alert-success animate__animated animate__slideInDown" role="alert">
                    {{ session('category_create') }}
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#add-user"><i
                        class="fas fa-plus mr-1"></i>Add Category</button>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Category List</h3>

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
                        <th>Category Name</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="#edit-modal{{ $category->id }}" data-toggle="modal">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $category->id }}" data-toggle="modal" data-target="#delete">
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
                        <h4 class="modal-title">Add Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/category/create" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputToken">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" id="exampleInputToken"
                                        placeholder="Enter Category Name">
                                </div>
                            </div>
                            <!-- /.card-body -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" class="btn btn-success" value="Add Category">
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
                        <p>Are you sure?</p>
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
        <!-- Edit Modal -->
        @if ($data->isNotEmpty())
            <div class="modal fade" id="edit-modal{{ $category->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/category/edit/{{ $category->id }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputToken">Category Name</label>
                                        <input type="text" name="category_name" class="form-control"
                                            id="exampleInputToken" placeholder="Enter Category Name"
                                            value="{{ $category->category_name }}">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" class="btn btn-success" value="Update Category">
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
                var deleteUrl = '/admin/category/delete/' + userId;
                // Set the delete button href attribute
                $('#deleteButton').attr('href', deleteUrl);
            });
        });
    </script>
@endsection
