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
    cartItems: CartItem[];
    cartItemCount: number;
    totalQuantity: number;
    subTotal: number;
};

function CartSubtotal({ totalQuantity, subTotal }: { totalQuantity: number; subTotal: number }) {
    return (
        <div className="col-span-4 p-4">
            <div className="space-y-4 rounded-lg border p-4">
                <div className="flex items-center justify-between">
                    <p className="text-lg">小計（{totalQuantity}個の商品）(税込み)</p>
                    <p className="text-lg font-semibold">{subTotal.toLocaleString()}円</p>
                </div>
                <Link href={route('checkout.index')}>
                    <Button variant={'addCart'} className="w-full">
                        レジに進む
                    </Button>
                </Link>
            </div>
        </div>
    );
}

export default function Cart({ cartItems, cartItemCount, totalQuantity, subTotal }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={cartItemCount}>
            <Head title="Dashboard" />

            <div className="grid grid-cols-12 pt-4">
                {cartItems && cartItems.length > 0 ? (
                    <>
                        <div className="col-span-8">
                            <div className="divide-y-1">
                                {cartItems.map((item) => (
                                    <CartItemCard key={item.id} item={item} />
                                ))}
                            </div>
                        </div>
                        <CartSubtotal totalQuantity={totalQuantity} subTotal={subTotal} />
                    </>
                ) : (
                    <div className="col-span-12 size-full text-center">
                        <h1 className="text-2xl font-semibold">カート内は空です</h1>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
