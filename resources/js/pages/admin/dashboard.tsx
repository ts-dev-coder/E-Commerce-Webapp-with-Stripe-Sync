import { TrendChart } from '@/components/admin/trend-chart';
import AdminLayout from '@/layouts/admin-layout';

export type TrendData = {
    date: string;
    total: number;
};

type Props = {
    salesTrend: TrendData[];
    userTrend: TrendData[];
};

export default function Dashboard({ salesTrend, userTrend }: Props) {
    return (
        <AdminLayout>
            <div className="w-full">
                <div>
                    <TrendChart
                        trendData={salesTrend}
                        cardTitle="売上推移"
                        cardDescription="期間別の売上トレンド"
                        label="Sales"
                        color="var(--chart-3)"
                    />
                </div>
                <div>
                    <TrendChart
                        trendData={userTrend}
                        cardTitle="ユーザー推移"
                        cardDescription="期間別のユーザートレンド"
                        label="Users"
                        color="var(--chart-2)"
                    />
                </div>
            </div>
        </AdminLayout>
    );
}
