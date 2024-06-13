@extends('layouts.admin')
@section('container')
    <!-- Content Header (Page header) -->

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
                <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#add-quiz"><i
                        class="fas fa-plus mr-1"></i>Add Quiz</button>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quiz List</h3>
                <div class="card-tools">
                    <form action="/admin/quiz" method="GET">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search"
                                value="{{ request('table_search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- ./card-header -->
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
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
                                <td>{{ $quiz->category->category_name }}</td>
                                <td>{{ $quiz->education->education_name }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#edit-quiz{{ $quiz->id }}">
                                        Edit
                                    </a>
                                    <a class="btn btn-sm btn-success" href="/admin/quiz/{{ $quiz->slug }}">Manage</a>
                                    <a class="btn btn-sm btn-warning" href="/admin/quiz/" data-toggle="modal"
                                        data-target="#review{{ $quiz->id }}">Review</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn ml-1"
                                        data-id="{{ $quiz->id }}" data-toggle="modal" data-target="#delete">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr class="expandable-body">
                                <td colspan="7">
                                    <p> Description : {{ $quiz->description }} <br> Token : {{ $quiz->token }} <br>
                                        Thumbnail : <br>
                                        <img class="img-thumbnail mb-1" src="/storage{{ asset($quiz->thumbnail) }}"
                                            alt="Thumbnail" style="width:200px;">
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <div class="modal fade" id="add-quiz">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Quiz</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/quiz/create" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputTitle">Quiz Title</label>
                                <input type="text" name="title" class="form-control" id="exampleInputTitle"
                                    placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDescription">Description</label>
                                <textarea class="form-control" name="description" rows="3" id="exampleInputDescription"
                                    placeholder="Enter Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputToken">Token</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="token" class="form-control"
                                        id="exampleInputToken generateToken" placeholder="Enter token">
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="cursor: pointer"
                                            onclick="tokenGenerate()">Generate</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="formFile" class="form-label">Thumbnail</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile3"
                                            accept="image/*" name="thumbnail"
                                            onchange="previewQuizImage(event, 'fileLabel3')">
                                        <label class="custom-file-label" id="fileLabel3" for="exampleInputFile3">Choose
                                            image</label>
                                    </div>
                                </div>
                                <div id="quizImagePreview" class="mt-1 text-muted">16:9 Aspect ratio is recommended</div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTime">Time</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="time" class="form-control" id="exampleInputTime"
                                        placeholder="Minutes">
                                    <div class="input-group-append">
                                        <span class="input-group-text">min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputCategory">Category</label>
                                            <select name="category_id" class="form-control" id="exampleInputCategory">
                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEducation">Education</label>
                                            <select class="form-control" name="education_id" id="exampleInputEducation">
                                                @foreach ($education as $edu)
                                                    <option value="{{ $edu->id }}">{{ $edu->education_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" value="Add Quiz">
                        </div>
                    </form>
                </div>
                <!-- /.modal-body -->
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
                    <p> <b>If you delete this, all the data related will be deleted!</b> <br> <br> Are you sure? </p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a id="deleteButton" class="btn btn-danger">
                        Delete
                    </a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- review modal-->
    @foreach ($data as $quiz)
        <div class="modal fade" id="review{{ $quiz->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Review</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Participated users</h3>
                                        <input type="date" id="local-date" name="local-date" value=""
                                            size="10" class="float-right card-title">
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>User</th>
                                                    <th>Points</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            @php
                                                $userId = auth()->user()->id;
                                                $userScore = $scores->first(function ($score) use ($userId, $quiz) {
                                                    return $score->user_id == $userId && $score->quiz_id == $quiz->id;
                                                });
                                            @endphp
                                            @foreach ($user as $users)
                                                @php
                                                    $specificScore = $users->scores->firstWhere('quiz_id', $quiz->id);
                                                @endphp
                                                <tr>
                                                    <td>{{ $users->id }}</td>
                                                    <td>{{ $users->email }}</td>
                                                    <td>
                                                        @if ($specificScore)
                                                            {{ $specificScore->score }}/{{ $quiz->max_score }}
                                                        @else
                                                            Not Attempted
                                                        @endif
                                                    </td>
                                                    <td><a href="/admin/quiz/review/{{ $quiz->slug }}/{{ $users->id }}"
                                                            class="btn btn-sm btn-primary">Review</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
    @foreach ($data as $quiz)
        {{-- edit quiz modal --}}
        <div class="modal fade" id="edit-quiz{{ $quiz->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Quiz</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/quiz/edit/{{ $quiz->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputTitle">Quiz Title</label>
                                    <input type="text" name="title" class="form-control" id="exampleInputTitle"
                                        placeholder="Enter title" value="{{ $quiz->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputDescription">Description</label>
                                    <textarea class="form-control" name="description" rows="3" id="exampleInputDescription"
                                        placeholder="Enter Description">{{ $quiz->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputDescription">Token </label>
                                    <input type="text" name="token" class="form-control" id="tokenGenerate"
                                        placeholder="Enter token" value="{{ $quiz->token }}">
                                </div>
                                <div class="form-group">
                                    <label for="formFile" class="form-label">Thumbnail</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile4"
                                                accept="image/*" onchange="editPreviewQuizImage(event, 'fileLabel4')"
                                                name="thumbnail">
                                            <label class="custom-file-label" id="fileLabel4"
                                                for="exampleInputFile4">Choose
                                                image</label>
                                        </div>
                                    </div>
                                    <div id="editQuizImagePreview" class="mt-1">
                                        @if ($quiz->thumbnail)
                                            <img src="/storage{{ asset($quiz->thumbnail) }}" class="img-thumbnail"
                                                style="width: 200px;" name="thumbnail">
                                        @else
                                            No thumbnail available
                                        @endif
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
                                                    <option value="{{ $cat->id }}">
                                                        {{ $cat->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Education</label>
                                            <select class="form-control" name="education_id">
                                                @foreach ($education as $edu)
                                                    <option value="{{ $edu->id }}">
                                                        {{ $edu->education_name }}
                                                    </option>
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
                    <input type="submit" class="btn btn-success" value="Edit Quiz">
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    @endforeach
@endsection

@section('scripts')
    <script>
        function tokenGenerate() {
            let generate = Math.random().toString(36).slice(1, 7);
            const valueToken = document.querySelector("#generateToken")
            valueToken.textContent = generate
        }

        $(document).ready(function() {
        // Capture delete button click event
        $('.delete-btn').click(function() {
            // Get the ID of the user
            var quizId = $(this).data('id');
            // Construct the delete URL
            var deleteUrl = '/admin/quiz/delete/' + quizId;
            // Set the delete button href attribute
            $('#deleteButton').attr('href', deleteUrl);
        });
        });
        });
    </script>
@endsection
