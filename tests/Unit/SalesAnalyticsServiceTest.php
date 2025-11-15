<?php

namespace Tests\Unit;

use App\Services\Admin\SalesAnalyticsService;

use Tests\TestCase;

class SalesAnalyticsServiceTest extends TestCase
{
    protected SalesAnalyticsService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SalesAnalyticsService();
    }
}
