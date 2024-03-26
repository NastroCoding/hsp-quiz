@extends('layouts.main')

@section('container')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (session()->has('register_success'))
        <div class="alert alert-success" role="alert">
            {{ session('register_success') }}
        </div>
    @endif

    <div class="login-form mt-5">
        <h1>Login Page</h1>
        <form action="/signin" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Token</label>
                <div class="col-sm-10">
                    <input type="text" name="token" class="form-control" id="inputEmail3">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword3">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>

@endsection
