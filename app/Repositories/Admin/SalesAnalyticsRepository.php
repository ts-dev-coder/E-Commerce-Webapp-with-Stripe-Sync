<?php

namespace App\Repositories\Admin;

use App\Models\OrderItem;

class SalesAnalyticsRepository
{
    /**
     * 日別売上を shadcn/ui 用の配列形式で返す
     *
     * @param int $days 過去何日分を取得するか（デフォルト30日）
     * @return array<int, array{date:string, total:int, orders:int}>
     */
    public function getDailySales(int $days = 30): array
    {
        $from = now()->subDays($days);

        $rows = OrderItem::selectRaw(
                'DATE(created_at) as date, SUM(price * quantity) as total'
            )
            ->where('created_at', '>=', $from)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $rows->map(function ($row) {
            return [
                'date'  => $row->date,
                'total' => (int) $row->total,
            ];
        })->values()->toArray();
    }
}
