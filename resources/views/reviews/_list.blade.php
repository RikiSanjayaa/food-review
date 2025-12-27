<div class="flex flex-col gap-3">
    @forelse ($reviews as $review)
        <div data-aos="fade-up" data-aos-duration="500">
            <div class="bg-gray-100 rounded-2xl p-3">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex gap-3 items-center">
                        <!-- Avatar -->
                        <div class="shrink-0">
                            <div
                                class="rounded-full bg-linear-to-r from-amber-500 to-orange-600 text-white flex items-center justify-center font-bold text-lg w-12 h-12">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                        </div>

                        <!-- Name and Time -->
                        <div>
                            <h6 class="font-bold mb-0 text-gray-900">{{ $review->user->name }}</h6>
                            <small class="text-gray-500 text-xs">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Star Rating -->
                    <div class="flex items-center">
                        <span class="text-amber-500 px-2 py-1 flex items-center gap-1">
                            <i class="bi bi-star-fill text-sm"></i> {{ $review->rating }}
                        </span>
                    </div>
                </div>

                @if ($review->is_hidden)
                    <div class="bg-gray-200 py-2 px-3 text-sm rounded-lg mb-2 text-gray-600">
                        <i class="bi bi-eye-slash mr-1"></i> Konten disembunyikan oleh moderator.
                    </div>
                @else
                    <p class="text-gray-900 mb-2 text-sm">{{ $review->comment }}</p>
                @endif

                <!-- Actions -->
                <div class="flex gap-3 justify-end opacity-75">
                    @auth
                        @can('delete', $review)
                            <form method="POST" action="{{ route('reviews.destroy', [$recipe, $review]) }}"
                                onsubmit="return confirm('Hapus ulasan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 p-0 bg-transparent border-0 text-xs cursor-pointer">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        @endcan

                        @if (auth()->id() !== $review->user_id && !$review->is_reported)
                            <form method="POST" action="{{ route('reviews.report', $review) }}">
                                @csrf
                                <button type="submit"
                                    class="text-gray-500 hover:text-gray-700 p-0 bg-transparent border-0 text-xs cursor-pointer">
                                    <i class="bi bi-flag"></i> Laporkan
                                </button>
                            </form>
                        @endif
                    @endauth

                    @can('moderate', $review)
                        <form method="POST" action="{{ route('reviews.moderate', $review) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="text-gray-700 hover:text-gray-900 p-0 bg-transparent border-0 text-xs cursor-pointer">
                                <i class="bi bi-shield-check"></i>
                                {{ $review->is_hidden ? 'Tampilkan' : 'Sembunyikan' }}
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 text-gray-500">
            <i class="bi bi-chat-square-dots text-6xl opacity-25 mb-3 block"></i>
            <p>Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
        </div>
    @endforelse
</div>

@if (method_exists($reviews, 'links'))
    <div class="mt-4 flex justify-center">
        {{ $reviews->links() }}
    </div>
@endif
