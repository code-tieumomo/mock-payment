<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/history', [OrderController::class, 'history'])->name('order.history');

Route::get('/{order}/success', [OrderController::class, 'success'])->name('order.success');
Route::get('/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
Route::get('/{order}/failure', [OrderController::class, 'failure'])->name('order.failure');
Route::any('/{order}/webhook', [OrderController::class, 'webhook'])
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->name('order.webhook');
