<?php

namespace App\Http\Requests\Api\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Category $category */
        $category = Category::find($this->route('category'))->first();

        if (empty($category)) {
            return false;
        }

        if ($category->user_id !== auth()->id()) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        $category = Category::find($this->route('category'))->first();

        return [
            'name' => ['required', 'string', Rule::unique('categories', 'name')->ignore($category->id)],
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, 'it\'s not yours category.');
    }
}
