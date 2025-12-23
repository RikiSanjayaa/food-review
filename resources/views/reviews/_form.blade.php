@php
    $existingReview = $recipe->reviews()->where('user_id', auth()->id())->first();
@endphp

<form method="POST" action="{{ route('reviews.store', $recipe) }}" class="mb-4 bg-light p-4 rounded-4 shadow-sm border-0">
    @csrf
    <h5 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2"></i>{{ $existingReview ? 'Edit Ulasan Anda' : 'Tulis Ulasan' }}</h5>
    
    <div class="mb-3">
        <label class="form-label fw-medium small text-uppercase text-secondary">Rating</label>
        <div class="rating-css">
            <select name="rating" class="form-select rounded-pill" required>
                <option value="" disabled selected>Pilih Bintang...</option>
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" @selected(old('rating', $existingReview?->rating) == $i)>{{ $i }} Bintang {{ str_repeat('★', $i) }}</option>
                @endfor
            </select>
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

