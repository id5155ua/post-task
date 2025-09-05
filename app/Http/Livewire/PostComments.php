<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;

class PostComments extends Component
{
    public Post $post;

    public string $newComment = '';

    public ?Comment $editingComment = null;

    public string $editingContent = '';

    protected $rules = [
        'newComment' => 'required|string|min:3|max:1000',
        'editingContent' => 'required|string|min:3|max:1000',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function addComment()
    {
        $this->validate(['newComment' => $this->rules['newComment']]);

        $this->post->comments()->create([
            'content' => $this->newComment,
            'user_id' => auth()->id(),
        ]);

        $this->newComment = '';
        $this->post->refresh();
    }

    /**
     * @throws AuthorizationException
     */
    protected function authorizeCommentAction(Comment $comment, string $action): void
    {
        $allowed = match ($action) {
            'update', 'delete' => auth()->id() === $comment->user_id,
            default => false
        };

        if (! $allowed) {
            throw new AuthorizationException('Unauthorized action.');
        }
    }

    public function startEditing(Comment $comment)
    {
        $this->authorizeCommentAction($comment, 'update');

        $this->editingComment = $comment;
        $this->editingContent = $comment->content;
    }

    public function updateComment()
    {
        $this->validate(['editingContent' => $this->rules['editingContent']]);

        $this->editingComment->update([
            'content' => $this->editingContent,
        ]);

        $this->cancelEditing();
        $this->post->refresh();
    }

    public function cancelEditing()
    {
        $this->editingComment = null;
        $this->editingContent = '';
    }

    public function deleteComment(Comment $comment)
    {
        $this->authorizeCommentAction($comment, 'delete');

        $comment->delete();
        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.post-comments', [
            'comments' => $this->post->comments()->with('user')->latest()->get(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
