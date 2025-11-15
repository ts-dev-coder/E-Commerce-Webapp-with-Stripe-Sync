<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Admin\SalesAnalyticsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class SalesAnalyticsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected SalesAnalyticsRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new SalesAnalyticsRepository();
    }

    public function test_it_returns_daily_sales_in_shadcn_chart_format()
    {
        Carbon::setTestNow('2024-04-10 00:00:00');

        $order1 = Order::factory()->create(['created_at' => '2024-04-01']);
        OrderItem::factory()->create([
            'order_id' => $order1->id,
            'price' => 1000,
            'quantity' => 2,
            'created_at' => '2024-04-01',
        ]);

        $order2 = Order::factory()->create(['created_at' => '2024-04-01']);
        OrderItem::factory()->create([
            'order_id' => $order2->id,
            'price' => 1000,
            'quantity' => 1,
            'created_at' => '2024-04-01',
        ]);

        $order3 = Order::factory()->create(['created_at' => '2024-04-02']);
        OrderItem::factory()->create([
            'order_id' => $order3->id,
            'price' => 500,
            'quantity' => 1,
            'created_at' => '2024-04-02',
        ]);

        $results = $this->repository->getDailySales(10);

        $this->assertEquals([
            [
                'date' => '2024-04-01',
                'total' => 3000,
            ],
            [
                'date' => '2024-04-02',
                'total' => 500,
            ],
        ], $results);
    }
}
