@extends('layouts.app')

@section('content')

    {{-- PREMIUM HERO SECTION --}}
    <section class="relative w-full h-screen overflow-hidden flex items-center justify-center text-center text-white bg-black"
        x-data="{
            activeSlide: 0,
            images: [
                '{{ asset('images/beranda/gambar1.jpg') }}',
                '{{ asset('images/beranda/gambar2.jpg') }}',
                '{{ asset('images/beranda/gambar3.jpg') }}',
                '{{ asset('images/beranda/gambar4.jpg') }}',
                '{{ asset('images/beranda/gambar5.jpg') }}'
            ],
            init() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.images.length;
                }, 7000);
            }
        }">

        {{-- BACKGROUND SLIDER (Absolute Position & Smooth Fade) --}}
        <template x-for="(img, index) in images" :key="index">
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-[3000ms] ease-in-out"
                :style="`background-image: url('${img}')`"
                :class="activeSlide === index ? 'opacity-100 scale-105' : 'opacity-0 scale-100'">
            </div>
        </template>

        {{-- OVERLAY --}}
        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-black/30 z-10"></div>

        {{-- CONTENT --}}
        <div class="relative z-20 container px-4 md:px-0 flex flex-col items-center justify-center h-full">
            
            {{-- BADGE --}}
            <div class="mb-8" data-aos="fade-down" data-aos-duration="1200">
                <span class="px-5 py-2 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-xs font-bold tracking-[0.2em] uppercase text-white/90 shadow-lg">
                    Food Reviews Community
                </span>
            </div>

            {{-- TITLE (Clean & Vibrant Gradient Focal Point) --}}
            <h1 class="text-5xl md:text-8xl font-extrabold mb-6 tracking-tight leading-tight text-white drop-shadow-2xl" 
                data-aos="fade-up" data-aos-duration="1200">
                Jelajahi <br class="md:hidden" />
                <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">
                    Resep Favoritmu
                </span>
            </h1>

            {{-- SUBTITLE --}}
            <p class="text-lg md:text-xl text-gray-100 mb-10 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md" 
               data-aos="fade-up" data-aos-delay="200" data-aos-duration="1200">
                Temukan inspirasi masak harian dari komunitas. 
                Cari, masak, dan bagikan pengalaman kulinermu.
            </p>

            {{-- PREMIUM SEARCH BAR (Sleek & Balanced) --}}
            <div class="w-full max-w-2xl" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                <form action="{{ route('recipes.index') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <i class="bi bi-search text-white text-xl group-focus-within:text-amber-500 transition-colors"></i>
                    </div>
                    
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           class="w-full py-3 pl-14 pr-6 rounded-full bg-transparent border border-white text-white placeholder-white/80 focus:outline-none focus:bg-white/10 focus:border-amber-500 transition-all duration-300 shadow-lg text-base"
                           placeholder="Mau masak apa hari ini?"
                           autocomplete="off">
                           
                    @if(request('tags'))
                        <input type="hidden" name="tags" value="{{ request('tags') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>
            </div>

        </div>

        {{-- SCROLL INDICATOR --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce duration-[2000ms]">
            <i class="bi bi-chevron-down text-white/40 text-2xl"></i>
        </div>
    </section>

    {{-- FILTER SECTION (Moved down/simplified) --}}
    <section class="py-8 bg-white border-bottom relative z-30">
        <div class="container">
            @include('components.filter-bar', [
                'filters' => $filters,
                'tags' => $tags,
                'sort' => $sort ?? 'newest',
                'hideSearch' => true // Optional: Pass a flag to hide search in component if adaptable
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
