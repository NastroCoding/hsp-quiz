@extends('layouts.admin')
@section('container')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Welcome Admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active"></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content ">
        <div class="container">
            <h4>Recent Quiz</h4>
            <button class="btn btn-sm btn-default mb-1" data-toggle="modal" data-target="#modal-filter"><i
                    class="fas fa-sliders"></i></button>
            <div class="row">
                @if ($data->isEmpty())
                    <div class="col-12">
                        <p>No quizzes found matching the criteria.</p>
                    </div>
                @else
                    @foreach ($data as $quiz)
                        <div class="col-lg-4">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="/storage{{ asset($quiz->thumbnail) }}" alt="Card image cap"
                                    style="width:100%; height:180px;">
                                <div class="card-header">
                                    <h5 class="card-title m-0">{{ $quiz->title }}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"> {{ $quiz->description }}</p>
                                    <a class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#edit-quiz{{ $quiz->id }}">
                                        Edit
                                    </a>
                                    <a class="btn btn-sm btn-success" href="/admin/quiz/{{ $quiz->slug }}">Manage</a>
                                    <a class="btn btn-sm btn-warning" href="/admin/quiz/" data-toggle="modal"
                                        data-target="#review">Review</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn ml-1"
                                        data-id="{{ $quiz->id }}" data-toggle="modal" data-target="#delete">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

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
                        <form action="/admin/quiz/edit/{{ $quiz->id }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="exampleInputDescription">Token</label>
                                    <input type="text" name="token" class="form-control" id="exampleInputTitle"
                                        placeholder="Enter token" value="{{ $quiz->token }}">
                                </div>
                                <div class="form-group">
                                    <label for="formFile" class="form-label">Thumbnail</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile4"
                                                accept="image/*" onchange="editPreviewQuizImage(event, 'fileLabel4')"
                                                name="thumbnail">
                                            <label class="custom-file-label" id="fileLabel4" for="exampleInputFile4">Choose
                                                image</label>
                                        </div>
                                    </div>
                                    <div id="editQuizImagePreview" class="mt-1">
                                        @if ($quiz->thumbnail)
                                            <img src="/storage{{ asset($quiz->thumbnail) }}" class="img-thumbnail"
                                                style="width: 200px;">
                                        @else
                                            No thumbnail available
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Time</label>
                                    <div class="input-group mb-3">
                                        <input type="number" name="time" class="form-control" placeholder="Minutes"
                                            value="{{ $quiz->time }}">
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
        </div>
    @endforeach
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
    <div class="modal fade" id="review">
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
                                                <th>Score</th>
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
                                                            {{ $users->calculateScoresForQuiz($quiz->id)->userScore }}/{{ $quiz->max_score }}
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
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- sort modal -->
    <div class="modal fade" id="modal-filter">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sort by</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="GET" action="{{ route('quiz.adminIndex') }}">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- select -->
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category">
                                            <option value="">None</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Education</label>
                                        <select class="form-control" name="education">
                                            <option value="">None</option>
                                            @foreach ($education as $edu)
                                                <option value="{{ $edu->id }}">{{ $edu->education_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Apply</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
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
    </script>
@endsection
