<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_users_screen_can_be_renderd()
    {
        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // ログイン状態にする
        $response = $this->actingAs($admin)->get('/admin/users');

        // ステータスコード確認
        $response->assertStatus(200);

        $this->assertStringContainsString('id="app"', html_entity_decode($response->getContent()));
    }
}
