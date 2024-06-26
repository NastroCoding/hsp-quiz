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
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success animate__animated animate__slideInDown" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Question List</h1>
                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#add-question">
                    <i class="fas fa-plus mr-1"></i>Add Question
                </button>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            @foreach ($questions as $question)
                <div class="col-md-6">
                    <div class="card card-default">
                        <!-- form start -->
                        <div class="card-header">
                            <p class="card-title text-muted">{{ $question->question_type }}</p>
                        </div>
                        <div class="card-body">
                            @if ($question->images)
                                <img src="{{ asset('' . $question->images) }}" alt="Question Image"
                                    style="max-width: 300px;" class="rounded">
                            @endif
                            <div class="form-group">
                                <p>{{ $question->number }}. {{ $question->question }}</p>
                            </div>
                            @if ($question->question_type == 'multiple_choice' || $question->question_type == 'weighted_multiple')
                                <div class="form-group">
                                    @foreach ($question->choices as $choice)
                                        <div class="form-check mb-1 mt-1">
                                            <!-- Add 'checked' attribute based on is_correct value -->
                                            @if ($question->question_type == 'weighted_multiple')
                                                <input class="form-check-input" type="radio" disabled>
                                            @else
                                                <input class="form-check-input" type="checkbox" name="checkbox1[]"
                                                    {{ $choice->is_correct ? 'checked' : '' }} disabled>
                                            @endif
                                            <label class="form-check-label">
                                                @if ($choice->image_choice)
                                                    <img src="{{ asset('storage/' . $choice->image_choice) }}"
                                                        alt="Choice Image" style="max-width: 200px;" class="rounded"><br>
                                                @endif

                                                {{ $choice->choice }}
                                                <span class="text-muted text-sm">
                                                    @if ($question->question_type == 'weighted_multiple')
                                                        +{{ $choice->point_value }} Points
                                                    @endif
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-info" data-toggle="modal"
                                data-id="{{ $question->id }}"
                                data-target="#edit-{{ $question->question_type }}{{ $question->id }}">Edit</button>

                            <button type="button" class="btn btn-danger btn-sm delete-btn float-right"
                                data-id="{{ $question->id }}" data-toggle="modal" data-target="#delete">
                                Delete
                            </button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- edit quiz modal -->
                <div class="modal fade" id="edit-question{{ $question->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="/admin/quiz/question/update" method="POST">
                                    @csrf
                                    <input type="hidden" name="question_id" id="editQuestionId">
                                    <!-- Your form fields for editing -->
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="submitEditForm()">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end edit question modal -->
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
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#weighted-mc"
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
                    <form action="/admin/quiz/question/create" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Hidden input for quiz ID -->
                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                            <div class="form-group">
                                <label for="inputQuestion">Question</label>
                                <br>
                                <small class="float-right text-muted"><span class="text-danger">*</span>Optional</small>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile1"
                                            accept="image/*" name="questionImage"
                                            onchange="previewImage(event, 'question', 'fileLabel1')">
                                        <label class="custom-file-label" id="fileLabel1" for="exampleInputFile1">Choose
                                            image</label>
                                    </div>
                                </div>
                                <div id="questionImagePreview" class="mt-1"></div>
                                <textarea id="inputQuestion" name="question" class="form-control" rows="4"></textarea>
                            </div>
                            <input type="hidden" name="question_type" value="multiple_choice">
                            <!-- You can include other fields here -->
                            <label>Options</label>
                            <div id="optionsContainer" class="form-group">
                                <!-- Options will be added dynamically here -->
                                <div class="input-group">
                                    <!-- Ensure that the hidden input has a default value of 0 -->
                                    <input type="hidden" name="is_correct[]" value="0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <!-- Checkbox to mark if the option is correct -->
                                            <input type="checkbox" name="is_correct_checkbox[]"
                                                onchange="updateIsCorrectValue(this)">
                                        </span>
                                    </div>
                                    <!-- Text input for the choice -->
                                    <input type="text" class="form-control" placeholder="Option 1" name="choices[]">
                                    <!-- File input for image -->
                                    <div class="input-group-append">
                                        <span class="input-group-text btn btn-default" style="cursor: pointer"
                                            onclick="uploadOptionImage(this)">
                                            <i class="fas fa-image"></i>
                                        </span>
                                        <!-- Button to remove the option -->
                                        <span class="input-group-text btn btn-danger" style="cursor: pointer"
                                            onclick="removeOption(this)">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </div>
                                    <!-- Input for image upload -->
                                    <input type="file" accept="image/*" style="display: none"
                                        onchange="previewOptionImage(event, 'imagePreview1')" class="optionImageInput"
                                        name="choice_images[]">
                                </div>
                                <!-- Image preview container -->
                                <div class="optionImagePreview" id="imagePreview1"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <br>
                            <button type="button" class="btn btn-primary" id="addOptionBtn" onclick="addOption()">Add
                                Option</button>
                            <input type="number" name="point_value" class="form-control float-right"
                                placeholder="Points" min="0" style="width: 100px;" required>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success float-right"
                                id="createQuestionBtn">Create</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
                    <form action="/admin/quiz/question/create/essay" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="question_type" value="essay">
                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Question</label>
                                <br>
                                <small class="float-right text-muted"><span class="text-danger">*</span>Optional</small>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile2"
                                            accept="image/*" onchange="previewEssayImage(event, 'fileLabel2')"
                                            name="essayImage">
                                        <label class="custom-file-label" id="fileLabel2" for="exampleInputFile2">Choose
                                            image</label>
                                        <div class="input-group-append">
                                            <small class="text-muted float-right input-group-text"><span
                                                    class="text-danger">*</span>Optional</small>
                                        </div>
                                    </div>
                                </div>
                                <div id="essayImagePreview" class="mt-1"></div>
                                <!-- Essay image preview container -->
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

    <!-- Weighted Multiple Choice modal -->
    <div class="modal fade" id="weighted-mc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Weighted Multiple Choice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/quiz/question/create/weighted" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="question_type" value="weighted_multiple">
                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputQuestion">Question</label>
                                <br>
                                <small class="float-right text-muted"><span class="text-danger">*</span>Optional</small>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile3"
                                            accept="image/*" onchange="previewWeightedEssayImage(event, 'fileLabel3')"
                                            name="weightedEssayImage">
                                        <label class="custom-file-label" id="fileLabel3" for="exampleInputFile3">Choose
                                            image</label>
                                        <div class="input-group-append">
                                            <small class="text-muted float-right input-group-text"><span
                                                    class="text-danger">*</span>Optional</small>
                                        </div>
                                    </div>
                                </div>
                                <div id="weighted-essayImagePreview" class="mt-1"></div>
                                <textarea id="inputQuestion" name="question" class="form-control" rows="4"></textarea>
                            </div>
                            <label for="inputName">Options</label>
                            <div id="weighted-optionsContainer">
                                <!-- Weighted Option 1 -->
                                <div class="input-group weighted-input-group">
                                    <input type="text" class="form-control" placeholder="Option 1" name="choices[]">
                                    <input type="number" min="0" class="form-control" placeholder="Points"
                                        name="point_value[]">
                                    <div class="input-group-append">
                                        <span class="input-group-text btn btn-default" style="cursor: pointer;"
                                            onclick="uploadWeightedOptionImage(this)">
                                            <i class="fas fa-image"></i>
                                        </span>
                                        <span class="input-group-text btn-danger btn" style="cursor: pointer;"
                                            onclick="removeWeightedOption(this)">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </div>
                                    <input type="file" accept="image/*" style="display: none;"
                                        onchange="previewWeightedOptionImage(event, 'imageLabel1', 'weightedImagePreview1')"
                                        class="weightedOptionImageInput" name="choice_images[]">
                                </div>
                                <div class="weightedOptionImagePreview" id="weightedImagePreview1"></div>
                                <!-- End Weighted Option 1 -->
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="addWeightedOptionBtn"
                                    onclick="addWeightedOption()">Add
                                    Option</button>
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
    </div>

    @foreach ($questions as $question)
        <!-- Edit modal -->
        @if ($question->question_type == 'multiple_choice')
            <div class="modal fade" id="edit-{{ $question->question_type }}{{ $question->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Multiple Choice</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/quiz/question/edit/{{ $question->id }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="quiz_id" value="{{ $question->quiz_id }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputQuestion">Question</label>
                                        <br>
                                        <small class="float-right text-muted"><span
                                                class="text-danger">*</span>Optional</small>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile4"
                                                    accept="image/*" name="questionImage"
                                                    onchange="editPreviewImage(event, 'question', 'fileLabel4')">
                                                <label class="custom-file-label" id="fileLabel4" for="exampleInputFile4">
                                                    Choose Image to change
                                                </label>
                                            </div>
                                        </div>
                                        <div id="questionEditImagePreview" class="mt-1">
                                            @if ($question->images)
                                                <img src="{{ asset('' . $question->images) }}" alt="Question Image"
                                                    style="max-width: 300px;" class="mb-2">
                                            @endif
                                        </div>
                                        <textarea id="inputQuestion" name="question" class="form-control" rows="4">{{ $question->question }}</textarea>
                                    </div>
                                    <input type="hidden" name="question_type" value="multiple_choice">
                                    <input type="hidden" />
                                    <input type="hidden" name="number" value="{{ $lastQuestionNumber }}">
                                    <label>Options</label>
                                    <div id="editOptionsContainer{{ $question->id }}" class="form-group">
                                        <!-- Options will be added dynamically here -->
                                        <!-- Your dynamic options HTML -->
                                        @foreach ($question->choices as $index => $choice)
                                            <div class="input-group">
                                                <!-- Hidden input for choice ID -->
                                                <input type="hidden" name="choices[{{ $index }}][id]"
                                                    value="{{ $choice->id }}">

                                                <!-- Hidden input for is_correct -->
                                                <input type="hidden" name="is_correct[{{ $index }}]"
                                                    id="isCorrect{{ $index }}"
                                                    value="{{ $choice->is_correct ? '1' : '0' }}">

                                                <!-- Checkbox for selecting correct choice -->
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <input type="checkbox"
                                                            name="is_correct_checkbox[{{ $index }}]"
                                                            {{ $choice->is_correct ? 'checked' : '' }}
                                                            onchange="updatedIsCorrectValue(this, {{ $index }})">
                                                    </span>
                                                </div>

                                                <!-- Input field for choice text -->
                                                <input type="text" class="form-control"
                                                    placeholder="Option {{ $index + 1 }}"
                                                    name="choices[{{ $index }}][text]"
                                                    value="{{ $choice->choice }}" />

                                                <!-- Button for uploading choice image -->
                                                <div class="input-group-append">
                                                    <span class="input-group-text btn btn-default" style="cursor: pointer"
                                                        onclick="uploadOptionImage(this)">
                                                        <i class="fas fa-image"></i>
                                                    </span>
                                                    <!-- Button for removing choice -->
                                                    <span class="input-group-text btn btn-danger" style="cursor: pointer"
                                                        onclick="removeOption(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </div>

                                                <!-- Input field for uploading choice image -->
                                                <input type="file" accept="image/*" style="display: none"
                                                    onchange="previewOptionImage(event, 'imagePreview{{ $index + 1 }}')"
                                                    class="optionImageInput"
                                                    name="choices[{{ $index }}][image]" />
                                            </div>
                                            <!-- Image preview container -->
                                            <div class="optionImagePreview mb-2" id="imagePreview{{ $index + 1 }}">
                                                <!-- Display the choice image if exists -->
                                                @if ($choice->image_choice)
                                                    <img src="{{ asset('storage/' . $choice->image_choice) }}"
                                                        alt="Choice Image" style="max-width: 300px;" class="mb-2">
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="form-group">
                                        <br>
                                        <button type="button" class="btn btn-primary" id="editAddOptionBtn"
                                            onclick="editAddOption({{ $question->id }})">Add Option</button>
                                        <input type="number" name="point_value" class="form-control float-right"
                                            placeholder="Points" min="0" style="width: 100px;"
                                            value="{{ $question->point_value }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info float-right"
                                        id="createQuestionBtn">Edit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        @elseif($question->question_type == 'essay')
            <!-- Edit Essay modal -->
            <div class="modal fade" id="edit-essay{{ $question->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Essay</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/quiz/question/edit/essay/{{ $question->id }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="quiz_id" value="{{ $question->quiz_id }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputName">Question</label>
                                        <br>
                                        <small class="float-right text-muted"><span
                                                class="text-danger">*</span>Optional</small>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input"
                                                    id="exampleInputFile5{{ $question->id }}" accept="image/*"
                                                    onchange="previewEditEssayImage(event, 'fileLabel5{{ $question->id }}', 'editEssayImagePreview{{ $question->id }}')"
                                                    name="essayImage">
                                                <label class="custom-file-label" id="fileLabel5{{ $question->id }}"
                                                    for="exampleInputFile5{{ $question->id }}">
                                                    @if ($question->images)
                                                        {{ $question->images }}
                                                    @else
                                                        Choose Image
                                                    @endif
                                                </label>
                                                <div class="input-group-append">
                                                    <small class="text-muted float-right input-group-text"><span
                                                            class="text-danger">*</span>Optional</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="editEssayImagePreview{{ $question->id }}" class="mt-1">
                                            @if ($question->images)
                                                <img src="{{ asset('' . $question->images) }}" alt="Question Image"
                                                    style="max-width: 300px;" class="mb-2">
                                            @endif
                                        </div>
                                        <!-- Essay image preview container -->
                                        <textarea id="inputDescription" name="question" class="form-control" rows="4">{{ $question->question }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info float-right"
                                        id="editQuestionBtn">Edit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        @else
            <!-- Edit Weighted Multiple Choice modal -->
            <div class="modal fade" id="edit-{{ $question->question_type }}{{ $question->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Weighted Multiple Choice</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/quiz/question/edit/weighted/{{ $question->id }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="question_type" value="weighted_multiple">
                                <input type="hidden" name="quiz_id" value="{{ $question->quiz_id }}">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="inputQuestion">Question</label>
                                        <br>
                                        <small class="float-right text-muted"><span
                                                class="text-danger">*</span>Optional</small>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input"
                                                    id="exampleInputFile6_edit" accept="image/*"
                                                    name="weightedEssayImage"
                                                    onchange="previewEditWeightedEssayImage(event, 'fileLabel6_edit', 'editWeighted-essayImagePreview')">
                                                <label class="custom-file-label" id="fileLabel6_edit"
                                                    for="exampleInputFile6_edit">
                                                    @if ($question->images)
                                                        {{ $question->images }}
                                                    @else
                                                        Choose image
                                                    @endif
                                                </label>
                                                <div class="input-group-append">
                                                    <small class="text-muted float-right input-group-text"><span
                                                            class="text-danger">*</span>Optional</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="editWeighted-essayImagePreview" class="mt-1">
                                            @if ($question->images)
                                                <img src="{{ asset('' . $question->images) }}" alt="Question Image"
                                                    style="max-width: 300px;" class="mb-2">
                                            @endif
                                        </div>
                                        <textarea id="inputQuestion" name="question" class="form-control" rows="4">{{ $question->question }}</textarea>
                                    </div>
                                    <div id="editWeighted-optionsContainer">
                                        <label for="inputName">Options</label>
                                        @foreach ($question->choices as $index => $choice)
                                            <div class="input-group weighted-input-group mb-2">
                                                <input type="hidden" name="choice_ids[]" value="{{ $choice->id }}">
                                                <input type="text" class="form-control"
                                                    placeholder="Option {{ $index + 1 }}"
                                                    name="choices[{{ $index }}]" value="{{ $choice->choice }}">
                                                <input type="number" min="0" class="form-control"
                                                    placeholder="Points" name="point_value[{{ $index }}]"
                                                    value="{{ $choice->point_value }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text btn btn-default"
                                                        style="cursor: pointer;"
                                                        onclick="uploadWeightedOptionImage(this)">
                                                        <i class="fas fa-image"></i>
                                                    </span>
                                                    <span class="input-group-text btn-danger btn" style="cursor: pointer;"
                                                        onclick="removeWeightedOption(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </div>
                                                <input type="file" accept="image/*" style="display: none;"
                                                    class="weightedOptionImageInput"
                                                    name="choice_images[{{ $index }}]"
                                                    onchange="previewWeightedOptionImage(event, 'imageLabel{{ $index }}', 'weightedImagePreview{{ $index }}')">
                                            </div>
                                            <div class="weightedOptionImagePreview mb-2"
                                                id="weightedImagePreview{{ $index }}">
                                                @if ($choice->image_choice)
                                                    <img src="{{ asset('storage/' . $choice->image_choice) }}"
                                                        alt="Choice Image" style="max-width: 300px;">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="addWeightedOptionBtn"
                                            onclick="editWeightedOption()">Add Option</button>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info float-right">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- Delete Modal -->
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Capture delete button click event
            $('.delete-btn').click(function() {
                // Get the ID of the user
                var userId = $(this).data('id');
                // Construct the delete URL
                var deleteUrl = '/admin/quiz/question/delete/' + userId;
                // Set the delete button href attribute
                $('#deleteButton').attr('href', deleteUrl);
            });
        });
    </script>
@endsection
