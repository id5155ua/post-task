<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostUpdateRequest extends FormRequest
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
        abort(403, 'It\'s not yours post.');
    }

    public function rules(): array
    {
        $postId = $this->route('post')->id;

        return [
            'title' => [
                'required',
                'string',
                'max:191',
                Rule::unique('posts')->ignore($postId),
            ],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
