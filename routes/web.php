<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductDetailController;
use App\Models\CartController;
use App\Models\CheckoutController;
use App\Models\OrderCompleteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');
Route::get('/products/{id}', ProductDetailController::class)->name('product-detail');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', CheckoutController::class)->name('checkout');
Route::get('/order/complete', OrderCompleteController::class)->name('order-complete');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
