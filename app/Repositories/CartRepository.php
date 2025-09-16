<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{
  public function getActiveCart(int $id) {

    return Cart::with('items.product')
                ->where('user_id', $id)
                ->where('status', 'active')
                ->first();
  }
}