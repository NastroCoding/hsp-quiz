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
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Education</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>183</td>
            <td>John Doe</td>
            <td>11-7-2014</td>
            <td>Approved</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1" data-toggle="modal" data-target="#delete">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="5">
              <p>
                Description
              </p>
            </td>
          </tr>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>219</td>
            <td>Alexander Pierce</td>
            <td>11-7-2014</td>
            <td>Pending</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="5">
              <p>
                Description
              </p>
            </td>
          </tr>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>657</td>
            <td>Alexander Pierce</td>
            <td>11-7-2014</td>
            <td>Approved</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="5">
              <p>
                Description
              </p>
            </td>
          </tr>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>175</td>
            <td>Mike Doe</td>
            <td>11-7-2014</td>
            <td>Denied</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="5">
              <p>
                Description
              </p>
            </td>
          </tr>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>134</td>
            <td>Jim Doe</td>
            <td>11-7-2014</td>
            <td>Approved</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="5">
              <p>
                Description
              </p>
            </td>
          </tr>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>494</td>
            <td>Victoria Doe</td>
            <td>11-7-2014</td>
            <td>Pending</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="5">
              <p>
                8==D
              </p>
            </td>
          </tr>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>832</td>
            <td>Michael Doe</td>
            <td>11-7-2014</td>
            <td>Approved</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="5">
              <p>
                Description
              </p>
            </td>
          </tr>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>982</td>
            <td>Rocky Doe</td>
            <td>11-7-2014</td>
            <td>Denied</td>
            <td><a class="btn btn-sm btn-info" href="/admin/quiz/question">Manage</a><button type="button" class="btn btn-sm btn-danger ml-1">Delete</button></td>
          </tr>
          <tr class="expandable-body">
            <td colspan="5">
              <p>
                Description
              </p>
            </td>
          </tr>
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
        <form>
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputTitle">Quiz Title</label>
              <input type="text" class="form-control" id="exampleInputTitle" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="exampleInputDescription">Description</label>
              <textarea class="form-control" rows="3" id="exampleInputDescription" placeholder="Enter Description"></textarea>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <!-- select -->
                  <div class="form-group">
                    <label>Category</label>
                    <select class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Education</label>
                    <select class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                </div>
              </div>
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
@endsection