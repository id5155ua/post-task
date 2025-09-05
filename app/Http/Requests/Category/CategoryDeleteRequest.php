<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CategoryDeleteRequest extends FormRequest
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
}
