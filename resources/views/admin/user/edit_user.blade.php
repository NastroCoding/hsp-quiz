@extends('layouts.admin')
@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @foreach ($data as $user)
            <form action="/admin/user/edit/{{ $user->id }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputToken">Token</label>
                        <input type="text" name="token" class="form-control" id="exampleInputToken"
                            placeholder="Enter Token" value="{{ $user->token }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail" placeholder="Email"
                            value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword"
                            placeholder="Password" value="{{ $user->password }}">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
                    <button type="button" onclick="history.back()" class="btn btn-default">Back</button>
                    <input type="submit" name="submit" class="btn btn-success" value="Edit User">
                </div>
            </form>
        @endforeach
    </div>
@endsection
