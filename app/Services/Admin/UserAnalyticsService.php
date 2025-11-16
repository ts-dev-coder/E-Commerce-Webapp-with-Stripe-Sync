<?php

namespace App\Services\Admin;

use App\Repositories\Admin\UserAnalyticsRepository;

class UserAnalyticsService
{
    protected UserAnalyticsRepository $repository;

    public function __construct(?UserAnalyticsRepository $repository = null)
    {
        $this->repository = $repository ?? new UserAnalyticsRepository();
    }

    public function getDailyUsersCountTrend(int $days = 30): array
    {
        return $this->repository->getDailyUsersCountTrend($days);
    }

}
