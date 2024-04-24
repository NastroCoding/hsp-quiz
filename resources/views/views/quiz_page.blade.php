@extends('layouts.quiz')

@section('number')
    <style>
        #responsive {
            min-width: 350px;
            max-width: 90%;
        }

        @media only screen and (min-width:768px) {
            #responsive {
                min-width: 600px;
                max-width: 100%;
            }
        }

        @media only screen and (max-width:280px) {
            #responsive {
                min-width: 250px;
                max-width: 100%;
            }
        }
    </style>
    @for ($i = 1; $i <= $lastQuestionNumber; $i++)
        @php
            $answered = false;
            foreach ($userAnswers as $userAnswer) {
                if ($userAnswer->question_id == $i) {
                    $answered = true;
                    break; // Exit the loop once an answer is found
                }
            }
        @endphp
        <a href="/quiz/view/{{ $slug }}/{{ $i }}"
            class="btn {{ $answered ? 'btn-success text-white' : 'btn-default' }} col {{ $question_number == $i ? 'active' : '' }}"
            style="margin: 1px;">{{ $i }}</a>
    @endfor
@endsection

@section('container')
    <div class="content-wrapper d-flex justify-content-center align-items-center">
        <div class="content">
            <div class="container">
                <div class="row ">
                    <!-- /.col-md-6 -->
                    <!-- Multiple Choice Form -->
                    @foreach ($questions as $que)
                        @if ($que->number == $question_number)
                            {{-- <div class="card card-default col-8" id="responsive">
                                <!-- Setting a minimum width of 300px and a maximum width of 90% -->
                                <div class="card-header">
                                    <h3 class="card-title">Number {{ $que->number }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="/quiz/answer" method="POST">
                                    @csrf
                                    <input type="hidden" name="question_id" value="{{ $que->id }}">
                                    @if ($que->question_type == 'multiple_choice' || $que->question_type == 'weighted_multiple')
                                        <div class="card-body">
                                            <div class="form-group">
                                                <p>{{ $que->question }}</p>
                                            </div>
                                            @foreach ($que->choices as $index => $choice)
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="choosen_choice_id" value="{{ $choice->id }}"
                                                            id="radio{{ $index + 1 }}">
                                                        <label class="form-check-label"
                                                            for="radio{{ $index + 1 }}">{{ $choice->choice }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <p class="text-sm text-muted float-right">{{ $que->question_type }}</p>
                                        </div>
                                        <!-- /.card-body -->
                                    @elseif ($que->question_type == 'essay')
                                        <div class="card-body">
                                            <div class="form-group">
                                                @if (file_exists('public/img/' . $que->images))
                                                    <p>ini ada foto</p>
                                                @endif
                                                <p>{{ $que->question }}</p>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                            </div>
                                            <p class="text-sm text-muted float-right">{{ $que->question_type }}</p>
                                        </div>
                                        <!-- /.card-body -->
                                    @endif
                                    <div class="card-body">
                                        <div class="form-group">
                                            @if (file_exists('public/img/' . $que->images))
                                                <p>ini ada foto</p>
                                            @endif
                                            <p>{{ $que->question }}</p>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                        </div>
                                        <p class="text-sm text-muted float-right">{{ $que->question_type }}</p>
                                    </div>
                                    <div class="card-footer">
                                        @if ($que->number != 1)
                                            <a href="javascript:void(0)"
                                                onclick="submitForm('   /quiz/view/{{ $slug }}/{{ $que->number - 1 }}')"
                                                class="btn btn-default"><i class="fas fa-angle-left"></i> Back</a>
                                        @endif
                                        @if ($que->number != $lastQuestionNumber)
                                            <a href="javascript:void(0)"
                                                onclick="submitForm('/quiz/view/{{ $slug }}/{{ $que->number + 1 }}')"
                                                class="btn btn-primary float-right">Next <i
                                                    class="fas fa-angle-right"></i></a>
                                        @else
                                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                                        @endif
                                    </div>
                                </form>

                            </div> --}}
                        @endif
                    @endforeach
                    <div class="card card-default col-5" id="responsive">
                        <!-- Setting a minimum width of 300px and a maximum width of 90% -->
                        <div class="card-header">
                            <h3 class="card-title">Number {{ $que->number }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="/quiz/answer" method="POST">
                            <input type="hidden" name="question_id" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <p></p>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label" for="radio"</label>
                                    </div>
                                </div>
                                <p class="text-sm text-muted float-right"></p>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="gambar-container">
                                        <form action="#">
                                            <div class="radio-group">
                                                <div class="gambar-item">
                                                    <label for="gambar_1"><img src="{{ URL::asset('dist/img/soal-1.jpg') }}"
                                                            alt="" width="300"></label>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore
                                                        qui id culpa natus esse, nam explicabo nemo quisquam autem odit vero
                                                        sequi. Repudiandae nulla, quasi blanditiis sunt illum quae non.</p>
                                                </div>
                                                <div class="gambar-item">
                                                    <input type="radio" id="gambar_2" name="gambar" value="gambar2">
                                                    <label for="gambar_2"><img src="{{ URL::asset('dist/img/soal-2.jpg') }}"
                                                            alt="" width="200"></label>
                                                </div>
                                                <div class="gambar-item">
                                                    <input type="radio" id="gambar_3" name="gambar" value="gambar3">
                                                    <label for="gambar_3">
                                                        <img src="{{ URL::asset('dist/img/soal-3.jpg') }}" alt=""
                                                            width="200">
                                                    </label>
                                                </div>
                                                <div class="gambar-item">
                                                    <input type="radio" id="gambar_4" name="gambar" value="gambar4">
                                                    <label for="gambar_4"><img src="{{ URL::asset('dist/img/soal-4.jpg') }}"
                                                            alt="" width="200"></label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                    </div>
                                    <p class="text-sm text-muted float-right"></p> --}}
                            </div>
                            <!-- /.card-body -->
                            <div class="card-body">
                                <div class="form-group">
                                    <p></p>
                                </div>
                                {{-- <div class="form-group">
                                    <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                </div> --}}
                                <p class="text-sm text-muted float-right"></p>
                            </div>
                            <div class="card-footer">
                                <a href="javascript:void(0)" onclick="" class="btn btn-default"><i
                                        class="fas fa-angle-left"></i> Back</a>
                                <a href="javascript:void(0)" onclick="" class="btn btn-primary float-right">Next <i
                                        class="fas fa-angle-right"></i></a>
                                <button type="submit" class="btn btn-primary float-right mr-1">Submit</button>
                            </div>
                        </form>

                    </div>
                    <!-- Essay Form -->

                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
    <script src="{{ URL::asset('/dist/js/countdown.js') }}"></script>
    <script>
        CountdownTimer.init("countdownTimer2");
        CountdownTimer.init("countdownTimer3");
    </script>
@endsection
