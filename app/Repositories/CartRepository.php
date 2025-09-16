<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;

class CartRepository
{
  public function getActiveCart(int $id) {

    return Cart::with('items.product')
                ->where('user_id', $id)
                ->where('status', 'active')
                ->first();
  }

  public function updateQuantity(CartItem $cartItem, int $updatedQuantity) {
    $cartItem->update([
        'quantity' => $updatedQuantity
    ]);
  }
}