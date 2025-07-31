<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $products = Product::where('is_published', true)
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get('id');

        // TODO: If the user is logged in, retrieve the count of cart items
        //       from the database
        $cartItemCount = 0;

        return Inertia::render('home', [
            'user' => $user,
            'products' => $products,
            'cartItemCount' => $cartItemCount
        ]);
    }
}
