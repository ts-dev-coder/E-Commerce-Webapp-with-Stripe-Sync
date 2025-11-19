<?php

namespace App\Repositories\Admin;

use App\Models\User;
use Carbon\CarbonPeriod;

class UserAnalyticsRepository
{
    /**
     * 指定期間の1日ごとのユーザー登録数の推移を返す
     *
     * @param int $days 過去日数（デフォルト30日）
     * @return array<int, array{date:string, total:int}>
     */
    public function getDailyUsersCountTrend(int $days = 30): array
    {
        $from = now()->subDays($days)->startOfDay();
        $to   = now()->endOfDay();

        $rows = User::selectRaw(
                'DATE(created_at) as date, COUNT(*) as total'
            )
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $period = CarbonPeriod::create($from, $to);
        $filled = collect();

        foreach ($period as $date) {
            /** @var \Carbon\CarbonInterface $date */
            $key = $date->toDateString();

            $filled->push([
                'date'  => $key,
                'total' => isset($rows[$key]) ? (int) $rows[$key]->total : 0,
            ]);
        }

        return $filled->toArray();
    }
}
