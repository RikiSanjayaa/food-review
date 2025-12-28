@extends('layouts.app')

@section('content')
    <div class="relative w-full flex items-center justify-center h-screen overflow-hidden"
        style="background: url('{{ asset('images/food-bg.png') }}') no-repeat center center/cover;">

        <div class="absolute top-0 left-0 w-full h-full bg-black/50"></div>
        <div class="absolute top-0 left-0 w-full h-full"
            style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(234, 88, 12, 0.3));"></div>

        <div class="max-w-7xl mx-auto px-4 relative z-10 py-10">
            <div class="flex justify-center">
                <div class="w-full max-w-md">
                    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-3xl overflow-hidden" data-aos="zoom-in"
                        data-aos-duration="800">
                        <div class="p-6 md:p-8">

                            <div class="text-center mb-6">
                                <h2 class="font-bold text-gray-900 mb-1 text-xl">Buat Akun Baru</h2>
                                <p class="text-gray-500 text-sm">Bergabunglah dengan komunitas pecinta kuliner.</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}" class="mb-3" x-data="{ showPassword: false, showConfirmPassword: false }">
                                @csrf
                                <div class="relative mb-3">
                                    <input type="text" name="name"
                                        class="w-full px-4 pt-6 pb-2 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent"
                                        id="nameInput" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                    <label for="nameInput"
                                        class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Nama
                                        Lengkap</label>
                                </div>
                                <div class="relative mb-3">
                                    <input type="email" name="email"
                                        class="w-full px-4 pt-6 pb-2 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent"
                                        id="emailInput" placeholder="Email" value="{{ old('email') }}" required>
                                    <label for="emailInput"
                                        class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Email</label>
                                </div>
                                <div class="relative mb-3">
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        class="w-full px-4 pt-6 pb-2 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent"
                                        id="passwordInput" placeholder="Kata Sandi" required>
                                    <label for="passwordInput"
                                        class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Kata
                                        Sandi</label>
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-4 top-3 text-gray-500 hover:text-orange-600 focus:outline-none cursor-pointer">
                                        <i class="bi" :class="showPassword ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                    </button>
                                </div>
                                <div class="relative mb-4">
                                    <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation"
                                        class="w-full px-4 pt-6 pb-2 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent"
                                        id="passwordConfirmInput" placeholder="Konfirmasi Kata Sandi" required>
                                    <label for="passwordConfirmInput"
                                        class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Konfirmasi
                                        Kata Sandi</label>
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                        class="absolute right-4 top-3 text-gray-500 hover:text-orange-600 focus:outline-none cursor-pointer">
                                        <i class="bi" :class="showConfirmPassword ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                    </button>
                                </div>

                                <button type="submit"
                                    class="w-full py-3 bg-linear-to-r from-amber-500 to-orange-600 text-white rounded-full font-bold hover:from-amber-600 hover:to-orange-700 transition-all mb-3 cursor-pointer">
                                    Daftar Sekarang
                                </button>
                            </form>

                            <div class="text-center">
                                <p class="text-gray-500 text-sm mb-0">Sudah punya akun?
                                    <a href="{{ route('login') }}"
                                        class="text-orange-600 font-bold no-underline hover:underline">Masuk</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
