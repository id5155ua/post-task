<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create post') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        @if ($categories->isEmpty())
            <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Нет доступных категорий!</strong>
                <span class="block sm:inline">Пожалуйста, создайте хотя бы одну категорию, прежде чем создавать статью.</span>
            </div>
            <div class="mb-4">
                <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create a category</a>
            </div>
        @else
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block">Title</label>
                    <input type="text" name="title" id="title"
                           class="border rounded px-2 py-1 w-full @error('title') border-red-500 @enderror"
                           value="{{ old('title') }}" required />
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="content" class="block">content</label>
                    <textarea name="content" id="content" class="border rounded px-2 py-1 w-full" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block">Category</label>
                    <select name="category_id" id="category_id" class="border rounded px-2 py-1 w-full" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
                <a href="{{ route('posts.index') }}" class="text-gray-500 ml-2">Back</a>
            </form>
        @endif
    </div>
</x-app-layout>
