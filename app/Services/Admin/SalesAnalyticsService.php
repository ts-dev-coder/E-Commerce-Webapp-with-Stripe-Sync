<?php

namespace App\Services\Admin;

use App\Repositories\Admin\SalesAnalyticsRepository;

class SalesAnalyticsService
{
    protected SalesAnalyticsRepository $repository;

    public function __construct(?SalesAnalyticsRepository $repository = null)
    {
        $this->repository = $repository ?? new SalesAnalyticsRepository();
    }
    public function getDailySales(int $days = 30): array
    {
        return $this->repository->getDailySales($days);
    }
}
