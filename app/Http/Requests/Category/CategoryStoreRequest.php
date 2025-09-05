<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191', 'unique:categories,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'The name has already been taken.',
            'name.max' => 'The name too long.',
        ];
    }
}
