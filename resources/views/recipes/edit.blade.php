@extends('layouts.app')

@section('content')
    <div class="col-lg-10 col-xl-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h5 mb-0">Edit recipe</h1>
                    <a href="{{ route('recipes.show', $recipe) }}" class="text-secondary small text-decoration-none">Back</a>
                </div>

                @include('recipes._form', [
                    'recipe' => $recipe,
                    'tags' => $tags,
                    'action' => route('recipes.update', $recipe),
                    'method' => 'PUT',
                ])
            </div>
        </div>
    </div>
@endsection

