<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Food Reviews') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light text-dark min-vh-100 d-flex flex-column">
    <header class="border-bottom bg-white sticky-top">
        <div class="container py-3 d-flex align-items-center justify-content-between gap-3">
            <a href="{{ route('recipes.index') }}" class="fw-semibold fs-5 text-success text-decoration-none">Food
                Reviews</a>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <span class="text-secondary small">Hi, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-secondary small text-decoration-none">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-success">
                        Sign up
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="container py-4 grow">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <p class="fw-semibold mb-2">Please fix the following:</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li class="mb-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
