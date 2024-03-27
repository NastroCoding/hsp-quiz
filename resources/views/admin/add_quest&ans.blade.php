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
          <h3 class="card-title">Add Questions & Options</h3>
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
            <button type="button" class="btn btn-success" id="addOptionBtn">Add Option</button>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</section>
@endsection