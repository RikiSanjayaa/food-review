@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto my-4 px-4">
        <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-2xl">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-xl font-bold dark:text-gray-100">Buat Resep Baru</h1>
                    <a href="{{ route('recipes.index') }}" class="text-gray-500 dark:text-gray-400 text-sm no-underline hover:text-gray-700 dark:hover:text-gray-300 hidden">Kembali</a>
                </div>

                @include('recipes._form', [
                    'recipe' => $recipe,
                    'tags' => $tags,
                    'action' => route('recipes.store'),
                    'method' => 'POST',
                ])
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
