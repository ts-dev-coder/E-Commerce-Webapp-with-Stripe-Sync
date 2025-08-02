<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $products = Product::where('is_published', true)
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get(['id', 'name', 'description', 'price', 'stock']);

        $cartItemCount = 0;
        if ($user && $user->cart) {
            $cartItemCount = $user->cart->items()->count();
        }

        return Inertia::render('home', [
            'user' => $user,
            'products' => $products,
            'cartItemCount' => $cartItemCount
        ]);
    }
}
