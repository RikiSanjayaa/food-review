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

        .navbar-logo {
            height: 28px !important;
            width: auto;
            object-fit: contain;
        }

        .navbar-logo:hover {
            transform: scale(1.05);
        }
        
        [x-cloak] { display: none !important; }
    </style>
    
<body class="transition-colors duration-500"
    x-data="{
        scrolled: false,
        mobileMenuOpen: false
    }">

    <div class="app-wrapper">

        <nav @scroll.window="scrolled = (window.pageYOffset > 50)"
            class="h-14.5 flex items-center transition-all duration-1000 ease-in-out z-1000
             {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'fixed top-0 left-0 right-0' : 'sticky top-0 bg-white border-b border-gray-200' }}"
            :class="{
                'bg-white/95 backdrop-blur-md': {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} &&
                    (scrolled || mobileMenuOpen),
                'bg-white': !
                    {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} ||
                    ({{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} &&
                        (scrolled || mobileMenuOpen)),
                'bg-transparent': {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} &&
                    !scrolled && !mobileMenuOpen
            }">

            <div class="w-[90%] md:w-[85%] lg:w-[80%] mx-auto h-full relative">
                <div class="w-full flex justify-between items-center h-full">

                    <a class="flex items-center gap-2 font-bold transition-colors duration-1000 ease-in-out h-14.5 pl-3 tracking-tight no-underline"
                        href="{{ route('recipes.index') }}">

                        <img src="{{ asset('logo.svg') }}" alt="Logo" class="navbar-logo">

                        <span class="hidden sm:block whitespace-nowrap ml-2 text-lg font-bold leading-none pt-0.5"
                            :class="[
                                {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} &&
                                (scrolled || mobileMenuOpen) ?
                                'bg-linear-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent' :
                                ({{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} ?
                                    'text-white' :
                                    'bg-linear-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent')
                            ]">Food
                            Reviews</span>
                    </a>

                    <ul
                        class="hidden lg:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 mb-0 list-none p-0">
                        <li>
                            <a class="transition-colors duration-1000 ease-in-out px-3 flex items-center text-sm font-medium leading-14.5 no-underline"
                                href="{{ route('recipes.index') }}">
                                <span
                                    :class="{{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }}
                                        ?
                                        (scrolled ?
                                            'font-bold bg-linear-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent' :
                                            'text-white hover:text-white/80') :
                                        'text-gray-900 hover:text-orange-600'">Beranda</span>
                            </a>
                        </li>
                    </ul>

                    <div class="hidden lg:flex items-center gap-3 -mr-4">
                        @auth

                            <div x-data="{ open: false }" class="relative">
                                <button
                                    class="px-3.5 py-1 rounded-full border-0 transition-all duration-1000 ease-in-out flex items-center gap-1 text-sm cursor-pointer"
                                    type="button" @click="open = !open"
                                    :class="[
                                        {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} &&
                                        !scrolled ?
                                        'bg-white/20 text-white backdrop-blur-sm hover:bg-white/30' :
                                        'hover:bg-orange-50 border border-orange-200'
                                    ]">
                                    <span
                                        :class="[
                                            {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} &&
                                            !scrolled ?
                                            'text-white' :
                                            'bg-linear-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent font-bold'
                                        ]">{{ Auth::user()->name }}</span>
                                    <i class="bi bi-chevron-down text-xs" :class="[
                                        {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} && !scrolled 
                                        ? 'text-white' 
                                        : 'text-gray-500'
                                    ]"></i>
                                </button>

                                <ul x-show="open" @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 bg-white border-0 rounded-xl py-2 list-none z-50 shadow-xl shadow-gray-200/50">
                                    <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Menu User
                                    </div>

                                    <li>
                                        <a href="{{ route('profile.index') }}"
                                            class="px-4 py-2 hover:bg-orange-50 text-sm font-bold flex items-center gap-2 no-underline">
                                            <i class="bi bi-person-circle text-orange-500"></i>
                                            <span class="bg-linear-to-r text-orange-500 bg-clip-text">
                                                Profil Saya</span>
                                        </a>
                                    </li>
                                    @if (Auth::user()->is_admin)
                                        <li>
                                            <a href="{{ route('recipes.create') }}"
                                                class="px-4 py-2 hover:bg-orange-50 text-sm font-bold flex items-center gap-2 no-underline">
                                                <i class="bi bi-plus-circle text-orange-500"></i>
                                                <span class="bg-linear-to-r text-orange-500 bg-clip-text">Tambah
                                                    Resep</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.tags.index') }}"
                                                class="px-4 py-2 hover:bg-orange-50 text-sm font-bold flex items-center gap-2 no-underline">
                                                <i class="bi bi-tags text-orange-500"></i>
                                                <span class="bg-linear-to-r text-orange-500 bg-clip-text">Kelola
                                                    Kategori</span>
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-left block px-4 py-2 text-red-500 hover:bg-red-50 text-sm cursor-pointer">
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="no-underline transition-colors duration-300 ease-in-out text-sm font-bold py-2 px-3"
                                :class="{{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }}
                                    &&
                                    !scrolled ? 'text-white hover:text-white/80' :
                                    'text-gray-500 hover:text-orange-600'">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                                class="no-underline rounded-md px-4 transition-all duration-300 ease-in-out text-sm py-2 font-bold"
                                :class="[
                                    {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} &&
                                    !scrolled ?
                                    'bg-transparent border-2 border-white text-white hover:bg-white hover:text-orange-600' :
                                    'border-0 bg-linear-to-r from-amber-500 to-orange-600 text-white'
                                ]">
                                Daftar
                            </a>
                        @endauth
                    </div>

                    <button
                        class="lg:hidden border-0 bg-transparent transition-all duration-1000 ease-in-out py-1 cursor-pointer"
                        type="button" @click="mobileMenuOpen = !mobileMenuOpen">
                        <i class="bi text-2xl"
                            :class="[
                                mobileMenuOpen ? 'bi-x' : 'bi-list',
                                {{ in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? 'true' : 'false' }} &&
                                !scrolled && !mobileMenuOpen ? 'text-white' : 'text-gray-900'
                            ]"></i>
                    </button>

                </div>


                <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="absolute top-full right-0 min-w-70 max-w-80 bg-white/95 backdrop-blur-xl border border-gray-100 rounded-2xl p-4 flex flex-col gap-3 lg:hidden shadow-2xl"
                    @click.outside="mobileMenuOpen = false">

                    @auth
                        <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            Menu User
                        </div>

                        <a href="{{ route('profile.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-orange-50 text-orange-600 font-bold transition-colors">
                            <i class="bi bi-person-circle text-orange-500"></i>
                            <span class="bg-linear-to-r text-orange-500 bg-clip-text">
                                Profil Saya</span>
                        </a>

                        @if (Auth::user()->is_admin)
                            <a href="{{ route('recipes.create') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-orange-50 text-orange-600 font-bold transition-colors">
                                <i class="bi bi-plus-circle text-lg"></i>
                                Tambah Resep
                            </a>
                            <a href="{{ route('admin.tags.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-orange-50 text-orange-600 font-bold transition-colors">
                                <i class="bi bi-tags text-lg"></i>
                                Kelola Kategori
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 text-red-500 font-bold transition-colors text-left cursor-pointer">
                                <i class="bi bi-box-arrow-right text-lg"></i>
                                Keluar
                            </button>
                        </form>
                    @else
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('login') }}"
                                class="flex items-center justify-center py-3 rounded-full border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors no-underline">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                                class="flex items-center justify-center py-3 rounded-full bg-linear-to-r from-amber-500 to-orange-600 text-white font-bold transition-all no-underline">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>

            </div>
        </nav>

        <main
            class="page-content {{ !in_array(request()->route()->getName(), ['recipes.index', 'login', 'register']) ? '' : '' }}">

            @yield('content')

        </main>

        @if (!in_array(request()->route()->getName(), ['login', 'register']))
            <footer class="bg-white border-t border-gray-200 py-4">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <p class="text-gray-500 text-sm mb-0">
                        &copy; {{ date('Y') }} Food Reviews.
                        Dibuat di Lombok.
                    </p>
                </div>
            </footer>
        @endif

    </div>

    <div class="fixed top-0 right-0 p-3 z-9999 flex flex-col gap-2">
        @if (session('status'))
            <div class="toast flex items-center text-white bg-linear-to-r from-amber-500 to-orange-600 border-0 rounded-xl"
                role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="flex items-center flex-1">
                    <div class="toast-body flex items-center px-4 py-3">
                        <i class="bi bi-check-circle-fill mr-2 text-lg"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button type="button" class="toast-close p-2 mr-2 text-white/80 hover:text-white"
                        aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="toast flex items-center text-white bg-red-500 border-0 rounded-xl" role="alert"
                aria-live="assertive" aria-atomic="true" data-delay="7000">
                <div class="flex flex-1">
                    <div class="toast-body px-4 py-3">
                        <div class="flex items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill mr-2 text-lg"></i>
                            <strong>Perhatian</strong>
                        </div>
                        <ul class="mb-0 pl-4 text-sm list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="toast-close p-2 mr-2 text-white/80 hover:text-white self-start mt-2"
                        aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Confirm Modal -->
    <div id="confirm-modal" x-data="{
        open: false,
        title: '',
        message: '',
        formToSubmit: null,
        show(form, title, message) {
            this.formToSubmit = form;
            this.title = title || 'Konfirmasi Hapus';
            this.message = message || 'Apakah Anda yakin ingin menghapus ini?';
            this.open = true;
        },
        confirm() {
            if (this.formToSubmit) {
                this.formToSubmit.submit();
            }
            this.open = false;
        },
        cancel() {
            this.formToSubmit = null;
            this.open = false;
        }
    }" x-cloak
        @open-confirm-modal.window="show($event.detail.form, $event.detail.title, $event.detail.message)">

        <div x-show="open" class="fixed inset-0 z-9999 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <!-- Background overlay -->
                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="cancel()">
                </div>

                <!-- Modal panel -->
                <div x-show="open" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl sm:p-8">

                    <!-- Icon -->
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 rounded-full bg-red-100">
                        <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-center text-gray-900 mb-2" x-text="title"></h3>

                    <!-- Message -->
                    <p class="text-center text-gray-500 mb-8" x-text="message"></p>

                    <!-- Buttons -->
                    <div class="flex flex-col-reverse sm:flex-row gap-3">
                        <button type="button" @click="cancel()"
                            class="flex-1 px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </button>
                        <button type="button" @click="confirm()"
                            class="flex-1 px-6 py-3 text-sm font-semibold text-white bg-linear-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 transition-all focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Global function to show confirm modal
        function showConfirmModal(form, title, message) {
            window.dispatchEvent(new CustomEvent('open-confirm-modal', {
                detail: {
                    form,
                    title,
                    message
                }
            }));
            return false;
        }

        AOS.init({
            duration: 900,
            once: true,
            offset: 60
        });

        document.addEventListener('DOMContentLoaded', function() {
            const toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(function(toastEl) {
                toastEl.classList.add('show');
                const delay = parseInt(toastEl.dataset.delay) || 5000;
                setTimeout(() => {
                    toastEl.classList.add('hide');
                    setTimeout(() => toastEl.remove(), 300);
                }, delay);

                const closeBtn = toastEl.querySelector('.toast-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        toastEl.classList.add('hide');
                        setTimeout(() => toastEl.remove(), 300);
                    });
                }
            });
        });
    </script>

</body>

</html>
