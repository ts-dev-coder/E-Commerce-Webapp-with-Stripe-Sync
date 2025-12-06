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
        // nameの$faker->companyでのみ使用
        $fakerEn = \Faker\Factory::create('en_US');

        $isPublished = $this->faker->boolean(50);

        return [
            'name' => function () use ($fakerEn) {
                $brand = $fakerEn->company();
                $item = $this->faker->randomElement(['Chair', 'Table', 'Lamp', 'Mug', 'Bag']);
                $model = strtoupper($this->faker->bothify('??-###'));

                return "{$brand} {$item} {$model}";
            },
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(500, 10000),
            'stock' => $this->faker->numberBetween(0, 100),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? Carbon::now()->subDays(rand(0, 30)) : null,
        ];
    }
}
