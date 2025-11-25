<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Price;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    private const EVENT_HANDLERS = [
        'product.created' => 'handleCreateProduct',
    ];

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature invalid.');
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook payload invalid.');
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $eventType = $event->type;

        Log::info('Stripe webhook received.', [
            'type' => $eventType,
        ]);

        if (array_key_exists($eventType, self::EVENT_HANDLERS)) {
            $method = self::EVENT_HANDLERS[$eventType];

            if (method_exists($this, $method)) {
                $this->{$method}($event);
            } else {
                Log::error("Mapped method '{$method}' does not exist.");
            }
        } else {
            Log::warning("Unhandled Stripe event received: {$eventType}");
        }

        return response()->json(['status' => 'success']);
    }

    private function handleCreateProduct($event)
    {
        Log::info('Stripe product.created called.');
        // $event->data->object に商品データが入っている
        $product = $event->data->object;

        $price = $this->findPrice($product->id);
        if (!$price) {
            Log::error('Price not found for product: ' . $product->id);
            return null;
        }
        
        $stock = $product->metadata->stock ?? 10;
        //TODO: 以下の二つのカラムをnullableにしたらnullに変更する
        $seoTitle = $product->metadata->seo_title ?? 'test seo title';
        $seoDescription = $product->metadata->seo_description ?? 'test seo description';

        Product::create([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $price->unit_amount,
            'stock' => $stock,
            'stripe_id' => $product->id,
            'stripe_price_id' => $price->id,
            'currency' => $price->currency,
            'creator' => 'admin',
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription
        ]);
        
        return null;
    }

    private function findPrice(string $productId): ?Price
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $prices = Price::all([
            'product' => $productId,
            'limit' => 1
        ]);

        return $prices->data[0] ?? null;
    }
}

