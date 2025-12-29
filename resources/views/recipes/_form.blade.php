<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mb-3">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Resep</label>
        <input type="text" name="title" value="{{ old('title', $recipe->title) }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
            placeholder="Masukkan judul resep..." required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Utama</label>
        <input type="file" name="hero_image"
            class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-orange-50 file:text-orange-600 file:font-medium hover:file:bg-orange-100 cursor-pointer">
        @if ($recipe->hero_image)
            <img src="{{ Storage::url($recipe->hero_image) }}" alt=""
                class="mt-2 rounded-lg h-16 w-16 object-cover bg-gray-100">
        @endif
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Galeri Foto Tambahan</label>
        <div class="space-y-3">
            <input type="file" name="images[]" multiple id="gallery-input"
                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-orange-50 file:text-orange-600 file:font-medium hover:file:bg-orange-100 cursor-pointer">
            <p class="text-xs text-gray-500">Bisa pilih banyak foto sekaligus. Kapasitas timbun foto tak terbatas!</p>

            <!-- Preview Container -->
            <div id="gallery-preview" class="flex flex-wrap gap-3">
                @if ($recipe->images->count() > 0)
                    @foreach ($recipe->images as $image)
                        <div class="relative w-20 h-20 rounded-lg overflow-hidden border border-gray-200 group">
                            <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-cover">
                            <!-- Helper text for existing images could go here if needed, or delete button -->
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="mt-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
        <textarea name="description" rows="2"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
            placeholder="Deskripsikan resep Anda secara singkat...">{{ old('description', $recipe->description) }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Persiapan (menit)</label>
            <input type="number" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                placeholder="Contoh: 15">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Masak (menit)</label>
            <input type="number" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                placeholder="Contoh: 30">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Porsi (orang)</label>
            <input type="number" name="servings" value="{{ old('servings', $recipe->servings) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                placeholder="Contoh: 4">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Kesulitan</label>
            <select name="difficulty"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition bg-white">
                <option value="mudah" @selected(old('difficulty', $recipe->difficulty) == 'mudah')>Mudah</option>
                <option value="sedang" @selected(old('difficulty', $recipe->difficulty) == 'sedang')>Sedang</option>
                <option value="sulit" @selected(old('difficulty', $recipe->difficulty) == 'sulit')>Sulit</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Diet</label>
            <input type="text" name="diet" value="{{ old('diet', $recipe->diet) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                placeholder="Contoh: vegetarian, halal">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Asal Masakan</label>
            <input type="text" name="cuisine" value="{{ old('cuisine', $recipe->cuisine) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                placeholder="Contoh: Indonesia, Lombok">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bahan-bahan</label>
            <textarea name="ingredients" rows="6"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                placeholder="Tuliskan bahan-bahan, satu per baris..." required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cara Membuat</label>
            <textarea name="steps" rows="6"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                placeholder="Tuliskan langkah-langkah, satu per baris..." required>{{ old('steps', $recipe->steps) }}</textarea>
        </div>
    </div>

    <div class="mt-4">
        <label class="flex items-center gap-2 mb-3 font-bold text-gray-500 text-sm">
            <i class="bi bi-tag-fill text-orange-600"></i> Kategori (Tag)
        </label>
        <div class="flex flex-wrap gap-2">
            @foreach ($tags as $tag)
                <label class="cursor-pointer relative select-none group">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="peer sr-only"
                        @checked(in_array($tag->id, old('tags', $recipe->tags->pluck('id')->toArray())))>
                    <div
                        class="px-3 py-2 rounded-full border-2 border-gray-100 bg-white text-gray-500 text-sm font-bold transition-all duration-300
                                group-hover:border-amber-400 group-hover:text-amber-600 group-hover:border-2
                                peer-checked:bg-linear-to-r peer-checked:from-amber-500 peer-checked:to-orange-600 peer-checked:text-white
                                whitespace-nowrap">
                        {{ $tag->name }}
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex items-center gap-3 mt-8">
        <button type="submit"
            class="px-6 py-2.5 bg-linear-to-r from-amber-500 to-orange-600 text-white font-bold rounded-lg hover:from-amber-600 hover:to-orange-700 transition-all">
            Simpan Resep
        </button>
        <button type="button" href="{{ $recipe->exists ? route('recipes.show', $recipe) : route('recipes.index') }}"
            class="text-gray-500 text-sm no-underline hover:text-gray-700">Batal</button>
    </div>
</form>

<script>
    document.getElementById('gallery-input').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('gallery-preview');
        const files = event.target.files;
        
        // Clear previous new previews
        const existingPreviews = previewContainer.querySelectorAll('.new-preview');
        existingPreviews.forEach(el => el.remove());

        if (files) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative w-20 h-20 rounded-lg overflow-hidden border border-gray-200 group new-preview';
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    });
</script>
