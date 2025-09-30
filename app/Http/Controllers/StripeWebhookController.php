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
        
        $eventType = $event->type;
        // 商品追加
        if($eventType === 'product.created') {
            error_log('商品の追加を行います。');
        } 
        // 商品価格の追加
        else if ($eventType === 'price.created') {
            error_log("商品価格の追加を行います。");
        }
        // 商品情報更新
        else if ($eventType === 'product.updated') {
            error_log("商品情報の更新を行います。");
        }
        // 商品削除
        else if ($eventType === 'product.deleted') {
            error_log("商品の削除を行います。");
        }
        // 決済完了
        else if ($eventType === 'checkout.session.completed') {
            error_log("決済が完了しました。");
        }
        
        return response()->json(['status' => 'success']);
    }
}
