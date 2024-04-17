@extends('layouts.admin')
@section('container')
<!-- Content Header (Page header) -->
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
            <h3 class="card-title">Registered User</h3>
        </div>
        <!-- ./card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <th>Token</th>
                        <th>Role</th>
                        <th>Education</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $user)
                    <tr data-widget="expandable-table" aria-expanded="false">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->token }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->education }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="/admin/quiz/edit/{{ $user->id }}" data-toggle="modal" data-target="#edit-user">
                                Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-btn ml-1" data-id="{{ $user->id }}" data-toggle="modal" data-target="#delete">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr class="expandable-body">
                        <td colspan="6">
                            <p>
                                Created at : {{ $user->created_at->format('H:m:s__Y-m-d') }} <br>
                                Updated at : {{ $user->updated_at->format('H:m:s__Y-m-d') }}
                            </p>

                            <p>
                                Created by : @if ($user->created_by == '')
                                System
                                @else
                                {{ $user->updated_by }}
                                @endif
                                <br>
                                Updated by : @if ($user->created_by == '')
                                System
                                @else
                                {{ $user->updated_by }}
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</section>
<!-- /.card -->
<!-- /.content -->
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
                            <input type="text" name="token" class="form-control" id="exampleInputToken" placeholder="Enter Token">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="role" id="" class="form-control">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Education</label>
                            <select name="education" id="" class="form-control">
                                @foreach ($education as $edu)
                                <option value="{{ $edu->id }}">{{ $edu->education_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Password">
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
<!-- Edit user -->
<div class="modal fade" id="edit-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputToken">Token</label>
                            <input type="text" name="token" class="form-control" id="exampleInputToken" placeholder="Enter Token">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="role" id="" class="form-control">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Education</label>
                            <select name="education" id="" class="form-control">
                                @foreach ($education as $edu)
                                <option value="{{ $edu->id }}">{{ $edu->education_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Password">
                        </div>
                    </div>
                    <!-- /.card-body -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="submit" class="btn btn-info" value="Edit User">
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- modal delete -->
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