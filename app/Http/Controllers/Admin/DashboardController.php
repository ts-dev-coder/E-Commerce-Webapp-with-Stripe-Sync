<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SalesAnalyticsService;
use App\Services\Admin\UserAnalyticsService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(SalesAnalyticsService $salesAnalyticsService, UserAnalyticsService $userAnalyticsService)
    {
        $sales = $salesAnalyticsService->getDailySales(365);
        $users = $userAnalyticsService->getDailyUsersCountTrend(365);

        return Inertia::render('admin/dashboard', [
            'salesTrend' => $sales,
            'userTrend' => $users
        ]);
    }
}
