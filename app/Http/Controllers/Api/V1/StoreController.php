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
            $store = Store::create([
                ...$request->validated(),
                'owner_id' => $request->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Store created successfully',
                'data' => $store,
            ], 201);
        }

        public function index(Request $request){
            $query = $request->user()->stores();

            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $perPage = $request->integer('per_page', 10);

            $stores = $query
                ->latest()
                ->paginate($perPage)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Stores retrieved successfully.',
                'data' => $stores,
            ]);
        }
}
