<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    use WithoutModelEvents;
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $productIds = DB::table('products')->pluck('id')->toArray();
        
        foreach ($productIds as $productId) {
            $categoryId = $categoryIds[array_rand($categoryIds)];

            DB::table('category_product')->updateOrInsert([
                'category_id' => $categoryId,
                'product_id'  => $productId
            ]);
        }
    }
}
