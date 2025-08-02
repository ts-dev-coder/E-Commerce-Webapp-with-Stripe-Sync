<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

// use Stripe\Checkout\Session;
// use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // TODO: Refactor to use Eloquent relationship from User model instead of
        //       querying directly
        $registeredDeliveryAddress = Address::where('user_id', $user->id)->get()->first();

        // TODO: Add payments table
        $registeredPaymentMethod = null;

        $cart = Cart::with('items.product')
                    ->where('user_id', $user->id)
                    ->first();

        $products = $cart->items->pluck('product');

        $cartItemCount = count($products);

        return Inertia::render('checkout', [
            'message' => 'hello world',
            'products' => $products,
            'cartItemCount' => $cartItemCount,
            'registeredDeliveryAddress' => $registeredDeliveryAddress,
            'registeredPaymentMethod' => $registeredPaymentMethod
        ]);
    }

    public function store(StoreCheckoutRequest $request)
    {
        $user = Auth::user();

        $cartItems = $request->validated('cart');
        $productIds = collect($cartItems)->pluck('product_id')->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // TODO: Refactor business logic (such as stock validation and cart checks) into a separate service class for better maintainability and testability in the future.
        $errors = [];
        foreach ($cartItems as $item) {
            $product = $products->get($item['product_id']);
            if (!$product) {
                $errors[] = [
                    'product_id' => $item['product_id'],
                    'message' => "Product with ID {$item['product_id']} not found."
                ];
                continue;
            }
            if ($product->stock <= 0) {
                $errors[] = [
                    'product_id' => $item['product_id'],
                    'message' => "The product '{$product->name}' is out of stock."
                ];
                continue;
            }
            if ($product->stock < $item['quantity']) {
                $errors[] = [
                    'product_id' => $item['product_id'],
                    'message' => "The requested quantity for '{$product->name}' exceeds the available stock."
                ];
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }

        // TODO: Implement after developing the frontend
        // Stripe::setApiKey(config('services.stripe.secret'));
        // $session = Session::create([
        //     TODO: Change to cart items data
        //     'line_items' => [[
        //         'price_data' => [
        //             'currency' => 'jpy',
        //             'product_data' => [
        //                 'name' => 'サンプル商品',
        //             ],
        //             'unit_amount' => 1200, // ¥1200
        //         ],
        //         'quantity' => 1,
        //     ]],
        //     'mode' => 'payment',
        //     'success_url' => route('checkout.success'),
        //     'cancel_url' => route('checkout.cancel'),
        // ]);

        // return redirect($session->url);
        return response()->json([
            'status' => 'success',
            'message' => 'Order complete.'
        ]);
    }
}
