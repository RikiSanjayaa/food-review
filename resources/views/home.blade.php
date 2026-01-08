@extends('layouts.app')

@section('content')

    {{-- Hero Section --}}
    <section
        class="relative w-full h-screen overflow-hidden flex items-center justify-center text-center text-white bg-black"
        x-data="{
            activeSlide: 0,
            images: [
                '{{ asset('images/Beranda/gambar1.jpg') }}',
                '{{ asset('images/Beranda/gambar2.jpg') }}',
                '{{ asset('images/Beranda/gambar3.jpg') }}',
                '{{ asset('images/Beranda/gambar4.jpg') }}',
                '{{ asset('images/Beranda/gambar5.jpg') }}'
            ],
            init() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.images.length;
                }, 7000);
            }
        }">

        <template x-for="(img, index) in images" :key="index">
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-2000 ease-in-out"
                :style="`background-image: url('${img}')`" :class="activeSlide === index ? 'opacity-100' : 'opacity-0'">
            </div>
        </template>

        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <div class="absolute inset-0 bg-linear-to-t from-black/90 via-transparent to-black/30 z-10"></div>

        <div class="relative z-20 container px-4 md:px-0 flex flex-col items-center justify-center h-full">
            <div class="mb-8" data-aos="fade-down" data-aos-duration="1200">
                <span
                    class="px-5 py-2 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-xs font-bold tracking-[0.2em] uppercase text-white/90 shadow-lg">
                    Premium Food Community
                </span>
            </div>

            <h1 class="text-5xl md:text-8xl font-extrabold mb-6 tracking-tight leading-tight text-white drop-shadow-2xl"
                data-aos="fade-up" data-aos-duration="1200">
                Cita Rasa <br class="md:hidden" />
                <span class="bg-linear-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">
                    Asli Sasambo
                </span>
            </h1>

            <p class="text-lg md:text-xl text-gray-100 mb-10 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md"
                data-aos="fade-up" data-aos-delay="200" data-aos-duration="1200">
                Dari manisnya persaudaraan hingga pedasnya kebersamaan, temukan cita rasa asli Sasambo di sini.
            </p>

            <div class="flex gap-4" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('recipes.index') }}"
                    class="px-8 py-4 bg-linear-to-r from-amber-500 to-orange-600 rounded-full font-bold text-white shadow-xl hover:scale-105 transition-transform no-underline">
                    Jelajahi Resep
                </a>
                <a href="{{ route('recipes.create') }}"
                    class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/30 rounded-full font-bold text-white hover:bg-white/20 transition-colors no-underline">
                    Bagikan Resep
                </a>
            </div>
        </div>

        <button @click="window.scrollBy({ top: window.innerHeight, behavior: 'smooth' })"
            class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce duration-2000 cursor-pointer hover:scale-110 transition-transform">
            <i class="bi bi-chevron-down text-white/40 hover:text-white/70 text-2xl transition-colors"></i>
        </button>
    </section>

    <style>
        .coverflow-container {
            perspective: 2000px;
            padding: 40px 0;
        }

        .coverflow-card {
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            transform-style: preserve-3d;
            filter: brightness(0.6) contrast(0.9);
        }

        .coverflow-card:hover {
            transform: scale(1.1) translateZ(100px) rotateY(0deg) !important;
            z-index: 100 !important;
            filter: brightness(1) contrast(1);
            box-shadow: 0 50px 100px -20px rgba(186, 73, 1, 0.4);
        }

        /* Dim other cards on hover */
        .group-flow:hover .coverflow-card:not(:hover) {
            filter: brightness(0.4) blur(4px);
            transform: scale(0.9) rotateY(0deg) !important;
            opacity: 0.5;
        }
    </style>

    {{-- Album-style Spotlight --}}
    <section class="py-32 bg-white dark:bg-neutral-950 overflow-hidden">
        <div class="max-w-350uto px-6 mb-20 text-center" data-aos="fade-up">
            <span class="text-xs font-black uppercase tracking-[0.4em] text-orange-500 mb-4 block">The Hall of Fame</span>
            <h2 class="text-5xl md:text-8xl font-black text-gray-900 dark:text-white mb-4 leading-none">
                The <span class="bg-linear-to-r from-orange-400 to-amber-600 bg-clip-text text-transparent">
                    Top Five</span>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-lg max-w-2xl mx-auto">Pilihan kurasi terbaik dengan rating
                tertinggi minggu ini. Eksplorasi cita rasa yang paling dicintai komunitas kami.</p>
        </div>

        {{-- Mobile: Horizontal scroll carousel --}}
        <div class="md:hidden overflow-x-auto scrollbar-hide">
            <div class="flex gap-4 px-6 pb-4" style="width: max-content;">
                @foreach ($popularRecipes->take(5) as $index => $recipe)
                    <div class="relative w-72 shrink-0" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <a href="{{ route('recipes.show', $recipe) }}" class="block no-underline group/card">
                            <div
                                class="relative aspect-4/5 rounded-2xl overflow-hidden shadow-2xl border border-white/5 bg-neutral-900">
                                @if ($recipe->hero_image)
                                    <img src="{{ Storage::url($recipe->hero_image) }}" alt="{{ $recipe->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-linear-to-br from-neutral-800 to-neutral-900 flex items-center justify-center">
                                        <i class="bi bi-egg-fried text-neutral-700 text-5xl"></i>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-x-0 bottom-0 bg-linear-to-t from-black/95 via-black/60 to-transparent p-6 flex flex-col justify-end min-h-[60%]">
                                    <span
                                        class="inline-block w-fit px-3 py-1 bg-orange-600/90 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-3">
                                        #{{ $index + 1 }}
                                    </span>
                                    <h3
                                        class="text-white text-xl font-black tracking-tight leading-tight mb-3 line-clamp-2">
                                        {{ $recipe->title }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="bi bi-star-fill text-amber-500"></i>
                                        <span
                                            class="text-white font-bold">{{ number_format($recipe->rating_avg, 1) }}</span>
                                        <span class="text-white/40 text-xs">({{ $recipe->rating_count }})</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Desktop: Coverflow effect --}}
        <div class="hidden md:flex coverflow-container justify-center items-center">
            <div class="flex -space-x-20 lg:-space-x-32 xl:-space-x-40 2xl:-space-x-48 group-flow">
                @foreach ($popularRecipes->take(5) as $index => $recipe)
                    <div class="coverflow-card relative w-52 lg:w-72 xl:w-96 2xl:w-120 shrink-0 pointer-events-auto rounded-2xl lg:rounded-3xl xl:rounded-[2.5rem]"
                        style="transform: rotateY({{ ($index - 2) * -15 }}deg) rotateZ({{ ($index - 2) * -2 }}deg) translateX({{ ($index - 2) * 30 }}px); z-index: {{ 5 - abs($index - 2) }};"
                        data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">

                        <a href="{{ route('recipes.show', $recipe) }}" class="block no-underline group/card">
                            <div
                                class="relative aspect-3/4 rounded-2xl lg:rounded-3xl xl:rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5 bg-neutral-900">
                                @if ($recipe->hero_image)
                                    <img src="{{ Storage::url($recipe->hero_image) }}" alt="{{ $recipe->title }}"
                                        class="w-full h-full object-cover transition-transform duration-1000 group-hover/card:scale-110">
                                @else
                                    <div
                                        class="w-full h-full bg-linear-to-br from-neutral-800 to-neutral-900 flex items-center justify-center">
                                        <i class="bi bi-egg-fried text-neutral-700 text-6xl"></i>
                                    </div>
                                @endif

                                {{-- Glassmorphism Content Overlay --}}
                                <div
                                    class="absolute inset-x-0 bottom-0 bg-linear-to-t from-black/95 via-black/40 to-transparent p-4 lg:p-6 xl:p-10 flex flex-col justify-end min-h-[50%] opacity-100">
                                    <div class="mb-2 xl:mb-4">
                                        <span
                                            class="px-2 lg:px-3 xl:px-4 py-1 xl:py-1.5 bg-orange-600/90 backdrop-blur-md text-white text-[8px] lg:text-[9px] xl:text-[10px] font-black uppercase tracking-widest xl:tracking-[0.2em] rounded-full">
                                            #{{ $index + 1 }}
                                        </span>
                                    </div>
                                    <h3
                                        class="text-white text-lg lg:text-2xl xl:text-4xl 2xl:text-5xl font-black tracking-tighter leading-[0.9] mb-2 lg:mb-4 xl:mb-6 group-hover/card:text-orange-400 transition-colors line-clamp-2">
                                        {{ $recipe->title }}
                                    </h3>
                                    <div
                                        class="flex items-center justify-between pt-2 lg:pt-4 xl:pt-6 border-t border-white/10 group-hover/card:border-orange-500/30 transition-colors">
                                        <div class="flex items-center gap-1 lg:gap-2 xl:gap-3">
                                            <div class="flex items-center gap-1 text-amber-500">
                                                <i class="bi bi-star-fill text-xs lg:text-sm"></i>
                                                <span
                                                    class="text-sm lg:text-base xl:text-xl font-black text-white italic tracking-tighter">{{ number_format($recipe->rating_avg, 1) }}</span>
                                            </div>
                                            <span
                                                class="text-white/30 text-[8px] lg:text-[9px] xl:text-[10px] font-black uppercase tracking-wider xl:tracking-widest pl-1 lg:pl-2 xl:pl-3 border-l border-white/10 hidden lg:inline">{{ $recipe->rating_count }}
                                                Ratings</span>
                                        </div>
                                        <div
                                            class="w-6 h-6 lg:w-8 lg:h-8 xl:w-10 xl:h-10 rounded-full bg-white/10 flex items-center justify-center group-hover/card:bg-orange-500 transition-all duration-500">
                                            <i class="bi bi-arrow-right text-white text-xs lg:text-sm xl:text-base"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-20 text-center" data-aos="fade-up">
            <a href="{{ route('recipes.index') }}"
                class="group relative inline-flex items-center gap-4 px-12 py-5 bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 rounded-full font-black text-sm uppercase tracking-[0.2em] hover:bg-orange-600 dark:hover:bg-orange-600 hover:text-white transition-all no-underline shadow-2xl">
                Jelajahi Semua Resep
                <i class="bi bi-arrow-right text-lg transition-transform group-hover:translate-x-2"></i>
            </a>
        </div>
    </section>

    {{-- Immersive Bento Spotlight --}}
    <section class="py-32 bg-neutral-50 dark:bg-neutral-900 relative overflow-hidden">
        {{-- Abstract Decorative Elements --}}
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-orange-500/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 w-125 h-125 bg-amber-500/10 rounded-full blur-[150px]"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-24" data-aos="fade-up">
                <span class="text-xs font-black uppercase tracking-[0.4em] text-orange-500 mb-4 block">Our Philosophy</span>
                <h2 class="text-6xl md:text-8xl font-black text-gray-900 dark:text-white tracking-tighter leading-[0.9]">
                    Karya Seni <br /> Dalam <span
                        class="bg-linear-to-r from-orange-400 to-amber-600 bg-clip-text text-transparent overflow-visible">Setiap
                        Suapan</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-6 h-auto md:h-175">
                {{-- Large Bento: Community --}}
                <div class="md:col-span-2 md:row-span-2 bg-white dark:bg-neutral-800 rounded-[3rem] p-12 flex flex-col justify-end relative overflow-hidden group shadow-2xl shadow-gray-200/50 dark:shadow-none"
                    data-aos="fade-right">
                    <div class="absolute top-12 left-12">
                        <i class="bi bi-people-fill text-6xl text-orange-500/20"></i>
                    </div>
                    <div class="relative z-10">
                        <div class="flex gap-4 mb-6">
                            <div class="flex -space-x-4">
                                @foreach ($recentUsers as $user)
                                    <div
                                        class="w-12 h-12 rounded-full border-4 border-white dark:border-neutral-800 bg-gray-200 overflow-hidden ring-2 ring-orange-500/30">
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full bg-linear-to-r from-amber-500 to-orange-600 text-white flex items-center justify-center font-bold text-sm">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                @if ($userCount > 5)
                                    <div
                                        class="w-12 h-12 rounded-full border-4 border-white dark:border-neutral-800 bg-orange-500 flex items-center justify-center text-white text-xs font-bold">
                                        +{{ $userCount - 5 }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-4xl font-black dark:text-white mb-4 tracking-tight">Bergabung dengan <br />
                            {{ number_format($userCount) }} Pecinta
                            Kuliner</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-sm leading-relaxed">Dari koki rumahan hingga
                            profesional,
                            semua berbagi rahasia dapur terbaiknya di sini.</p>
                    </div>
                    {{-- Decorative Circle --}}
                    <div
                        class="absolute -right-20 -top-20 w-64 h-64 border-40 border-orange-500/5 rounded-full group-hover:scale-110 transition-transform duration-700">
                    </div>
                </div>

                <div class="bg-linear-to-br from-orange-500 to-amber-600 rounded-[3rem] p-8 text-white flex flex-col items-center justify-center text-center shadow-xl hover:-translate-y-1.25 transition-transform"
                    data-aos="zoom-in" data-aos-delay="100">
                    <span class="text-6xl font-black mb-2 tracking-tighter">{{ number_format($recipeCount) }}</span>
                    <span class="text-sm font-bold uppercase tracking-widest opacity-80">Resep Terverifikasi</span>
                </div>

                {{-- Bento: Image Accent --}}
                <div class="bg-gray-200 dark:bg-neutral-700 rounded-[3rem] relative overflow-hidden group"
                    data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('images/Beranda/gambar2.jpg') }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000"
                        alt="cooking">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute bottom-6 left-6 text-white font-black text-xl">High Quality <br /> Ingredients
                    </div>
                </div>

                {{-- Bento: Wide Stat (Rising Star) --}}
                @if ($risingStar)
                    <a href="{{ route('users.show', $risingStar) }}"
                        class="md:col-span-2 bg-neutral-900 border border-neutral-800 rounded-[3rem] p-8 flex items-center justify-between group shadow-xl no-underline"
                        data-aos="fade-left" data-aos-delay="300">
                        <div class="flex flex-col">
                            <span class="text-orange-500 text-xs font-black uppercase tracking-widest mb-2 italic">Rising
                                Star Bulan
                                Ini</span>
                            <h4 class="text-white text-2xl font-black tracking-tight">{{ $risingStar->name }}</h4>
                            <p class="text-neutral-500 text-sm mt-1">Berbagi {{ $risingStar->recipes_count }} resep bulan
                                ini</p>
                        </div>
                        <div
                            class="w-20 h-20 rounded-2xl overflow-hidden rotate-3 group-hover:rotate-0 transition-transform duration-500 border-2 border-orange-500">
                            @if ($risingStar->avatar)
                                <img src="{{ asset('storage/' . $risingStar->avatar) }}"
                                    class="w-full h-full object-cover" alt="{{ $risingStar->name }}">
                            @else
                                <div
                                    class="w-full h-full bg-linear-to-r from-amber-500 to-orange-600 text-white flex items-center justify-center font-bold text-2xl">
                                    {{ strtoupper(substr($risingStar->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <i class="bi bi-arrow-up-right text-3xl text-neutral-700 absolute top-8 right-8"></i>
                    </a>
                @else
                    <div class="md:col-span-2 bg-neutral-900 border border-neutral-800 rounded-[3rem] p-8 flex items-center justify-center text-center group shadow-xl"
                        data-aos="fade-left" data-aos-delay="300">
                        <span class="text-neutral-500 italic">Jadilah bintang tamu bulan ini!</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Creative Quote Section --}}
    <section class="py-40 bg-white dark:bg-neutral-950 text-center">
        <div class="container mx-auto px-6">
            <div class="relative inline-block" data-aos="fade-up">
                <i class="bi bi-quote text-9xl absolute -top-16 -left-16 text-orange-500/10"></i>
                <p
                    class="text-2xl md:text-4xl font-medium text-gray-700 dark:text-neutral-300 leading-tight tracking-tight max-w-4xl mx-auto italic">
                    "Dari manisnya persaudaraan hingga pedasnya kebersamaan, <br class="hidden md:block" />
                    temukan <span
                        class="text-gray-900 dark:text-white font-black border-b-4 border-orange-500/30">cita rasa asli Sasambo</span> di sini."
                </p>
                <div class="mt-12 flex flex-col items-center">
                    <div class="w-12 h-0.5 bg-orange-500 mb-4"></div>
                    <span class="text-xs font-black uppercase tracking-widest text-gray-400">Gusto di Amore</span>
                </div>
            </div>
        </div>
    </section>

@endsection
