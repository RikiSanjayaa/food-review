@extends('layouts.app')

@section('content')

    {{-- HERO --}}
    <section class="explore-hero">
        <div class="explore-hero-content py-5 container">
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
        </div>
    </section>

    {{-- FILTER SECTION --}}
    <section class="search-section">
        <div class="filter-outer container" data-aos="fade-up">
            @include('components.filter-bar', [
                'filters' => $filters,
                'tags' => $tags,
                'sort' => $sort ?? 'newest',
            ])
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
                                    <img src="{{ Storage::url($recipe->hero_image) }}" class="card-img-top"
                                        alt="{{ $recipe->title }}" style="height:180px;object-fit:cover;">
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
                                        <div class="fw-bold text-warning">
                                            <i class="bi bi-star-fill"></i> {{ number_format($recipe->rating_avg, 1) }}
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

    {{-- AUTO SCROLL KE HASIL RESEP SETELAH SEARCH --}}
    @if (request()->has('q') || request()->has('tags') || request()->has('diet'))
        <script>
            window.addEventListener('load', function() {
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
