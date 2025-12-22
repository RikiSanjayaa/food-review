<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mb-3">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label small">Title</label>
            <input type="text" name="title" value="{{ old('title', $recipe->title) }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label small">Hero image</label>
            <input type="file" name="hero_image" class="form-control form-control-sm">
            @if ($recipe->hero_image)
                <img src="{{ Storage::url($recipe->hero_image) }}" alt="" class="mt-2 rounded" style="height: 64px; width: 64px; object-fit: cover;">
            @endif
        </div>
    </div>

    <div class="mt-3">
        <label class="form-label small">Short description</label>
        <textarea name="description" rows="2" class="form-control">{{ old('description', $recipe->description) }}</textarea>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-4">
            <label class="form-label small">Prep time (mins)</label>
            <input type="number" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Cook time (mins)</label>
            <input type="number" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Servings</label>
            <input type="number" name="servings" value="{{ old('servings', $recipe->servings) }}" class="form-control">
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-4">
            <label class="form-label small">Difficulty</label>
            <input type="text" name="difficulty" value="{{ old('difficulty', $recipe->difficulty) }}" class="form-control" placeholder="easy / medium / hard">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Diet</label>
            <input type="text" name="diet" value="{{ old('diet', $recipe->diet) }}" class="form-control" placeholder="vegan, gluten-free">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Cuisine</label>
            <input type="text" name="cuisine" value="{{ old('cuisine', $recipe->cuisine) }}" class="form-control">
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-6">
            <label class="form-label small">Ingredients</label>
            <textarea name="ingredients" rows="6" class="form-control" required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label small">Steps</label>
            <textarea name="steps" rows="6" class="form-control" required>{{ old('steps', $recipe->steps) }}</textarea>
        </div>
    </div>

    <div class="mt-2">
        <label class="form-label small">Tags</label>
        <div class="d-flex flex-wrap gap-2">
            @foreach ($tags as $tag)
                <label class="form-check-label d-flex align-items-center gap-2 small">
                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tags', $recipe->tags->pluck('id')->toArray())))>
                    <span>{{ $tag->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 mt-3">
        <button type="submit" class="btn btn-success btn-sm">Save</button>
        <a href="{{ $recipe->exists ? route('recipes.show', $recipe) : route('recipes.index') }}" class="text-secondary small text-decoration-none">Cancel</a>
    </div>
</form>

