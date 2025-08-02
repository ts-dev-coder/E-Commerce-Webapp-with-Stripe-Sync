<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;


class ProductDetailController extends Controller
{
    public function __invoke(int $id)
    {
        $user = Auth::user();

        $product = Product::find($id);

        // TODO: If product is not exists, redirect top page
        if($product === null) {
             return response()->json([
                'message' => 'error product is not found'
             ], 404);
        }

        $cartItemCount = 0;
        if ($user && $user->cart) {
            $cartItemCount = $user->cart->items()->count();
        }

        return Inertia::render('product-detail', [
            'message' => 'success',
            'product' => $product,
            'id' => $id,
            'cartItemCount' => $cartItemCount,
            'user' => $user
        ]);
    }
}
