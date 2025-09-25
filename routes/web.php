<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');

Route::get('/products/{product}', ProductDetailController::class)->name('product-detail');

// Stripe
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/items/{item}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/checkout/success', function () {
        return Inertia::render('checkout-success');
    })->name('checkout.success');
    Route::get('/checkout/cancel', function () {
        return Inertia::render('checkout-cancel');
    })->name('checkout.cancel');

    Route::post('/shipping-addresses', [AddressController::class, 'store'])->name('shipping-addresses');

    
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
