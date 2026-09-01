<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],

            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->where('store_id', $this->route('store'))
                    ->ignore($category),
            ],

            'description' => ['sometimes', 'nullable', 'string'],

            'image' => ['sometimes', 'nullable', 'string', 'max:500'],

            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}