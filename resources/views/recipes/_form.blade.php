<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mb-3">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label small">Judul Resep</label>
            <input type="text" name="title" value="{{ old('title', $recipe->title) }}" class="form-control" placeholder="Masukkan judul resep..." required>
        </div>
        <div class="col-md-6">
            <label class="form-label small">Foto Utama</label>
            <input type="file" name="hero_image" class="form-control form-control-sm">
            @if ($recipe->hero_image)
                <img src="{{ Storage::url($recipe->hero_image) }}" alt="" class="mt-2 rounded" style="height: 64px; width: 64px; object-fit: cover;">
            @endif
        </div>
    </div>

    <div class="mt-3">
        <label class="form-label small">Deskripsi Singkat</label>
        <textarea name="description" rows="2" class="form-control" placeholder="Deskripsikan resep Anda secara singkat...">{{ old('description', $recipe->description) }}</textarea>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-4">
            <label class="form-label small">Waktu Persiapan (menit)</label>
            <input type="number" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}" class="form-control" placeholder="Contoh: 15">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Waktu Masak (menit)</label>
            <input type="number" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}" class="form-control" placeholder="Contoh: 30">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Porsi (orang)</label>
            <input type="number" name="servings" value="{{ old('servings', $recipe->servings) }}" class="form-control" placeholder="Contoh: 4">
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-4">
            <label class="form-label small">Tingkat Kesulitan</label>
            <select name="difficulty" class="form-select">
                <option value="mudah" @selected(old('difficulty', $recipe->difficulty) == 'mudah')>Mudah</option>
                <option value="sedang" @selected(old('difficulty', $recipe->difficulty) == 'sedang')>Sedang</option>
                <option value="sulit" @selected(old('difficulty', $recipe->difficulty) == 'sulit')>Sulit</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label small">Jenis Diet</label>
            <input type="text" name="diet" value="{{ old('diet', $recipe->diet) }}" class="form-control" placeholder="Contoh: vegetarian, halal">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Asal Masakan</label>
            <input type="text" name="cuisine" value="{{ old('cuisine', $recipe->cuisine) }}" class="form-control" placeholder="Contoh: Indonesia, Lombok">
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-6">
            <label class="form-label small">Bahan-bahan</label>
            <textarea name="ingredients" rows="6" class="form-control" placeholder="Tuliskan bahan-bahan, satu per baris..." required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label small">Cara Membuat</label>
            <textarea name="steps" rows="6" class="form-control" placeholder="Tuliskan langkah-langkah, satu per baris..." required>{{ old('steps', $recipe->steps) }}</textarea>
        </div>
    </div>

    <div class="mt-2">
        <label class="form-label small">Kategori (Tag)</label>
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
        <button type="submit" class="btn btn-success btn-sm">Simpan Resep</button>
        <a href="{{ $recipe->exists ? route('recipes.show', $recipe) : route('recipes.index') }}" class="text-secondary small text-decoration-none">Batal</a>
    </div>
</form>

