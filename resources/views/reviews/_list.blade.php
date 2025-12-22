<div class="list-group list-group-flush">
    @forelse ($reviews as $review)
        <div class="list-group-item">
            <div class="d-flex gap-3">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <span class="text-muted fw-semibold">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <div class="fw-semibold">{{ $review->user->name }}</div>
                            <div class="text-muted small">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="fw-semibold text-warning">{{ $review->rating }}★</span>
                            @if ($review->is_hidden)
                                <span class="badge text-bg-danger">Hidden</span>
                            @endif
                            @if ($review->is_reported)
                                <span class="badge text-bg-warning">Reported</span>
                            @endif
                        </div>
                    </div>
                    @if ($review->comment)
                        <p class="mt-2 mb-2">{{ $review->comment }}</p>
                    @endif
                    <div class="d-flex align-items-center gap-3 text-muted small">
                        @can('delete', $review)
                            <form method="POST" action="{{ route('reviews.destroy', [$recipe, $review]) }}" onsubmit="return confirm('Delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm p-0">Delete</button>
                            </form>
                        @endcan
                        @auth
                            @if (! $review->is_reported && ! auth()->user()->is_admin)
                                <form method="POST" action="{{ route('reviews.report', $review) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm p-0">Report</button>
                                </form>
                            @endif
                        @endauth
                        @can('moderate', $review)
                            <form method="POST" action="{{ route('reviews.moderate', $review) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-link btn-sm p-0">
                                    {{ $review->is_hidden ? 'Unhide' : 'Hide' }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted small py-3">No reviews yet. Be the first!</p>
    @endforelse
</div>

@if ($reviews instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-3">
        {{ $reviews->links() }}
    </div>
@endif

