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
            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#add-user"><i class="fas fa-plus mr-1"></i>Add User</button>
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
                    <th>Token</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="edit-user.html">
                            Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">
                            Delete
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>219</td>
                    <td>Alexander Pierce</td>
                    <td>11-7-2014</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="edit-user.html">
                            Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">
                            Delete
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>657</td>
                    <td>Bob Doe</td>
                    <td>11-7-2014</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="edit-user.html">
                            Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">
                            Delete
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>175</td>
                    <td>Mike Doe</td>
                    <td>11-7-2014</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="edit-user.html">
                            Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="modal fade" id="add-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputToken">Token</label>
                    <input type="text" class="form-control" id="exampleInputToken" placeholder="Enter Token">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password">
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Add User</button>
                </div>
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
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.content -->
@endsection