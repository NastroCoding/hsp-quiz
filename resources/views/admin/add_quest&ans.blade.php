@extends('layouts.admin')
@section('container')
    <!-- Main content -->
        <section class="content">
        <div class="row">
          <div class="col-md-6 m-auto">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Question & Answers</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="inputName">Question</label>
                  <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                  <label for="inputDescription">Answer</label>
                  <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        </section>
@endsection
