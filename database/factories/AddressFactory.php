<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'        => User::factory(),
            'recipient_name' => $this->faker->name(),
            'postal_code'    => $this->faker->postcode(),
            'prefecture'     => $this->faker->prefecture(),
            'city'           => $this->faker->city(),
            'street'         => $this->faker->streetAddress(),
            'building'       => $this->faker->optional()->secondaryAddress(),
            'phone_number'   => $this->faker->numerify('0##########'),
            'is_default'     => false,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
