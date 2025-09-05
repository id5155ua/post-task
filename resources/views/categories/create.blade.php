<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a category') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block">Category name</label>
                <input type="text" name="name" id="name" class="border rounded px-2 py-1 w-full" required />
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
            <a href="{{ route('categories.index') }}" class="text-gray-500 ml-2">Back</a>
        </form>
    </div>
</x-app-layout>
