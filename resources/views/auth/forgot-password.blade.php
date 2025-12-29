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
                    <div class="bg-white/90 backdrop-blur-xl border border-white/40 shadow-2xl rounded-3xl overflow-hidden"
                         data-aos="zoom-in" data-aos-duration="800">
                        <div class="p-8">

                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center bg-linear-to-r from-amber-500 to-orange-600 text-white rounded-full mb-3 w-14 h-14 text-2xl">
                                    <i class="bi bi-key-fill"></i>
                                </div>
                                <h2 class="font-bold text-gray-900 mb-1 text-xl">Lupa Password?</h2>
                                <p class="text-gray-500 text-sm">Masukkan email Anda dan kami akan mengirimkan link reset password.</p>
                            </div>

                            @if (session('status'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                    <span class="block sm:inline">{{ session('status') }}</span>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="relative mb-4">
                                    <input type="email" name="email"
                                        class="w-full px-4 pt-6 pb-2 bg-gray-100 border-0 rounded-full focus:ring-2 focus:ring-orange-500 outline-none transition peer placeholder-transparent"
                                        id="emailInput" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                    <label for="emailInput"
                                        class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-1 peer-[:not(:placeholder-shown)]:text-xs">Email</label>
                                    @error('email')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="w-full py-3 bg-linear-to-r from-emerald-500 to-teal-600 text-white rounded-full font-bold hover:from-emerald-600 hover:to-teal-700 transition-all mb-3 cursor-pointer shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    Kirim Link Reset
                                </button>
                                
                                <div class="text-center mt-4">
                                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-orange-500 transition-colors">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
                                    </a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
