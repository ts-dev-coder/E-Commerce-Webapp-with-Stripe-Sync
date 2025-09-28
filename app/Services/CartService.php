<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;

use App\Repositories\CartRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CartService {
  private CartRepository $cartRepository;

  public function __construct(CartRepository $cartRepository)
  {
    $this->cartRepository = $cartRepository;
  }

  public function getOrCreateActiveCart(User $user) {
    return $this->cartRepository->getOrCreateActiveCart($user->id);
  }

  public function updateCartItemQuantity(CartItem $cartItem, int $updatedQuantity) {
    return $this->cartRepository->updateQuantity($cartItem, $updatedQuantity);
  }

  public function deleteCartItem(int $cartItemId) {
    return $this->cartRepository->deleteCartItem($cartItemId);
  }

  public function getCartItemCount(User $user) {
    return $user->cartItemCount();
  }

  public function getTotalQuantity(Cart $cart): int {
    return $cart->items->sum('quantity');
  }

  public function getTotal(Cart $cart): int {
    $subTotal = $this->getSubtotal($cart);

    // TODO:env fileで管理する方法も検討する
    $taxRate = $this->getTaxRate();
    $tax = intval($subTotal * $taxRate);

    $shippingFee = $this->getShippingFee();

    return $subTotal + $tax + $shippingFee;
  }

  public function getTaxRate(): float {
    return config('cart.tax_rate');
  }

  public function getShippingFee(): int {
    return config('cart.shipping_fee');
  }

  public function getSubtotal(Cart $cart): int {
    return $cart->items->sum(fn($item) => $item->price * $item->quantity);
  }

  public function addToCart(int $productId, int $requestedQuantity): void {

    $product = Product::find($productId);
    /**
     * -------------------------------
     * 商品内の同一商品であれば、個数の更新
     * 新規の追加であれば、CartItems tableへ追加
     * -------------------------------
     */
    $this->updateOrCreateCartItem($product, $requestedQuantity);
  }

  private function updateOrCreateCartItem(Product $product, int $requestedQuantity): void {
    $activeCart = $this->cartRepository->getOrCreateActiveCart(Auth::id());
    
    $cartItem = $this->findCartItemByProduct($activeCart->items, $product->id);

    if($cartItem === null) {
      $this->cartRepository->addCartItem($activeCart, $product, $requestedQuantity);
    }
    else {
      $updatedQuantity = $cartItem->quantity + $requestedQuantity;
      $this->cartRepository->updateQuantity($cartItem, $updatedQuantity);
    }
  }

  private function findCartItemByProduct(Collection $cartItems, int $productId): ?CartItem {
    return $cartItems->first(fn ($item) => $item->product_id === $productId);
  }
}