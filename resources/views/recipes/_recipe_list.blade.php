@if ($recipes->isEmpty())
  <div class="flex flex-col items-center justify-center py-32 text-center" data-aos="fade-up">
    <div class="w-32 h-32 bg-gray-50 dark:bg-neutral-800 rounded-full flex items-center justify-center mb-8 shadow-inner">
      <i class="bi bi-search text-5xl text-gray-300 dark:text-gray-600"></i>
    </div>
    <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-3">Tidak ditemukan</h3>
    <p class="text-gray-500 dark:text-gray-400 text-lg max-w-lg mx-auto leading-relaxed">Maaf, kami tidak menemukan resep
      yang
      cocok dengan pencarian Anda. Coba kata kunci lain atau reset filter.</p>
  </div>
@else
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach ($recipes as $loop => $recipe)
      <div class="group h-full" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}" data-aos-duration="1000">

        <a href="{{ route('recipes.show', $recipe) }}"
          class="block h-full bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-orange-100/60 dark:hover:shadow-orange-900/30 transition-all duration-500 transform hover:-translate-y-2 relative border border-gray-100/50 dark:border-neutral-700 no-underline! text-gray-900! dark:text-gray-100!">

          <div
            class="relative w-full aspect-video overflow-hidden bg-gray-100 dark:bg-neutral-700 group-hover:brightness-[1.02] transition-all">
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
                                      }" x-init="autoPlay()" class="relative w-full h-full group/carousel">

                @foreach ($allImages as $index => $image)
                  <div x-show="activeSlide === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                    class="absolute inset-0 w-full h-full">
                    <img src="{{ Storage::url($image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
                  </div>
                @endforeach

                <!-- Navigation Arrows -->
                <div role="button" @click.prevent.stop="prev()"
                  class="absolute left-1 top-1/2 -translate-y-1/2 p-1 text-white/70 hover:text-white transition-colors duration-300 opacity-0 group-hover/carousel:opacity-100 z-10 cursor-pointer">
                  <i class="bi bi-chevron-left text-2xl drop-shadow-md"></i>
                </div>
                <div role="button" @click.prevent.stop="next()"
                  class="absolute right-1 top-1/2 -translate-y-1/2 p-1 text-white/70 hover:text-white transition-colors duration-300 opacity-0 group-hover/carousel:opacity-100 z-10 cursor-pointer">
                  <i class="bi bi-chevron-right text-2xl drop-shadow-md"></i>
                </div>

                <!-- Dots -->
                <div
                  class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10 opacity-0 group-hover/carousel:opacity-100 transition-opacity">
                  @foreach ($allImages as $index => $image)
                    <div role="button" @click.prevent.stop="activeSlide = {{ $index }}"
                      class="h-1.5 rounded-full transition-all duration-300 shadow-sm cursor-pointer"
                      :class="activeSlide === {{ $index }} ? 'w-4 bg-orange-500' : 'w-1.5 bg-white/60 hover:bg-white'">
                    </div>
                  @endforeach
                </div>
              </div>
            @elseif ($allImages->count() === 1)
              <img src="{{ Storage::url($allImages->first()) }}"
                class="w-full h-full object-cover transform scale-100 group-hover:scale-110 transition-transform duration-700 ease-in-out"
                alt="{{ $recipe->title }}" loading="lazy">
            @else
              <div
                class="w-full h-full flex flex-col items-center justify-center text-gray-300 dark:text-gray-600 gap-1 bg-gray-50 dark:bg-neutral-700">
                <i class="bi bi-card-image text-3xl opacity-50"></i>
                <span class="text-[10px] uppercase tracking-widest font-bold opacity-30">No Image</span>
              </div>
            @endif

            <div
              class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500 pointer-events-none">
            </div>

            @if ($recipe->totalTime())
              <div class="absolute top-3 left-3">
                <div
                  class="bg-black/40 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-white border border-white/10 flex items-center gap-1.5 shadow-sm">
                  <i class="bi bi-clock text-amber-400"></i> {{ $recipe->totalTime() }}m
                </div>
              </div>
            @endif

            <div class="absolute top-3 right-3">
              <div
                class="bg-white/95 dark:bg-neutral-800/95 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-extrabold text-gray-900 dark:text-gray-100 border border-white/20 dark:border-neutral-600 flex items-center gap-1 shadow-sm">
                <i class="bi bi-star-fill text-amber-400"></i>
                {{ number_format($recipe->rating_avg, 1) }}
              </div>
            </div>
          </div>

          <div class="p-4 flex flex-col h-full bg-white dark:bg-neutral-800 relative">

            <div class="flex flex-wrap gap-1.5 mb-2.5">
              @php
                $tags_styles = [
                  'bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 border-orange-100 dark:border-orange-800',
                  'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-800',
                  'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800',
                ];
              @endphp
              @foreach ($recipe->tags->take(2) as $index => $tag)
                <div
                  class="px-2 py-0.75 rounded-md text-[9px] uppercase tracking-widest font-bold border {{ $tags_styles[$index % 3] }}">
                  {{ $tag->name }}
                </div>
              @endforeach
              @if ($recipe->tags->count() > 2)
                <div
                  class="px-2 py-0.75 rounded-md text-[9px] font-bold text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-neutral-700 border border-gray-100 dark:border-neutral-600">
                  +{{ $recipe->tags->count() - 2 }}
                </div>
              @endif
            </div>

            <h3
              class="text-[15px] font-extrabold text-gray-900 dark:text-gray-100 mb-1.5 leading-snug group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors line-clamp-1 tracking-tight">
              {{ $recipe->title }}
            </h3>

            <p
              class="text-gray-500 dark:text-gray-400 text-[11px] leading-relaxed mb-2 line-clamp-2 font-medium tracking-wide">
              {{ Str::limit($recipe->description, 90) }}
            </p>

            <div class="border-t border-gray-100 dark:border-neutral-700 w-full my-2"></div>

            <div class="flex items-center justify-between">

              <div
                class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 font-medium group-hover:text-orange-500 dark:group-hover:text-orange-400 transition-colors">
                <i class="bi bi-chat-text-fill text-orange-400"></i>
                <span>
                  <span
                    class="font-bold text-gray-700 dark:text-gray-300 group-hover:text-orange-600 dark:group-hover:text-orange-400">{{ $recipe->visible_reviews_count ?? 0 }}</span>
                  Ulasan
                </span>
              </div>

              <div
                class="flex items-center gap-1 text-xs font-bold text-gray-700 dark:text-gray-300 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                Lihat Detail Resep <i class="bi bi-arrow-right"></i>
              </div>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  @if ($recipes->hasPages())
    <div class="mt-20 flex items-center justify-between border-t border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-4 py-3 sm:px-6 rounded-2xl shadow-sm" data-aos="fade-up">
      {{-- Mobile: Simple Previous/Next --}}
      <div class="flex flex-1 justify-between sm:hidden">
        @if ($recipes->onFirstPage())
          <span class="relative inline-flex items-center rounded-md border border-gray-300 dark:border-neutral-600 bg-gray-100 dark:bg-neutral-800 px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">Previous</span>
        @else
          <a href="{{ $recipes->previousPageUrl() }}" class="pagination-link relative inline-flex items-center rounded-md border border-gray-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-neutral-700">Previous</a>
        @endif
        @if ($recipes->hasMorePages())
          <a href="{{ $recipes->nextPageUrl() }}" class="pagination-link relative ml-3 inline-flex items-center rounded-md border border-gray-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-neutral-700">Next</a>
        @else
          <span class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 dark:border-neutral-600 bg-gray-100 dark:bg-neutral-800 px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">Next</span>
        @endif
      </div>

      {{-- Desktop: Full pagination --}}
      <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700 dark:text-gray-400">
            Showing
            <span class="font-medium">{{ $recipes->firstItem() }}</span>
            to
            <span class="font-medium">{{ $recipes->lastItem() }}</span>
            of
            <span class="font-medium">{{ $recipes->total() }}</span>
            results
          </p>
        </div>
        <div>
          <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
            {{-- Previous Button --}}
            @if ($recipes->onFirstPage())
              <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-300 dark:text-gray-600 ring-1 ring-inset ring-gray-300 dark:ring-neutral-600 cursor-not-allowed">
                <span class="sr-only">Previous</span>
                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                  <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
              </span>
            @else
              <a href="{{ $recipes->previousPageUrl() }}" class="pagination-link relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 dark:text-gray-500 ring-1 ring-inset ring-gray-300 dark:ring-neutral-600 hover:bg-gray-50 dark:hover:bg-neutral-700 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Previous</span>
                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                  <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
              </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($recipes->getUrlRange(1, $recipes->lastPage()) as $page => $url)
              @if ($page == $recipes->currentPage())
                <span aria-current="page" class="relative z-10 inline-flex items-center bg-orange-500 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500">{{ $page }}</span>
              @elseif ($page == 1 || $page == $recipes->lastPage() || abs($page - $recipes->currentPage()) <= 1)
                <a href="{{ $url }}" class="pagination-link relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 ring-1 ring-inset ring-gray-300 dark:ring-neutral-600 hover:bg-gray-50 dark:hover:bg-neutral-700 focus:z-20 focus:outline-offset-0">{{ $page }}</a>
              @elseif ($page == 2 || $page == $recipes->lastPage() - 1)
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-neutral-600">...</span>
              @endif
            @endforeach

            {{-- Next Button --}}
            @if ($recipes->hasMorePages())
              <a href="{{ $recipes->nextPageUrl() }}" class="pagination-link relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 dark:text-gray-500 ring-1 ring-inset ring-gray-300 dark:ring-neutral-600 hover:bg-gray-50 dark:hover:bg-neutral-700 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Next</span>
                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                  <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </a>
            @else
              <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-300 dark:text-gray-600 ring-1 ring-inset ring-gray-300 dark:ring-neutral-600 cursor-not-allowed">
                <span class="sr-only">Next</span>
                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                  <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </a>
            @endif
          </nav>
        </div>
      </div>
    </div>
  @endif
@endif