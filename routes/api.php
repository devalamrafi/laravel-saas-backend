<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\StoreAddressController;
use App\Http\Controllers\Api\V1\StoreController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\HealthController;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/health', [HealthController::class, 'index']);

// Auth routes
Route::post('/v1/auth/register', [AuthController::class, 'register']);
Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/v1/auth/me', [AuthController::class, 'me']);
    Route::post('/v1/auth/logout', [AuthController::class, 'logout']);
});
// Route::middleware(['auth:sanctum', 'role:super_admin'])->get('/v1/auth/admin-test', function () {
//     return response()->json([
//         'message' => 'Welcome Super Admin!',
//     ]);
// });
Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    Route::patch('/v1/users/{user}/role', [UserController::class, 'updateRole']);
});

// Store routes
Route::middleware(['auth:sanctum','role:store_owner,super_admin'])->post('/v1/stores', [StoreController::class, 'store']);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->get(
    '/v1/my-stores',
    [StoreController::class, 'index']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->get(
    '/v1/my-stores/{store}',
    [StoreController::class, 'show']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->patch(
    '/v1/my-stores/{store}',
    [StoreController::class, 'update']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->delete(
    '/v1/my-stores/{store}',
    [StoreController::class, 'destroy']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->post(
    '/v1/my-stores/{store}/address',
    [StoreAddressController::class, 'store']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->get(
    '/v1/my-stores/{store}/address',
    [StoreAddressController::class, 'show']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->patch(
    '/v1/my-stores/{store}/address',
    [StoreAddressController::class, 'update']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->delete(
    '/v1/my-stores/{store}/address',
    [StoreAddressController::class, 'destroy']
);

// Product routes
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->post(
    '/v1/my-stores/{store}/products',
    [ProductController::class, 'store']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->get(
    '/v1/my-stores/{store}/products',
    [ProductController::class, 'index']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->get(
    '/v1/my-stores/{store}/products/{product}',
    [ProductController::class, 'show']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->patch(
    '/v1/my-stores/{store}/products/{product}',
    [ProductController::class, 'update']
);
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->delete(
    '/v1/my-stores/{store}/products/{product}',
    [ProductController::class, 'destroy']
);

// Category routes
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->post(
    '/v1/my-stores/{store}/categories',
    [CategoryController::class, 'store']
);