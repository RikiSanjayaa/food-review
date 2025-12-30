@forelse ($replies as $reply)
    <div class="bg-white dark:bg-neutral-800 p-3 rounded-xl border border-gray-100 dark:border-neutral-700 shadow-sm">
        <div class="flex justify-between items-start mb-1">
            <div class="flex gap-2 items-center">
                <a href="{{ route('users.show', $reply->user) }}"
                    class="font-bold text-xs text-gray-900 dark:text-gray-100 hover:text-orange-600 dark:hover:text-orange-400 no-underline">
                    {{ $reply->user->name }}
                </a>
                <span class="text-gray-400 dark:text-gray-500 text-[10px]">&bull;</span>
                <small class="text-gray-500 dark:text-gray-400 text-[10px]">{{ $reply->created_at->diffForHumans() }}</small>
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
@empty
    <div class="text-center py-4 text-gray-400 dark:text-gray-500 text-xs">
        Belum ada balasan.
    </div>
@endforelse
