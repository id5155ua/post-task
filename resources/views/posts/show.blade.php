<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6 max-w-4xl">
        <!-- Карточка post -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <!-- Заголовок карточки -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">{{ $post->title }}</h3>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <span>Category: {{ $post->category->name }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $post->comments->count() }} comments</span>
                </div>
            </div>

            <!-- Контент карточки -->
            <div class="p-6">
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <!-- Футер карточки с действиями -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                <a href="{{ route('posts.index') }}" class="text-gray-500 hover:text-gray-700">
                    ← Back to list
                </a>
            </div>
        </div>

        @livewire('post-comments', ['post' => $post])
    </div>
</x-app-layout>
