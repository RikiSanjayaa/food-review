@extends('layouts.app')

@section('content')

@auth
<div class="action-top-wrapper">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-end">
            <a href="{{ route('recipes.create') }}"
               class="btn btn-success rounded-pill px-4 fw-semibold shadow">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Resep
            </a>
        </div>
    </div>
</div>
@endauth

{{-- HERO --}}
<section class="explore-hero">
    <div class="explore-hero-content">

        <span class="hero-badge" data-aos="fade-down">
            Food Reviews
        </span>

        <h1 class="hero-title" data-aos="fade-up">
            Jelajahi Resep Favoritmu
        </h1>

        <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
            Temukan berbagai resep pilihan dari komunitas.
            Jelajahi hidangan populer, lalu gunakan pencarian dan filter
            untuk menemukan menu terbaik sesuai selera Anda.
        </p>

        {{-- HERO CAROUSEL --}}
        <div class="recipe-carousel-wrapper" data-aos="fade-up" data-aos-delay="200">

            <button class="carousel-nav prev" type="button" onclick="scrollCarousel(-1)">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="recipe-carousel" id="heroCarousel">

                <div class="recipe-slide">
                    <img src="{{ asset('images/hero/ayam.jpg') }}" alt="Ayam Goreng">
                    <div class="slide-overlay">
                        <span class="slide-tag">Populer</span>
                        <h4>Ayam Goreng</h4>
                    </div>
                </div>

                <div class="recipe-slide">
                    <img src="{{ asset('images/hero/mie.jpg') }}" alt="Mie Spesial">
                    <div class="slide-overlay">
                        <span class="slide-tag">Favorit</span>
                        <h4>Mie Spesial</h4>
                    </div>
                </div>

                <div class="recipe-slide">
                    <img src="{{ asset('images/hero/salad.jpg') }}" alt="Salad Segar">
                    <div class="slide-overlay">
                        <span class="slide-tag">Sehat</span>
                        <h4>Salad Segar</h4>
                    </div>
                </div>

                <div class="recipe-slide">
                    <img src="{{ asset('images/hero/nasi.jpeg') }}" alt="Nasi Tradisional">
                    <div class="slide-overlay">
                        <span class="slide-tag">Tradisional</span>
                        <h4>Nasi Tradisional</h4>
                    </div>
                </div>

                <div class="recipe-slide">
                    <img src="{{ asset('images/hero/seblak.jpg') }}" alt="Seblak Pedas">
                    <div class="slide-overlay">
                        <span class="slide-tag">Pedas</span>
                        <h4>Seblak Pedas</h4>
                    </div>
                </div>

            </div>

            <button class="carousel-nav next" type="button" onclick="scrollCarousel(1)">
                <i class="bi bi-chevron-right"></i>
            </button>

        </div>
    </div>
</section>

{{-- FILTER SECTION --}}
<section class="search-section">
    <div class="container">
        <div class="filter-outer" data-aos="fade-up">
            @include('components.filter-bar', [
                'filters' => $filters,
                'tags' => $tags,
                'sort' => $sort ?? 'newest',
            ])
        </div>
    </div>
</section>

{{-- =========================
   RECIPE GRID (TARGET SCROLL)
   ========================= --}}
<section class="recipe-section" id="recipe-results">
    <div class="container">

        @if ($recipes->isEmpty())
            <div class="text-center text-secondary py-5">
                <i class="bi bi-search fs-1 mb-3 d-block"></i>
                <p class="mb-0">Belum ada resep yang cocok.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($recipes as $recipe)
                    <div class="col-md-4">
                        <a href="{{ route('recipes.show', $recipe) }}"
                           class="card recipe-card h-100 text-decoration-none text-dark shadow-sm">

                            @if ($recipe->hero_image)
                                <img
                                    src="{{ Storage::url($recipe->hero_image) }}"
                                    class="card-img-top"
                                    alt="{{ $recipe->title }}"
                                    style="height:180px;object-fit:cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light"
                                     style="height:180px;">
                                    <span class="text-secondary small">
                                        Tidak ada gambar
                                    </span>
                                </div>
                            @endif

                            <div class="card-body">

                                <h6 class="fw-bold mb-1">
                                    {{ $recipe->title }}
                                </h6>

                                <p class="small text-secondary mb-2">
                                    {{ Str::limit($recipe->description, 120) }}
                                </p>

                                <div class="d-flex align-items-center gap-3 small text-muted mb-2">
                                    <div class="fw-bold text-success">
                                        ⭐ {{ number_format($recipe->rating_avg, 1) }}
                                    </div>

                                    <span>
                                        {{ $recipe->visible_reviews_count ?? $recipe->rating_count }} ulasan
                                    </span>

                                    @if ($recipe->totalTime())
                                        <span>{{ $recipe->totalTime() }} menit</span>
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($recipe->tags->take(3) as $tag)
                                        <span class="badge text-bg-light">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $recipes->links() }}
            </div>
        @endif

    </div>
</section>

{{-- CAROUSEL SCRIPT --}}
<script>
function scrollCarousel(direction) {
    document.getElementById('heroCarousel').scrollBy({
        left: direction * 320,
        behavior: 'smooth'
    });
}
</script>

{{-- AUTO SCROLL KE HASIL RESEP SETELAH SEARCH --}}
@if(request()->has('q') || request()->has('tags') || request()->has('diet'))
<script>
window.addEventListener('load', function () {
    const target = document.getElementById('recipe-results');
    if (target) {
        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
});
</script>
@endif

@endsection
