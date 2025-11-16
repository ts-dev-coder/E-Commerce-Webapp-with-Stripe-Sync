<?php

namespace App\Repositories\Admin;

use App\Models\User;

class UserAnalyticsRepository
{
    /**
     * 設計
     * 引数に期間を受け取り、その期間の間の一日分ずつのユーザーの登録の数の
     * 推移を配列に纏めたデータを返す
     * 
     * @param int $days
     * @return array<int, array{date:string, total:int}>
     */
    public function getDailyUsersCountTrend(int $days = 30): array
    {
        $from = now()->subDays($days);

        $rows = User::selectRaw(
            'DATE(created_at) as date, COUNT(*) as total'
        )
        ->where('created_at', '>=', $from)
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return $rows->map(function ($row) {
            return [
                'date' => $row->date,
                'total' => (int) $row->total
            ];
        })->values()->toArray();
    }
}
