<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\StoreController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\HealthController;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/health', [HealthController::class, 'index']);
Route::middleware(['auth:sanctum','role:store_owner,super_admin'])->post('/v1/stores', [StoreController::class, 'store']);
Route::post('/v1/auth/register', [AuthController::class, 'register']);
Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/v1/auth/me', [AuthController::class, 'me']);
    Route::post('/v1/auth/logout', [AuthController::class, 'logout']);
});
Route::middleware(['auth:sanctum', 'role:super_admin'])->get('/v1/auth/admin-test', function () {
    return response()->json([
        'message' => 'Welcome Super Admin!',
    ]);
});
Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    Route::patch('/v1/users/{user}/role', [UserController::class, 'updateRole']);
});
Route::middleware(['auth:sanctum', 'role:store_owner,super_admin'])->get(
    '/v1/my-stores',
    [StoreController::class, 'index']
);