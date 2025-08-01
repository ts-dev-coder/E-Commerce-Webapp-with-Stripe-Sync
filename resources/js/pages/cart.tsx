import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { Product, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

type Props = {
    products: Product[];
    cartItemCount: number;
};

export default function Cart({ products, cartItemCount }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={cartItemCount}>
            <Head title="Dashboard" />
            <div className="flex min-h-screen flex-col items-center py-8">
                <h2 className="mb-6 text-2xl font-bold">ショッピングカート</h2>
                <div className="w-full max-w-3xl space-y-4">
                    {products && products.length > 0 ? (
                        products.map((product: Product) => (
                            <div key={product.id} className="flex items-center rounded-lg bg-white p-4 shadow">
                                <img src={''} alt={product.name} className="mr-4 h-24 w-24 rounded border object-cover" />
                                <div className="flex-1">
                                    <div className="text-lg font-semibold">{product.name}</div>
                                    <div className="mb-2 text-sm text-muted-foreground">{product.description}</div>
                                    <div className="mb-2 flex items-baseline">
                                        <span className="mr-1 text-base text-primary">¥</span>
                                        <span className="text-xl font-bold">{product.price}</span>
                                    </div>
                                    <span className="text-xs text-gray-500">在庫: {product.stock}</span>
                                </div>
                                <div className="ml-4 flex flex-col items-end">
                                    <Button variant="outline" size="sm" className="mb-2">
                                        削除
                                    </Button>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p className="text-center text-gray-600">カートに商品はありません。</p>
                    )}
                </div>
                {/* レジに進むボタンセクション */}
                {products && products.length > 0 && (
                    <div className="mt-8 flex w-full max-w-3xl justify-end">
                        <Button className="px-8 py-3 text-lg" variant="default">
                            レジに進む
                        </Button>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
