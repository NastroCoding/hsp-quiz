@extends('layouts.admin')
@section('container')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Quiz</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Quiz</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#add-user"><i class="fas fa-plus mr-1"></i>Add Quiz</button>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Quiz List</h3>
    </div>
    <!-- ./card-header -->
    <div class="card-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>id</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Time</th>
            <th>Category</th>
            <th>Education</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $quiz)

          <tr data-widget="expandable-table" aria-expanded="false">
            <td>{{ $quiz->id }}</td>
            <td>{{ $quiz->title }}</td>
            <td>{{ $quiz->slug }}</td>
            <td>{{ $quiz->time }}</td>
            <td>{{ $quiz->category_id }}</td>
            <td>{{ $quiz->education_id }}</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1" data-toggle="modal" data-target="#delete">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="7">
              <p>{{ $quiz->description }}</p>
            </td>
          </tr>
          @endforeach          
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
</section>
<div class="modal fade" id="add-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Quiz</h4>
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
              <input type="text" name="title" class="form-control" id="exampleInputTitle" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="exampleInputDescription">Description</label>
              <textarea class="form-control" name="description" rows="3" id="exampleInputDescription" placeholder="Enter Description"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputDescription">Token</label>
              <input type="text" name="token" class="form-control" id="exampleInputTitle" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="">Time</label>
              <div class="input-group mb-3">
                <input type="number" name="time" class="form-control" placeholder="Minutes">
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
                      @foreach ($category as $cat)
                      <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Education</label>
                    <select class="form-control" name="education_id">
                      @foreach ($education as $edu)
                      <option value="{{ $edu->id }}">{{ $edu->education_name }}</option>
                      @endforeach
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
          <input type="submit" class="btn btn-success" value="Add User">
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
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@endsection