<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
        Carbon::setTestNow('2024-04-10 00:00:00');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow();
    }

    public function test_it_returns_daily_sales_in_shadcn_chart_format()
    {

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
                'date' => '2024-03-31',
                'total' => 0,
            ],
            [
                'date' => '2024-04-01',
                'total' => 3000,
            ],
            [
                'date' => '2024-04-02',
                'total' => 500,
            ],
            [
                'date' => '2024-04-03',
                'total' => 0,
            ],
            [
                'date' => '2024-04-04',
                'total' => 0,
            ],
            [
                'date' => '2024-04-05',
                'total' => 0,
            ],
            [
                'date' => '2024-04-06',
                'total' => 0,
            ],
            [
                'date' => '2024-04-07',
                'total' => 0,
            ],
            [
                'date' => '2024-04-08',
                'total' => 0,
            ],
            [
                'date' => '2024-04-09',
                'total' => 0,
            ],
            [
                'date' => '2024-04-10',
                'total' => 0,
            ],
        ], $results);
    }

    public function test_getTodayTotalSales_returns_today_total_sales_data()
    {
        // 商品データ
        $product1 = Product::factory()->create([
            'price' => 500,
        ]);
        $product2 = Product::factory()->create([
            'price' => 200,
        ]);
        $product3 = Product::factory()->create([
            'price' => 100,
        ]);
        
        // 注文データ
        $order1 = Order::factory()->create();
        $order2 = Order::factory()->create();
        $order3 = Order::factory()->create();

        // 注文商品データ
        OrderItem::factory()->create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'quantity' => 10,
            'purchase_at' => now(),
        ]);
        OrderItem::factory()->create([
            'order_id' => $order2->id,
            'product_id' => $product2->id,
            'quantity' => 10,
            'purchase_at' => now(),
        ]);
        OrderItem::factory()->create([
            'order_id' => $order3->id,
            'product_id' => $product3->id,
            'quantity' => 10,
            'purchase_at' => now(),
        ]);

        $result = $this->repository->getTodayTotalSales();

        $this->assertEquals(8000, $result, 'TodayTotalSales should be 8000.');
    }

    public function test_getTodayTotalSales_returns_zero_when_no_sales_exist_today()
    {
        $result = $this->repository->getTodayTotalSales();

        $this->assertEquals(0, $result);
    }
}
