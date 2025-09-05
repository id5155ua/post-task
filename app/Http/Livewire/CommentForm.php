<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentForm extends Component
{
    public $postId;

    public $content;

    protected $rules = [
        'content' => 'required|string',
    ];

    public function save()
    {
        $this->validate();

        Comment::create([
            'content' => $this->content,
            'post_id' => $this->postId,
        ]);

        $this->reset('content');
        $this->emit('commentAdded');
    }

    public function render()
    {
        return view('livewire.comment-form');
    }
}
