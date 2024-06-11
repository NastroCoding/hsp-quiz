@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | HSPnet</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/hspadmin.css') }}" />
    {{-- Animate.css --}}
    {{-- <link rel="stylesheet" href="{{ URL::asset('dist/css/animate.css')}}"> --}}
    <style>
        .input-group {
            display: flex;
            align-items: center;
            position: relative;
        }

        .input-group input {
            flex: 1;
            padding-right: 40px;
        }

        .input-group-append {
            position: absolute;
            right: 13%;
            top: 50%;
            transform: translateY(-50%);
        }

        .input-group-text {
            border: none;
            background: none;
        }
    </style>
</head>

<body class="hold-transition register-page">
    <div class="wrapper">
        <section class="login-container d-flex justify-content-evenly">
            <div class="login-box">
                <div class="login-logo">
                    <img src="{{ URL::asset('dist/img/logo.png') }}" alt="Transjakarta" />
                    <div>
                        <h1>HSPNet</h1>
                        <h6>Create your Account!</h6>
                    </div>
                </div>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            <p>Username or password is incorrect!</p>
                        </div>
                    @endforeach
                @endif
                @if (session()->has('register_success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('register_success') }}
                    </div>
                @endif
                <form action="/signup" method="POST">
                    @csrf
                    <div class="login-input-box">
                        <i class="fa-solid fa-user"></i>
                        <input type="email" placeholder="Email" name="email" />
                    </div>
                    <div class="login-input-box">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" id="inputPassword" />
                        <div class="input-group-append">
                            <span class="input-group-text btn btn-default " style="cursor: pointer;">
                                <i class="fas fa-eye toggle-password"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit">Register</button>
                </form>
                <div class="credit">
                    <p>Already have an account? login <a href="/">here</a></p>
                    <p>&copy; HSPnet - 2024</p>
                </div>
            </div>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('#inputPassword');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
