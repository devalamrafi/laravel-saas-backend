<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => ['nullable', 'string'],

            'image' => ['nullable', 'string', 'max:500'],

            'is_active' => ['nullable', 'boolean'],
        ];
    }
}