@extends('layouts.app')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1543353071-873f17a7a088?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        height: 60vh;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }
    .feature-card {
        transition: transform 0.3s ease;
    }
    .feature-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@section('content')
<div class="hero-section mb-5 shadow" data-aos="fade-up">
    <div class="p-4">
        <h1 class="display-4 fw-bold mb-3">Selamat Datang di Food Review</h1>
        <p class="lead mb-4">Temukan, Bagikan, dan Nikmati Resep Kuliner Terbaik Indonesia</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('recipes.index') }}" class="btn btn-success btn-lg px-4">Jelajahi Resep</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Gabung Sekarang</a>
            @endguest
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 border-0 shadow-sm feature-card bg-white">
            <div class="card-body text-center p-4">
                <div class="mb-3 text-success">
                    <i class="bi bi-search fs-1"></i>
                </div>
                <h3 class="h5 fw-bold">Cari Resep Mudah</h3>
                <p class="text-secondary small">Temukan ribuan resep masakan dari seluruh nusantara dengan fitur pencarian canggih.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 border-0 shadow-sm feature-card bg-white">
            <div class="card-body text-center p-4">
                <div class="mb-3 text-success">
                    <i class="bi bi-pencil-square fs-1"></i>
                </div>
                <h3 class="h5 fw-bold">Tulis Ulasan</h3>
                <p class="text-secondary small">Bagikan pengalaman memasak Anda dan berikan ulasan jujur untuk membantu pengguna lain.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 border-0 shadow-sm feature-card bg-white">
            <div class="card-body text-center p-4">
                <div class="mb-3 text-success">
                    <i class="bi bi-people-fill fs-1"></i>
                </div>
                <h3 class="h5 fw-bold">Komunitas Kuliner</h3>
                <p class="text-secondary small">Bergabunglah dengan komunitas pecinta kuliner yang saling mendukung dan berbagi inspirasi.</p>
            </div>
        </div>
    </div>
</div>
@endsection
