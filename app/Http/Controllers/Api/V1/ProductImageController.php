<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(
        UploadProductImageRequest $request,
        $store,
        $product
    ) {
        // Find store owned by authenticated user
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        // Find product belonging to this store
        $product = $store->products()
            ->find($product);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        // Store image in storage/app/public/products
        $path = $request->file('image')
            ->store('products', 'public');

        // Save image path in database
        $productImage = $product->images()->create([
            'image' => $path,
            'is_primary' => $product->images()->count() === 0,
            'sort_order' => $product->images()->count(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product image uploaded successfully.',
            'data' => $productImage,
        ], 201);
    }

    public function index(
        Request $request,
        $store,
        $product
    ) {
        // Find store owned by authenticated user
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        // Find product belonging to this store
        $product = $store->products()
            ->find($product);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        $images = $product->images()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Product images retrieved successfully.',
            'data' => $images,
        ]);
    }


    public function destroy(
        Request $request,
        $store,
        $product,
        $image
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

        $product = $store->products()
            ->find($product);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        $productImage = $product->images()
            ->find($image);

        if (!$productImage) {
            return response()->json([
                'success' => false,
                'message' => 'Product image not found.',
            ], 404);
        }

        Storage::disk('public')->delete($productImage->image);

        $productImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product image deleted successfully.',
        ]);
    }
}