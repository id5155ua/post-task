<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Category $category */
        $category = $this->route('category');

        if (empty($category)) {
            return false;
        }

        if ($category->user_id !== auth()->id()) {
            return false;
        }

        return true;
    }

    protected function failedAuthorization()
    {
        abort(403, 'it\'s not yours category.');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:191',
                Rule::unique('categories', 'name')->ignore($this->route('category')->id),
            ],
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
