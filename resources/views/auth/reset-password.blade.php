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
                    <div class="bg-white/90 dark:bg-neutral-800/90 backdrop-blur-xl border border-white/40 dark:border-neutral-700 shadow-2xl rounded-3xl overflow-hidden"
                         data-aos="zoom-in" data-aos-duration="800">
                        <div class="p-8">

                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center bg-linear-to-r from-amber-500 to-orange-600 text-white rounded-full mb-3 w-14 h-14 text-2xl">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </div>
                                <h2 class="font-bold text-gray-900 dark:text-gray-100 mb-1 text-xl">Reset Password</h2>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Buat password baru untuk akun Anda.</p>
                            </div>

                            <form method="POST" action="{{ route('password.reset.update') }}" x-data="{ showPassword: false, showConfirmPassword: false }">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="relative mb-4">
                                    <input type="email" name="email"
                                        class="w-full px-4 pt-6 pb-2 bg-gray-100/50 dark:bg-neutral-700/50 border-0 rounded-full focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent cursor-not-allowed text-gray-500 dark:text-gray-400"
                                        id="emailInput" placeholder="Email" value="{{ $request->email ?? old('email') }}" readonly required>
                                    <label for="emailInput"
                                        class="absolute left-4 top-3 text-gray-500 dark:text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Email</label>
                                </div>

                                <div class="relative mb-4">
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        class="w-full px-4 pt-6 pb-2 bg-gray-100 dark:bg-neutral-700 border-0 rounded-full focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent dark:text-gray-100"
                                        id="passwordInput" placeholder="Password Baru" required autofocus>
                                    <label for="passwordInput"
                                        class="absolute left-4 top-3 text-gray-500 dark:text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Password Baru</label>
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-4 top-3 text-gray-500 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 focus:outline-none cursor-pointer">
                                        <i class="bi" :class="showPassword ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                    </button>
                                    @error('password')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="relative mb-6">
                                    <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation"
                                        class="w-full px-4 pt-6 pb-2 bg-gray-100 dark:bg-neutral-700 border-0 rounded-full focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent dark:text-gray-100"
                                        id="passwordConfirmInput" placeholder="Konfirmasi Password" required>
                                    <label for="passwordConfirmInput"
                                        class="absolute left-4 top-3 text-gray-500 dark:text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Konfirmasi Password</label>
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                        class="absolute right-4 top-3 text-gray-500 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 focus:outline-none cursor-pointer">
                                        <i class="bi" :class="showConfirmPassword ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                    </button>
                                </div>

                                <button type="submit"
                                    class="w-full py-3 bg-linear-to-r from-emerald-500 to-teal-600 text-white rounded-full font-bold hover:from-emerald-600 hover:to-teal-700 transition-all mb-3 cursor-pointer shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    Reset Password
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
