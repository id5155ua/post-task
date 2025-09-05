<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Статті користувача
 *
 * @property int $id
 * @property int $post_id ІД Статті
 * @property int $user_id ІД Користувача
 * @property int $created_at Створення
 * @property int $updated_at Оновлення
 */
class PostUser extends Model
{
    protected $table = 'post_user';

    protected $fillable = [
        'user_id',
        'post_id',
    ];
}
