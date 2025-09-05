<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Категорія
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property Post $post
 * @property User $user
 */
class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
