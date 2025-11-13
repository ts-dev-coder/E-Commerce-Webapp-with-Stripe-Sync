<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_it_returns_products_matching_keyword()
    {
        Product::factory()->create(['name' => 'iphone 17']);
        Product::factory()->create(['name' => 'google pixel']);
        Product::factory()->create(['name' => 'meta quest']);
        Product::factory()->create(['name' => 'galaxy']);

        $filters = ['name' => 'iphone'];
        $result = $this->repository->findByFilters($filters);

        $this->assertCount(1, $result);
        $this->assertEquals('iphone 17', $result->first()->name);
    }

    public function test_it_returns_empty_collection_when_no_match()
    {
        Product::factory()->create(['name' => 'galaxy']);
        $filters = ['name' => 'iphone'];
        $result = $this->repository->findByFilters($filters);

        $this->assertCount(0, $result);
    }
}
