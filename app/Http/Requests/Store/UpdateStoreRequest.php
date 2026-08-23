<?php

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],

            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('stores', 'slug')->ignore($this->route('store')),
            ],

            'email' => ['sometimes', 'nullable', 'email'],

            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],

            'description' => ['sometimes', 'nullable', 'string'],

            'logo' => ['sometimes', 'nullable', 'string', 'max:255'],

            'banner' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
