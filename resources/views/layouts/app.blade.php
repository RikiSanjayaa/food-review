<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Food Reviews') }}</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f7f6;
            color: #212529;
        }

        .app-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-content {
            flex: 1;
        }

        .container-narrow {
            max-width: 1140px;
            margin-inline: auto;
        }

        .navbar {
            backdrop-filter: saturate(180%) blur(10px);
            background: rgba(255,255,255,.92);
        }

        .navbar-brand {
            letter-spacing: -.02em;
        }

        .navbar-logo {
            height: 32px;
            width: auto;
            transition: transform .2s ease;
        }

        .navbar-logo:hover {
            transform: scale(1.05);
        }

        .nav-link {
            font-weight: 500;
        }
    </style>
</head>

<body>
<div class="app-wrapper">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top border-bottom">
        <div class="container-fluid px-4 px-lg-5">

            <!-- BRAND LOGO -->
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-success"
               href="{{ route('recipes.index') }}">

                <img
                    src="{{ asset('logoku.png') }}"
                    alt="Food Reviews Logo"
                    class="navbar-logo">

                <span>{{ config('app.name') }}</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-lg-3">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('recipes.index') ? 'text-success fw-semibold' : '' }}"
                           href="{{ route('recipes.index') }}">
                            Beranda
                        </a>
                    </li>

                    @auth
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn btn-outline-success rounded-pill px-4 dropdown-toggle"
                                    type="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="dropdown-item py-2 text-danger">
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}"
                               class="btn btn-link text-secondary text-decoration-none">
                                Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}"
                               class="btn btn-success rounded-pill px-4">
                                Daftar
                            </a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="page-content">

        <div class="container-narrow mt-4">
            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center"
                     role="alert" data-aos="fade-down">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-4"
                     role="alert" data-aos="fade-down">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Perhatian
                    </h6>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @yield('content')

    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-4">
        <div class="container text-center">
            <p class="text-secondary small mb-0">
                &copy; {{ date('Y') }} Food Reviews.
                Dibuat dengan <span class="text-danger">&hearts;</span> di Lombok.
            </p>
        </div>
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 900,
        once: true,
        offset: 60
    });
</script>

</body>
</html>
