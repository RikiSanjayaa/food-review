<form method="GET" action="{{ route('recipes.index') }}"
    class="w-full md:w-[85%] lg:w-[80%] mx-auto relative z-40 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white/40 shadow-[0_20px_40px_-10px_rgba(0,0,0,0.1)] p-6 md:p-10 mb-16 transition-all duration-300"
    data-aos="fade-up" data-aos-duration="1000">

    <div class="mb-6 md:mb-8">
        <label class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-widest mb-3 pl-1">
            <i class="bi bi-tag-fill text-amber-500"></i> Cari Berdasarkan Kategori
        </label>

        <div
            class="flex overflow-x-auto pb-4 md:pb-0 md:flex-wrap gap-2.5 -mx-4 px-4 md:mx-0 md:px-0 scrollbar-hide snap-x">
            @foreach ($tags as $tag)
                <label class="cursor-pointer relative select-none group shrink-0 snap-start">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="peer sr-only"
                        @checked(in_array($tag->id, $filters['tags'] ?? []))>
                    <div
                        class="px-6 py-3 rounded-full border-2 border-gray-100 bg-white text-gray-500 text-sm font-bold transition-all duration-300
                                group-hover:border-amber-400 group-hover:text-amber-600 group-hover:border-2
                                peer-checked:bg-linear-to-r peer-checked:from-amber-500 peer-checked:to-orange-600 peer-checked:text-white
                                whitespace-nowrap">
                        {{ $tag->name }}
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:flex lg:items-center lg:gap-6 gap-3 mb-8 w-full">

        <div class="lg:flex-1 w-full text-left">
            <label
                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1 text-[0.65rem] md:text-xs">Diet</label>
            <div class="relative group">
                <i
                    class="bi bi-leaf absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-amber-500 transition-colors bg-white md:bg-transparent pr-1"></i>
                <select name="diet"
                    class="w-full appearance-none pl-9 md:pl-11 pr-8 md:pr-10 py-3 md:py-3.5 bg-gray-50 border border-transparent hover:bg-white hover:border-amber-200 hover:shadow-sm rounded-2xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 text-gray-700 font-bold cursor-pointer transition-all outline-none text-sm md:text-base truncate">
                    <option value="">Semua</option>
                    @foreach ($diets as $key => $label)
                        <option value="{{ $key }}" @selected(($filters['diet'] ?? '') === $key)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <i
                    class="bi bi-chevron-down absolute right-3 md:right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            </div>
        </div>

        <div class="lg:flex-1 w-full text-left">
            <label
                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1 text-[0.65rem] md:text-xs">Urutkan</label>
            <div class="relative group">
                <i
                    class="bi bi-sort-down absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-amber-500 transition-colors bg-white md:bg-transparent pr-1"></i>
                <select name="sort"
                    class="w-full appearance-none pl-9 md:pl-11 pr-8 md:pr-10 py-3 md:py-3.5 bg-gray-50 border border-transparent hover:bg-white hover:border-amber-200 hover:shadow-sm rounded-2xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 text-gray-700 font-bold cursor-pointer transition-all outline-none text-sm md:text-base truncate">
                    <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>
                        Terbaru
                    </option>
                    <option value="rating" @selected(($filters['sort'] ?? '') === 'rating')>
                        Rating
                    </option>
                    <option value="time" @selected(($filters['sort'] ?? '') === 'time')>
                        Waktu
                    </option>
                </select>
                <i
                    class="bi bi-chevron-up absolute right-3 md:right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            </div>
        </div>

        <div class="lg:flex-1 w-full text-left">
            <label
                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1 text-[0.65rem] md:text-xs">Min
                Waktu</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
                    <span class="text-gray-400 font-bold text-xs md:text-sm">Min</span>
                </div>
                <input type="number" name="time_min" value="{{ $filters['time_min'] ?? '' }}"
                    class="w-full pl-10 md:pl-12 pr-2 md:pr-4 py-3 md:py-3.5 bg-gray-50 border border-transparent hover:bg-white hover:border-amber-200 hover:shadow-sm rounded-2xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 text-center font-bold text-gray-700 placeholder-gray-300 transition-all outline-none text-sm md:text-base"
                    placeholder="0" min="0">
            </div>
        </div>

        <div class="lg:flex-1 w-full text-left">
            <label
                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1 text-[0.65rem] md:text-xs">Max
                Waktu</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
                    <span class="text-gray-400 font-bold text-xs md:text-sm">Max</span>
                </div>
                <input type="number" name="time_max" value="{{ $filters['time_max'] ?? '' }}"
                    class="w-full pl-10 md:pl-12 pr-2 md:pr-4 py-3 md:py-3.5 bg-gray-50 border border-transparent hover:bg-white hover:border-amber-200 hover:shadow-sm rounded-2xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 text-center font-bold text-gray-700 placeholder-gray-300 transition-all outline-none text-sm md:text-base"
                    placeholder="Auto" min="0">
            </div>
        </div>

    </div>

    <div class="flex items-center gap-4 pt-4 md:pt-6 border-t border-gray-100/80 mt-2 justify-between md:justify-end">

        <a href="{{ route('recipes.index') }}"
            class="flex items-center gap-2 text-sm font-bold text-gray-400! hover:text-red-500! transition-colors duration-300 px-2 py-2 order-1 md:order-2 no-underline">
            <i class="bi bi-arrow-counterclockwise text-lg"></i>
            <span class="text-xs md:text-sm uppercase">Reset</span>
        </a>

        <button type="submit"
            class="flex-1 md:flex-none px-6 py-3 border-2 border-amber-100 hover:border-amber-400 md:px-10 md:py-4 bg-linear-to-r from-amber-500 to-orange-600 hover:bg-orange-600 rounded-full! text-white font-bold text-sm transition-colors duration-300 flex items-center justify-center gap-2 md:gap-3 whitespace-nowrap order-2 md:order-1">
            <span>Terapkan Filter</span>
            <i class="bi bi-arrow-right"></i>
        </button>

    </div>

</form>
