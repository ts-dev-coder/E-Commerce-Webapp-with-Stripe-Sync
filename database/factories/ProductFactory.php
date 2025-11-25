<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isPublished = $this->faker->boolean(50);

        // TODO: 販売日と販売終了日に関しては、予約機能を実装時にデータを
        //       挿入するので、それまでは,nullにしておく
        // 販売開始日: 今日以降（0～30日後）
        // $startDate = Carbon::now()->addDays(rand(0, 30));

        // 販売終了日: 販売開始日から1～30日後
        // $endDate = (clone $startDate)->addDays(rand(1, 30));

        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(500, 10000),
            'stock' => $this->faker->numberBetween(0, 100),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? Carbon::now()->subDays(rand(0, 30)) : null,
            'available_from' => null,
            'available_until' => null,
            'stripe_id' => 'prod_test_00000',
            'stripe_price_id' => 'price_test',
            'currency' => 'jpy',
            'is_physical' => true,
            'creator' => 'test creator',
            'seo_title' => 'test seo title',
            'seo_description' => 'test seo description',
            'deleted_at' => null,
        ];
    }
}
