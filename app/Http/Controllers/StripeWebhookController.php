<?php

namespace App\Http\Controllers;

use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cart;
use App\Models\Order;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            // Webhook イベントの検証
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }
        
        
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            # TODO: Change the user id hard code
            
            DB::transaction(function () {
                $cart = Cart::with('items.product')
                    ->where('user_id', 1)
                    ->where('status', 'active')
                    ->first();

                if (!$cart) {
                    return;
                }
                
                $order = Order::create([
                    'user_id' => 1,
                    'total_amount' => 3000,
                    // TODO: Replace with shiping_address_id once the column is added to cart table.
                    'shipping_address_id' => 1
                ]);

                $cart->update(['status' => 'success']);
            });
        }

        return response()->json(['status' => 'success']);
    }
}
