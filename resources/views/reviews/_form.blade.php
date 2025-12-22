@php
    $existingReview = $recipe->reviews()->where('user_id', auth()->id())->first();
@endphp

<form method="POST" action="{{ route('reviews.store', $recipe) }}" class="mb-4">
    @csrf
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label small">Rating</label>
            <select name="rating" class="form-select" required>
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" @selected(old('rating', $existingReview?->rating) == $i)>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-9">
            <label class="form-label small">Comment</label>
            <textarea name="comment" rows="2" class="form-control" placeholder="What did you think?">{{ old('comment', $existingReview?->comment) }}</textarea>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3 mt-3">
        <button type="submit" class="btn btn-success btn-sm">
            {{ $existingReview ? 'Update review' : 'Post review' }}
        </button>
        @if ($existingReview)
            <span class="text-muted small">Editing your previous review</span>
        @endif
    </div>
</form>

