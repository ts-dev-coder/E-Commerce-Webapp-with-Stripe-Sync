<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyCartItemRequest;
use App\Http\Requests\StoreCartRequest;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

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

        $products = $cart === null ? null : $cart->items->pluck('product');

        // TODO: fetch the products image

        $cartItemCount = $products === null ? 0 : count($products);

        return Inertia::render('cart', [
            'products' => $products,
            'cartItemCount' => $cartItemCount
        ]);
    }

    /**
     * Validation and product existence check are handled in the StoreCartRequest class.
     */
    public function store(StoreCartRequest $request)
    {
        $user = Auth::user();
        
        $cart = Cart::where('user_id', $user->id)->first();
        
        $existsCartItem = CartItem::where('cart_id', $cart->id)
                                    ->where('product_id', $request->validated('product_id'))
                                    ->first();
        $product = Product::find($request->validated('product_id'))->first();
        if($product->stock <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient stock for the requested quantity.'
            ], 422);
        }

        if($existsCartItem) {
            $stock = $product->stock;

            $requestQuantity = $request->validated('quantity');
            $existingQuantity = $existsCartItem->quantity;
            $totalQuantity = $requestQuantity + $existingQuantity;

            if($totalQuantity > $stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Requested quantity exceeds available stock.'
                ], 422);
            }

            $existsCartItem->quantity = $totalQuantity;
            $existsCartItem->save();

            $cartItemCount = CartItem::where('cart_id', $cart->id)
                            ->count('*');

            return response()->json([
                'status' => 'success',
                'type' => 'update',
                'message' => 'The quantity has been updated.',
                'cartItemCount' => $cartItemCount,
            ], 200); 
        }
        else {
            CartItem::create([
                'quantity' => $request->validated('quantity'),
                'price' => $product->price,
                'cart_id' => $cart->id,
                'product_id' => $request->validated('product_id')
            ]);

            $cartItemCount = CartItem::where('cart_id', $cart->id)
                                      ->count('*');

            return response()->json([
                'status' => 'success',
                'type' => 'created',
                'message' => 'The product has been added to the cart.',
                'cartItemCount' => $cartItemCount
            ], 201); 
        }
    }

    public function destroy(DestroyCartItemRequest $request)
    {
        $cartItem = CartItem::find($request->validated('cart_item_id'));
        $cartItem->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Cart item deleted successfully.'
        ]);
    }
}
