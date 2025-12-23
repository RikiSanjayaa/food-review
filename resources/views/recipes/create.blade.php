@extends('layouts.app')

@section('content')
    <div class="col-lg-10 col-xl-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h5 mb-0">Buat Resep Baru</h1>
                    <a href="{{ route('recipes.index') }}" class="text-secondary small text-decoration-none">Kembali</a>
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

