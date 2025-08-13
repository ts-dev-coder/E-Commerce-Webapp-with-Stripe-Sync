import { Head, Link } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';

import { Button } from '@/components/ui/button';
import { CartItemCard } from '@/components/cart-item-card';

import { CartItem, type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];

type Props = {
    data: CartItem[];
    cartItemCount: number;
};

function CartSubtotal({ data }: { data: CartItem[] }) {
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
            <Link href="/checkout">
                <Button>レジに進む</Button>
            </Link>
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
