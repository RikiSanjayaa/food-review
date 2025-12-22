@extends('layouts.app')

@section('content')
    <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h5 mb-4">Log in</h1>
                <form method="POST" action="{{ route('login') }}" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password</label>
                        <input type="password" name="password" required class="form-control">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Log in</button>
                </form>
                <p class="text-secondary small mb-0">No account? <a href="{{ route('register') }}" class="text-success">Sign up</a></p>
            </div>
        </div>
    </div>
@endsection

