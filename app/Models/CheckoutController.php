<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Model
{
    public function __invoke()
    {
        $user = Auth::user();

        // TODO: Refactor to use Eloquent relationship from User model instead of
        //       querying directly
        $registeredDeliveryAddress = Address::where('user_id', 1)->get()->first();

        // TODO: Add payments table
        $registeredPaymentMethod = null;

        $cart = Cart::with('items.product')
                    ->where('user_id', 1)
                    ->first();

        $products = $cart->items->pluck('product');

        // TODO: If the user is logged in, retrieve the count of cart items
        //       from the database
        $cartItemCount = count($products);

        // TODO: Change response data to page component
        return response()->json([
            'message' => 'hello world',
            'products' => $products,
            'cartItemCount' => $cartItemCount,
            'registeredDeliveryAddress' => $registeredDeliveryAddress,
            'registeredPaymentMethod' => $registeredPaymentMethod
        ]);
    }
}
