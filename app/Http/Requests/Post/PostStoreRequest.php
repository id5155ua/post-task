<?php

namespace App\Http\Requests\Post;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191', 'unique:posts,title'],
            'content' => ['required', 'string'],
            'category_id' => [
                'required',
                'integer',
                Rule::exists(Category::class, 'id'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'The title has already been taken.',
            'title.max' => 'The title too long.',
        ];
    }
}
