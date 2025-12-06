<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\CarbonPeriod;

class SalesAnalyticsRepository
{
    /**
     * 日別売上を shadcn/ui 用の配列形式で返す
     *
     * @param int $days 過去何日分を取得するか（デフォルト30日）
     * @return array<int, array{date:string, total:int}>
     */
    public function getDailySales(int $days = 30): array
    {
        $from = now()->subDays($days)->startOfDay();
        $to   = now()->endOfDay();

        $rows = OrderItem::selectRaw(
                'DATE(created_at) as date, SUM(price * quantity) as total'
            )
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $period = CarbonPeriod::create($from, $to);
        $filled = collect();

        /** @var \Carbon\Carbon $date */
        foreach ($period as $date) {
            $key = $date->toDateString();

            $filled->push([
                'date'  => $key,
                'total' => isset($rows[$key]) ? (int) $rows[$key]->total : 0,
            ]);
        }

        return $filled->toArray();
    }

    public function getTodayTotalSales(): int
    {
        $result = Order::whereBetween('created_at', [
            now()->startOfDay(),
            now()->endOfDay(),
        ])
        ->sum('total_amount');

        return (int) ($result ?? 0);
    }
}
