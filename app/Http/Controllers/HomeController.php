<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;

class HomeController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $categories = Category::all();
        $result = [];
        foreach ($categories as $category) {
            $products = $category->products()
                        ->where('is_published', true)
                        ->where('stock', '>', 0)
                        ->limit(5)
                        ->get(['id', 'name', 'description', 'price', 'max_quantity']);
            $result[$category->name] = $products;
        }

        $cartItemCount = 0;
        if ($user && $user->cart) {
            $cartItemCount = $user->cart->items()->count();
        }

        return Inertia::render('home', [
            'categoryProducts' => $result,
            'cartItemCount' => $cartItemCount
        ]);
    }
}
