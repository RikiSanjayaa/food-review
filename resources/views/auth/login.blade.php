@extends('layouts.app')

@section('content')
    <div class="position-relative w-100 d-flex align-items-center justify-content-center" 
         style="height: 100vh; overflow: hidden; background: url('{{ asset('images/food-bg.png') }}') no-repeat center center/cover;">
        

        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.5;"></div>
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(234, 88, 12, 0.3));"></div>

        <div class="container position-relative z-2 py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-4">
                    <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="zoom-in" data-aos-duration="800"
                         style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px);">
                        <div class="card-body p-4 p-md-5">
                            
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center bg-gradient-orange-plain text-white rounded-circle mb-3 shadow" 
                                     style="width: 56px; height: 56px; font-size: 1.5rem;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <h2 class="fw-bold text-dark mb-1">Selamat Datang!</h2>
                                <p class="text-secondary small">Masuk untuk mulai berbagi resep.</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="mb-3">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control rounded-4 border-0 bg-light" 
                                           id="emailInput" placeholder="name@example.com" value="{{ old('email') }}" required>
                                    <label for="emailInput" class="text-secondary">Email</label>
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" name="password" class="form-control rounded-4 border-0 bg-light" 
                                           id="passwordInput" placeholder="Password" required>
                                    <label for="passwordInput" class="text-secondary">Kata Sandi</label>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label small text-secondary" for="remember">Ingat Saya</label>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-gradient-orange w-100 py-3 rounded-pill fw-bold shadow-sm mb-3">
                                    Masuk Sekarang
                                </button>
                            </form>
                            
                            <div class="text-center">
                                <p class="text-secondary small mb-0">Belum punya akun? 
                                    <a href="{{ route('register') }}" class="text-orange fw-bold text-decoration-none">Daftar Gratis</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
