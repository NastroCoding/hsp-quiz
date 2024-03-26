@extends('layouts.admin')
@section('container')
    <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Quiz</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Quiz Title</label>
                                <input type="text" id="inputName" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Add Questions</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputEstimatedBudget">Question</label>
                                <input type="text" id="inputEstimatedBudget" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Add Answer" class="btn btn-success" />
                            </div>
                            <div class="form-group">
                                <!-- Jawaban Pilihan Disini -->
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Submit Question" class="btn btn-success float-right" />
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Questions and Answers</h3>

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
                                <th>Question</th>
                                <th>Answers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>183</td>
                                <td>John Doe</td>
                                <td>11-7-2014</td>
                            </tr>
                            <tr>
                                <td>219</td>
                                <td>Alexander Pierce</td>
                                <td>11-7-2014</td>
                            </tr>
                            <tr>
                                <td>657</td>
                                <td>Bob Doe</td>
                                <td>11-7-2014</td>
                            </tr>
                            <tr>
                                <td>175</td>
                                <td>Mike Doe</td>
                                <td>11-7-2014</td>
                            </tr>
                            <tr>
                                <td>134</td>
                                <td>Jim Doe</td>
                                <td>11-7-2014</td>
                            </tr>
                            <tr>
                                <td>494</td>
                                <td>Victoria Doe</td>
                                <td>11-7-2014</td>
                            </tr>
                            <tr>
                                <td>832</td>
                                <td>Michael Doe</td>
                                <td>11-7-2014</td>
                            </tr>
                            <tr>
                                <td>982</td>
                                <td>Rocky Doe</td>
                                <td>11-7-2014</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="#" class="btn btn-secondary">Reset</a>
                    <input type="submit" value="Create new Quiz" class="btn btn-success float-right" />
                </div>
            </div>
        </section>
@endsection
