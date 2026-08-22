<?php

use App\Http\Controllers\Api\V1\StoreController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\HealthController;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/health', [HealthController::class, 'index']);
Route::post('/v1/stores', [StoreController::class, 'store']);