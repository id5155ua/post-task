<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Post $post */
        $post = $this->route('post');

        if (! $post->users()->where('users.id', auth()->id())->exists()) {
            return false;
        }

        return true;
    }

    protected function failedAuthorization()
    {
        abort(403, 'It\'s not yours стаття.');
    }
}
