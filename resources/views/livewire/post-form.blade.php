<form wire:submit.prevent="save">
    <input type="text" wire:model="title" placeholder="Title" required>
    <textarea wire:model="content" placeholder="Content" required></textarea>
    <select wire:model="category_id" required>
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit">Save</button>
</form>
