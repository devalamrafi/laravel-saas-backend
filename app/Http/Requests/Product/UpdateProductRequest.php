<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],

            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product),
            ],

            'description' => ['sometimes', 'nullable', 'string'],

            'price' => ['sometimes', 'required', 'numeric', 'min:0'],

            'compare_price' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
                'gte:price',
            ],

            'stock' => ['sometimes', 'required', 'integer', 'min:0'],

            'sku' => ['sometimes', 'nullable', 'string', 'max:100'],

            'status' => [
                'sometimes',
                'nullable',
                'in:active,inactive,draft',
            ],
        ];
    }
}