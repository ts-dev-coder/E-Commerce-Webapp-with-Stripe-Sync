<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;

class CartService
{
  public function canAddProduct(
    Product $product, 
    CartItem $cartItem, 
    int $reqQuantity
  ): bool
  {
      $existsQuantity = $cartItem->quantity;
      
      return ($existsQuantity + $reqQuantity) <= $product->stock;
  }
}