@extends('layouts.admin')
@section('container')
    <!-- Main content -->
        <section class="content">
        <div class="row">
          <div class="col-md-6 m-auto">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Quiz</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="inputName">Quiz Title</label>
                  <input type="text" id="inputName" class="form-control">
                </div>
                <div class="form-group">
                  <label for="inputDescription">Description</label>
                  <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                </div>
                <button type="button" class="btn btn-success float-right">Create Quiz</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quiz</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px">
                            <input type="text" name="table_search" class="form-control float-right"
                                placeholder="Search" />

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Quiz</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>183</td>
                                <td>John Doe</td>
                                <td><a type="button" class="btn btn-info btn-sm" href="/admin/quiz/question">Manage</a></td>
                            </tr>
                            <tr>
                                <td>219</td>
                                <td>Alexander Pierce</td>
                                <td><a type="button" class="btn btn-info btn-sm" href="/admin/quiz/question">Manage</a></td>
                            </tr>
                            <tr>
                                <td>657</td>
                                <td>Bob Doe</td>
                                <td><a type="button" class="btn btn-info btn-sm" href="/admin/quiz/question">Manage</a></td>
                            </tr>
                            <tr>
                                <td>175</td>
                                <td>Mike Doe</td>
                                <td><a type="button" class="btn btn-info btn-sm" href="/admin/quiz/question">Manage</a></td>
                            </tr>
                            <tr>
                                <td>134</td>
                                <td>Jim Doe</td>
                                <td><a type="button" class="btn btn-info btn-sm" href="/admin/quiz/question">Manage</a></td>
                            </tr>
                            <tr>
                                <td>494</td>
                                <td>Victoria Doe</td>
                                <td><a type="button" class="btn btn-info btn-sm" href="/admin/quiz/question">Manage</a></td>
                            </tr>
                            <tr>
                                <td>832</td>
                                <td>Michael Doe</td>
                                <td><a type="button" class="btn btn-info btn-sm" href="/admin/quiz/question">Manage</a></td>
                            </tr>
                            <tr>
                                <td>982</td>
                                <td>Rocky Doe</td>
                                <td><a type="button" class="btn btn-info btn-sm" href="/admin/quiz/question">Manage</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
@endsection
