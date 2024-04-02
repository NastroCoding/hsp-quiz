@extends('layouts.quiz')
@section('container')

<div class="content-wrapper d-flex justify-content-center align-items-center">
    <div class="content">
        <div class="container">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="card card-default" style="max-width: 500px;">
                    <!-- Limiting the width to 500px -->
                    <div class="card-header">
                        <h3 class="card-title">Question 1</h3>
                        <h3 class="card-title text-muted float-right">Time Remaining: <span id="countdownTimer2"></span></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus ea at, consequatur earum iure ab totam quibusdam corporis quasi, magni voluptatem quis aperiam aut maiores doloribus! Earum molestiae odio et!</p>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question1" id="radio1">
                                    <label class="form-check-label" for="radio1">A</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question1" id="radio2">
                                    <label class="form-check-label" for="radio2">B</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question1" id="radio3">
                                    <label class="form-check-label" for="radio3">C</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question1" id="radio4">
                                    <label class="form-check-label" for="radio4">D</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question1" id="radio5">
                                    <label class="form-check-label" for="radio5">E</label>
                                </div>
                            </div>
                            <div class="form-group">

                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a type="submit" class="btn btn-default"><i class="fas fa-angle-left"></i> Back</a>
                            <a type="submit" class="btn btn-primary float-right">Next <i class="fas fa-angle-right"></i></a>
                        </div>
                    </form>
                </div>
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
</script>
@endsection