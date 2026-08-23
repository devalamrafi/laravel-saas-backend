<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],

            'description' => ['nullable', 'string'],

            'price' => ['required', 'numeric', 'min:0'],

            'compare_price' => ['nullable', 'numeric', 'min:0', 'gte:price'],

            'stock' => ['required', 'integer', 'min:0'],

            'sku' => ['nullable', 'string', 'max:100'],

            'status' => ['nullable', 'in:active,inactive,draft'],
            
        ];
    }
}