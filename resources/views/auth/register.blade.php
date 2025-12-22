@extends('layouts.app')

@section('content')
    <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h5 mb-4">Create account</h1>
                <form method="POST" action="{{ route('register') }}" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password</label>
                        <input type="password" name="password" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Confirm password</label>
                        <input type="password" name="password_confirmation" required class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Sign up</button>
                </form>
                <p class="text-secondary small mb-0">Already registered? <a href="{{ route('login') }}" class="text-success">Log in</a></p>
            </div>
        </div>
    </div>
@endsection

