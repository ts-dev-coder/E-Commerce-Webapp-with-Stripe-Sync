<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\Admin\UserAnalyticsRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAnalyticsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected UserAnalyticsRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserAnalyticsRepository();
        Carbon::setTestNow('2025-04-10 00:00:00');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow();
    }

    public function test_it_returns_daily_users_count_trend()
    {
        // 3日分のユーザー登録を行う
        // 2日前
        User::factory()->count(2)->create([
            'created_at' => now()->subDays(2)
        ]);
        // 1日前
        User::factory()->count(3)->create([
            'created_at' => now()->subDays(1)
        ]);
        // 当日
        User::factory()->count(1)->create([
            'created_at' => now()
        ]);

        // 3日分のユーザー数の推移を取得する
        $trend = $this->repository->getDailyUsersCountTrend(2);

        // $trendが配列かどうか
        $this->assertIsArray($trend);
        // $trendが空ではないかどうか
        $this->assertNotEmpty($trend);
        
        // キーが一致しているかどうか
        $first = $trend[0];
        $this->assertArrayHasKey('date', $first);
        $this->assertArrayHasKey('total', $first);

        // データの数が3日分かどうか
        $this->assertCount(3, $trend);

        // 日付順が古いものから新しいものになっているかどうか
        $this->assertEquals(
            now()->subDays(2)->format('Y-m-d'),
            $trend[0]['date']
        );

        $this->assertEquals(
            now()->subDays(1)->format('Y-m-d'),
            $trend[1]['date']
        );

        $this->assertEquals(
            now()->format('Y-m-d'),
            $trend[2]['date']
        );
        
        // ユーザー数が正しいか
        $this->assertEquals(
        [
            ['date' => '2025-04-08', 'total' => 2],
            ['date' => '2025-04-09', 'total' => 3],
            ['date' => '2025-04-10', 'total' => 1],
        ],
            $trend
        );

    }
}
