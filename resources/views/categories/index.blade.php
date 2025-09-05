@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('categories.create') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                Create a category
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Мобильные карточки -->
        <div class="space-y-4 md:hidden">
            @foreach ($categories as $category)
                <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800">{{ $category->name }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="text-yellow-600 hover:text-yellow-800 text-sm px-2 py-1 border border-yellow-300 rounded">
                                Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm px-2 py-1 border border-red-300 rounded"
                                        onclick="return confirm('Delete category?')">
                                    Delete
                                </button>
                            </form>
                        </div>
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
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ACTION
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $category->name }}
                                </div>
                            </td>
                            @if($category->user_id === Auth::user()->id)
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Delete category?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @else
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
