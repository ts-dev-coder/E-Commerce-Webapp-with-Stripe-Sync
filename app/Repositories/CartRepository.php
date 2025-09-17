<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;

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
}