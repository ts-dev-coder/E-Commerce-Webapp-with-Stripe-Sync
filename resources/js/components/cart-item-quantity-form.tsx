import { useForm } from '@inertiajs/react';

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
    const { data } = useForm<UpdateCartItemQuantityForm>({
        product_id: productId,
        quantity: quantity,
    });

    return (
        <form>
            <div className="flex items-center gap-x-2">
                <Button type="submit" size={'sm'}>
                    -
                </Button>
                <div className="w-14 rounded-lg border border-slate-400/50 px-4 py-1 text-center">
                    <span className='text-sm font-semibold'>{data.quantity}</span>
                </div>
                <Button type="submit" size={'sm'}>
                    +
                </Button>
            </div>
            <div>
                <span className="text-sm text-red-500">error message</span>
            </div>
        </form>
    );
}
