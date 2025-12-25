@php
    $diets = [
        'vegan' => 'Vegan',
        'vegetarian' => 'Vegetarian',
        'gluten-free' => 'Bebas Gluten',
        'halal' => 'Halal'
    ];
@endphp

<form method="GET" action="{{ route('recipes.index') }}">

    {{-- =========================
       SEARCH BAR
       ========================= --}}
    <div class="filter-search mb-4">
        <i class="bi bi-search"></i>
        <input
            type="search"
            name="q"
            value="{{ $filters['q'] ?? '' }}"
            placeholder="Cari resep atau bahan favorit..."
        >
    </div>

    {{-- =========================
       KATEGORI
       ========================= --}}
    <div class="mb-4">
        <div class="filter-label">Kategori</div>
        <div class="filter-tags">
            @foreach ($tags as $tag)
                <label class="tag-chip">
                    <input
                        type="checkbox"
                        name="tags[]"
                        value="{{ $tag->id }}"
                        @checked(in_array($tag->id, $filters['tags'] ?? []))
                    >
                    {{ $tag->name }}
                </label>
            @endforeach
        </div>
    </div>

    {{-- =========================
       FILTER GRID
       ========================= --}}
    <div class="row g-4 mt-2">

        {{-- DIET --}}
        <div class="col-md-3">
            <label class="filter-label">Diet</label>
            <select name="diet" class="form-select filter-input">
                <option value="">Semua Diet</option>
                @foreach ($diets as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(($filters['diet'] ?? '') === $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- SORT --}}
        <div class="col-md-3">
            <label class="filter-label">Urutkan</label>
            <select name="sort" class="form-select filter-input">
                <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>
                    Terbaru
                </option>
                <option value="rating" @selected(($filters['sort'] ?? '') === 'rating')>
                    Rating Tertinggi
                </option>
                <option value="time" @selected(($filters['sort'] ?? '') === 'time')>
                    Waktu Tercepat
                </option>
            </select>
        </div>

        {{-- MIN TIME --}}
        <div class="col-md-3">
            <label class="filter-label">Min Waktu (menit)</label>
            <input
                type="number"
                name="time_min"
                value="{{ $filters['time_min'] ?? '' }}"
                class="form-control filter-input"
                placeholder="0"
                min="0"
            >
        </div>

        {{-- MAX TIME --}}
        <div class="col-md-3">
            <label class="filter-label">Max Waktu (menit)</label>
            <input
                type="number"
                name="time_max"
                value="{{ $filters['time_max'] ?? '' }}"
                class="form-control filter-input"
                placeholder="0"
                min="0"
            >
        </div>

    </div>

    {{-- =========================
       ACTION BUTTON
       ========================= --}}
    <div class="filter-actions mt-4">
        <button type="submit" class="filter-btn">
            Terapkan Filter
        </button>

        <a href="{{ route('recipes.index') }}" class="filter-reset-btn">
            Reset
        </a>
    </div>

</form>
