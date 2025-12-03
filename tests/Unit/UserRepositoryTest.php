<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\Admin\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository();
    }

    
    public function test_findByFilters_return_users_when_filters_is_empty()
    {
        User::factory()
            ->count(40)
            ->sequence(fn ($seq) => [
                'created_at' => now()->subMinutes($seq->index),
            ])
            ->create();

        $filters = [];
        $limit = 30;
        $result = $this->repository->findByFilters($filters, $limit);

        $this->assertCount($limit, $result);

        $this->assertTrue(
            $result->first()->created_at->gt($result->last()->created_at),
            'Users are not ordered by latest.'
        );

        $this->assertInstanceOf(User::class, $result->first());
    }
    
    public function test_findByFilters_returns_users_when_filter_is_only_name()
    {
        User::factory()
            ->count(40)
            ->sequence(fn ($seq) => [
                'name' => 'test user',
                'created_at' => now()->subMinutes($seq->index),
            ])
            ->create();

        User::factory()
            ->count(20)
            ->sequence(fn ($seq) => [
                'name' => 'other user',
                'created_at' => now()->subMinutes(100 + $seq->index),
            ])
            ->create();

        $filters = ['name' => 'test'];
        $limit = 30;

        $result = $this->repository->findByFilters($filters, $limit);

        $this->assertCount($limit, $result);

        $this->assertTrue(
            $result->every(fn ($user) => str_contains($user->name, 'test')),
            'Name filter did not apply correctly.'
        );

        $this->assertTrue(
            $result->first()->created_at->gt($result->last()->created_at),
            'Users are not ordered by latest.'
        );

        $this->assertInstanceOf(User::class, $result->first());
    }
    
    public function test_findByFilters_returns_users_when_filter_is_only_email()
    {
        User::factory()
            ->count(40)
            ->sequence(fn ($seq) => [
                'email' => "test{$seq->index}@example.co.jp",
                'created_at' => now()->subMinutes($seq->index),
            ])
            ->create();

        User::factory()
            ->count(20)
            ->sequence(fn ($seq) => [
                'email' => "other{$seq->index}@example.co.jp",
                'created_at' => now()->subMinutes(100 + $seq->index),
            ])
            ->create();

        $filters = ['email' => 'test'];
        $limit = 30;

        $result = $this->repository->findByFilters($filters, $limit);

        $this->assertCount($limit, $result);

        $this->assertTrue(
            $result->every(fn ($user) => str_contains($user->email, 'test')),
            'Email filter did not apply correctly.'
        );

        $this->assertTrue(
            $result->first()->created_at->gt($result->last()->created_at),
            'Emails are not ordered by latest.'
        );

        $this->assertInstanceOf(User::class, $result->first());
    }
    
    public function test_findByFilters_returns_users_when_filter_is_name_and_email()
    {
        User::factory()->create([
            'name' => 'test user',
            'email' => 'hiImEnginerr@gmail.com'
        ]);
        
        User::factory()
            ->count(20)
            ->sequence(fn ($seq) => [
                'email' => "other{$seq->index}@example.co.jp",
                'created_at' => now()->subMinutes(100 + $seq->index),
            ])
            ->create();
        
        $filters = [
            'name' => 'test user',
            'email' => 'hiImEnginerr@gmail.com'
        ];

        $result = $this->repository->findByFilters($filters);

        $this->assertCount(1, $result);

        $this->assertTrue(
            $result->every(fn ($user) => str_contains($user->name, 'test user')),
            'Name filter did not apply correctly.'
        );

        $this->assertTrue(
            $result->every(fn ($user) => $user->email === 'hiImEnginerr@gmail.com'),
            'Email filter did not apply correctly.'
        );

        $this->assertInstanceOf(User::class, $result->first());
    }
    
    public function test_findByFilters_returns_empty_collection_when_no_match()
    {
        User::factory()->create(['name' => 'goodmorninguser']);
        User::factory()->create(['name' => 'goodafternoonuser']);
        User::factory()->create(['name' => 'goodevninguser']);

        $filters = ['name' => 'test'];

        $result = $this->repository->findByFilters($filters);

        $this->assertInstanceOf(Collection::class, $result);

        $this->assertTrue($result->isEmpty());
        $this->assertCount(0, $result);
    }
}
