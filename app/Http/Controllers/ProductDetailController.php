<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;


class ProductDetailController extends Controller
{
    public function __invoke(Product $product)
    {        
        $user = Auth::user();

        $cartItemCount = $user?->cartItemCount() ?? 0;

        return Inertia::render('product-detail', [
            'product' => $product,
            'cartItemCount' => $cartItemCount
        ]);
    }
}
