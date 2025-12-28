@php
    $existingReview = $recipe
        ->reviews()
        ->where('user_id', auth()->id())
        ->first();
@endphp

<form method="POST" action="{{ route('reviews.store', $recipe) }}" class="mb-4 bg-gray-100 p-4 rounded-2xl">
    @csrf
    <h5 class="font-bold mb-3 flex items-center gap-2">
        <i class="bi bi-pencil-square"></i>
        {{ $existingReview ? 'Edit Ulasan Anda' : 'Tulis Ulasan' }}
    </h5>

    <div class="mb-3">
        <label class="block font-medium text-xs uppercase text-gray-500 mb-1">Rating</label>
        <div class="star-rating">
            <input type="radio" name="rating" value="5" id="star5" @checked(old('rating', $existingReview?->rating) == 5) required>
            <label for="star5" title="5 bintang"><i class="bi bi-star-fill"></i></label>

            <input type="radio" name="rating" value="4" id="star4" @checked(old('rating', $existingReview?->rating) == 4)>
            <label for="star4" title="4 bintang"><i class="bi bi-star-fill"></i></label>

            <input type="radio" name="rating" value="3" id="star3" @checked(old('rating', $existingReview?->rating) == 3)>
            <label for="star3" title="3 bintang"><i class="bi bi-star-fill"></i></label>

            <input type="radio" name="rating" value="2" id="star2" @checked(old('rating', $existingReview?->rating) == 2)>
            <label for="star2" title="2 bintang"><i class="bi bi-star-fill"></i></label>

            <input type="radio" name="rating" value="1" id="star1" @checked(old('rating', $existingReview?->rating) == 1)>
            <label for="star1" title="1 bintang"><i class="bi bi-star-fill"></i></label>
        </div>
    </div>

    <div class="mb-3">
        <label class="block font-medium text-xs uppercase text-gray-500 mb-1">Komentar</label>
        <textarea name="comment" rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
            placeholder="Bagikan pengalaman memasak Anda..." required>{{ old('comment', $existingReview?->comment) }}</textarea>
    </div>

    <div class="flex items-center gap-2">
        <button type="submit"
            class="px-4 py-2 bg-linear-to-r from-amber-500 to-orange-600 text-white font-bold rounded-full hover:from-amber-600 hover:to-orange-700 transition-all">
            {{ $existingReview ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}
        </button>
    </div>
</form>
