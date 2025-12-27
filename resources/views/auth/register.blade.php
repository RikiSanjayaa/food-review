@extends('layouts.app')

@section('content')
    <div class="position-relative w-100 d-flex align-items-center justify-content-center" 
         style="height: 100vh; overflow: hidden; background: url('{{ asset('images/food-bg.png') }}') no-repeat center center/cover;">
        

        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.5;"></div>
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(234, 88, 12, 0.3));"></div>

        <div class="container position-relative z-2 py-5">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5 col-xl-5">
                    <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="zoom-in" data-aos-duration="800"
                         style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px);">
                        <div class="card-body p-4 p-md-5">
                            
                            <div class="text-center mb-4">
                                <h2 class="fw-bold text-dark mb-1">Buat Akun Baru</h2>
                                <p class="text-secondary small">Bergabunglah dengan komunitas pecinta kuliner.</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}" class="mb-3">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" class="form-control rounded-4 border-0 bg-light" 
                                           id="nameInput" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                    <label for="nameInput" class="text-secondary">Nama Lengkap</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control rounded-4 border-0 bg-light" 
                                           id="emailInput" placeholder="name@example.com" value="{{ old('email') }}" required>
                                    <label for="emailInput" class="text-secondary">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" class="form-control rounded-4 border-0 bg-light" 
                                           id="passwordInput" placeholder="Password" required>
                                    <label for="passwordInput" class="text-secondary">Kata Sandi</label>
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" name="password_confirmation" class="form-control rounded-4 border-0 bg-light" 
                                           id="passwordConfirmInput" placeholder="Konfirmasi Password" required>
                                    <label for="passwordConfirmInput" class="text-secondary">Konfirmasi Kata Sandi</label>
                                </div>

                                <button type="submit" class="btn btn-gradient-orange w-100 py-3 rounded-pill fw-bold shadow-sm mb-3">
                                    Daftar Sekarang
                                </button>
                            </form>
                            
                            <div class="text-center">
                                <p class="text-secondary small mb-0">Sudah punya akun? 
                                    <a href="{{ route('login') }}" class="text-orange fw-bold text-decoration-none">Masuk</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
