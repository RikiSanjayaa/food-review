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
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-[2000ms] ease-in-out"
                :style="`background-image: url('${img}')`"
                :class="activeSlide === index ? 'opacity-100' : 'opacity-0'">
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
                           
                    @if(request('tags') && is_array(request('tags')))
                        @foreach(request('tags') as $tag)
                            <input type="hidden" name="tags[]" value="{{ $tag }}">
                        @endforeach
                    @elseif(request('tags'))
                         <input type="hidden" name="tags[]" value="{{ request('tags') }}">
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

    {{-- FILTER SECTION --}}
    <section class="relative z-30 -mt-12 md:-mt-20 px-4 lg:px-6 mb-20 w-full">
        <div class="w-full">
            @include('components.filter-bar', [
                'filters' => $filters,
                'tags' => $tags,
                'sort' => $sort ?? 'newest',
                'hideSearch' => true
            ])
        </div>
    </section>

    {{-- =========================
    RECIPE GRID (Bento & Breathable)
    ========================= --}}
    <section class="pb-24 min-h-screen relative overflow-hidden" id="recipe-results">
        
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-100/30 rounded-full blur-3xl -z-10 translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-amber-50/40 rounded-full blur-3xl -z-10 -translate-x-1/3 translate-y-1/3"></div>

        <div class="w-full max-w-[1600px] mx-auto px-6 md:px-12">

            {{-- Section Title --}}
            <div class="mb-12 text-center" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Jelajahi Resep</h2>
                <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full mx-auto"></div>
            </div>

            @if ($recipes->isEmpty())
                <div class="flex flex-col items-center justify-center py-32 text-center" data-aos="fade-up">
                    <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mb-8 shadow-inner">
                        <i class="bi bi-search text-5xl text-gray-300"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-3">Tidak ditemukan</h3>
                    <p class="text-gray-500 text-lg max-w-lg mx-auto leading-relaxed">Maaf, kami tidak menemukan resep yang cocok dengan pencarian Anda. Coba kata kunci lain atau reset filter.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($recipes as $loop => $recipe)
                        {{-- CARD ITEM --}}
                        <div class="group h-full" 
                             data-aos="fade-up" 
                             data-aos-delay="{{ ($loop->index % 4) * 100 }}" 
                             data-aos-duration="1000">
                            
                            <a href="{{ route('recipes.show', $recipe) }}" class="block h-full bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-orange-100/60 transition-all duration-500 transform hover:-translate-y-2 relative border border-gray-100/50">
                                
                                {{-- Image Wrapper --}}
                                <div class="relative w-full aspect-video overflow-hidden bg-gray-100 group-hover:brightness-[1.02] transition-all">
                                    @if ($recipe->hero_image)
                                        <img src="{{ Storage::url($recipe->hero_image) }}" 
                                             class="w-full h-full object-cover transform scale-100 group-hover:scale-110 transition-transform duration-700 ease-in-out"
                                             alt="{{ $recipe->title }}"
                                             loading="lazy">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 gap-1 bg-gray-50">
                                            <i class="bi bi-card-image text-3xl opacity-50"></i>
                                            <span class="text-[10px] uppercase tracking-widest font-bold opacity-30">No Image</span>
                                        </div>
                                    @endif
                                    
                                    {{-- Overlay (Gradient Bottom) --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>

                                    {{-- Time Badge (Top Left) --}}
                                    @if ($recipe->totalTime())
                                        <div class="absolute top-3 left-3">
                                            <div class="bg-black/40 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-white border border-white/10 flex items-center gap-1.5 shadow-sm">
                                                <i class="bi bi-clock text-amber-400"></i> {{ $recipe->totalTime() }}m
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Rating Badge (Top Right) --}}
                                    <div class="absolute top-3 right-3">
                                        <div class="bg-white/95 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-extrabold text-gray-900 border border-white/20 flex items-center gap-1 shadow-sm">
                                            <i class="bi bi-star-fill text-amber-400"></i> {{ number_format($recipe->rating_avg, 1) }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-4 flex flex-col h-full bg-white relative">
                                    
                                    {{-- Tags (Modern Pills) --}}
                                    <div class="flex flex-wrap gap-1.5 mb-2.5">
                                        @php
                                            $tags_styles = [
                                                'bg-orange-50 text-orange-600 border-orange-100', 
                                                'bg-blue-50 text-blue-600 border-blue-100', 
                                                'bg-emerald-50 text-emerald-600 border-emerald-100', 
                                            ];
                                        @endphp
                                        @foreach ($recipe->tags->take(2) as $index => $tag)
                                            <div class="px-2 py-[3px] rounded-md text-[9px] uppercase tracking-widest font-bold border {{ $tags_styles[$index % 3] }}">
                                                {{ $tag->name }}
                                            </div>
                                        @endforeach
                                        @if($recipe->tags->count() > 2)
                                            <div class="px-2 py-[3px] rounded-md text-[9px] font-bold text-gray-400 bg-gray-50 border border-gray-100">
                                                +{{ $recipe->tags->count() - 2 }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Title --}}
                                    <h3 class="text-[15px] font-extrabold text-gray-900 mb-1.5 leading-snug group-hover:text-orange-600 transition-colors line-clamp-1 tracking-tight">
                                        {{ $recipe->title }}
                                    </h3>

                                    {{-- Description --}}
                                    <p class="text-gray-500 text-[11px] leading-relaxed mb-2 line-clamp-2 font-medium tracking-wide">
                                        {{ Str::limit($recipe->description, 90) }}
                                    </p>

                                    {{-- Separator --}}
                                    <div class="border-t border-gray-100 w-full my-2"></div>

                                    {{-- Footer (Actionable) --}}
                                    <div class="flex items-center justify-between">
                                        
                                        {{-- Reviews --}}
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500 font-medium group-hover:text-orange-500 transition-colors">
                                            <i class="bi bi-chat-text-fill text-orange-400"></i>
                                            <span>
                                                <span class="font-bold text-gray-700 group-hover:text-orange-600">{{ $recipe->visible_reviews_count ?? 0 }}</span> Ulasan
                                            </span>
                                        </div>
                                        
                                        {{-- Link --}}
                                        <div class="flex items-center gap-1 text-xs font-bold text-gray-700 group-hover:text-orange-600 transition-colors">
                                            Lihat Detail Resep <i class="bi bi-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-20 flex justify-center" data-aos="fade-up">
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
