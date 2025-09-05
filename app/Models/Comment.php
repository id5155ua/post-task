<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Категорія
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $content
 * @property User $user
 * @property Post $post
 */
class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'content'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
