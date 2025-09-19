<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreCheckoutRequest;

use App\Repositories\CartRepository;
use App\Services\StripeCheckoutService;

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
            'cartItemCount' => $cartItems->count(),
            'defaultAddress' => $defaultAddress
        ]);
    }

    public function store(StoreCheckoutRequest $request, CartRepository $cartRepository, StripeCheckoutService $chekcoutService)
    {
        $cart = $cartRepository->getOrCreateActiveCart(Auth::id());

        $session = $chekcoutService->createCheckoutSession($cart);
            
        return Inertia::location($session->url);
    }
}
