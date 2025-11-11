<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_products_screen_can_be_renderd()
    {
        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // ログイン状態にする
        $response = $this->actingAs($admin)->get('/admin/products');

        // ステータスコード確認
        $response->assertStatus(200);

        $this->assertStringContainsString('id="app"', html_entity_decode($response->getContent()));
    }

    public function test_update_product_using_the_correct_data()
    {
        // Arrange
        $product = Product::factory()->create([
            'name' => 'test name',
            'description' => 'hello world',
            'price' => 1000,
            'stock' => 100,
            'max_quantity' => 10,
            'is_published' => true,
            'published_at' => now(),
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $updatedProduct = [
            'name' => 'test name updated',
            'description' => 'hello world updated',
            'price' => 2000,
            'stock' => 200,
            'max_quantity' => 20,
            'is_published' => false,
        ];

        $url = '/admin/products/' . $product->id;
        
        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $admin */
        $response = $this->actingAs($admin)->patch($url, $updatedProduct);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $updatedProduct['name'],
            'price' => $updatedProduct['price'],
            'is_published' => $updatedProduct['is_published'],
        ]);
    }

    public function test_admin_can_be_deleted()
    {
        $product = Product::factory()->create([
            'name' => 'test name',
            'description' => 'hello world',
            'price' => 1000,
            'stock' => 100,
            'max_quantity' => 10,
            'is_published' => true,
            'published_at' => now(),
        ]);

        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $url = '/admin/products/' . $product->id;
        $response = $this->actingAs($admin)->delete($url);

        $response->assertStatus(200);
    }
}
