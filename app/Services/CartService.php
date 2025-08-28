<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Collection;

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

  public function updateQuantity(CartItem $cartItem, int $reqQuantity): void
  {
      $cartItem->quantity = $cartItem->quantity + $reqQuantity;
      $cartItem->save();
  }
  
  public function getOrCreateCart($user)
  {
      $cart = $user->cart()->first();
      if ($cart === null) {
          $cart = $user->cart()->create([]);
      }
      return $cart;
  }

  public function getCartItem($cart, $productId)
  {
      return $cart->items()->where('product_id', $productId)->first();
  }

  public function addCartItem($cart, $product, $quantity)
  {
      return CartItem::create([
          'quantity' => $quantity,
          'price' => $product->price,
          'cart_id' => $cart->id,
          'product_id' => $product->id
      ]);
  }

  public function getTotalAmount(Collection $items): int
  {
    // TODO: config fileに移すかどうか考える
    $shippingFee = 500;
    return $this->calculateTotalAmount($items) + $shippingFee;
  }

  private function calculateTotalAmount(Collection $items): int
  {
    return $items->sum(function ($item) {
        return $item->price * $item->quantity;
    });
  }
}