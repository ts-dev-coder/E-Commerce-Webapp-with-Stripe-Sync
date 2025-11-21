<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all()->toArray();
        $products = Product::all()->toArray();

        OrderItem::factory()->count(100)->create([
            'order_id' => function () use ($orders) {
                return $orders[array_rand($orders)]['id'];
            },
            'product_id' => function () use ($products) {
                return $products[array_rand($products)]['id'];
            },
            'created_at' => function () {
                return Carbon::now()
                ->subDays(rand(0, 365))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59));
            },
            'updated_at' => fn($attr) => $attr['created_at'],
        ]);
    }
}
