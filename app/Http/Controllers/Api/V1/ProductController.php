<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(CreateProductRequest $request,$store) {
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $product = $store->products()->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'data' => $product,
        ], 201);
    }

    public function index(Request $request, $store){
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $query = $store->products();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->integer('per_page', 10);

        $products = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully.',
            'data' => $products,
        ]);
    }

    public function show(Request $request, $store, $product){
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $product = $store->products()
            ->find($product);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product retrieved successfully.',
            'data' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, $store, $product) {
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $product = $store->products()
            ->find($product);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        $product->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.',
            'data' => $product->fresh(),
        ]);
    }

    public function destroy(Request $request, $store, $product){
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $product = $store->products()
            ->find($product);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        $product->update([
            'status' => 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product deactivated successfully.',
            'data' => $product->fresh(),
        ]);
    }
}