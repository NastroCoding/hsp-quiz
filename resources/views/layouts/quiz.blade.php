<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page }} | HSPnet</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/adminlte.min.css') }}" />
    {{-- Animate.css --}}
    <link rel="stylesheet" href="{{ URL::asset('dist/css/animate.css')}}">
</head>

<body class="hold-transition sidebar-collapse">
    <div class="wrapper">
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">HSPnet</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-3">
                    <div class="row m-1">
                        <p>Time Left: <span id="demo"></span></p>
                    </div>
                    <div class="row row-cols-5 m-1">
                        <a href="" class="btn btn-default col">1</a>
                        <a href="" class="btn btn-default col">2</a>
                        <a href="" class="btn btn-default col">3</a>
                        <a href="" class="btn btn-default col">4</a>
                        <a href="" class="btn btn-default col">5</a>
                        <a href="" class="btn btn-default col">6</a>
                        <a href="" class="btn btn-default col">7</a>
                        <a href="" class="btn btn-default col">8</a>
                        <a href="" class="btn btn-default col">9</a>
                        <a href="" class="btn btn-default col">10</a>
                    </div>
                    <div></div>
                    <div class="row m-1">
                        <button class="btn btn-primary btn-sm">Finish Attempt</button>
                    </div>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        @yield('container')
        <footer class="main-footer">
            <strong>Copyright &copy; 2024
                <a href="">HSP Net</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ URL::asset('dist/js/adminlte.js') }}"></script>

    {{-- CUSTOM SCRIPT --}}
    <script src="{{ URL::asset('/dist/js/hspsite.js') }}"></script>

    {{-- JQuery  --}}
    <script src="{{ URL::asset('/dist/js/jquery.min.js')}}"></script>
    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("Jan 5, 2030 15:37:25").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>
</body>

</html>