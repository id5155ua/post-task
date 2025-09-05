<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $posts = Post::where('title', 'like', '%'.$this->search.'%')->paginate(10);

        return view('livewire.post-index', ['posts' => $posts]);
    }
}
