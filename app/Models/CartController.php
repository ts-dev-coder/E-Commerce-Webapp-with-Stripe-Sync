<?php

namespace App\Models;

use App\Http\Requests\StoreCartRequest;

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

    /**
     * Validation and product existence check are handled in the StoreCartRequest class.
     */
    public function store(StoreCartRequest $request)
    {
        // TODO: Separate the logic for authenticated and non-authenticated cases after the authentication feature is implemented on the frontend.
        $cart = Cart::where('user_id', 1)->first();
        
        // TODO: CartItem内に同一の商品のデータを検索
        // TODO: あれば、quantityを更新する
        // TODO: なければ、新たなCartItemとして保存
        
        return response()->json([
            'message' => 'hello world',
            'cart' => $cart
        ]); 
    }
}
