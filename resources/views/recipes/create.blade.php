@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto my-4 px-4">
        <div class="bg-white shadow-sm rounded-2xl">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-xl font-bold">Buat Resep Baru</h1>
                    <a href="{{ route('recipes.index') }}" class="text-gray-500 text-sm no-underline hover:text-gray-700">Kembali</a>
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
@endsection
