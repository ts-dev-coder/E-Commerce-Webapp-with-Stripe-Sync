<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyCartItemRequest;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartQuantityRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cart = Cart::with('items.product')
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->first();

        $cartItems = $cart->items;

        // TODO: fetch the products image

        $cartItemCount = $cartItems === null ? 0 : count($cartItems);

        return Inertia::render('cart', [
            'cartItems' => $cartItems,
            'cartItemCount' => $cartItemCount
        ]);
    }

    /**
     * Validation and product existence check are handled in the StoreCartRequest class.
     */
    public function store(StoreCartRequest $request, CartService $cartService)
    {
        $product = Product::find($request->validated('product_id'));
        $productStock = $product->stock;
        if($productStock <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'The product is out of stock.'
            ], 422);
        }

        $requestQuantity = $request->validated('quantity');
        if($productStock < $requestQuantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient stock for the requested quantity.'
            ], 422);
        }

        $user = Auth::user();
        $cart = $cartService->getOrCreateCart($user);
        $existsCartItem = $cartService->getCartItem($cart, $product->id);

        if ($existsCartItem === null) {
            $cartService->addCartItem($cart, $product, $requestQuantity);

            return redirect()->route('product-detail', ['product' => $request->validated('product_id')]);
        }

        if(!$cartService->canAddProduct($product, $existsCartItem, $requestQuantity)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient stock for the requested quantity.',
            ], 422);
        }

        $cartService->updateQuantity($existsCartItem, $requestQuantity);

        return redirect()->route('product-detail', ['product' => $request->validated('product_id')]);        
    }

    public function updateQuantity(UpdateCartQuantityRequest $request, CartItem $item) {

        $item->update([
            'quantity' => $request->validated('quantity')
        ]);

        return redirect()->back();
    }

    public function destroy(DestroyCartItemRequest $request)
    {
        $cartItem = CartItem::find($request->validated('cart_item_id'));
        $cartItem->delete();
        
        return redirect()->back();
    }
}
