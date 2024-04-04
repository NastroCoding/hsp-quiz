@extends('layouts.admin')
@section('container')
    <!-- Main content -->
    <style>
        .input-group {
            margin-bottom: 10px;
        }
    </style>

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
                    <h1>Question List</h1>
                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#add-question"><i
                        class="fas fa-plus mr-1"></i>Add Question</button>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            @php
                $count = 0;
            @endphp
            @foreach ($questions as $question)
                @php
                    $count++;
                @endphp
                <div class="col-md-6">
                    <div class="card card-default">
                        <!-- form start -->
                        <div class="card-header">
                            <p class="card-title text-muted">{{ $question->question_type }}</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <p>{{ $count }}. {{ $question->question }}</p>
                            </div>
                            @if ($question->question_type == 'multiple_choice' || $question->question_type == 'weighted_multiple')
                                <div class="form-group">
                                    @foreach ($question->choices as $choice)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="radio1">
                                            <label class="form-check-label">{{ $choice->choice }} <span
                                                    class="text-muted text-sm">
                                                    @if ($question->question_type == 'weighted_multiple')
                                                        +{{ $choice->point_value }} Points
                                                    @endif
                                                </span></label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#edit-multiple-choice">Edit</button>
                            <a href="/admin/quiz/question/delete/{{ $question->id }}"
                                class="btn btn-danger float-right">Delete</a>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            @endforeach
        </div>
    </section>

    <!-- question type modal -->
    <div class="modal fade" id="add-question">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Choose Question Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 offset-md-3 text-center mb-1">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#multiple-choice"
                                onclick="closeQuestionModal()">Multiple Choice</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 text-center mt-1 mb-1">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#essay"
                                onclick="closeQuestionModal()">Essay</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 text-center mt-1">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#weighted-mc-modal"
                                onclick="closeQuestionModal()">Weighted Multiple
                                Choice</button>
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

    <!-- multiple choice modal -->
    <div class="modal fade" id="multiple-choice">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Multiple Choice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/quiz/question/create" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputQuestion">Question</label>
                                <textarea id="inputQuestion" name="question" class="form-control" rows="4"></textarea>
                            </div>
                            <input type="hidden" name="question_type" value="multiple_choice">
                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                            <div id="optionsContainer" class="form-group">
                                <!-- Options will be added dynamically here -->
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="addOptionBtn">
                                    Add Option
                                </button>
                                <input type="number" name="point_value" class="form-control float-right"
                                    placeholder="Points" min="0" style="width: 100px;" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success float-right"
                                id="createQuestionBtn">Create</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <!-- Essay modal -->
    <div class="modal fade" id="essay">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Essay</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/quiz/question/create/essay" method="POST">
                        @csrf
                        <input type="hidden" name="question_type" value="essay">
                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Question</label>
                                <textarea id="inputDescription" name="question" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success float-right" id="createQuestionBtn">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

<!-- Weighted Multiple Choice Question Modal -->
<div class="modal fade" id="weighted-mc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Weighted Multiple Choice</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/quiz/question/create/weighted" method="POST">
                @csrf
                <input type="hidden" name="question_type" value="weighted_multiple">
                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Question</label>
                        <textarea id="inputDescription" name="question" class="form-control" rows="4"></textarea>
                    </div>
                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                    <div class="form-group" id="weighted-optionsContainer">
                        <div class="input-group weighted-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><input type="radio" name="is_correct" /></span>
                            </div>
                            <input type="text" name="choices[]" class="form-control" placeholder="Option 1" />
                            <input type="number" name="point_value[]" class="form-control" placeholder="Points" min="0" />
                            <div class="input-group-append">
                                <span class="input-group-text btn-danger btn" style="cursor: pointer" onclick="removeWeightedOption(this)">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="addWeightedOptionBtn">Add Option</button>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success float-right">Create</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Edit modal -->
<!-- multiple choice modal -->
<div class="modal fade" id="edit-multiple-choice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Multiple Choice</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/quiz/question/create" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Question</label>

                            <div class="input-group">
                                <textarea id="inputDescription" name="question" class="form-control" rows="4"></textarea>

                            </div>
                        </div>
                        <input type="hidden" name="question_type" value="multiple_choice">
                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                        <div id="optionsContainer" class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><input type="radio" name="is_correct" /></span>
                                </div>
                                <input type="text" name="choices[]" class="form-control" placeholder="Option 1" />
                                <div class="input-group-append">
                                    <span class="input-group-text btn-danger btn" style=" cursor: pointer" onclick="removeOption(this)"><i class="fas fa-trash"></i></span>
                                </div>
                            </div>
                            <!-- /input-group -->
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="addOptionBtn">
                                Add Option
                            </button>
                            <input type="number" name="point_value" class="form-control float-right" placeholder="Points" min="0" style="width: 100px;" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success float-right" id="createQuestionBtn">Create</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<!-- Essay modal -->
<div class="modal fade" id="edit-essay">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Essay</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/quiz/question/create/essay" method="POST">
                    @csrf
                    <input type="hidden" name="question_type" value="essay">
                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Question</label>
                            <textarea id="inputDescription" name="question" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </form>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success float-right" id="createQuestionBtn">
                        Create
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<!-- Weighted Multiple Choice Question Modal -->
<div class="modal fade" id="edit-weighted-mc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Weighted Multiple Choice</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/quiz/question/create/weighted" method="POST">
                @csrf
                <input type="hidden" name="question_type" value="weighted_multiple">
                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Question</label>
                        <textarea id="inputDescription" name="question" class="form-control" rows="4"></textarea>
                    </div>
                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                    <div class="form-group" id="weighted-optionsContainer">
                        <div class="input-group weighted-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><input type="radio" name="is_correct" /></span>
                            </div>
                            <input type="text" name="choices[]" class="form-control" placeholder="Option 1" />
                            <input type="number" name="point_value[]" class="form-control" placeholder="Points" min="0" />
                            <div class="input-group-append">
                                <span class="input-group-text btn-danger btn" style="cursor: pointer" onclick="removeWeightedOption(this)">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="addWeightedOptionBtn">Add Option</button>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success float-right">Create</button>
                </div>
            </form>

        </div>
    </div>
</div>

    <script>
        function closeQuestionModal() {
            var modal = document.getElementById('add-question');
            var modalBackdrop = document.querySelector('.modal-backdrop');
            modalBackdrop.parentNode.removeChild(modalBackdrop);
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
    </script>
@endsection
