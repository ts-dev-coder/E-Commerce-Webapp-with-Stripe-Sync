<?php

namespace Tests\Unit;

use App\Repositories\Admin\SalesRepository;
use Tests\TestCase;

class SalesRepositoryTest extends TestCase
{
    protected SalesRepository $respository;

    public function setUp(): void
    {
        parent::setUp();

        $this->respository = new SalesRepository();
    }
}
