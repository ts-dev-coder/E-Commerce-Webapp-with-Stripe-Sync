<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreCheckoutRequest;

use App\Services\CartService;
use App\Services\StripeCheckoutService;

class CheckoutController extends Controller
{
    public function index(CartService $cartService)
    {
        $user = Auth::user();

        $activeCart = $cartService->getOrCreateActiveCart($user);
        $cartItems = $activeCart->items;

        if($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // TODO: fetch the products image;

        return Inertia::render('checkout', [
            'cartItems' => $cartItems,
            'cartItemCount' => $cartService->getCartItemCount($user),
            'defaultAddress' => $user->defaultAddress,
            'addresses' => $user->nonDefaultAddresses,
            'shippingFee' => $cartService->getShippingFee(),
            'subTotal' => $cartService->getSubtotal($activeCart),
            'totalPrice' => $cartService->getTotal($activeCart)
        ]);
    }

    public function store(StoreCheckoutRequest $request, CartService $cartService, StripeCheckoutService $chekcoutService)
    {
        $activeCart = $cartService->getOrCreateActiveCart(Auth::user());

        $session = $chekcoutService->createCheckoutSession($activeCart);
            
        return Inertia::location($session->url);
    }
}
