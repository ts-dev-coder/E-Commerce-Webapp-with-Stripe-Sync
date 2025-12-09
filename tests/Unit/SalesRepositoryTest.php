<?php

namespace Tests\Unit;

use App\Repositories\Admin\SalesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected SalesRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new SalesRepository();
    }
}
