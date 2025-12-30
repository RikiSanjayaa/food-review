@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f8f9fa] dark:bg-neutral-950 transition-colors duration-500 relative overflow-hidden">

        <div
            class="fixed top-0 left-0 w-full h-125 bg-linear-to-b from-orange-50/80 to-transparent dark:from-orange-900/10 dark:to-transparent -z-10">
        </div>
        <div
            class="fixed top-[-20%] right-[-10%] w-150 h-150 rounded-full bg-linear-to-br from-amber-200/20 to-orange-200/20 dark:from-amber-900/10 dark:to-orange-900/10 blur-3xl -z-10 pointer-events-none">
        </div>
        <div
            class="fixed bottom-0 left-0 w-125 h-125 bg-linear-to-tr from-rose-100/30 to-orange-100/30 dark:from-rose-900/10 dark:to-orange-900/10 blur-3xl -z-10 pointer-events-none">
        </div>

        <div class="container mx-auto px-4 py-12 md:py-24 relative z-10 max-w-4xl">

            <div class="mb-12" data-aos="fade-down">
                <h1
                    class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight font-jakarta">
                    Pengaturan Profil
                </h1>
            </div>

            <div class="space-y-12">

                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-orange-500/5 border border-white/60 dark:border-neutral-700 relative overflow-hidden"
                    data-aos="fade-up">

                    <div class="flex items-center gap-4 mb-10 pb-8 border-b border-gray-100 dark:border-neutral-700">
                        <div
                            class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-2xl flex items-center justify-center text-orange-600 dark:text-orange-400 shadow-sm transform -rotate-3">
                            <i class="bi bi-person-lines-fill text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">Informasi Pribadi</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Foto profil dan detail publik.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col md:flex-row gap-10">

                            <div class="shrink-0 flex flex-col items-center md:items-start text-center md:text-left">
                                <div class="relative inline-block group cursor-pointer mb-4">
                                    <div
                                        class="w-36 h-36 rounded-full border-[6px] border-white dark:border-neutral-700 overflow-hidden bg-white dark:bg-neutral-700 relative z-10 group-hover:scale-[1.02] transition-transform duration-300">
                                        <img id="avatar-preview"
                                            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                                            alt="{{ $user->name }}" class="w-full h-full object-cover">

                                        <label for="avatar-input"
                                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer">
                                            <i class="bi bi-camera-fill text-white text-3xl"></i>
                                        </label>
                                    </div>
                                </div>
                                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*"
                                    onchange="document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0])">
                                <p class="text-xs text-gray-400 dark:text-gray-500 font-bold mt-2">Maks. 2MB (JPG, PNG)</p>
                            </div>

                            <div class="flex-1 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 pl-3">Nama
                                            Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                            class="w-full px-6 py-3.5 rounded-full bg-gray-50 dark:bg-neutral-900 border-gray-200 dark:border-neutral-700 text-gray-900 dark:text-gray-100 font-bold focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all placeholder-gray-300 dark:placeholder-gray-600">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 pl-3">Email</label>
                                        <div class="relative">
                                            <input type="email" value="{{ $user->email }}" disabled
                                                class="w-full px-6 py-3.5 rounded-full bg-gray-100 dark:bg-neutral-900/50 border-transparent text-gray-400 dark:text-gray-500 font-bold cursor-not-allowed">
                                            <i
                                                class="bi bi-lock-fill absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-600"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 pl-3">Bio
                                        Singkat</label>
                                    <textarea name="bio" rows="3"
                                        class="w-full px-6 py-4 rounded-3xl bg-gray-50 dark:bg-neutral-900 border-gray-200 dark:border-neutral-700 text-gray-900 dark:text-gray-100 font-medium focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all placeholder-gray-300 dark:placeholder-gray-600 leading-relaxed"
                                        placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->bio) }}</textarea>
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="submit"
                                        class="flex-1 md:flex-none px-6 py-3 border-2 border-amber-100 hover:border-amber-400 md:px-10 md:py-4 bg-linear-to-r from-amber-500 to-orange-600 hover:bg-orange-600 rounded-full! text-white font-bold text-sm transition-colors duration-300 flex items-center justify-center gap-2 md:gap-3 whitespace-nowrap order-2 md:order-1">
                                        Simpan Perubahan <i
                                            class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="security"
                    class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-orange-500/5 border border-white/60 dark:border-neutral-700"
                    data-aos="fade-up" data-aos-delay="100">

                    <div class="flex items-center gap-4 mb-10 pb-8 border-b border-gray-100 dark:border-neutral-700">
                        <div
                            class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-sm transform rotate-3">
                            <i class="bi bi-shield-check text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">Keamanan & Password</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Perbarui kata sandi untuk
                                melindungi akunmu.</p>
                        </div>
                    </div>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6 max-w-3xl mx-auto">

                            <div x-data="{ show: false }">
                                <label
                                    class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 pl-3">Kata
                                    Sandi Saat Ini</label>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="current_password" required
                                        class="w-full px-6 py-3.5 rounded-full bg-gray-50 dark:bg-neutral-900 border-gray-200 dark:border-neutral-700 text-gray-900 dark:text-gray-100 font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all placeholder-gray-300 dark:placeholder-gray-600 pr-12">
                                    <button type="button" @click="show = !show"
                                        class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                    </button>
                                </div>
                                <div class="mt-2 text-right px-3">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="text-sm text-gray-500 dark:text-gray-400 hover:text-orange-500 font-medium transition-colors">
                                            Lupa Kata Sandi?
                                        </a>
                                    @else
                                        <a href="#"
                                            class="text-sm text-gray-500 dark:text-gray-400 hover:text-orange-500 font-medium transition-colors cursor-not-allowed opacity-50"
                                            title="Fitur belum tersedia">
                                            Lupa Kata Sandi?
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div x-data="{ show: false }">
                                    <label
                                        class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 pl-3">Kata
                                        Sandi Baru</label>
                                    <div class="relative">
                                        <input :type="show ? 'text' : 'password'" name="password" required
                                            class="w-full px-6 py-3.5 rounded-full bg-gray-50 dark:bg-neutral-900 border-gray-200 dark:border-neutral-700 text-gray-900 dark:text-gray-100 font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all placeholder-gray-300 dark:placeholder-gray-600 pr-12">
                                        <button type="button" @click="show = !show"
                                            class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                            <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                        </button>
                                    </div>
                                </div>

                                <div x-data="{ show: false }">
                                    <label
                                        class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 pl-3">Konfirmasi
                                        Kata Sandi</label>
                                    <div class="relative">
                                        <input :type="show ? 'text' : 'password'" name="password_confirmation" required
                                            class="w-full px-6 py-3.5 rounded-full bg-gray-50 dark:bg-neutral-900 border-gray-200 dark:border-neutral-700 text-gray-900 dark:text-gray-100 font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all placeholder-gray-300 dark:placeholder-gray-600 pr-12">
                                        <button type="button" @click="show = !show"
                                            class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                            <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 flex justify-end">
                                <button type="submit"
                                    class="flex-1 md:flex-none px-6 py-3 border-2 border-amber-100 hover:border-amber-400 md:px-10 md:py-4 bg-linear-to-r from-amber-500 to-orange-600 hover:bg-orange-600 rounded-full! text-white font-bold text-sm transition-colors duration-300 flex items-center justify-center gap-2 md:gap-3 whitespace-nowrap order-2 md:order-1">
                                    Simpan Perubahan <i
                                        class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="fixed bottom-8 right-8 z-50">
            <a href="{{ route('profile.index') }}"
                class="w-14 h-14 rounded-full bg-linear-to-tr from-orange-400 to-amber-500 text-white shadow-xl shadow-orange-500/30 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:shadow-orange-500/50 group"
                title="Kembali ke Profil">
                <i class="bi bi-arrow-left text-2xl drop-shadow-sm group-hover:-translate-x-1 transition-transform"></i>
            </a>
        </div>

    </div>
@endsection