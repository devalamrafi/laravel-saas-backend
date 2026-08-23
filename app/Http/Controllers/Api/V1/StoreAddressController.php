<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateStoreAddressRequest;
use App\Http\Requests\Store\UpdateStoreAddressRequest;
use Illuminate\Http\Request;

class StoreAddressController extends Controller
{
    public function store(CreateStoreAddressRequest $request,int $store) {
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        if ($store->address) {
            return response()->json([
                'success' => false,
                'message' => 'This store already has an address.',
            ], 422);
        }

        $address = $store->address()->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Store address created successfully.',
            'data' => $address,
        ], 201);
    }

    public function show(Request $request, int $store){
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $address = $store->address;

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Store address not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Store address retrieved successfully.',
            'data' => $address,
        ]);
    }

    public function update(UpdateStoreAddressRequest $request,int $store) {
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $address = $store->address;

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Store address not found.',
            ], 404);
        }

        $address->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Store address updated successfully.',
            'data' => $address->fresh(),
        ]);
    }

    public function destroy(Request $request, $store){
        $store = $request->user()
            ->stores()
            ->find($store);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.',
            ], 404);
        }

        $address = $store->address;

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Store address not found.',
            ], 404);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Store address deleted successfully.',
        ]);
    }
}
