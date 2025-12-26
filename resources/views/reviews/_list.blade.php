<div class="d-flex flex-column gap-3">
    @forelse ($reviews as $review)
        <div data-aos="fade-up" data-aos-duration="500">
            <div class="card border-0 bg-light rounded-4 rounded-tl-0 shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex gap-3 align-items-center">
                        <!-- Avatar -->
                        <div class="shrink-0">
                            <div class="rounded-circle bg-gradient bg-success text-white d-flex align-items-center justify-content-center shadow-sm fw-bold fs-5"
                                style="width: 50px; height: 50px; background: linear-gradient(45deg, #198754, #20c997);">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                        </div>

                        <!-- Name and Time -->
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $review->user->name }}</h6>
                            <small class="text-secondary"
                                style="font-size: 0.75rem;">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Star Rating -->
                    <div class="d-flex align-items-center">
                        <span class="text-warning px-2 py-1 d-flex align-items-center gap-1">
                            <i class="bi bi-star-fill small"></i> {{ $review->rating }}
                        </span>
                    </div>
                </div>

                @if ($review->is_hidden)
                    <div class="alert alert-secondary py-2 px-3 small rounded-3 mb-2">
                        <i class="bi bi-eye-slash me-1"></i> Konten disembunyikan oleh moderator.
                    </div>
                @else
                    <p class="text-dark mb-2" style="font-size: 0.95rem;">{{ $review->comment }}</p>
                @endif

                <!-- Actions -->
                <div class="d-flex gap-3 justify-content-end opacity-75">
                    @auth
                        @can('delete', $review)
                            <form method="POST" action="{{ route('reviews.destroy', [$recipe, $review]) }}"
                                onsubmit="return confirm('Hapus ulasan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link link-danger p-0 text-decoration-none small"
                                    style="font-size: 0.8rem;">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        @endcan

                        @if (auth()->id() !== $review->user_id && !$review->is_reported)
                            <form method="POST" action="{{ route('reviews.report', $review) }}">
                                @csrf
                                <button type="submit" class="btn btn-link link-secondary p-0 text-decoration-none small"
                                    style="font-size: 0.8rem;">
                                    <i class="bi bi-flag"></i> Laporkan
                                </button>
                            </form>
                        @endif
                    @endauth

                    @can('moderate', $review)
                        <form method="POST" action="{{ route('reviews.moderate', $review) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-link link-dark p-0 text-decoration-none small"
                                style="font-size: 0.8rem;">
                                <i class="bi bi-shield-check"></i>
                                {{ $review->is_hidden ? 'Tampilkan' : 'Sembunyikan' }}
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-secondary">
            <i class="bi bi-chat-square-dots display-4 opacity-25 mb-3"></i>
            <p>Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
        </div>
    @endforelse
</div>

@if (method_exists($reviews, 'links'))
    <div class="mt-4 d-flex justify-content-center">
        {{ $reviews->links() }}
    </div>
@endif
