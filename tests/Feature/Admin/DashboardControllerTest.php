<?php

namespace Tests\Feature\Admin;

use Mockery;

use App\Models\User;
use App\Services\Admin\SalesAnalyticsService;
use App\Services\Admin\UserAnalyticsService;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Inertia\Testing\AssertableInertia as Assert;


use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_renders_dashboard_page_with_sales_and_user_trend()
    {
        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        
        $mockSalesService = Mockery::mock(SalesAnalyticsService::class);
        $mockUserService = Mockery::mock(UserAnalyticsService::class);
        
        // モックデータ（1年間の売上とユーザー推移）
        $salesMockData = [
            ['date' => '2025-01-01', 'total' => 1000],
            ['date' => '2025-01-02', 'total' => 1500],
        ];
        
        $usersMockData = [
            ['date' => '2025-01-01', 'total' => 5],
            ['date' => '2025-01-02', 'total' => 7],
        ];
        
        $mockSalesService->shouldReceive('getDailySales')
        ->once(2)
        ->andReturn($salesMockData);
        
        $mockUserService->shouldReceive('getDailyUsersCountTrend')
        ->once(2)
        ->andReturn($usersMockData);
        
        $this->app->instance(SalesAnalyticsService::class, $mockSalesService);
        $this->app->instance(UserAnalyticsService::class, $mockUserService);

        // ログイン状態にする
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn (Assert $page) =>
            $page->component('admin/dashboard')
                ->where('salesTrend', $salesMockData)
                ->where('userTrend', $usersMockData)
        );

        $response->assertStatus(200);
    }
}
