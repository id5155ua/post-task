<?php

namespace App\Queries;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostIndexQuery
{
    private ?string $search;

    public function __construct(?string $search)
    {
        $this->search = $search;
    }

    public function __invoke(): Builder
    {
        return Post::query()
            ->with('category')
            ->withCount('comments')
            ->when($this->search, function ($q, $s) {
                return $q->where('title', 'like', "%{$s}%");
            })
            ->latest();
    }
}
