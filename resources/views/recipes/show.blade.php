@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Floating Back Button -->
        <a href="{{ url()->previous() }}" class="btn-float-back" title="Kembali">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div class="row g-4 py-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Hero Image & Header -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" data-aos="fade-up">
                    @if ($recipe->hero_image)
                        <img src="{{ Storage::url($recipe->hero_image) }}" alt="{{ $recipe->title }}"
                            class="w-100 object-fit-cover" style="height: 400px;">
                    @endif
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-start gap-4 mb-3">
                            <div>
                                <h1 class="fw-bold display-6 mb-2">{{ $recipe->title }}</h1>
                                <p class="text-secondary mb-0">Oleh <span
                                        class="fw-semibold text-dark">{{ $recipe->user?->name ?? 'Anonim' }}</span></p>
                            </div>
                            <div class="text-end bg-light p-3 rounded-4">
                                <div class="fw-bold text-warning fs-4 d-flex align-items-center justify-content-end gap-2">
                                    <i class="bi bi-star-fill"></i> {{ number_format($recipe->rating_avg, 1) }}
                                </div>
                                <div class="text-secondary small">{{ $recipe->rating_count }} ulasan</div>
                            </div>
                        </div>

                        @if ($recipe->description)
                            <p class="text-secondary lead fs-6">{{ $recipe->description }}</p>
                        @endif

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            @foreach ($recipe->tags as $tag)
                                <span
                                    class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fw-medium">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Ingredients Checklist -->
                    <div class="col-md-5" data-aos="fade-up" data-aos-delay="100">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4 d-flex align-items-center">
                                    <span
                                        class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                        style="width: 32px; height: 32px;"><i class="bi bi-basket"></i></span>
                                    Bahan-bahan
                                </h4>
                                <div class="d-flex flex-column gap-3">
                                    @foreach (explode("\n", $recipe->ingredients) as $index => $ingredient)
                                        @if (trim($ingredient))
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input fs-5 border-2 me-2" type="checkbox"
                                                    id="ing-{{ $index }}">
                                                <label class="form-check-label fs-6 pt-1" for="ing-{{ $index }}">
                                                    {{ trim($ingredient) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cooking Steps -->
                    <div class="col-md-7" data-aos="fade-up" data-aos-delay="200">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4 d-flex align-items-center">
                                    <span
                                        class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                        style="width: 32px; height: 32px;"><i class="bi bi-fire"></i></span>
                                    Cara Membuat
                                </h4>
                                <div class="d-flex flex-column gap-3">
                                    @foreach (explode("\n", $recipe->steps) as $index => $step)
                                        @if (trim($step))
                                            <div class="d-flex gap-3 p-3 bg-light rounded-4">
                                                <div class="shrink-0 fw-bold text-success fs-5">
                                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                                </div>
                                                <div class="text-dark">
                                                    {{ trim($step) }}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recipe Information -->
                <div class="card border-0 shadow-sm rounded-4 mt-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Informasi Resep</h3>

                        <div class="recipe-info-grid">
                            <div class="info-box">
                                <i class="bi bi-clock-history"></i>
                                <div class="label">Waktu Persiapan</div>
                                <div class="value">{{ $recipe->prep_time ?? '-' }} mnt</div>
                            </div>

                            <div class="info-box">
                                <i class="bi bi-stopwatch"></i>
                                <div class="label">Waktu Masak</div>
                                <div class="value">{{ $recipe->cook_time ?? '-' }} mnt</div>
                            </div>

                            <div class="info-box">
                                <i class="bi bi-people"></i>
                                <div class="label">Porsi</div>
                                <div class="value">{{ $recipe->servings ?? '-' }} org</div>
                            </div>

                            <div class="info-box">
                                <i class="bi bi-globe-americas"></i>
                                <div class="label">Asal Masakan</div>
                                <div class="value">{{ $recipe->cuisine ?? '-' }}</div>
                            </div>

                            <!-- Full width -->
                            <div class="info-box full">
                                <i class="bi bi-bar-chart-fill"></i>
                                <div class="label">Tingkat Kesulitan</div>
                                <div class="value text-capitalize">{{ $recipe->difficulty ?? '-' }}</div>
                            </div>
                        </div>

                        @can('update', $recipe)
                            <hr class="my-4 border-secondary-subtle">
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('recipes.edit', $recipe) }}"
                                    class="btn btn-outline-secondary rounded-pill fw-bold grow">
                                    <i class="bi bi-pencil me-1"></i> Edit Resep
                                </a>
                                <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
                                    onsubmit="return confirm('Hapus resep ini?');" class="grow">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold">
                                        <i class="bi bi-trash me-1"></i> Hapus Resep
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4" data-aos="fade-left">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Ulasan Komunitas</h5>

                        @auth
                            @include('reviews._form', ['recipe' => $recipe])
                        @else
                            <div class="alert alert-light border-0 rounded-4 text-center py-4 mb-4">
                                <i class="bi bi-lock fs-1 text-secondary opacity-25 d-block mb-2"></i>
                                <p class="small mb-0">Silakan <a href="{{ route('login') }}"
                                        class="text-success fw-bold text-decoration-none">masuk</a>
                                    untuk memberikan ulasan.</p>
                            </div>
                        @endauth

                        @include('reviews._list', ['reviews' => $reviews, 'recipe' => $recipe])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
