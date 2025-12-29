@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto my-10 px-4">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-lg font-semibold text-gray-800">Kelola Kategori</h1>
                    <a href="{{ route('admin.tags.create') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-linear-to-r from-orange-400 to-orange-500 rounded-lg hover:from-orange-500 hover:to-orange-600 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Kategori
                    </a>
                </div>

                @if (session('success'))
                    <div class="flex items-center justify-between p-4 mb-4 text-green-800 bg-green-100 rounded-lg"
                        role="alert">
                        <span>{{ session('success') }}</span>
                        <button type="button" onclick="this.parentElement.remove()"
                            class="text-green-800 hover:text-green-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-sm font-semibold text-gray-700 w-1/4">
                                    Nama Kategori
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-sm font-semibold text-gray-700 w-1/4">
                                    Slug
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-sm font-semibold text-gray-700 w-1/4">
                                    Jumlah Resep
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-right text-sm font-semibold text-gray-700">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($tags as $tag)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $tag->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $tag->slug }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            {{ $tag->recipes_count ?? 0 }} Resep
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.tags.edit', $tag) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-gray-500 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST"
                                                onsubmit="return showConfirmModal(this, 'Hapus Kategori', 'Apakah Anda yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-red-500 border border-red-300 rounded-lg hover:bg-red-50 hover:text-red-700 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-12 text-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Belum ada kategori yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center mt-6">
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="fixed bottom-8 right-8 z-50">
        <a href="{{ route('recipes.index') }}"
            class="w-14 h-14 rounded-full bg-linear-to-tr from-orange-400 to-amber-500 text-white shadow-xl shadow-orange-500/30 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:shadow-orange-500/50 group"
            title="Kembali">
            <i class="bi bi-arrow-left text-2xl drop-shadow-sm group-hover:-translate-x-1 transition-transform"></i>
        </a>
    </div>
@endsection
