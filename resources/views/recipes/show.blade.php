@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8 d-flex flex-column gap-3">
            <div class="card shadow-sm">
                @if ($recipe->hero_image)
                    <img src="{{ Storage::url($recipe->hero_image) }}" alt="{{ $recipe->title }}" class="card-img-top" style="max-height: 360px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h1 class="h4 mb-1">{{ $recipe->title }}</h1>
                            <p class="text-secondary small mb-0">By {{ $recipe->user?->name ?? 'Unknown' }}</p>
                        </div>
                        <div class="text-end">
                            <div class="fw-semibold text-success fs-5">{{ number_format($recipe->rating_avg, 1) }}★</div>
                            <div class="text-muted small">{{ $recipe->rating_count }} ratings</div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3 small text-muted">
                        @if ($recipe->totalTime())
                            <span class="badge text-bg-light">Total: {{ $recipe->totalTime() }} mins</span>
                        @endif
                        @if ($recipe->diet)
                            <span class="badge text-bg-light text-capitalize">{{ $recipe->diet }}</span>
                        @endif
                        @if ($recipe->difficulty)
                            <span class="badge text-bg-light">{{ ucfirst($recipe->difficulty) }}</span>
                        @endif
                        @foreach ($recipe->tags as $tag)
                            <span class="badge text-bg-success">{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    @if ($recipe->description)
                        <p class="mt-3">{{ $recipe->description }}</p>
                    @endif

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <h2 class="h6">Ingredients</h2>
                            <pre class="bg-light p-3 rounded border text-body" style="white-space: pre-line;">{{ $recipe->ingredients }}</pre>
                        </div>
                        <div class="col-md-6">
                            <h2 class="h6">Steps</h2>
                            <pre class="bg-light p-3 rounded border text-body" style="white-space: pre-line;">{{ $recipe->steps }}</pre>
                        </div>
                    </div>

                    @can('update', $recipe)
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" onsubmit="return confirm('Delete this recipe?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">Reviews</h2>
                    @auth
                        @include('reviews._form', ['recipe' => $recipe])
                    @else
                        <p class="text-secondary small mb-3">Please <a class="text-success" href="{{ route('login') }}">log in</a> to add a review.</p>
                    @endauth

                    @include('reviews._list', ['reviews' => $reviews, 'recipe' => $recipe])
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h6 mb-3">Recipe details</h3>
                    <dl class="row mb-0 small">
                        <dt class="col-6 text-muted">Prep time</dt>
                        <dd class="col-6">{{ $recipe->prep_time ?? '—' }} mins</dd>
                        <dt class="col-6 text-muted">Cook time</dt>
                        <dd class="col-6">{{ $recipe->cook_time ?? '—' }} mins</dd>
                        <dt class="col-6 text-muted">Servings</dt>
                        <dd class="col-6">{{ $recipe->servings ?? '—' }}</dd>
                        <dt class="col-6 text-muted">Cuisine</dt>
                        <dd class="col-6">{{ $recipe->cuisine ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection

