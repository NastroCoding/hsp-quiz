<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSPnet</title>
    <link rel="shortcut icon" href="{{ URL::asset('dist/img/favicon.ico') }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/adminlte.min.css') }}" />
    {{-- Animate.css --}}
    <link rel="stylesheet" href="{{ URL::asset('dist/css/animate.css') }}">
</head>

<body class="hold-transition layout-top-nav ">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <img src="{{ URL::asset('dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image"
                        style="opacity: 0.8" />
                </a>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="/quiz" class="nav-link">Quiz</a>
                        </li>
                        <li class="nav-item">
                            <a href="/score" class="nav-link">Score</a>
                        </li>
                    </ul>
                </div>
                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link dropdown-toggle">{{ Auth::user()->name }}</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li>
                                <a href="/logout" class="dropdown-item">Logout</a>
                            </li>
                        </ul>
                    </li>
                    <!-- Notifications Dropdown Menu -->
                </ul>
            </div>
        </nav>
        @yield('container')
        <!-- /.navbar -->
        <!-- /.content-wrapper -->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-light">
            <div class="p-3">
                <a class="nav-link" data-widget="control-sidebar" href="#">Toggle Control Sidebar</a>
                <!-- Content of the sidebar goes here -->
            </div>
        </aside>
        <!-- /.control-sidebar -->
        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024
                <a href="">HSP Net</a>.</strong>
            All rights reserved.
        </footer>
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
                <form method="GET" action="{{ route('quiz.filter') }}">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Education</label>
                                        <select class="form-control" name="education">
                                            <option value="">None</option>
                                            @foreach ($education as $edu)
                                                <option value="{{ $edu->id }}"
                                                    {{ isset($selectedEducation) && $selectedEducation == $edu->id ? 'selected' : '' }}>
                                                    {{ $edu->education_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category">
                                            <option value="">None</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ isset($selectedCategory) && $selectedCategory == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->category_name }}
                                                </option>
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

    @if ($data->isNotEmpty())
        @foreach ($data as $quiz)
            <div class="modal fade" id="modal-quiz">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Enter Quiz</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/quiz/view/{{ $quiz->slug }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Enter quiz code</label>
                                        <input type="text" name="token" class="form-control"
                                            id="exampleInputEmail1" placeholder="XXXXXX">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Go</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        @endforeach
    @endif
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ URL::asset('dist/js/adminlte.js') }}"></script>

    {{-- CUSTOM SCRIPT --}}
    <script src="{{ URL::asset('/dist/js/hspsite.js') }}"></script>

    {{-- JQuery  --}}
    <script src="{{ URL::asset('/dist/js/jquery.min.js') }}"></script>

    @yield('scripts')
</body>

</html>
