<?php

namespace Tests\Unit;

use App\Repositories\Admin\UserAnalyticsRepository;
use App\Services\Admin\UserAnalyticsService;

use Mockery;
use Tests\TestCase;

class UserAnalyticsServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_returns_daily_user_count_trend_for_given_days()
    {
        $mockRepository = Mockery::mock(UserAnalyticsRepository::class);

        $mockData = [
            ['date' => '2025-04-06', 'total'=> 10],
            ['date' => '2025-04-07', 'total'=> 30],
            ['date' => '2025-04-08', 'total'=> 49],
            ['date' => '2025-04-09', 'total'=> 50],
            ['date' => '2025-04-10', 'total'=> 100],
        ];

        $mockRepository->shouldReceive('getDailyUsersCountTrend')
            ->once()
            ->with(5)
            ->andReturn($mockData);

        $service = new UserAnalyticsService($mockRepository);

        $result = $service->getDailyUsersCountTrend(5);
        
        $this->assertSame($mockData, $result);
    }
    
}
