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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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

        /* HARD FIX V2: Ultra-Micro Navbar Overrides REMOVED - BALANCED V2 APPLIED */
        .navbar {
            transition: all 0.3s ease;
            min-height: 70px; /* Standard Professional Height */
        }
        
        .navbar-logo {
            height: 40px; /* Clear & Authoritative */
            width: auto;
            transition: transform .2s ease;
        }

        .navbar-logo:hover {
            transform: scale(1.05);
        }

        .nav-link, .btn {
            font-size: 16px; /* Comfortable Readability */
            font-weight: 500;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            letter-spacing: -.02em;
            height: 100%; /* Ensure full height alignment */
        }
        
        /* Ensure dropdown button matches symmetry */
        .user-dropdown-btn {
            padding: 8px 24px; /* Balanced padding */
        }
    </style>
</head>

    <div class="app-wrapper">

        <!-- NAVBAR -->
        <nav x-data="{ scrolled: false }" 
             @scroll.window="scrolled = (window.pageYOffset > 50)"
             class="navbar navbar-expand-lg transition-all duration-1000 ease-in-out py-0
             {{ request()->routeIs('recipes.index') ? 'fixed-top' : 'sticky-top bg-white border-bottom shadow-sm' }}"
             :class="{
                 'bg-white/95 backdrop-blur-md shadow-sm': {{ request()->routeIs('recipes.index') ? 'true' : 'false' }} && scrolled,
                 'bg-transparent': {{ request()->routeIs('recipes.index') ? 'true' : 'false' }} && !scrolled
             }"
             style="z-index: 1000;">
            
            <div class="container"> {{-- Symmetry Enforced --}}
                <div class="w-100 d-flex justify-content-between align-items-center" style="min-height: 70px;">

                    <!-- BRAND LOGO (LEFT) -->
                    <a class="navbar-brand d-flex align-items-center gap-3 fw-bold transition-colors duration-1000 ease-in-out"
                        href="{{ route('recipes.index') }}"
                        :class="{{ request()->routeIs('recipes.index') ? 'scrolled ? \'text-success\' : \'text-white\'' : '\'text-success\'' }}">

                        <img src="{{ asset('logo.svg') }}" alt="Logo" class="navbar-logo">

                        <span class="d-none d-sm-block" style="font-size: 1.25rem; font-weight: 700;">Food Reviews</span>
                    </a>

                    <!-- BERANDA (CENTER) - Hidden on Mobile -->
                    <ul class="navbar-nav d-none d-lg-flex gap-5 align-items-center"> {{-- Wide gap for luxury feel --}}
                        <li class="nav-item">
                            <a class="nav-link transition-colors duration-1000 ease-in-out px-2"
                               href="{{ route('recipes.index') }}"
                               :class="[
                                   {{ request()->routeIs('recipes.index') ? 'true' : 'false' }} && !scrolled 
                                        ? 'text-white hover:text-white/80' 
                                        : 'text-dark hover:text-success',
                                   {{ request()->routeIs('recipes.index') ? 'true' : 'false' }} 
                                        ? (scrolled ? 'fw-bold text-success' : 'fw-bold text-white') 
                                        : ''
                               ]">
                                Beranda
                            </a>
                        </li>
                    </ul>

                    <!-- AUTH SECTION (RIGHT) - Desktop -->
                    <div class="d-none d-lg-flex align-items-center gap-3">
                        @auth
                            <div class="dropdown">
                                <button class="btn user-dropdown-btn rounded-pill dropdown-toggle border-0 transition-all duration-1000 ease-in-out" 
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        :class="[
                                            {{ request()->routeIs('recipes.index') ? 'true' : 'false' }} && !scrolled 
                                                ? 'bg-white/20 text-white backdrop-blur-sm hover:bg-white/30' 
                                                : 'btn-outline-success text-dark'
                                        ]">
                                    {{ Auth::user()->name }}
                                </button>
                                
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2">
                                    @if (Auth::user()->is_admin)
                                        <li>
                                            <a href="{{ route('recipes.create') }}"
                                                class="dropdown-item py-2 text-success text-sm">
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
                                            <button type="submit" class="dropdown-item py-2 text-danger text-sm">
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" 
                               class="btn btn-link text-decoration-none transition-colors duration-1000 ease-in-out text-sm font-medium py-1 px-2"
                               :class="{{ request()->routeIs('recipes.index') ? 'true' : 'false' }} && !scrolled ? 'text-white/90 hover:text-white' : 'text-secondary'">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" 
                               class="btn rounded-pill px-4 border-0 transition-all duration-1000 ease-in-out text-sm py-1 font-semibold"
                               :class="{{ request()->routeIs('recipes.index') ? 'true' : 'false' }} && !scrolled ? 'bg-white text-success hover:bg-white/90' : 'btn-success text-white'">
                                Daftar
                            </a>
                        @endauth
                    </div>

                    <!-- Hamburger Menu (Mobile) -->
                    <button class="navbar-toggler border-0 d-lg-none transition-all duration-1000 ease-in-out py-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon" 
                              style="width: 1.2em; height: 1.2em;"
                              :style="{{ request()->routeIs('recipes.index') ? 'true' : 'false' }} && !scrolled ? 'filter: invert(1);' : ''">
                        </span>
                    </button>

                </div>

                <!-- Mobile Menu -->
                <div class="collapse navbar-collapse bg-white rounded-3 p-3 mt-2 shadow-lg d-lg-none" id="navbarNav">
                    <ul class="navbar-nav">
                        @auth
                            @if (Auth::user()->is_admin)
                                <li class="nav-item">
                                    <a href="{{ route('recipes.create') }}" class="nav-link text-success text-sm">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Tambah Resep
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link text-danger text-start p-0 text-sm">
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link text-sm">
                                    Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link text-sm">
                                    Daftar
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="page-content {{ !request()->routeIs('recipes.index') ? 'py-4' : '' }}">

            @yield('content')

        </main>

        <!-- FOOTER -->
        <footer class="bg-white border-top py-4">
            <div class="container text-center">
                <p class="text-secondary small mb-0">
                    &copy; {{ date('Y') }} Food Reviews.
                    Dibuat di Lombok.
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
