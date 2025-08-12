import { useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

import { Button } from './ui/button';

type Props = {
    readonly cartItemId: number;
    readonly productId: number;
    readonly maxQuantity: number;
    quantity: number;
};

type UpdateCartItemQuantityForm = {
    readonly product_id: number;
    quantity: number;
};

export function CartItemQuantityForm({ cartItemId, productId, maxQuantity, quantity }: Props) {
    const { data, setData, patch, processing } = useForm<UpdateCartItemQuantityForm>({
        product_id: productId,
        quantity: quantity,
    });

    // TODO: 2から１の変更時にform eventが発火しない為、下記の2つの状態を変更する
    const availableMinus = data.quantity === 1;
    const availablePlus = data.quantity >= maxQuantity;

    const isValidQuantity = (updatedQuantity: number): boolean => {
        if (updatedQuantity <= 0 || updatedQuantity > maxQuantity) return false;

        return true;
    };

    const changeQuantity = (delta: number) => {
        const updatedQuantity = data.quantity + delta;
        if (isValidQuantity(updatedQuantity) === false) {
            return;
        }

        setData('quantity', updatedQuantity);
    };

    const handleUpdateQuantity: FormEventHandler = (e) => {
        e.preventDefault();

        patch(route('cart.updateQuantity', { item: cartItemId }), {
            onSuccess: () => {
                console.log('success');
            },
        });
    };

    return (
        <form onSubmit={handleUpdateQuantity}>
            <div className="flex items-center gap-x-2">
                <Button type="submit" size={'sm'} onClick={() => changeQuantity(-1)} disabled={availableMinus || processing}>
                    -
                </Button>
                <div className="w-14 rounded-lg border border-slate-400/50 px-4 py-1 text-center">
                    <span className="text-sm font-semibold">{data.quantity}</span>
                </div>
                <Button type="submit" size={'sm'} onClick={() => changeQuantity(1)} disabled={availablePlus || processing}>
                    +
                </Button>
            </div>
            {/* TODO: If server respose is error, Display error message */}
        </form>
    );
}
