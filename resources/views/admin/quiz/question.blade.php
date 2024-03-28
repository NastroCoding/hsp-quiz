@extends('layouts.admin')
@section('container')
<!-- Main content -->
<style>
  .input-group {
    margin-bottom: 10px;
  }
</style>

<section class="content">
  <div class="row justify-content-center align-items-center" style="height:100%;">
    <div class="col-md-6 m-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Create Questions</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="inputName">Question</label>
            <textarea id="inputDescription" class="form-control" rows="4"></textarea>
          </div>
          <div id="optionsContainer" class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><input type="radio" name="option"></span>
              </div>
              <input type="text" class="form-control" placeholder="Option 1">
              <div class="input-group-append">
                <span class="input-group-text" style="background-color: red; cursor: pointer;" onclick="removeOption(this)"><i class="fas fa-trash" style="color: white;"></i></span>
              </div>
            </div>
            <!-- /input-group -->
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-primary" id="addOptionBtn">Add Option</button>
            <button type="button" class="btn btn-success float-right">Create</button>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Question List</h3>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Question</th>
                <th class="text-center"></th>
              </tr>
            </thead>
            <tbody>
              <tr data-widget="expandable-table" aria-expanded="false">
                <td>183</td>
                <td>John Doe</td>
                <td><button type="button" class="btn-sm btn btn-info">Edit</button><button type="button" class="btn-sm btn btn-danger ml-1">Delete</button></td>
              </tr>
              <tr class="expandable-body">
                <td colspan="5">
                  <ol type="A">
                    <li>Option 1</li>
                    <li>Option 2</li>
                    <li>Option 3</li>
                    <li>Option 4</li>
                  </ol>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</section>
@endsection