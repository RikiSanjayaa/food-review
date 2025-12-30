@props(['recipe'])

<div class="group h-full relative p-4">
    <a href="{{ route('recipes.show', $recipe) }}" class="block no-underline">
        <div
            class="relative aspect-square rounded-3xl overflow-hidden shadow-lg group-hover:shadow-orange-500/20 transition-all duration-500">
            @if ($recipe->hero_image)
                <img src="{{ Storage::url($recipe->hero_image) }}" alt="{{ $recipe->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            @else
                <div class="w-full h-full bg-gray-100 dark:bg-neutral-800 flex items-center justify-center">
                    <i class="bi bi-image text-gray-300 dark:text-gray-700 text-4xl"></i>
                </div>
            @endif

            <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>

            <div class="absolute top-4 left-4">
                <span
                    class="bg-white/20 backdrop-blur-md rounded-full text-[10px] font-bold text-white border border-white/20 px-3 py-1">
                    {{ $recipe->cuisine ?? 'Modern' }}
                </span>
            </div>

            <div class="absolute bottom-6 left-6 right-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="flex items-center text-amber-400 gap-1 text-sm font-black">
                        <i class="bi bi-star-fill text-xs"></i>
                        {{ number_format($recipe->rating_avg, 1) }}
                    </div>
                    <span class="text-white/60 text-[10px]">&bull; {{ $recipe->visible_reviews_count ?? 0 }}
                        Ulasan</span>
                </div>
                <h3
                    class="text-white font-black text-xl leading-tight line-clamp-2 tracking-tight group-hover:text-orange-400 transition-colors">
                    {{ $recipe->title }}
                </h3>
            </div>
        </div>
    </a>
</div>
