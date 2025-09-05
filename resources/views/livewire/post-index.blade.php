<div>
    <input type="text" wire:model="search" placeholder="Search by title" />

    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>
                    <button wire:click="edit({{ $post->id }})">Edit</button>
                    <button wire:click="delete({{ $post->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}
</div>
