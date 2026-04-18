<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}?v=2">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo.png') }}?v=2">
    <title>
        @yield('title') | Hebat Dokter
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    @stack('css')
    <style>
        body {
            min-height: 100vh;
            overflow-x: hidden;
            background-color: #f8f9fa;
        }

        .navbar-brand img {
            max-height: 40px;
            width: auto;
        }

        .navbar-nav .nav-link {
            font-weight: 600;
        }

        .hero-section {
            background-color: #f8f9fa;
            padding: 3rem 0;
        }

        .hero-section .display-4 {
            font-size: clamp(2.25rem, 5vw, 3.7rem);
            line-height: 1.1;
        }

        .feature-card,
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover,
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 40px rgba(0, 0, 0, 0.12);
        }

        .doctor-avatar,
        .icon {
            width: 56px;
            height: 56px;
            min-width: 56px;
            min-height: 56px;
            font-size: 1.2rem;
        }

        .card-img-top {
            max-width: 100%;
            height: auto;
            object-fit: cover;
        }

        .ratio {
            min-height: 220px;
        }

        .position-fixed.home-button {
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .alert-custom {
            width: calc(100% - 2rem);
            max-width: 500px;
            margin: 0 auto;
        }

        .card-body {
            padding: 1.5rem;
        }

        @media (max-width: 991.98px) {
            .hero-section {
                padding: 2.5rem 0;
            }

            .ratio {
                min-height: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .navbar-nav {
                text-align: right;
                width: 100%;
            }

            .navbar-nav .nav-item {
                width: 100%;
            }

            .navbar-nav .nav-link {
                padding: 0.75rem 0;
                text-align: left;
            }

            .hero-section {
                padding: 1.8rem 0;
            }

            .hero-section .display-4 {
                font-size: 2.4rem;
            }

            .doctor-avatar,
            .icon {
                width: 48px;
                height: 48px;
                font-size: 1rem;
            }

            .card-body {
                padding: 1.25rem;
            }

            .position-fixed.home-button {
                top: auto;
                left: auto;
                bottom: 16px;
                right: 16px;
            }

            .navbar-toggler {
                border: none;
                width: 46px;
                height: 46px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background-color: rgba(255,255,255,0.15);
                border-radius: 0.75rem;
                transition: background-color 0.2s ease;
                color: #000;
            }

            .navbar-toggler:hover,
            .navbar-toggler:focus {
                background-color: rgba(255,255,255,0.25);
            }

            .navbar-toggler-icon {
                display: inline-block;
                width: 24px;
                height: 2px;
                background-color: currentColor;
                position: relative;
            }

            .navbar-toggler-icon::before,
            .navbar-toggler-icon::after {
                content: '';
                width: 24px;
                height: 2px;
                background-color: currentColor;
                position: absolute;
                left: 0;
            }

            .navbar-toggler-icon::before {
                top: -7px;
            }

            .navbar-toggler-icon::after {
                top: 7px;
            }

            .navbar-light .navbar-toggler {
                color: #000;
                background-color: rgba(0, 0, 0, 0.05);
            }

            .navbar-light .navbar-toggler-icon,
            .navbar-light .navbar-toggler-icon::before,
            .navbar-light .navbar-toggler-icon::after {
                background-color: #000;
            }

            .navbar-dark .navbar-toggler {
                color: #fff;
                background-color: rgba(255, 255, 255, 0.15);
            }

            .navbar-dark .navbar-toggler-icon,
            .navbar-dark .navbar-toggler-icon::before,
            .navbar-dark .navbar-toggler-icon::after {
                background-color: #fff;
            }

            .navbar-collapse {
                background-color: #fff;
                border-radius: 1rem;
                padding: 1rem;
                margin-top: 0.75rem;
            }

            .navbar-nav {
                width: 100%;
            }

            .navbar-nav .nav-item {
                width: 100%;
            }

            .navbar-nav .nav-link {
                width: 100%;
                padding: 0.75rem 1rem;
                color: #000 !important;
            }

            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link:focus {
                color: #000 !important;
                background-color: rgba(0,0,0,0.03);
            }

            .navbar .dropdown-menu {
                width: 100%;
                margin-top: 0.5rem;
                border-radius: 0.75rem;
                background-color: #fff;
            }

            .navbar .dropdown-menu .dropdown-item {
                color: #000;
            }

            .navbar .dropdown-menu .dropdown-item:hover,
            .navbar .dropdown-menu .dropdown-item:focus {
                color: #000;
                background-color: rgba(0,0,0,0.03);
            }

            .navbar-brand {
                margin-bottom: 0.75rem;
            }

            .feature-card,
            .card {
                border-radius: 1rem;
            }
        }
    </style>
</head>

<body class="{{ $class ?? '' }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-custom text-white alert-danger max-width-500 fixed-top fade border-0 show mt-5 mx-auto"
                        role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-custom text-white alert-success max-width-500 fixed-top fade border-0 show mt-5 mx-auto"
                        role="alert">
                        <i class="ni ni-check-bold"></i>
                        {{ session('success') }}

                    </div>
                @endif
                @if (session('failed'))
                    <div class="alert alert-custom text-white alert-danger max-width-500 fixed-top fade border-0 show mt-5 mx-auto"
                        role="alert">
                        {{ session('failed') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
           <main class="main-content border-radius-lg">
                @yield('content')
            </main>
            @auth
                @include('layouts.footers.auth.footer')
            @else
                @include('layouts.footers.guest.footer')
            @endauth
            @include('components.fixed-plugin')

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = @json(session('success'));
            const failedMessage = @json(session('failed') ?? session('error'));
            if (successMessage) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: successMessage,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
            if (failedMessage) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: failedMessage,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        });

        function hideAlert() {
            const alertElement = document.querySelector('.alert-custom');
            if (alertElement) {
                alertElement.style.opacity = '0';
                setTimeout(function() {
                    alertElement.remove();
                }, 1000);
            }
        }

        setTimeout(function() {
            hideAlert();
        }, 5000);
        // Trigger the hideAlert function when the user clicks on the alert (optional)
        document.addEventListener('click', function(event) {
            if (event.target.matches('.alert-custom')) {
                hideAlert();
            }
        });
    </script>
</body>

</html>
