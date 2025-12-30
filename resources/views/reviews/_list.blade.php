<div class="flex flex-col gap-4">
    @forelse ($reviews as $review)
        <div data-aos="fade-up" data-aos-duration="500" x-data="{ replyOpen: false }">
            <div class="bg-gray-100 dark:bg-neutral-900/50 rounded-2xl p-4">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex gap-3 items-center">
                        <!-- Avatar -->
                        <a href="{{ route('users.show', $review->user) }}" class="shrink-0 group block">
                            @if ($review->user->avatar)
                                <img src="{{ asset('storage/' . $review->user->avatar) }}" alt="{{ $review->user->name }}"
                                    class="w-10 h-10 aspect-square rounded-full object-cover ring-2 ring-transparent group-hover:ring-orange-400 transition-all">
                            @else
                                <div
                                    class="rounded-full bg-linear-to-r from-amber-500 to-orange-600 text-white flex items-center justify-center font-bold text-sm w-10 h-10 aspect-square ring-2 ring-transparent group-hover:ring-orange-400 dark:group-hover:ring-orange-500 transition-all">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </a>

                        <div>
                            <a href="{{ route('users.show', $review->user) }}"
                                class="font-bold mb-0 text-gray-900 dark:text-gray-100 hover:text-orange-600 dark:hover:text-orange-400 transition-colors text-sm no-underline">
                                {{ $review->user->name }}
                            </a>
                            <small
                                class="text-gray-500 dark:text-gray-400 text-[10px] block">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Star Rating (Only for top level) -->
                    <div class="flex items-center">
                        <span
                            class="text-amber-500 px-2 py-1 flex items-center gap-1 bg-white dark:bg-neutral-800 rounded-lg shadow-sm border border-gray-100 dark:border-neutral-700">
                            <i class="bi bi-star-fill text-xs"></i> <span
                                class="text-xs font-bold">{{ $review->rating }}</span>
                        </span>
                    </div>
                </div>

                @if ($review->is_hidden)
                    <div
                        class="bg-gray-200 dark:bg-neutral-800 py-2 px-3 text-xs rounded-lg mb-2 text-gray-600 dark:text-gray-400 italic">
                        <i class="bi bi-eye-slash mr-1"></i> Konten disembunyikan oleh moderator.
                    </div>
                @else
                    <p class="text-gray-800 dark:text-gray-200 mb-3 text-sm leading-relaxed">{{ $review->comment }}</p>
                @endif

                <!-- Actions -->
                <div
                    class="flex gap-4 justify-between items-center border-t border-gray-200/50 dark:border-neutral-700 pt-2 mt-2">
                    <div class="flex gap-3">
                        @auth
                            <button @click="replyOpen = !replyOpen"
                                class="text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 font-bold text-xs bg-transparent border-0 cursor-pointer flex items-center gap-1">
                                <i class="bi bi-reply-fill"></i> Balas
                            </button>
                        @endauth
                    </div>

                    <div class="flex gap-3 opacity-60 hover:opacity-100 transition-opacity">
                        @auth
                            @can('delete', $review)
                                <form method="POST" action="{{ route('reviews.destroy', [$recipe, $review]) }}"
                                    onsubmit="return showConfirmModal(this, 'Hapus Ulasan', 'Apakah Anda yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 p-0 bg-transparent border-0 text-[10px] cursor-pointer"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endcan

                            @if (auth()->id() !== $review->user_id && !$review->is_reported)
                                <form method="POST" action="{{ route('reviews.report', $review) }}">
                                    @csrf
                                    <button type="submit"
                                        class="text-gray-500 hover:text-gray-700 p-0 bg-transparent border-0 text-[10px] cursor-pointer"
                                        title="Laporkan">
                                        <i class="bi bi-flag"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth

                        @can('moderate', $review)
                            <form method="POST" action="{{ route('reviews.moderate', $review) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="text-gray-700 hover:text-gray-900 p-0 bg-transparent border-0 text-[10px] cursor-pointer"
                                    title="Moderasi">
                                    <i class="bi bi-shield-check"></i>
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Reply Form -->
            @auth
                <div x-show="replyOpen" x-transition class="mt-2 ml-8">
                    <form action="{{ route('reviews.store', $recipe) }}" method="POST"
                        class="bg-gray-50 dark:bg-neutral-900/30 p-3 rounded-xl border border-gray-200 dark:border-neutral-800">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $review->id }}">
                        <input type="hidden" name="rating" value="5">

                        <div class="flex gap-2">
                            <input type="text" name="comment" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-950 focus:border-orange-400 dark:focus:border-orange-500 outline-none transition-all bg-white dark:bg-neutral-800 dark:text-gray-100"
                                placeholder="Tulis balasan Anda...">
                            <button type="submit"
                                class="bg-orange-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-orange-600 transition-colors shrink-0">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            @endauth

            <!-- Replies List -->
            @if ($review->replies->count() > 0)
                <div class="mt-2 ml-8 flex flex-col gap-2 border-l-2 border-gray-200 dark:border-neutral-800 pl-4 py-1">
                    @foreach ($review->replies as $reply)
                        <div
                            class="bg-white dark:bg-neutral-800 p-3 rounded-xl border border-gray-100 dark:border-neutral-700 shadow-sm">
                            <div class="flex justify-between items-start mb-1">
                                <div class="flex gap-2 items-center">
                                    <a href="{{ route('users.show', $reply->user) }}"
                                        class="font-bold text-xs text-gray-900 dark:text-gray-100 hover:text-orange-600 dark:hover:text-orange-400 no-underline">
                                        {{ $reply->user->name }}
                                    </a>
                                    <span class="text-gray-400 dark:text-gray-500 text-[10px]">&bull;</span>
                                    <small
                                        class="text-gray-500 dark:text-gray-400 text-[10px]">{{ $reply->created_at->diffForHumans() }}</small>
                                </div>

                                @can('delete', $reply)
                                    <form method="POST" action="{{ route('reviews.destroy', [$recipe, $reply]) }}"
                                        onsubmit="return showConfirmModal(this, 'Hapus Balasan', 'Hapus balasan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-400 hover:text-red-600 border-0 bg-transparent cursor-pointer text-[10px]">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-xs">{{ $reply->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <div
            class="text-center py-12 text-gray-500 dark:text-gray-400 bg-white dark:bg-neutral-900/30 rounded-2xl border border-dashed border-gray-300 dark:border-neutral-700">
            <i class="bi bi-chat-square-dots text-4xl opacity-25 mb-2 block"></i>
            <p class="text-sm">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
        </div>
    @endforelse
</div>

@if (method_exists($reviews, 'links'))
    <div class="mt-4 flex justify-center">
        {{ $reviews->links('vendor.pagination.bootstrap-5') }}
    </div>
@endif