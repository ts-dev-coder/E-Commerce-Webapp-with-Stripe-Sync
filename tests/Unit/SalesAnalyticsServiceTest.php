<?php

namespace Tests\Unit;

use App\Repositories\Admin\SalesAnalyticsRepository;
use App\Services\Admin\SalesAnalyticsService;
use Mockery;
use Tests\TestCase;

class SalesAnalyticsServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_returns_daily_sales()
    {
        $mockRepository = Mockery::mock(SalesAnalyticsRepository::class);

        $mockData = [
            ['date' => '2024-01-01', 'total' => 2000],
            ['date' => '2024-01-02', 'total' => 1500],
            ['date' => '2024-01-03', 'total' => 500],
            ['date' => '2024-01-04', 'total' => 9000],
            ['date' => '2024-01-05', 'total' => 10900],
        ];

        $mockRepository->shouldReceive('getDailySales')
            ->once()
            ->with(30)
            ->andReturn($mockData);

        $service = new SalesAnalyticsService($mockRepository);

        $result = $service->getDailySales(30);

        $this->assertEquals($mockData, $result);
    }
}
