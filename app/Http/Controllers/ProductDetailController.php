<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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

        // TODO: If the user is logged in, retrieve the count of cart items
        //       from the database
        $cartItemCount = 0;

        return Inertia::render('product-detail', [
            'message' => 'success',
            'product' => $product,
            'id' => $id,
            'cartItemCount' => $cartItemCount,
            'user' => $user
        ]);
    }
}
