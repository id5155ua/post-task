<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Стаття
 *
 * @property int $id
 * @property string $title
 * @property string $post_id
 * @property int $category_id
 * @property int $created_at
 * @property int $updated_at
 */
class CategoryPost extends Model
{
    protected $table = 'category_post';

    protected $fillable = [
        'category_id',
        'post_id',
    ];
}
