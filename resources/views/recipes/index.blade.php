@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-1">Jelajahi Resep</h1>
            <p class="text-secondary small mb-0">Cari, filter, dan Berikan ulasan hidangan favorit Anda.</p>
        </div>
        @auth
            <a href="{{ route('recipes.create') }}" class="btn btn-success btn-sm">
                + Tambah Resep
            </a>
        @endauth
    </div>

    @include('components.filter-bar', ['filters' => $filters, 'tags' => $tags, 'sort' => $sort ?? 'newest'])

    @if ($recipes->isEmpty())
        <div class="text-center text-secondary py-4">
            Belum ada resep yang cocok dengan filter Anda.
        </div>
    @else
        <div class="row g-3">
            @foreach ($recipes as $recipe)
                <div class="col-md-4">
                    <a href="{{ route('recipes.show', $recipe) }}" class="card h-100 text-decoration-none text-dark shadow-sm">
                        @if ($recipe->hero_image)
                            <img src="{{ Storage::url($recipe->hero_image) }}" class="card-img-top" alt="{{ $recipe->title }}" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 180px;">
                                <span class="text-secondary small">Tidak ada gambar</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h2 class="card-title h6">{{ $recipe->title }}</h2>
                            <p class="card-text text-secondary small">{{ Str::limit($recipe->description, 120) }}</p>
                            <div class="d-flex align-items-center gap-3 text-muted small mb-2">
                                <span class="fw-semibold text-success">{{ number_format($recipe->rating_avg, 1) }}★</span>
                                <span>{{ $recipe->visible_reviews_count ?? $recipe->rating_count }} ulasan</span>
                                @if ($recipe->totalTime())
                                    <span>{{ $recipe->totalTime() }} menit</span>
                                @endif
                            </div>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($recipe->tags->take(3) as $tag)
                                    <span class="badge text-bg-light">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $recipes->links() }}
        </div>
    @endif
@endsection

