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
        User::factory()->count(2)->create([
            'created_at' => '2025-04-01'
        ]);

        User::factory()->count(3)->create([
            'created_at' => '2025-04-02'
        ]);

        User::factory()->count(1)->create([
            'created_at' => '2025-04-03'
        ]);

        $trend = $this->repository->getDailyUsersCountTrend(10);
        
        $this->assertEquals(
        [
            ['date' => '2025-03-31', 'total' => 0],
            ['date' => '2025-04-01', 'total' => 2],
            ['date' => '2025-04-02', 'total' => 3],
            ['date' => '2025-04-03', 'total' => 1],
            ['date' => '2025-04-04', 'total' => 0],
            ['date' => '2025-04-05', 'total' => 0],
            ['date' => '2025-04-06', 'total' => 0],
            ['date' => '2025-04-07', 'total' => 0],
            ['date' => '2025-04-08', 'total' => 0],
            ['date' => '2025-04-09', 'total' => 0],
            ['date' => '2025-04-10', 'total' => 0],   
        ],
            $trend
        );

    }
}
