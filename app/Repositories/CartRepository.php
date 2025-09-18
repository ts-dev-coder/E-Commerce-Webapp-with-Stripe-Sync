<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartRepository
{
  public function getOrCreateActiveCart(int $userId): Cart {
    return Cart::with('items.product')
        ->where('user_id', $userId)
        ->where('status', 'active')
        ->first()
        ?? Cart::create([
            'user_id' => $userId,
            'status' => 'active',
        ]);
  }

  public function updateQuantity(CartItem $cartItem, int $updatedQuantity) {
    $cartItem->update([
        'quantity' => $updatedQuantity
    ]);
  }

  public function deleteCartItem(int $cartItemId) {
    $cartItem = CartItem::find($cartItemId);

    if($cartItem) {
      $cartItem->delete();
    }
  }

  public function addCartItem(Cart $activeCart, Product $product, int $quantity): void {
    CartItem::create([
        'cart_id' => $activeCart->id,
        'product_id' => $product->id,
        'price' => $product->price,
        'quantity' => $quantity,
    ]);
  }
} 