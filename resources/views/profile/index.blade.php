@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f8f9fa] relative overflow-hidden" x-data="{ activeTab: 'recipes' }">

        <div class="fixed top-0 left-0 w-full h-125 bg-linear-to-b from-orange-50/80 to-transparent -z-10"></div>
        <div
            class="fixed top-[-20%] right-[-10%] w-200 h-200 rounded-full bg-linear-to-br from-amber-200/20 to-orange-200/20 blur-3xl -z-10 pointer-events-none">
        </div>
        <div
            class="fixed bottom-[-10%] left-[-10%] w-150 h-150 rounded-full bg-linear-to-tr from-rose-100/30 to-orange-100/30 blur-3xl -z-10 pointer-events-none">
        </div>

        <div class="container mx-auto px-4 pt-28 pb-20 relative z-10 max-w-350">

            <div class="flex flex-col items-center justify-center text-center mb-16 relative" data-aos="fade-down"
                data-aos-duration="1000">

                <div class="relative mb-6 group cursor-pointer">
                    <div
                        class="absolute -inset-0.5 bg-linear-to-tr from-orange-400 to-amber-500 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-500">
                    </div>
                    <div
                        class="w-32 h-32 md:w-40 md:h-40 rounded-full border-[6px] border-white shadow-2xl overflow-hidden bg-white relative z-10">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div
                                class="w-full h-full bg-linear-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-5xl md:text-6xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    @if ($user->is_admin)
                        <div class="absolute bottom-2 right-2 z-20 bg-blue-500 text-white w-8 h-8 flex items-center justify-center rounded-full border-[3px] border-white shadow-md"
                            title="Verified Chef">
                            <i class="bi bi-patch-check-fill text-sm"></i>
                        </div>
                    @endif
                </div>

                <h1
                    class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight drop-shadow-sm font-jakarta">
                    {{ $user->name }}
                </h1>
                <p
                    class="text-gray-500 font-medium text-lg mb-8 bg-white/60 backdrop-blur-sm px-6 py-1.5 rounded-full border border-gray-100 shadow-sm inline-flex items-center gap-2">
                    <i class="bi bi-envelope text-orange-400"></i> {{ $user->email }}
                </p>

                <div
                    class="flex flex-wrap items-center justify-center gap-6 md:gap-12 mb-8 bg-white/80 backdrop-blur-xl px-10 py-5 rounded-4xl shadow-xl shadow-orange-500/5 border border-white/60">
                    <div class="flex flex-col items-center px-4">
                        <span class="text-2xl font-black text-gray-900">{{ $user->recipes->count() }}</span>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Resep</span>
                    </div>

                    <div class="w-px h-10 bg-gray-200"></div>

                    <div class="flex flex-col items-center px-4">
                        <span class="text-2xl font-black text-gray-900">{{ $user->reviews->count() }}</span>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Ulasan</span>
                    </div>

                    <div class="w-px h-10 bg-gray-200"></div>

                    <div class="flex flex-col items-center px-4">
                        <span class="text-2xl font-black text-gray-900">{{ $user->created_at->format('M Y') }}</span>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Bergabung</span>
                    </div>
                </div>

                @if ($user->bio)
                    <div class="max-w-2xl mx-auto text-gray-600 font-medium leading-relaxed italic relative px-8">
                        <i class="bi bi-quote text-3xl text-orange-200 absolute -top-4 left-0"></i>
                        {{ $user->bio }}
                        <i class="bi bi-quote text-3xl text-orange-200 absolute -bottom-4 right-0 rotate-180"></i>
                    </div>
                @endif

                @if ($isOwner)
                    <div class="mt-8">
                        <a href="{{ route('profile.edit') }}"
                            class="flex-1 md:flex-none px-6 py-3 border-2 border-amber-100 hover:border-amber-400 md:px-10 md:py-4 bg-linear-to-r from-amber-500 to-orange-600 hover:bg-orange-600 rounded-full! text-white font-bold text-sm transition-colors duration-300 flex items-center justify-center gap-2 md:gap-3 whitespace-nowrap order-2 md:order-1">
                            <i class="bi bi-pencil-square"></i> Edit Profil
                        </a>
                    </div>
                @endif
            </div>

            <div class="mb-10 border-b border-gray-200/60 flex justify-center sticky top-17.5 z-30 bg-[#f8f9fa]/95 backdrop-blur-sm pt-4"
                data-aos="fade-up" data-aos-delay="100">
                <div class="flex gap-10">
                    <button @click="activeTab = 'recipes'"
                        class="pb-4 text-sm font-bold uppercase tracking-widest transition-all duration-300 border-b-[3px] px-2"
                        :class="activeTab === 'recipes' ? 'border-orange-500 text-orange-600' :
                            'border-transparent text-gray-400 hover:text-gray-600'">
                        <i class="bi bi-grid-3x3-gap-fill mr-1.5 text-lg relative -top-0.5"></i>
                        {{ $isOwner ? 'Resep Saya' : 'Resep' }}
                    </button>
                    <button @click="activeTab = 'reviews'"
                        class="pb-4 text-sm font-bold uppercase tracking-widest transition-all duration-300 border-b-[3px] px-2"
                        :class="activeTab === 'reviews' ? 'border-amber-500 text-amber-600' :
                            'border-transparent text-gray-400 hover:text-gray-600'">
                        <i class="bi bi-star-fill mr-1.5 text-lg relative -top-0.5"></i>
                        {{ $isOwner ? 'Ulasan Saya' : 'Ulasan' }}
                    </button>
                </div>
            </div>

            <div class="min-h-100">

                <div x-show="activeTab === 'recipes'" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">

                    @if ($user->recipes->isEmpty())
                        <div class="flex flex-col items-center justify-center py-24 text-center">
                            <div
                                class="w-48 h-48 bg-orange-50 rounded-full flex items-center justify-center mb-6 animate-pulse">
                                <i class="bi bi-egg-fried text-6xl text-orange-300"></i>
                            </div>
                            @if ($isOwner)
                                <h3 class="text-2xl font-black text-gray-900 mb-2">Dapur Masih Sepi Nih</h3>
                                <p class="text-gray-500 mb-8 max-w-md mx-auto">Kamu belum berbagi resep apapun. Yuk mulai
                                    masak dan inspirasi orang lain sekarang!</p>
                                <a href="{{ route('recipes.create') }}"
                                    class="btn-linear-orange px-8 py-3.5 rounded-full font-bold shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-1 transition-all flex items-center gap-2">
                                    <i class="bi bi-plus-lg"></i> Buat Resep Baru
                                </a>
                            @else
                                <h3 class="text-2xl font-black text-gray-900 mb-2">Belum Ada Resep</h3>
                                <p class="text-gray-500 max-w-md mx-auto">{{ $user->name }} belum membagikan resep apapun.
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($user->recipes as $recipe)
                                <div
                                    class="group h-full bg-white rounded-4xl p-3 shadow-sm hover:shadow-2xl hover:shadow-orange-100/60 transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative">
                                    <div class="relative aspect-video overflow-hidden rounded-3xl bg-gray-100 group-hover:brightness-[1.02] transition-all mb-3">
                                        <a href="{{ route('recipes.show', $recipe) }}" class="block w-full h-full">
                                            <img src="{{ $recipe->hero_image ? Storage::url($recipe->hero_image) : asset('images/placeholder-recipe.jpg') }}"
                                                class="w-full h-full object-cover transform scale-100 group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                        </a>

                                        <div
                                            class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                        </div>

                                        <div
                                            class="absolute top-2.5 right-2.5 bg-white/95 backdrop-blur px-2.5 py-1 rounded-lg text-xs font-extrabold shadow-sm flex items-center gap-1 z-10">
                                            <i class="bi bi-star-fill text-amber-500"></i>
                                            {{ number_format($recipe->rating_avg, 1) }}
                                        </div>

                                        @if ($isOwner)
                                            <div
                                                class="absolute bottom-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-20">
                                                <a href="{{ route('recipes.edit', $recipe) }}"
                                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-white text-gray-900 hover:bg-blue-500 hover:text-white shadow-lg transition-colors"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-fill text-xs"></i>
                                                </a>
                                                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                                                    onsubmit="return showConfirmModal(this, 'Hapus Resep', 'Apakah Anda yakin ingin menghapus resep ini?')">
                                                    @csrf @method('DELETE')
                                                    <button
                                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-white text-gray-900 hover:bg-red-500 hover:text-white shadow-lg transition-colors"
                                                        title="Hapus">
                                                        <i class="bi bi-trash-fill text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="px-1 flex flex-col">
                                        <div class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1">
                                            {{ $recipe->created_at->diffForHumans(null, true) }}</div>
                                        <h3
                                            class="text-[15px] font-extrabold text-gray-900 mb-1 leading-snug line-clamp-1 group-hover:text-orange-600 transition-colors">
                                            <a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a>
                                        </h3>

                                        <div
                                            class="flex items-center justify-between mt-3 pt-3 border-t border-dashed border-gray-100">
                                            <div
                                                class="flex items-center gap-1.5 text-xs text-gray-500 font-medium group-hover:text-orange-500 transition-colors">
                                                <i class="bi bi-chat-text-fill text-orange-400"></i>
                                                <span>
                                                    <span
                                                        class="font-bold text-gray-700 group-hover:text-orange-600">{{ $recipe->reviews_count ?? 0 }}</span>
                                                    Ulasan
                                                </span>
                                            </div>

                                            <div
                                                class="flex items-center gap-1 text-[10px] font-bold text-gray-400 group-hover:text-orange-600 transition-colors uppercase tracking-wider">
                                                Lihat Detail <i class="bi bi-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div x-show="activeTab === 'reviews'" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                    style="display: none;">

                    @if ($user->reviews->isEmpty())
                        <div class="flex flex-col items-center justify-center py-24 text-center">
                            <div class="w-48 h-48 bg-amber-50 rounded-full flex items-center justify-center mb-6">
                                <i class="bi bi-chat-heart text-6xl text-amber-300"></i>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2">Belum Ada Ulasan</h3>
                            @if ($isOwner)
                                <p class="text-gray-500 text-lg">Jelajahi resep dan bagikan pendapatmu!</p>
                            @else
                                <p class="text-gray-500 text-lg">{{ $user->name }} belum memberikan ulasan apapun.</p>
                            @endif
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($user->reviews as $review)
                                <div
                                    class="bg-white rounded-4xl p-6 shadow-sm hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 border border-gray-100 group relative overflow-hidden">

                                    <div class="flex items-center gap-4 mb-4 relative z-10">
                                        <a href="{{ route('recipes.show', $review->recipe) }}"
                                            class="block w-14 h-14 rounded-2xl overflow-hidden shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                                            <img src="{{ $review->recipe->hero_image ? Storage::url($review->recipe->hero_image) : asset('images/placeholder-recipe.jpg') }}"
                                                class="w-full h-full object-cover">
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <div
                                                class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                                Mengulas:</div>
                                            <a href="{{ route('recipes.show', $review->recipe) }}"
                                                class="block text-base font-extrabold text-gray-900 hover:text-orange-500 transition-colors line-clamp-1">
                                                {{ $review->recipe->title }}
                                            </a>
                                        </div>

                                        @if ($isOwner)
                                            <form
                                                action="{{ route('reviews.destroy', ['recipe' => $review->recipe->id, 'review' => $review->id]) }}"
                                                method="POST"
                                                onsubmit="return showConfirmModal(this, 'Hapus Ulasan', 'Apakah Anda yakin ingin menghapus ulasan ini?')">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="w-8 h-8 flex items-center justify-center rounded-full text-gray-300 hover:bg-red-50 hover:text-red-500 transition-all">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="flex gap-1 mb-3 relative z-10">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-amber-400 text-sm"></i>
                                        @endfor
                                    </div>

                                    <div
                                        class="bg-gray-50 rounded-2xl p-4 relative z-10 group-hover:bg-amber-50/50 transition-colors">
                                        <p class="text-gray-700 font-medium italic leading-relaxed text-sm">
                                            "{{ $review->comment }}"</p>
                                    </div>

                                    <div class="mt-4 text-right">
                                        <span
                                            class="text-[10px] font-bold text-gray-400 bg-white px-2 py-1 rounded-full border border-gray-100">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>

                                    <div
                                        class="absolute -bottom-6 -right-6 w-24 h-24 bg-amber-100/50 rounded-full blur-2xl group-hover:bg-amber-200/50 transition-colors z-0">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

        </div>

        <div class="fixed bottom-8 right-8 flex flex-col gap-4 z-50">
            @if ($isOwner)
                <a href="{{ route('recipes.create') }}"
                    class="w-14 h-14 rounded-full bg-linear-to-tr from-orange-400 to-amber-500 text-white shadow-xl shadow-orange-500/30 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:shadow-orange-500/50 group"
                    title="Tambah Resep Baru">
                    <i
                        class="bi bi-plus-lg text-2xl drop-shadow-sm group-hover:rotate-90 transition-transform duration-300"></i>
                </a>
            @endif

            <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('recipes.index') }}"
                class="w-14 h-14 rounded-full bg-linear-to-tr from-orange-400 to-amber-500 text-white shadow-xl shadow-orange-500/30 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:shadow-orange-500/50 group"
                title="Kembali">
                <i class="bi bi-arrow-left text-2xl drop-shadow-sm group-hover:-translate-x-1 transition-transform"></i>
            </a>
        </div>

    </div>
@endsection
