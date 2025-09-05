<div>

    <div class="mb-4 text-sm text-gray-600">
        {{ $comments->count() }} comments
    </div>

    <!-- List of Comments -->
    <div class="space-y-4" wire:poll.5000ms>
        @forelse($comments as $comment)
            <div class="bg-white p-4 rounded-lg border border-gray-200" wire:key="comment-{{ $comment->id }}">
                @if($editingComment?->id === $comment->id)
                    <!-- Режим редактирования -->
                    <div>
                        <textarea
                            wire:model="editingContent"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            rows="3"
                        ></textarea>
                        <div class="mt-2 flex space-x-2">
                            <button
                                wire:click="updateComment"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition"
                            >
                                Сохранить
                            </button>
                            <button
                                wire:click="cancelEditing"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-1 rounded text-sm transition"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Обычный режим просмотра -->
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="font-medium text-gray-800">
                                {{ $comment->user->name }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                            @if($comment->updated_at != $comment->created_at)
                                <span class="text-xs text-gray-400">(изменен)</span>
                            @endif
                        </div>

                        @auth
                            @if(auth()->id() === $comment->user_id)
                                <div class="flex space-x-2">
                                    <button
                                        wire:click="startEditing({{ $comment->id }})"
                                        class="text-blue-600 hover:text-blue-800 text-sm"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        wire:click="deleteComment({{ $comment->id }})"
                                        onclick="return confirm('Delete comment?')"
                                        class="text-red-600 hover:text-red-800 text-sm"
                                    >
                                        Delete
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $comment->content }}</p>
                @endif
            </div>
        @empty
            <div class="text-center text-gray-500 py-8">
                No comments yet. Be the first!
            </div>
        @endforelse
    </div>

    <!-- Форма добавления comment -->
    @auth
        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium text-gray-800 mb-3">Add new comment</h4>
            <form wire:submit.prevent="addComment">
                <div class="mb-3">
                    <textarea
                        wire:model="newComment"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        rows="3"
                        placeholder="Write your comment..."
                        required
                    ></textarea>
                    @error('newComment')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Отправить comment</span>
                    <span wire:loading>Отправка...</span>
                </button>
            </form>
        </div>
    @else
        <div class="mt-6 text-center text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Войдите</a>, чтобы оставить comment
        </div>
    @endauth
</div>
