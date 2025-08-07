import { Head } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';

import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import { Product, type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

type Response = {
    id: number;
    cart_id: number;
    product_id: number;
    quantity: number;
    price: number;
    created_at: string;
    updated_at: string;
    product: Product;
};

type Props = {
    data: Response[];
    cartItemCount: number;
};

function CartItemCard({ item }: { item: Response }) {
    return (
        <Card className="shadow-md">
            <CardContent className="flex gap-6 p-6">
                <img
                    src={'https://placehold.co/400x300?text=No+Image'}
                    alt={item.product.name}
                    className="size-36 rounded-lg border border-gray-200 object-cover"
                />
                <div className="flex flex-1 flex-col justify-between">
                    <div>
                        <div className="mb-1 text-lg font-semibold">{item.product.name}</div>
                        <div className="mb-2 text-base font-bold text-primary">¥{item.price.toLocaleString()}</div>
                        <div className="mb-2">
                            {item.quantity > 0 ? (
                                <span className="rounded bg-green-50 px-2 py-0.5 text-xs text-green-600">在庫あり</span>
                            ) : (
                                <span className="rounded bg-red-50 px-2 py-0.5 text-xs text-red-600">一時的に在庫切れ</span>
                            )}
                        </div>
                    </div>
                    <div className="flex items-center gap-2">
                        <span className="text-sm text-gray-500">数量:</span>
                        <Select defaultValue={String(item.quantity)}>
                            <SelectTrigger className="w-16">
                                <SelectValue placeholder="個数" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="1">1</SelectItem>
                                <SelectItem value="2">2</SelectItem>
                                <SelectItem value="3">3</SelectItem>
                                <SelectItem value="4">4</SelectItem>
                                <SelectItem value="5">5</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
            </CardContent>
        </Card>
    );
}

function CartSubtotal({ data }: { data: Response[] }) {
    const totalQuantity = data.reduce((sum, item) => sum + item.quantity, 0);
    const totalPrice = data.reduce((sum, item) => sum + item.price * item.quantity, 0);
    return (
        <div className="mt-8 flex items-center justify-between rounded-lg border bg-gray-50 px-6 py-4">
            <div className="text-base font-medium text-gray-700">小計（{totalQuantity}個の商品）(税込み)</div>
            <div className="text-xl font-bold text-primary">¥{totalPrice.toLocaleString()}</div>
        </div>
    );
}

function CheckoutButton() {
    return (
        <div className="mt-6 flex w-full max-w-3xl justify-end">
            <Button>
                レジに進む
            </Button>
        </div>
    );
}

export default function Cart({ data, cartItemCount }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={cartItemCount}>
            <Head title="Dashboard" />
            <div className="flex min-h-screen flex-col items-center py-8">
                <h2 className="mb-6 text-2xl font-bold">ショッピングカート</h2>
                <div className="w-full max-w-3xl space-y-4">
                    {data && data.map((item) => <CartItemCard key={item.id} item={item} />)}
                    <CartSubtotal data={data} />
                </div>
                <CheckoutButton />
            </div>
        </AppLayout>
    );
}
