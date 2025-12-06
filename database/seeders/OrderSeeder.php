<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach($users as $user)
        {
            $address = Address::factory()->create([
                'user_id' => $user->id,
                'recipient_name' => $user->name,
            ]);

            $orderCreatedAt = fake()->dateTimebetween($user->created_at, now());

            Order::factory()->create([
                'user_id' => $user->id,
                'shipping_address_id' => $address->id,
                'created_at' => $orderCreatedAt,
                'updated_at' => fn($attr) => $attr['created_at'],
            ]);
        }
    }
}
