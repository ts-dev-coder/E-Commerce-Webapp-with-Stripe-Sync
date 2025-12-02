<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProductRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProductRepository();
    }

    public function test_findByFilters_returns_products_when_filters_is_empty()
    {
        Product::factory()
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
            'Products are not ordered by latest.'
        );

        $this->assertInstanceOf(Product::class, $result->first());
    }

    public function test_findByFilters_returns_products_when_filter_is_only_name()
    {
        Product::factory()
            ->count(40)
            ->sequence(fn ($seq) => [
                'name' => 'test product',
                'created_at' => now()->subMinutes($seq->index),
            ])
            ->create();

        Product::factory()
            ->count(20)
            ->sequence(fn ($seq) => [
                'name' => 'other product',
                'created_at' => now()->subMinutes(100 + $seq->index),
            ])
            ->create();

        $filters = ['name' => 'test'];
        $limit = 30;

        $result = $this->repository->findByFilters($filters, $limit);

        $this->assertCount($limit, $result);

        $this->assertTrue(
            $result->every(fn ($product) => str_contains($product->name, 'test')),
            'Name filter did not apply correctly.'
        );

        $this->assertTrue(
            $result->first()->created_at->gt($result->last()->created_at),
            'Products are not ordered by latest.'
        );

        $this->assertInstanceOf(Product::class, $result->first());
    }

    public function test_findByFilters_returns_products_when_filter_is_only_price()
    {
        Product::factory()->count(25)->create(['price' => 100]);
        Product::factory()->count(15)->create(['price' => 200]);

        $filters = ['price' => 100];
        $limit = 30;

        $result = $this->repository->findByFilters($filters, $limit);

        $this->assertCount(25, $result);

        $this->assertTrue(
            $result->every(fn ($product) => $product->price === 100),
            'Price filter did not apply correctly.'
        );
    }

    public function test_findByFilters_returns_products_when_filter_is_only_is_published()
    {
        Product::factory()->count(20)->create(['is_published' => true]);
        Product::factory()->count(20)->create(['is_published' => false]);

        $filters = ['is_published' => true];
        $limit = 30;

        $result = $this->repository->findByFilters($filters, $limit);

        $this->assertCount(20, $result);

        $this->assertTrue(
            $result->every(fn ($product) => $product->is_published == true),
            'is_published filter did not apply correctly.'
        );
    }

    public function test_findByFilters_returns_products_when_filter_is_name_and_is_published()
    {
        Product::factory()->count(40)->create([
            'name' => 'test product',
            'is_published' => true,
        ]);

        Product::factory()->count(20)->create([
            'name' => 'test product',
            'is_published' => false,
        ]);

        Product::factory()->count(20)->create([
            'name' => 'other product',
            'is_published' => true,
        ]);

        $filters = [
            'name' => 'test',
            'is_published' => true,
        ];

        $limit = 30;

        $result = $this->repository->findByFilters($filters, $limit);

        $this->assertCount(30, $result);

        $this->assertTrue(
            $result->every(fn ($p) => str_contains($p->name, 'test')),
            'Name filter did not apply correctly.'
        );

        $this->assertTrue(
            $result->every(fn ($p) => $p->is_published == true),
            'is_published filter did not apply correctly.'
        );
    }

    public function test_findByFilters_returns_empty_collection_when_no_match()
    {
        Product::factory()->create(['name' => 'galaxy']);
        Product::factory()->create(['name' => 'android']);
        Product::factory()->create(['name' => 'pixel']);

        $filters = ['name' => 'iphone'];

        $result = $this->repository->findByFilters($filters);

        $this->assertInstanceOf(Collection::class, $result);

        $this->assertTrue($result->isEmpty());
        $this->assertCount(0, $result);
    }

}
