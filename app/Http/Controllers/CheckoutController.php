<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Model
{
    public function index()
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

    public function store()
    {
        $user = Auth::user();

        /**
         * Provided data
         * payment method, address and cart infomation
         */

        // Validation
        // Reconfirmation of product and price
        // Preparing for payments with Stripe
        // Provisional registration of an order
        // Stripe payment confirmation
        // Registration of an order and update product stock

        return response()->json([
            'status' => 'suucess',
            'message' => 'hello world'
        ]);
    }
}
