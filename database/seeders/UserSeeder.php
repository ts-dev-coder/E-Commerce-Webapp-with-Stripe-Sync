<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory(100)->create([
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
