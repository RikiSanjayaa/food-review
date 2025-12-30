@extends('layouts.app')

@section('content')
    {{-- Search/Filter Header --}}
    <section class="py-12 bg-gray-50 dark:bg-neutral-900 border-b border-gray-100 dark:border-neutral-800">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-gray-100 mb-2 tracking-tight">Katalog
                        <span class="text-orange-500">Resep</span>
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400">Temukan ribuan inspirasi memasak dari seluruh penjuru dunia.
                    </p>
                </div>

                <div class="w-full max-w-md">
                    <form action="{{ route('recipes.index') }}" method="GET" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-search text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}"
                            class="w-full py-4 pl-12 pr-6 rounded-full bg-white dark:bg-neutral-800 border-2 border-transparent focus:border-orange-500 text-gray-900 dark:text-white shadow-sm outline-none transition-all"
                            placeholder="Cari masakan favoritmu...">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 px-4 lg:px-6">
        <div class="container mx-auto">
            @include('components.filter-bar', [
                'filters' => $filters,
                'tags' => $tags,
                'sort' => $sort ?? 'newest',
                'diets' => $diets,
                'hideSearch' => true,
            ])
        </div>
    </section>

    <section class="pb-12 relative overflow-hidden" id="recipe-results">
        <div class="w-full max-w-7xl mx-auto px-6">
            <div x-data="recipeTable()" id="recipe-list-container" class="relative">
                <!-- Loading Overlay -->
                <div x-show="loading" x-transition.opacity
                    class="absolute inset-0 z-50 bg-white/50 dark:bg-neutral-950/50 backdrop-blur-[2px] flex items-center justify-center rounded-3xl">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 border-4 border-orange-500/20 border-t-orange-500 rounded-full animate-spin">
                        </div>
                        <span
                            class="text-orange-600 font-bold text-sm tracking-widest uppercase animate-pulse">Memuat...</span>
                    </div>
                </div>

                <div id="recipe-results-content"
                    :class="{ 'opacity-50 pointer-events-none transition-opacity duration-300': loading }">
                    @include('recipes._recipe_list')
                </div>
            </div>

            <script>
                function recipeTable() {
                    return {
                        loading: false,
                        init() {
                            this.$el.addEventListener('click', (e) => {
                                const link = e.target.closest('a.pagination-link') || e.target.closest(
                                    '.pagination-links a');
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

                                document.getElementById('recipe-results').scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });

                                // For the main index page, updating URL is actually useful for sharing searches
                                window.history.pushState({}, '', url);

                                if (window.AOS) {
                                    window.AOS.refresh();
                                }
                            } catch (error) {
                                console.error('Error fetching recipes:', error);
                            } finally {
                                this.loading = false;
                            }
                        }
                    }
                }
            </script>
        </div>
    </section>
@endsection
