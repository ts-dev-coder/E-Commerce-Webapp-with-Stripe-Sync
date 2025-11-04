<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_latest_10_users()
    {
        $users = User::factory()
            ->count(15)
            ->sequence(fn ($sequence) => [
                'created_at' => now()->subMinutes($sequence->index),
            ])
            ->create();

        $service = new UserService();
        $users = $service->retrieveLatestUsers();

        $this->assertCount(10, $users);

        $this->assertTrue(
            $users->first()->created_at->gt($users->last()->created_at),
            'Users are not orderd by latest.'
        );

        $this->assertInstanceOf(User::class, $users->first());
    }
}
