<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Repositories\Admin\SalesRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected SalesRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new SalesRepository();
        Carbon::setTestNow('2024-04-10 12:00:00');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow();
    }

    public function test_it_returns_sales_within_the_given_range()
    {
        // 範囲内
        Order::factory()->create([
            'total_amount' => 1000,
            'created_at' => Carbon::now()->setTime(0, 0, 0),
        ]);

        Order::factory()->create([
            'total_amount' => 2000,
            'created_at' => Carbon::now()->setTime(23, 59, 59),
        ]);

        Order::factory()->create([
            'total_amount' => 3000,
            'created_at' => Carbon::now()->setTime(12, 0 , 0),
        ]);

        // 範囲外
        Order::factory()->create([
            'total_amount' => 9999,
            'created_at' => Carbon::yesterday(),
        ]);

        Order::factory()->create([
            'total_amount' => 5555,
            'created_at' => Carbon::tomorrow(),
        ]);

        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();
        $result = $this->repository->fetchSalesByDateRange($start, $end);

        $this->assertEquals(6000, $result, 'Expected sales data to be 6000 for the default date range');
    }
}
