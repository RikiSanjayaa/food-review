@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto my-10 px-4">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-lg font-semibold text-gray-800">Edit Kategori</h1>
                    <a href="{{ route('admin.tags.index') }}"
                        class="text-sm text-gray-500 hover:text-gray-700 transition-colors">Kembali</a>
                </div>

                <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text"
                            class="w-full px-4 py-2 rounded-lg focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all"
                            id="name" name="name" value="{{ old('name', $tag->name) }}"
                            placeholder="Masukkan nama kategori..." autofocus>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('admin.tags.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-linear-to-r from-orange-400 to-orange-500 rounded-lg hover:from-orange-500 hover:to-orange-600 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
