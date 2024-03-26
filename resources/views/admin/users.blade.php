@extends('layouts.admin')
@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admin.html">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registered User</h3>

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
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Actions</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>183</td>
                        <td>John Doe</td>
                        <td>11-7-2014</td>
                        <td>
                            <a class="btn btn-block btn-info btn-sm" href="edit-user.html">
                                Edit
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-danger btn-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>219</td>
                        <td>Alexander Pierce</td>
                        <td>11-7-2014</td>
                        <td>
                            <a class="btn btn-block btn-info btn-sm" href="edit-user.html">
                                Edit
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-danger btn-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>657</td>
                        <td>Bob Doe</td>
                        <td>11-7-2014</td>
                        <td>
                            <a class="btn btn-block btn-info btn-sm" href="edit-user.html">
                                Edit
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-danger btn-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>175</td>
                        <td>Mike Doe</td>
                        <td>11-7-2014</td>
                        <td>
                            <a class="btn btn-block btn-info btn-sm" href="edit-user.html">
                                Edit
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-danger btn-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.content -->
@endsection
