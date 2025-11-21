<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartItemSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cartIds   = DB::table('carts')->pluck('id');
        $productIds = DB::table('products')->pluck('id');

        CartItem::factory()->count(100)->create([
            'cart_id'   => fn() => $cartIds->random(),
            'product_id' => fn() => $productIds->random(),
        ]);
    }
}
