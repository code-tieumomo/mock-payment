<?php

use App\Http\Controllers\OrderController;
use App\Http\Middleware\EnsureRequestHasApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('orders', [OrderController::class, 'store'])
    ->middleware(EnsureRequestHasApiKey::class)
    ->middleware('throttle:2,1');
