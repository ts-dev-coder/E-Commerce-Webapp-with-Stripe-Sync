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
        
        /**
         * Seeder fileの実行日より一年の間でユーザー生成を行いかつ、実際のアプリのように
         * 日付が新しくなればなるほどユーザーの登録数が増えるような仕様
         */
        User::factory(100)->create([
            'created_at' => function () {
                $maxDays = 365;
                // 調整値: lambdaが大きいほど最近にユーザーの作成日が集中する
                $lambda = 1 / 60; 

                $daysAgo = intval(-log(1 - mt_rand() / mt_getrandmax()) / $lambda);

                // 上限を365日以内にする
                $daysAgo = min($daysAgo, $maxDays);

                return Carbon::now()
                    ->subDays($daysAgo)
                    ->subHours(rand(0, 23))
                    ->subMinutes(rand(0, 59));
            },
            'updated_at' => fn($attr) => $attr['created_at'],
        ]);
    }
}
