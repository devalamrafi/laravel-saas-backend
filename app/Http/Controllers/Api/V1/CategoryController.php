<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller{
    public function store(
        CreateCategoryRequest $request,
        $store
    ) {
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $slugExists = $store->categories()
            ->where('slug', $request->slug)
            ->exists();

        if ($slugExists) {
            throw ValidationException::withMessages([
                'slug' => ['This slug already exists in this store.'],
            ]);
        }

        $category = $store->categories()->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data' => $category,
        ], 201);
    }
}