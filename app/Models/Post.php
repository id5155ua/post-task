<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Стаття
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string $content Наповнення статті
 * @property int $category_id Звязок до категорії
 * @property int $created_at Створення
 * @property int $updated_at Оновлення
 * @property Comment[] $comments
 * @property Category $category
 * @property PostUser[] $postUser
 */
class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'category_id',
        'title',
        'content',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)
            ->with('user');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            PostUser::class,
            'post_id',
            'user_id')
            ->withTimestamps();
    }

    public function isAuthor(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->users()->where('users.id', $user->id)->exists();
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
