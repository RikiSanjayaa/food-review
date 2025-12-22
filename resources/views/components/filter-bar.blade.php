@php
    $diets = ['vegan' => 'Vegan', 'vegetarian' => 'Vegetarian', 'gluten-free' => 'Gluten-free'];
@endphp

<form method="GET" action="{{ route('recipes.index') }}" class="bg-white border rounded p-4 mb-4 shadow-sm">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label small">Search</label>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Keyword or ingredient">
        </div>

        <div class="col-md-4">
            <label class="form-label small">Diet</label>
            <select name="diet" class="form-select">
                <option value="">Any</option>
                @foreach ($diets as $key => $label)
                    <option value="{{ $key }}" @selected(($filters['diet'] ?? '') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label small">Sort</label>
            <select name="sort" class="form-select">
                <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Newest</option>
                <option value="rating" @selected(($filters['sort'] ?? '') === 'rating')>Rating</option>
                <option value="time" @selected(($filters['sort'] ?? '') === 'time')>Shortest time</option>
            </select>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-8">
            <span class="form-label small d-block">Tags</span>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($tags as $tag)
                    <label class="form-check-label d-flex align-items-center gap-2 small">
                        <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, $filters['tags'] ?? []))>
                        <span>{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            <div class="row g-2">
                <div class="col-6">
                    <label class="form-label small">Min time</label>
                    <input type="number" name="time_min" value="{{ $filters['time_min'] ?? '' }}" class="form-control" placeholder="mins">
                </div>
                <div class="col-6">
                    <label class="form-label small">Max time</label>
                    <input type="number" name="time_max" value="{{ $filters['time_max'] ?? '' }}" class="form-control" placeholder="mins">
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-success">Apply</button>
        <a href="{{ route('recipes.index') }}" class="text-secondary small text-decoration-none">Reset</a>
    </div>
</form>

