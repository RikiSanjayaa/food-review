@extends('layouts.app')

@section('content')
    <div class="relative w-full flex items-center justify-center h-screen overflow-hidden"
        style="background: url('{{ asset('images/food-bg.png') }}') no-repeat center center/cover;">

        <div class="absolute top-0 left-0 w-full h-full bg-black/50"></div>
        <div class="absolute top-0 left-0 w-full h-full"
            style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(234, 88, 12, 0.3));"></div>

        <div class="max-w-7xl mx-auto px-4 relative z-10 py-10">
            <div class="flex justify-center">
                <div class="w-full max-w-sm">
                    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-3xl overflow-hidden" data-aos="zoom-in"
                        data-aos-duration="800">
                        <div class="p-6 md:p-8">

                            <div class="text-center mb-6">
                                <div
                                    class="inline-flex items-center justify-center bg-linear-to-r from-amber-500 to-orange-600 text-white rounded-full mb-3 w-14 h-14 text-2xl">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <h2 class="font-bold text-gray-900 mb-1 text-xl">Selamat Datang!</h2>
                                <p class="text-gray-500 text-sm">Masuk untuk mulai berbagi resep.</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="mb-3">
                                @csrf
                                <div class="relative mb-3">
                                    <input type="email" name="email"
                                        class="w-full px-4 py-3 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent"
                                        id="emailInput" placeholder="Email" value="{{ old('email') }}" required>
                                    <label for="emailInput"
                                        class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Email</label>
                                </div>
                                <div class="relative mb-4">
                                    <input type="password" name="password"
                                        class="w-full px-4 py-3 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent"
                                        id="passwordInput" placeholder="Kata Sandi" required>
                                    <label for="passwordInput"
                                        class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Kata
                                        Sandi</label>
                                </div>

                                <div class="flex justify-between items-center mb-4">
                                    <label class="flex items-center cursor-pointer">
                                        <input
                                            class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500 mr-2"
                                            type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-500">Ingat Saya</span>
                                    </label>
                                </div>

                                <button type="submit"
                                    class="w-full py-3 bg-linear-to-r from-amber-500 to-orange-600 text-white rounded-full font-bold hover:from-amber-600 hover:to-orange-700 transition-all mb-3 cursor-pointer">
                                    Masuk Sekarang
                                </button>
                            </form>

                            <div class="text-center">
                                <p class="text-gray-500 text-sm mb-0">Belum punya akun?
                                    <a href="{{ route('register') }}"
                                        class="text-orange-600 font-bold no-underline hover:underline">Daftar Gratis</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
