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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
            background: rgba(255, 255, 255, .92);
        }

        .navbar-brand {
            letter-spacing: -.02em;
        }

        .navbar-logo {
            height: 40px;
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
            <div class="container">
                <div class="w-100 d-flex justify-content-between align-items-center">

                    <!-- BRAND LOGO (LEFT) -->
                    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-success"
                        href="{{ route('recipes.index') }}">

                        <img src="{{ asset('logo.svg') }}" alt="Food Reviews Logo" class="navbar-logo">

                        <span>Food Reviews</span>
                    </a>

                    <!-- BERANDA (CENTER) - Hidden on Mobile -->
                    <ul class="navbar-nav d-none d-lg-flex">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('recipes.index') ? 'text-success fw-semibold' : '' }}"
                                href="{{ route('recipes.index') }}">
                                Beranda
                            </a>
                        </li>
                    </ul>

                    <!-- AUTH SECTION (RIGHT) - Desktop -->
                    <div class="d-none d-lg-flex align-items-center gap-3">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-outline-success rounded-pill px-4 dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2">
                                    @if (Auth::user()->is_admin)
                                        <li>
                                            <a href="{{ route('recipes.create') }}"
                                                class="dropdown-item py-2 text-success">
                                                <i class="bi bi-plus-circle me-1"></i>
                                                Tambah Resep
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-link text-secondary text-decoration-none">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-success rounded-pill px-4">
                                Daftar
                            </a>
                        @endauth
                    </div>

                    <!-- Hamburger Menu (Mobile) -->
                    <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                </div>

                <!-- Mobile Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mt-3">
                        @auth
                            @if (Auth::user()->is_admin)
                                <li class="nav-item d-lg-none">
                                    <a href="{{ route('recipes.create') }}" class="nav-link text-success">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Tambah Resep
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item d-lg-none">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link text-danger text-start p-0 ">
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item d-lg-none">
                                <a href="{{ route('login') }}" class="nav-link">
                                    Masuk
                                </a>
                            </li>
                            <li class="nav-item d-lg-none">
                                <a href="{{ route('register') }}" class="nav-link">
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

    <!-- Toast Notifications Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        @if (session('status'))
            <div class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="toast align-items-center text-white bg-danger border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="7000">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <strong>Perhatian</strong>
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 900,
            once: true,
            offset: 60
        });

        // Auto-show toasts on page load
        document.addEventListener('DOMContentLoaded', function() {
            const toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(function(toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        });
    </script>

</body>

</html>
