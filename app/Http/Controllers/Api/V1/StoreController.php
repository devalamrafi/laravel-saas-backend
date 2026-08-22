<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
        public function store(CreateStoreRequest $request)
        {
            $store = Store::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Store created successfully',
                'data' => $store,
            ], 201);
        }
}
