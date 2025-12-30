@extends('layouts.app')

@section('content')

    <section
        class="relative w-full h-screen overflow-hidden flex items-center justify-center text-center text-white bg-black"
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

        <template x-for="(img, index) in images" :key="index">
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-2000e-in-out"
                :style="`background-image: url('${img}')`" :class="activeSlide === index ? 'opacity-100' : 'opacity-0'">
            </div>
        </template>

        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <div class="absolute inset-0 bg-linear-to-trom-black/90 via-transparent to-black/30 z-10"></div>

        <div class="relative z-20 container px-4 md:px-0 flex flex-col items-center justify-center h-full">

            <div class="mb-8" data-aos="fade-down" data-aos-duration="1200">
                <span
                    class="px-5 py-2 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-xs font-bold tracking-[0.2em] uppercase text-white/90 shadow-lg">
                    Food Reviews Community
                </span>
            </div>

            <h1 class="text-5xl md:text-8xl font-extrabold mb-6 tracking-tight leading-tight text-white drop-shadow-2xl"
                data-aos="fade-up" data-aos-duration="1200">
                Jelajahi <br class="md:hidden" />
                <span class="bg-linear-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">
                    Resep Favoritmu
                </span>
            </h1>

            <p class="text-lg md:text-xl text-gray-100 mb-10 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md"
                data-aos="fade-up" data-aos-delay="200" data-aos-duration="1200">
                Temukan inspirasi masak harian dari komunitas.
                Cari, masak, dan bagikan pengalaman kulinermu.
            </p>

            <div class="w-full max-w-2xl" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                <form action="{{ route('recipes.index') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <i class="bi bi-search text-white text-xl group-focus-within:text-amber-500 transition-colors"></i>
                    </div>

                    <input type="text" name="q" value="{{ request('q') }}"
                        class="w-full py-3 pl-14 pr-6 rounded-full bg-transparent border border-white text-white placeholder-white/80 focus:outline-none focus:bg-white/10 focus:border-amber-500 transition-all duration-300 shadow-lg text-base"
                        placeholder="Mau masak apa hari ini?" autocomplete="off">

                    @if (request('tags') && is_array(request('tags')))
                        @foreach (request('tags') as $tag)
                            <input type="hidden" name="tags[]" value="{{ $tag }}">
                        @endforeach
                    @elseif(request('tags'))
                        <input type="hidden" name="tags[]" value="{{ request('tags') }}">
                    @endif
                    @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>
            </div>

        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce duration-2000">
            <i class="bi bi-chevron-down text-white/40 text-2xl"></i>
        </div>
    </section>

    <section class="relative z-30 -mt-12 md:-mt-20 px-4 lg:px-6 mb-20 w-full">
        <div class="w-full">
            @include('components.filter-bar', [
                'filters' => $filters,
                'tags' => $tags,
                'sort' => $sort ?? 'newest',
                'diets' => $diets,
                'hideSearch' => true,
            ])
        </div>
    </section>

    <section class="pb-24 min-h-screen relative overflow-hidden" id="recipe-results">

        <div
            class="absolute top-0 right-0 w-96 h-96 bg-orange-100/30 dark:bg-orange-900/20 rounded-full blur-3xl -z-10 translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-125 h-125 bg-amber-50/40 dark:bg-amber-900/20 rounded-full blur-3xl -z-10 -translate-x-1/3 translate-y-1/3">
        </div>

        <div class="w-full max-w-400 mx-auto px-6 md:px-12">

            <div class="mb-12 text-center" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-gray-100 mb-4 tracking-tight">Jelajahi Resep</h2>
                <div class="w-20 h-1.5 bg-linear-to-r from-amber-400 to-orange-500 rounded-full mx-auto"></div>
            </div>

            <div x-data="recipeTable()" id="recipe-list-container" class="relative min-h-[400px]">
                <!-- Loading Overlay -->
                <div x-show="loading" x-transition.opacity
                    class="absolute inset-0 z-50 bg-white/50 dark:bg-neutral-950/50 backdrop-blur-[2px] flex items-center justify-center rounded-3xl">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 border-4 border-orange-500/20 border-t-orange-500 rounded-full animate-spin"></div>
                        <span class="text-orange-600 font-bold text-sm tracking-widest uppercase animate-pulse">Memuat...</span>
                    </div>
                </div>

                <div id="recipe-results-content" :class="{ 'opacity-50 pointer-events-none transition-opacity duration-300': loading }">
                    @include('recipes._recipe_list')
                </div>
            </div>

            <script>
                function recipeTable() {
                    return {
                        loading: false,
                        init() {
                            // Listen for clicks on pagination links inside our container
                            this.$el.addEventListener('click', (e) => {
                                const link = e.target.closest('a.pagination-link') || e.target.closest('.pagination-links a');
                                if (link) {
                                    e.preventDefault();
                                    this.fetchRecipes(link.href);
                                }
                            });
                        },
                        async fetchRecipes(url) {
                            this.loading = true;
                            try {
                                const response = await fetch(url, {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                });
                                const html = await response.text();
                                document.getElementById('recipe-results-content').innerHTML = html;
                                
                                // Scroll to results smoothly
                                document.getElementById('recipe-results').scrollIntoView({ behavior: 'smooth', block: 'start' });
                                
                                // Update URL without refreshing (DISABLED per user request to keep Dashboard/Page static)
                                // window.history.pushState({}, '', url);
                                
                                // Re-trigger AOS if it exists
                                if (window.AOS) {
                                    window.AOS.refresh();
                                }
                            } catch (error) {
                                console.error('Error fetching recipes:', error);
                                alert('Gagal memuat resep. Silakan coba lagi.');
                            } finally {
                                this.loading = false;
                            }
                        }
                    }
                }
            </script>

        </div>
    </section>

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
