<?php

namespace Tests\Feature\Product;

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
}
