<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;

use App\Models\Cart;

class StripeCheckoutService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * カート情報からStripeのCheckoutセッションを作成
     *
     * @param Cart $cart
     * @return Session
     */
    public function createCheckoutSession(Cart $cart): Session
    {
        $lineItems = $cart->items->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        // 配送料を追加
        $lineItems[] = [
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => 'Shipping Fee',
                ],
                'unit_amount' => 500,
            ],
            'quantity' => 1,
        ];

        return Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);
    }
}
