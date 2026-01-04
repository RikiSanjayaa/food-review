@extends('layouts.app')

@section('content')
  <div class="min-h-[70vh] flex items-center justify-center px-4 mt-20">
    <div class="bg-white dark:bg-neutral-800 shadow-lg rounded-2xl p-8 max-w-md w-full text-center" data-aos="fade-up">
      <div
        class="w-20 h-20 mx-auto mb-6 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
        <i class="bi bi-envelope-check text-4xl text-orange-500"></i>
      </div>

      <h1 class="text-2xl font-bold mb-3 dark:text-gray-100">Verifikasi Email Anda</h1>

      <p class="text-gray-600 dark:text-gray-400 mb-6">
        Sebelum melanjutkan, silakan periksa email Anda untuk link verifikasi.
        Jika Anda tidak menerima email, klik tombol di bawah untuk mengirim ulang.
      </p>

      @if (session('status'))
        <div
          class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl px-4 py-3 mb-6">
          <i class="bi bi-check-circle mr-1"></i>
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('verification.resend') }}" class="mb-4">
        @csrf
        <button type="submit"
          class="w-full px-8 py-4 bg-linear-to-r from-amber-500 to-orange-600 text-white rounded-full font-bold shadow-xl hover:scale-105 transition-transform">
          <i class="bi bi-arrow-repeat mr-2"></i>
          Kirim Ulang Email Verifikasi
        </button>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
          class="text-gray-500 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 text-sm transition-colors">
          <i class="bi bi-box-arrow-left mr-1"></i>
          Keluar dan gunakan akun lain
        </button>
      </form>
    </div>
  </div>
@endsection