<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use Carbon\Carbon;

class SalesRepository
{
    public function fetchSalesByDateRange(Carbon $start, Carbon $end): float
    {
        return Order::whereBetween('created_at', [$start, $end])
            ->sum('total_amount');
    }
}
