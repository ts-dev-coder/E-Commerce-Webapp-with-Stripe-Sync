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

    public function test_product_can_be_updated()
    {
        $product = Product::factory()->create([
            'name' => 'test old product',
            'description' => 'This is old product',
            'price' => 1000,
            'stock' => 100,
            'max_quantity' => 10,
            'is_published' => 1,
            'published_at' => now()
        ]);

        $updateData = [
            'name' => 'test update product',
            'description' => 'This is update product',
            'price' => 2000,
            'stock' => 200,
            'max_quantity' => 20,
            'is_published' => 0,
            'published_at' => null
        ];

        $service = new ProductService();
        $result = $service->updateProduct($product, $updateData);

        $this->assertTrue($result);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'test update product',
            'description' => 'This is update product',
            'price' => 2000,
            'stock' => 200,
            'max_quantity' => 20,
            'is_published' => 0,
            'published_at' => null,
        ]);
    }

    public function test_product_update_fails_with_invalid_data()
    {
        $product = Product::factory()->create([
            'name' => 'test old product',
            'description' => 'This is old product',
            'price' => 1000,
            'stock' => 100,
            'max_quantity' => 10,
            'is_published' => 1,
            'published_at' => now()
        ]);

        $invalidUpdateData = [
            'price' => null
        ];
        
        $service = new ProductService();
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        $service->updateProduct($product, $invalidUpdateData);
    }
}
