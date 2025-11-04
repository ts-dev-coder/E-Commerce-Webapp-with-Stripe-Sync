<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_latest_10_products()
    {
        Product::factory()
            ->count(15)
            ->sequence(fn ($sequence) => [
                'created_at' => now()->subMinutes($sequence->index),
            ])
            ->create();
        
        
        $service = new ProductService();
        $products = $service->retrieveLatestProducts();

        // Productsの配列の数が10個であること
        $this->assertCount(10, $products);
        
        // 配列の中身が最新順になっていること
        $this->assertTrue(
            $products->first()->created_at->gt($products->last()->created_at),
            'Products are not ordered by latest.'
        );

        // 配列の中身がProduct instanceであること
        $this->assertInstanceOf(Product::class, $products->first());
    }
}
