<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;

use App\Services\CartService;

class ProductDetailController extends Controller
{
    public function __invoke(Product $product, CartService $cartService)
    {        
        return Inertia::render('product-detail', [
            'product' => $product,
            'cartItemCount' => $cartService->getCartItemCount(Auth::user())
        ]);
    }
}
