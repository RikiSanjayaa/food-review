@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <!-- Floating Back Button -->
        <a href="{{ url()->previous() }}"
            class="fixed bottom-8 right-8 w-14 h-14 bg-linear-to-br from-amber-500 to-orange-600 text-white rounded-full flex items-center justify-center text-2xl shadow-lg shadow-orange-600/35 transition-all z-1000 no-underline hover:from-amber-600 hover:to-orange-700 hover:-translate-y-1 hover:scale-105 hover:shadow-xl hover:shadow-orange-600/50 active:-translate-y-0.5 active:scale-100 max-md:bottom-6 max-md:right-6 max-md:w-13 max-md:h-13 max-md:text-xl max-sm:bottom-4 max-sm:right-4 max-sm:w-12 max-sm:h-12 max-sm:text-lg"
            title="Kembali">
            <i class="bi bi-arrow-left leading-none"></i>
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 py-10">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Hero Image & Header -->
                <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-2xl overflow-hidden mb-4" data-aos="fade-up">

                    @php
                        $allImages = collect();
                        if ($recipe->hero_image) {
                            $allImages->push($recipe->hero_image);
                        }
                        foreach ($recipe->images as $img) {
                            $allImages->push($img->image_path);
                        }
                    @endphp

                    @if ($allImages->count() > 1)
                        <!-- Alpine.js Carousel -->
                        <div x-data="{
                                    activeSlide: 0,
                                    total: {{ $allImages->count() }},
                                    next() { this.activeSlide = (this.activeSlide === this.total - 1) ? 0 : this.activeSlide + 1 },
                                    prev() { this.activeSlide = (this.activeSlide === 0) ? this.total - 1 : this.activeSlide - 1 },
                                    autoPlay() { setInterval(() => { this.next() }, 5000) }
                                }" x-init="autoPlay()" class="relative w-full h-96 group">

                            <!-- Slides -->
                            @foreach ($allImages as $index => $image)
                                <div x-show="activeSlide === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                                    x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                                    class="absolute inset-0 w-full h-full">
                                    <img src="{{ Storage::url($image) }}" alt="{{ $recipe->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach

                            <!-- Navigation Arrows (Transparent) -->
                            <button @click="prev()"
                                class="absolute left-2 top-1/2 -translate-y-1/2 p-2 text-white/70 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100">
                                <i class="bi bi-chevron-left text-4xl drop-shadow-md"></i>
                            </button>
                            <button @click="next()"
                                class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-white/70 hover:text-white transition-colors duration-300 opacity-0 group-hover:opacity-100">
                                <i class="bi bi-chevron-right text-4xl drop-shadow-md"></i>
                            </button>

                            <!-- Dots -->
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                @foreach ($allImages as $index => $image)
                                    <button @click="activeSlide = {{ $index }}"
                                        class="h-2 rounded-full transition-all duration-300 shadow-sm" :class="activeSlide === {{ $index }} ? 'w-6 bg-orange-500' :
                                                        'w-2 bg-white/60 hover:bg-white'">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @elseif ($allImages->count() === 1)
                        <!-- Single Image -->
                        <div class="w-full h-96">
                            <img src="{{ Storage::url($allImages->first()) }}" alt="{{ $recipe->title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <!-- Fallback -->
                        <div
                            class="w-full h-96 bg-gray-100 dark:bg-neutral-700 flex items-center justify-center text-gray-400 dark:text-gray-500">
                            <i class="bi bi-image text-6xl"></i>
                        </div>
                    @endif

                    <div class="p-6 md:p-8">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-3">
                            <div>
                                <h1 class="font-bold text-3xl md:text-4xl mb-2 dark:text-gray-100">{{ $recipe->title }}</h1>
                                <p class="text-gray-500 dark:text-gray-400 mb-0">Oleh <span
                                        class="font-semibold text-gray-900 dark:text-gray-200">{{ $recipe->user?->name ?? 'Anonim' }}</span>
                                </p>
                            </div>
                            <div class="text-right bg-gray-100 dark:bg-neutral-700 p-3 rounded-2xl">
                                <div class="font-bold text-amber-500 text-2xl flex items-center justify-end gap-2">
                                    <i class="bi bi-star-fill"></i> {{ number_format($recipe->rating_avg, 1) }}
                                </div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">{{ $recipe->rating_count }} ulasan
                                </div>
                            </div>
                        </div>

                        @if ($recipe->description)
                            <p class="text-gray-500 dark:text-gray-400 text-base">{{ $recipe->description }}</p>
                        @endif

                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach ($recipe->tags as $tag)
                                <span
                                    class="bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 border border-orange-200 dark:border-orange-800 rounded-full px-3 py-1.5 text-sm font-medium">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <!-- Ingredients Checklist -->
                    <div class="md:col-span-2" data-aos="fade-up" data-aos-delay="100">
                        <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-2xl h-full">
                            <div class="p-6">
                                <h4 class="font-bold mb-4 flex items-center text-lg dark:text-gray-100">
                                    <span
                                        class="bg-linear-to-r from-amber-500 to-orange-600 text-white rounded-full flex items-center justify-center mr-2 w-8 h-8">
                                        <i class="bi bi-basket"></i>
                                    </span>
                                    Bahan-bahan
                                </h4>
                                <div class="flex flex-col gap-2">
                                    @foreach (explode("\n", $recipe->ingredients) as $index => $ingredient)
                                        @if (trim($ingredient))
                                            <label
                                                class="ingredient-item flex items-center gap-3 cursor-pointer p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-neutral-700 transition-all">
                                                <input type="checkbox" id="ing-{{ $index }}" class="sr-only">
                                                <div
                                                    class="checkbox-box w-6 h-6 shrink-0 rounded-lg border-2 border-gray-300 dark:border-neutral-600 flex items-center justify-center transition-all">
                                                    <svg class="checkbox-icon w-4 h-4 text-white transition-all" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <span
                                                    class="ingredient-text text-base text-gray-700 dark:text-gray-300 transition-all">
                                                    {{ trim($ingredient) }}
                                                </span>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cooking Steps -->
                    <div class="md:col-span-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-2xl h-full">
                            <div class="p-6">
                                <h4 class="font-bold mb-4 flex items-center text-lg dark:text-gray-100">
                                    <span
                                        class="bg-linear-to-r from-amber-500 to-orange-600 text-white rounded-full flex items-center justify-center mr-2 w-8 h-8">
                                        <i class="bi bi-fire"></i>
                                    </span>
                                    Cara Membuat
                                </h4>
                                <div class="flex flex-col gap-3">
                                    @foreach (explode("\n", $recipe->steps) as $index => $step)
                                        @if (trim($step))
                                            <div class="flex gap-3 p-3 bg-gray-100 dark:bg-neutral-700 rounded-2xl">
                                                <div class="shrink-0 font-bold text-orange-600 dark:text-orange-400 text-lg">
                                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                                </div>
                                                <div class="text-gray-900 dark:text-gray-200">
                                                    {{ trim($step) }}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recipe Information -->
                <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-2xl mt-6" data-aos="fade-up"
                    data-aos-delay="300">
                    <div class="p-6 md:p-8">
                        <h3 class="font-bold mb-4 text-xl dark:text-gray-100">Informasi Resep</h3>

                        <div class="grid grid-cols-2 gap-3.5 max-lg:grid-cols-1">
                            <div
                                class="bg-white dark:bg-neutral-800 rounded-2xl p-4 text-center border-2 border-gray-200 dark:border-neutral-700 transition-all duration-300 hover:border-orange-500">
                                <i class="bi bi-clock-history block text-2xl text-orange-600 mb-1"></i>
                                <div
                                    class="text-xs font-extrabold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-0.5">
                                    Waktu Persiapan</div>
                                <div class="font-bold text-base text-gray-900 dark:text-gray-100">
                                    {{ $recipe->prep_time ?? '-' }} mnt
                                </div>
                            </div>

                            <div
                                class="bg-white dark:bg-neutral-800 rounded-2xl p-4 text-center border-2 border-gray-200 dark:border-neutral-700 transition-all duration-300 hover:border-orange-500">
                                <i class="bi bi-stopwatch block text-2xl text-orange-600 mb-1"></i>
                                <div
                                    class="text-xs font-extrabold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-0.5">
                                    Waktu Masak</div>
                                <div class="font-bold text-base text-gray-900 dark:text-gray-100">
                                    {{ $recipe->cook_time ?? '-' }} mnt
                                </div>
                            </div>

                            <div
                                class="bg-white dark:bg-neutral-800 rounded-2xl p-4 text-center border-2 border-gray-200 dark:border-neutral-700 transition-all duration-300 hover:border-orange-500">
                                <i class="bi bi-people block text-2xl text-orange-600 mb-1"></i>
                                <div
                                    class="text-xs font-extrabold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-0.5">
                                    Porsi</div>
                                <div class="font-bold text-base text-gray-900 dark:text-gray-100">
                                    {{ $recipe->servings ?? '-' }} org
                                </div>
                            </div>

                            <div
                                class="bg-white dark:bg-neutral-800 rounded-2xl p-4 text-center border-2 border-gray-200 dark:border-neutral-700 transition-all duration-300 hover:border-orange-500">
                                <i class="bi bi-globe-americas block text-2xl text-orange-600 mb-1"></i>
                                <div
                                    class="text-xs font-extrabold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-0.5">
                                    Asal Masakan</div>
                                <div class="font-bold text-base text-gray-900 dark:text-gray-100">
                                    {{ $recipe->cuisine ?? '-' }}
                                </div>
                            </div>

                            <!-- Full width -->
                            <div
                                class="col-span-2 max-lg:col-span-1 bg-white dark:bg-neutral-800 rounded-2xl p-4 text-center border-2 border-gray-200 dark:border-neutral-700 transition-all duration-300 hover:border-orange-500">
                                <i class="bi bi-bar-chart-fill block text-2xl text-orange-600 mb-1"></i>
                                <div
                                    class="text-xs font-extrabold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-0.5">
                                    Tingkat Kesulitan</div>
                                <div class="font-bold text-base text-gray-900 dark:text-gray-100 capitalize">
                                    {{ $recipe->difficulty ?? '-' }}
                                </div>
                            </div>
                        </div>

                        @can('update', $recipe)
                            <hr class="my-4 border-gray-200 dark:border-neutral-700">
                            <div class="flex gap-2 flex-wrap">
                                <a href="{{ route('recipes.edit', $recipe) }}"
                                    class="px-4 py-2 border border-gray-300 dark:border-neutral-600 text-gray-700 dark:text-gray-300 rounded-full font-bold hover:bg-gray-100 dark:hover:bg-neutral-700 transition no-underline flex-1 text-center">
                                    <i class="bi bi-pencil mr-1"></i> Edit Resep
                                </a>
                                <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
                                    onsubmit="return showConfirmModal(this, 'Hapus Resep', 'Apakah Anda yakin ingin menghapus resep ini? Tindakan ini tidak dapat dibatalkan.')"
                                    class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-red-500 text-white rounded-full font-bold hover:bg-red-600 transition cursor-pointer">
                                        <i class="bi bi-trash mr-1"></i> Hapus Resep
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1" x-data="sidebarHeight()" x-init="init()">
                <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-2xl lg:sticky lg:top-24" data-aos="fade-left">
                    <div class="p-4 flex flex-col" :style="maxHeightStyle">
                        <h5 class="font-bold mb-4 dark:text-gray-100 shrink-0">Ulasan Komunitas</h5>

                        <!-- Star Filter -->
                        @if (!empty($ratingDistribution) && array_sum($ratingDistribution) > 0)
                            <div class="mb-4 shrink-0" x-data="starFilter()">
                                <div class="flex flex-wrap gap-1.5">
                                    <button @click="filterBy(null)"
                                        class="px-3 py-1.5 rounded-full text-xs font-bold transition-all border"
                                        :class="currentFilter === null
                                            ? 'bg-orange-500 text-white border-orange-500'
                                            : 'bg-gray-100 dark:bg-neutral-700 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-neutral-600 hover:border-orange-400'">
                                        Semua
                                    </button>
                                    @for ($star = 5; $star >= 1; $star--)
                                        @php $count = $ratingDistribution[$star] ?? 0; @endphp
                                        @if ($count > 0)
                                            <button @click="filterBy({{ $star }})"
                                                class="px-3 py-1.5 rounded-full text-xs font-bold transition-all border flex items-center gap-1"
                                                :class="currentFilter === {{ $star }}
                                                    ? 'bg-orange-500 text-white border-orange-500'
                                                    : 'bg-gray-100 dark:bg-neutral-700 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-neutral-600 hover:border-orange-400'">
                                                <i class="bi bi-star-fill text-amber-400" :class="currentFilter === {{ $star }} && 'text-white'"></i>
                                                {{ $star }}
                                                <span class="text-[10px] opacity-70">({{ $count }})</span>
                                            </button>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @endif

                        @auth
                            @include('reviews._form', ['recipe' => $recipe])
                        @else
                            <div class="bg-gray-100 dark:bg-neutral-700 rounded-2xl text-center py-8 mb-4 shrink-0">
                                <i class="bi bi-lock text-4xl text-gray-300 dark:text-gray-500 block mb-2"></i>
                                <p class="text-sm mb-0 dark:text-gray-400">Silakan <a href="{{ route('login') }}"
                                        class="text-orange-600 dark:text-orange-400 font-bold no-underline hover:underline">masuk</a>
                                    untuk memberikan ulasan.</p>
                            </div>
                        @endauth

                        <div x-data="reviewPagination()" id="review-list-container" class="relative flex-1 overflow-y-auto min-h-0">
                            <!-- Review Loading Overlay -->
                            <div x-show="loading" x-transition.opacity
                                class="absolute inset-0 z-50 bg-white/50 dark:bg-neutral-800/50 backdrop-blur-[1px] flex items-center justify-center rounded-2xl">
                                <div
                                    class="w-8 h-8 border-3 border-orange-500/20 border-t-orange-500 rounded-full animate-spin">
                                </div>
                            </div>

                            <div id="review-list-content"
                                :class="{ 'opacity-50 pointer-events-none transition-opacity duration-300': loading }">
                                @include('reviews._list', ['reviews' => $reviews, 'recipe' => $recipe])
                            </div>
                        </div>

                        <script>
                            function reviewPagination() {
                                return {
                                    loading: false,
                                    init() {
                                        this.$el.addEventListener('click', (e) => {
                                            const link = e.target.closest('a.pagination-link') || e.target.closest('.pagination-links a');
                                            if (link) {
                                                e.preventDefault();
                                                this.fetchReviews(link.href);
                                            }
                                        });
                                    },
                                    async fetchReviews(url) {
                                        this.loading = true;
                                        try {
                                            const response = await fetch(url, {
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                }
                                            });
                                            const html = await response.text();
                                            const reviewContent = document.getElementById('review-list-content');
                                            reviewContent.innerHTML = html;

                                            // Re-initialize Alpine.js for new elements
                                            if (window.Alpine) {
                                                Alpine.initTree(reviewContent);
                                            }
                                        } catch (error) {
                                            console.error('Error fetching reviews:', error);
                                        } finally {
                                            this.loading = false;
                                        }
                                    }
                                }
                            }

                            function sidebarHeight() {
                                return {
                                    maxHeightStyle: '',
                                    init() {
                                        this.calculateHeight();
                                        window.addEventListener('resize', () => this.calculateHeight());
                                    },
                                    calculateHeight() {
                                        // Only apply on lg screens and up
                                        if (window.innerWidth < 1024) {
                                            this.maxHeightStyle = '';
                                            return;
                                        }
                                        // Calculate: viewport height - sticky top offset - some padding
                                        const viewportHeight = window.innerHeight;
                                        const topOffset = 96; // lg:top-24 = 6rem = 96px
                                        const bottomPadding = 40; // py-10 bottom padding
                                        const maxHeight = viewportHeight - topOffset - bottomPadding;
                                        this.maxHeightStyle = `max-height: ${maxHeight}px`;
                                    }
                                }
                            }

                            function starFilter() {
                                return {
                                    currentFilter: {{ $starFilter ?? 'null' }},
                                    async filterBy(star) {
                                        if (this.currentFilter === star) return;
                                        this.currentFilter = star;

                                        const baseUrl = '{{ route('recipes.show', $recipe) }}';
                                        const url = star ? `${baseUrl}?star=${star}` : baseUrl;

                                        const reviewContent = document.getElementById('review-list-content');

                                        // Show loading state
                                        reviewContent.classList.add('opacity-50', 'pointer-events-none');

                                        try {
                                            const response = await fetch(url, {
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                }
                                            });
                                            const html = await response.text();
                                            reviewContent.innerHTML = html;

                                            // Re-initialize Alpine.js for new elements
                                            if (window.Alpine) {
                                                Alpine.initTree(reviewContent);
                                            }
                                        } catch (error) {
                                            console.error('Error filtering reviews:', error);
                                        } finally {
                                            reviewContent.classList.remove('opacity-50', 'pointer-events-none');
                                        }
                                    }
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection