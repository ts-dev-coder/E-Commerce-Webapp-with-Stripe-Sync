<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\CartRepository;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index(CartRepository $cartRepository)
    {
        $user = Auth::user();

        $activeCart = $cartRepository->getOrCreateActiveCart($user->id);
        $cartItems = $activeCart->items;

        if($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // TODO: fetch the products image

        $defaultAddress = $user->defaultAddress;

        return Inertia::render('checkout', [
            'cartItems' => $cartItems,
            'cartItemCount' => count($cartItems),
            'defaultAddress' => $defaultAddress
        ]);
    }

    public function store(StoreCheckoutRequest $request, CartService $cartService)
    {

        $user = Auth::user();
        $cart = Cart::with('items.product')
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->first();

        Stripe::setApiKey(config('services.stripe.secret'));
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

        $lineItems[] = [
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => '配送料',
                ],
                'unit_amount' => 500, // 500円
            ],
            'quantity' => 1,
        ];

        // Checkout セッション作成
        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);
            
        return Inertia::location($session->url);
    }
}
