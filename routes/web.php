<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderCompleteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');
Route::get('/products/{id}', ProductDetailController::class)->name('product-detail');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/order/complete', OrderCompleteController::class)->name('order-complete');

Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::delete('/cart', [CartController::class, 'destroy'])->name('delete.destroy');

// TODO: Add success route and cancel route for stripe

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
