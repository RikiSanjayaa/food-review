@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto my-10 px-4">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">Tambah Kategori</h1>
                    <a href="{{ route('admin.tags.index') }}"
                        class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors no-underline">Kembali</a>
                </div>

                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nama
                            Kategori</label>
                        <input type="text"
                            class="w-full px-4 py-2 bg-white dark:bg-neutral-700 border border-gray-300 dark:border-neutral-600 dark:text-gray-100 rounded-2xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all outline-none"
                            id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama kategori..."
                            autofocus>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('admin.tags.index') }}"
                            class="px-5 py-2 text-sm font-bold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-neutral-700 rounded-full hover:bg-gray-200 dark:hover:bg-neutral-600 transition-colors no-underline border-0">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-bold text-white bg-linear-to-r from-amber-500 to-orange-600 rounded-full! hover:from-amber-600 hover:to-orange-700 transition-all border-0 cursor-pointer">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection