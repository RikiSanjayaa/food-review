@php
    $existingReview = $recipe->reviews()->where('user_id', auth()->id())->first();
@endphp

<form method="POST" action="{{ route('reviews.store', $recipe) }}" class="mb-4 bg-light p-4 rounded-4 shadow-sm border-0">
    @csrf
    <h5 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2"></i>{{ $existingReview ? 'Edit Ulasan Anda' : 'Tulis Ulasan' }}</h5>
    
    <div class="mb-3">
        <label class="form-label fw-medium small text-uppercase text-secondary">Rating</label>
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
        <label class="form-label fw-medium small text-uppercase text-secondary">Komentar</label>
        <textarea name="comment" rows="3" class="form-control rounded-4" placeholder="Bagikan pengalaman memasak Anda..." required>{{ old('comment', $existingReview?->comment) }}</textarea>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
            {{ $existingReview ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}
        </button>
        @if ($existingReview)
            <span class="text-secondary small ms-2"><i class="bi bi-info-circle me-1"></i>Anda sedang mengedit ulasan sebelumnya.</span>
        @endif
    </div>
</form>

