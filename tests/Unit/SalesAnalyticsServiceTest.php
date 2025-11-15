<?php

namespace Tests\Unit;

use App\Services\Admin\SalesAnalyticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesAnalyticsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected SalesAnalyticsService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SalesAnalyticsService();
    }

    
}
