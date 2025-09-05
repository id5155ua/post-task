<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostForm extends Component
{
    public $postId;

    public $title;

    public $content;

    public $category_id;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'required|exists:categories,id',
    ];

    public function mount($postId = null)
    {
        if ($postId) {
            $post = Post::find($postId);
            $this->postId = $post->id;
            $this->title = $post->title;
            $this->content = $post->content;
            $this->category_id = $post->category_id;
        }
    }

    public function save()
    {
        $this->validate();

        Post::updateOrCreate(
            ['id' => $this->postId],
            [
                'title' => $this->title,
                'content' => $this->content,
                'category_id' => $this->category_id,
            ]
        );

        $this->reset();
        $this->emit('postSaved');
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}
