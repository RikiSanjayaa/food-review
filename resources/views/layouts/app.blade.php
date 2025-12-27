<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Food Reviews') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        .navbar {
            transition: all 0.3s ease;
            height: 58px !important;
            min-height: 58px !important;
            padding: 0 !important;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 30px rgba(0,0,0,0.04) !important; 
        }
        
        .navbar-logo {
            height: 36px !important;
            width: auto;
            transition: transform .2s ease;
            object-fit: contain;
        }

        .navbar-logo:hover {
            transform: scale(1.05);
        }

        .nav-link {
            font-size: 15px;
            font-weight: 500;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            line-height: 58px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            letter-spacing: -.02em;
            height: 58px !important;
            padding: 0 !important;
            margin: 0 !important;
            padding-left: 12px !important; 
        }
        
        .user-dropdown-btn {
            padding: 4px 14px !important;
            font-size: 14px;
            line-height: normal;
            height: auto;
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="app-wrapper">

        <nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
             @scroll.window="scrolled = (window.pageYOffset > 50)"
             class="navbar navbar-expand-lg transition-all duration-1000 ease-in-out
             {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'fixed-top' : 'sticky-top bg-white border-bottom' }}"
             :class="{
                 'bg-white/95 backdrop-blur-md': {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && (scrolled || mobileMenuOpen),
                 'bg-white': !{{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} || ({{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && (scrolled || mobileMenuOpen)),
                 'bg-transparent': {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && !scrolled && !mobileMenuOpen
             }"
             style="z-index: 1000;">
            
            <div class="w-[90%] md:w-[85%] lg:w-[80%] mx-auto h-100 relative">
                <div class="w-100 d-flex justify-content-between align-items-center h-100">

                    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold transition-colors duration-1000 ease-in-out"
                        href="{{ route('recipes.index') }}">

                        <img src="{{ asset('logo.svg') }}" alt="Logo" class="navbar-logo">

                        <span class="d-none d-sm-block text-nowrap" 
                              style="font-size: 1.15rem; font-weight: 700; line-height: 1; padding-top: 2px;"
                              :class="[
                                  {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && (scrolled || mobileMenuOpen)
                                      ? 'bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent' 
                                      : ({{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} 
                                          ? 'text-white' 
                                          : 'bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent')
                              ]">Food Reviews</span>
                    </a>

                    <ul class="navbar-nav d-none d-lg-flex position-absolute start-50 top-50 translate-middle mb-0">
                        <li class="nav-item">
                            <a class="nav-link transition-colors duration-1000 ease-in-out px-3 d-flex align-items-center"
                               href="{{ route('recipes.index') }}">
                                <span :class="
                                   {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} 
                                       ? (scrolled 
                                            ? 'fw-bold bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent' 
                                            : 'text-white hover:text-white/80')
                                       : 'text-dark hover:text-orange-600'
                               ">Beranda</span>
                            </a>
                        </li>
                    </ul>

                    <div class="d-none d-lg-flex align-items-center gap-3" style="margin-right: -16px !important;">
                        @auth
                            <div class="dropdown">
                                <button class="btn user-dropdown-btn rounded-pill dropdown-toggle border-0 transition-all duration-1000 ease-in-out d-flex align-items-center gap-1" 
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        :class="[
                                            {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && !scrolled 
                                                ? 'bg-white/20 text-white backdrop-blur-sm hover:bg-white/30' 
                                                : 'hover:bg-orange-50 border border-orange-200'
                                        ]">
                                    <span :class="[
                                            {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && !scrolled 
                                                ? 'text-white' 
                                                : 'bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent fw-bold'
                                        ]">{{ Auth::user()->name }}</span>
                                </button>
                                
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2">
                                    @if (Auth::user()->is_admin)
                                        <li>
                                            <a href="{{ route('recipes.create') }}"
                                                class="dropdown-item py-2 hover:bg-orange-50 text-sm font-bold d-flex align-items-center gap-2">
                                                <i class="bi bi-plus-circle text-orange-500"></i>
                                                <span class="bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent">Tambah Resep</span>
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger hover:bg-red-50 text-sm">
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" 
                               class="btn text-decoration-none transition-colors duration-300 ease-in-out text-sm font-bold py-2 px-3"
                               :class="{{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && !scrolled ? 'text-white hover:text-white/80' : 'text-gray-500 hover:text-orange-600'">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" 
                               class="btn rounded-full px-4 transition-all duration-300 ease-in-out text-sm py-2 font-bold hover:-translate-y-0.5"
                               :class="[
                                   {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && !scrolled 
                                        ? 'bg-transparent border-2 border-white text-white hover:bg-white hover:text-orange-600' 
                                        : 'border-0 shadow-lg shadow-amber-500/20 hover:shadow-orange-500/40 bg-gradient-to-r from-amber-500 to-orange-600 text-white'
                               ]">
                                Daftar
                            </a>
                        @endauth
                    </div>

                    <button class="navbar-toggler border-0 d-lg-none transition-all duration-1000 ease-in-out py-1" 
                            type="button" 
                            @click="mobileMenuOpen = !mobileMenuOpen">
                        <span class="navbar-toggler-icon" 
                              style="width: 1.2em; height: 1.2em;"
                              :style="{{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && !scrolled && !mobileMenuOpen ? 'filter: invert(1);' : ''">
                        </span>
                    </button>

                </div>


                <div x-show="mobileMenuOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="absolute top-full left-0 w-full bg-white/95 backdrop-blur-xl border-t border-gray-100 shadow-xl p-4 flex flex-col gap-3 d-lg-none"
                     style="border-radius: 0 0 1.5rem 1.5rem;"
                     @click.outside="mobileMenuOpen = false">
                    
                    @auth
                        <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            Menu User
                        </div>
                        
                        @if (Auth::user()->is_admin)
                        <a href="{{ route('recipes.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-orange-50 text-orange-600 font-bold transition-colors">
                            <i class="bi bi-plus-circle text-lg"></i>
                            Tambah Resep
                        </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 text-danger font-bold transition-colors text-left">
                                <i class="bi bi-box-arrow-right text-lg"></i>
                                Keluar
                            </button>
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('login') }}" class="flex items-center justify-center py-3 rounded-full border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center justify-center py-3 rounded-full bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold shadow-lg shadow-amber-500/20 hover:shadow-orange-500/40 transition-all">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>

            </div>
        </nav>

        <main class="page-content {{ !in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'py-4' : '' }}">

            @yield('content')

        </main>

        @if(!in_array(request()->route()->getName(), ['login', 'register']))
            <footer class="bg-white border-top py-4">
                <div class="container text-center">
                    <p class="text-secondary small mb-0">
                        &copy; {{ date('Y') }} Food Reviews.
                        Dibuat di Lombok.
                    </p>
                </div>
            </footer>
        @endif

    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        @if (session('status'))
            <div class="toast align-items-center text-white bg-gradient-orange-plain border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
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
