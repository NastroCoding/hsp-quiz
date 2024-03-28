@extends('layouts.admin')
@section('container')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#add-user"><i class="fas fa-plus mr-1"></i>Create User</button>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Expandable Table</h3>
        </div>
        <!-- ./card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th>Email</th>
                        <th>Education</th>
                        <th>Role</th>
                        <th>Password</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $user)
                        <tr>
                            <td>{{ $user->token }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->education }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm reveal-password-btn"
                                        data-password="{{ $user->password }}">Reveal Password</button>
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" href="/admin/user/edit/{{ $user->id }}">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $user->id }}" data-toggle="modal" data-target="#delete">
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
                        <h4 class="modal-title">Create User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/user/create" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputToken">Token</label>
                                    <input type="text" name="token" class="form-control" id="exampleInputToken"
                                        placeholder="Enter Token">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail"
                                        placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword">Password</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword"
                                        placeholder="Password">
                                </div>
                            </div>
                            <!-- /.card-body -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" class="btn btn-success" value="Create User">
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
                var deleteUrl = '/admin/user/delete/' + userId;
                // Set the delete button href attribute
                $('#deleteButton').attr('href', deleteUrl);
            });
        });
    </script>
@endsection