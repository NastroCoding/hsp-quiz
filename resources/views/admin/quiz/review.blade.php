@extends('layouts.admin')
@section('container')
<section class="content-header">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
        {{ $error }}
    </div>
    @endforeach
    @endif
    @if (session()->has('quiz_success'))
    <div class="alert alert-success animate__animated animate__slideInDown" role="alert">
        {{ session('quiz_success') }}
    </div>
    @endif
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quiz 1</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/quiz">Quiz</a></li>
                    <li class="breadcrumb-item active">Review</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <h3>
                User
            </h3>
            <div class="card card-default">
                <!-- form start -->
                <div class="card-header">
                    <p class="card-title text-muted">multiple_choice</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <p>1. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque corrupti necessitatibus voluptas, facere quas nam sint architecto excepturi velit soluta numquam sit ut sequi reprehenderit iste ipsam earum veritatis? Perspiciatis.</p>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio1">
                            <label class="form-check-label"> <span class="text-muted text-sm">
                                    +10 Points
                                </span></label>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
@endsection