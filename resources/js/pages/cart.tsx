import { Head, Link } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';

import { Button } from '@/components/ui/button';

import { CartItemCard } from '@/components/cart-item-card';
import { CartItem } from '@/types';

type Props = {
    cartItems: CartItem[];
    cartItemCount: number;
    totalQuantity: number;
    subTotal: number;
};

function CartSubtotal({ totalQuantity, subTotal }: { totalQuantity: number; subTotal: number }) {
    return (
        <div className="p-4">
            <div className="space-y-4 rounded-lg border p-4">
                <div className="flex items-center gap-x-5">
                    <p className="text-lg">小計（{totalQuantity}個の商品）(税込み)</p>
                    <p className="text-lg font-semibold">{subTotal.toLocaleString()}円</p>
                </div>
                <Link href={route('checkout.index')}>
                    <Button>
                        レジに進む
                    </Button>
                </Link>
            </div>
        </div>
    );
}

export default function Cart({ cartItems, cartItemCount, totalQuantity, subTotal }: Props) {
    return (
        <AppLayout cartItemCount={cartItemCount}>
            <Head title="Dashboard" />
            <div className="flex h-[calc(100vh-4rem)] w-full md:max-w-7xl">
                <div className="w-[800px] divide-y-2 overflow-y-auto">
                    {cartItems.map((item) => (
                        <CartItemCard key={item.id} item={item} />
                    ))}
                </div>
                <CartSubtotal totalQuantity={totalQuantity} subTotal={subTotal} />
            </div>
        </AppLayout>
    );
}
