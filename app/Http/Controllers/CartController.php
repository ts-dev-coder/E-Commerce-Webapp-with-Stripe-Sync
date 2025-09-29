<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\DestroyCartItemRequest;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartQuantityRequest;

use App\Models\CartItem;

use App\Services\CartService;

class CartController extends Controller
{
    public function index(CartService $cartService)
    {
        $activeCart = $cartService->getOrCreateActiveCart(Auth::user());

        // TODO: fetch the products image

        return Inertia::render('cart', [
            'cartItems' => $activeCart->items,
            'cartItemCount' => $cartService->getCartItemCount(Auth::user()),
            'totalQuantity' => $cartService->getTotalQuantity($activeCart),
            'subTotal' => $cartService->getSubtotal($activeCart)
        ]);
    }

    /**
     * Validation and product existence check are handled in the StoreCartRequest class.
     */
    public function store(StoreCartRequest $request, CartService $cartService)
    {
        try {
            $cartService->addToCart($request->validated('product_id'), $request->validated('quantity'));
    
            return redirect()->route('cart.index');

        } catch(\RuntimeException $e) {
            error_log($e->getMessage());

            return redirect()->back()->withErrors(['quantity' => "An error occured. Please try again."]);
        } catch (\Exception $e) {
            error_log($e->getMessage());

            return redirect()->route('home');
        }
    }

    public function updateQuantity(UpdateCartQuantityRequest $request, CartItem $item, CartService $cartService) 
    {
        $cartService->updateCartItemQuantity($item, $request->validated('quantity'));
        return redirect()->back();
    }

    public function destroy(DestroyCartItemRequest $request, CartService $cartService)
    {
        $cartService->deleteCartItem($request->validated('cart_item_id'));
        return redirect()->back();
    }
}
