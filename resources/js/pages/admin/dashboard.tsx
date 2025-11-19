import { SalesAreaChart } from '@/components/sales-area-chart';
import AdminLayout from '@/layouts/admin-layout';

type TrendData = {
    date: string;
    total: number;
};

export type SalesTrend = TrendData[];
export type UserTrend = TrendData[];

type Props = {
    salesTrend: SalesTrend;
    userTrend: UserTrend;
};

export default function Dashboard({ salesTrend, userTrend }: Props) {
    return (
        <AdminLayout>
            <div className="w-full">
                <div>
                    <SalesAreaChart
                        salesTrend={salesTrend}
                        cardTitle="売上推移"
                        cardDescription="期間別の売上トレンド"
                        label="Sales"
                        color="var(--chart-3)"
                    />
                </div>
                <div>
                    <SalesAreaChart
                        salesTrend={userTrend}
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
