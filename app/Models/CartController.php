<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CartController extends Model
{
    public function index()
    {
        $user = Auth::user();

        // TODO: Replace hardcoded user_id with authenticated user's ID
        //       after implementing auth

        // TODO: If user is not login, use the session id
        $cart = Cart::with('items.product')
                    ->where('user_id', 1)
                    ->first();

        $products = $cart->items->pluck('product');

        // TODO: fetch the products image

        $cartItemCount = count($products);

        // TODO: Change return page component
        return response()->json([
            'message' => 'suucess',
            'products' => $products,
            'cartItemCount' => $cartItemCount
        ]);
    }
}
