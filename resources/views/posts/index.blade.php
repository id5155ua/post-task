<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of posts') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                Create post
            </a>

            <form method="GET" action="{{ route('posts.index') }}" class="w-full sm:w-auto">
                <div class="flex gap-2">
                    <input type="text" name="search" placeholder="Search by title"
                           class="border rounded px-3 py-2 flex-1 sm:w-64"
                           value="{{ request('search') }}" />
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                        Search
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Мобильные карточки -->
        <div class="space-y-4 md:hidden">
            @foreach ($posts as $post)
                <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-800 text-sm">{{ $post->title }}</h3>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                            {{ $post->category->name }}
                        </span>
                    </div>

                    <div class="text-xs text-gray-500 mb-3">
                        Создано: {{ $post->created_at->diffForHumans() }}
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('posts.show', $post) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm px-2 py-1 border border-blue-300 rounded">
                            Show
                        </a>
                        <a href="{{ route('posts.edit', $post) }}"
                           class="text-yellow-600 hover:text-yellow-800 text-sm px-2 py-1 border border-yellow-300 rounded">
                            Edit
                        </a>
                        <button wire:click="confirmDelete({{ $post->id }})"
                                class="text-red-600 hover:text-red-800 text-sm px-2 py-1 border border-red-300 rounded">
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Десктопная таблица -->
        <div class="hidden md:block">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            TITLE
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            CREATED
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ACTION
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($posts as $post)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $post->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $post->category->name }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $post->created_at->format('d.m.Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-900">Show</a>
                                    <a href="{{ route('posts.edit', $post) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Delete post ?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Пагинация -->
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
