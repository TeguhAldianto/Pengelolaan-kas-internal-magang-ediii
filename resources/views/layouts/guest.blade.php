<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Sistem Keuangan - Login</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
</head>

<body class="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <nav
                    class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid pe-0">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="{{ url('/') }}">
                            Finance System Magang UNESA
                        </a>
                        <div class="collapse navbar-collapse" id="navigation">
                            <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
                                <li class="nav-item">
                                    {{-- <a class="nav-link d-flex align-items-center me-2 active" aria-current="page"
                                        href="{{ route('dashboard') }}">
                                        <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i> Dashboard
                                    </a> --}}
                                </li>
                                @auth
                                    <li class="nav-item">
                                        <a class="nav-link me-2" href="{{ route('profile.edit') }}">
                                            <i class="fa fa-user opacity-6 text-dark me-1"></i> Profile
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link me-2" href="{{ route('register') }}">
                                            <i class="fas fa-user-circle opacity-6 text-dark me-1"></i> Sign Up
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link me-2" href="{{ route('login') }}">
                                            <i class="fas fa-key opacity-6 text-dark me-1"></i> Sign In
                                        </a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    {{ $slot }}

    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center mt-1">
                    <p class="mb-0 text-secondary">
                        Copyright (UNESA) ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> Finance Electronic Data Interchange Indonesia.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
</body>

</html>
