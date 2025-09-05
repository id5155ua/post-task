<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostCards extends Component
{
    public function render()
    {
        $posts = Post::with('users', 'category')
            ->withCount('comments')
            ->latest()
            ->paginate(3);

        return view('livewire.post-cards', compact('posts'));
    }
}
