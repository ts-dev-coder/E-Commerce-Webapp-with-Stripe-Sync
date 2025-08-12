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
    const { data, setData } = useForm<UpdateCartItemQuantityForm>({
        product_id: productId,
        quantity: quantity,
    });

    const isValidQuantity = (updatedQuantity: number): boolean => {
        if (updatedQuantity <= 0 || updatedQuantity > maxQuantity) return false;

        return true;
    };

    const handleMinus = () => {
        const updatedQuantity = data.quantity - 1;
        if (isValidQuantity(updatedQuantity) === false) {
            return;
        }

        setData('quantity', updatedQuantity);
    };

    const handlePlus = () => {
        const updatedQuantity = data.quantity + 1;
        if (isValidQuantity(updatedQuantity) === false) {
            return;
        }
        setData('quantity', updatedQuantity);
    };

    return (
        <form>
            <div className="flex items-center gap-x-2">
                <Button type="button" size={'sm'} onClick={handleMinus}>
                    -
                </Button>
                <div className="w-14 rounded-lg border border-slate-400/50 px-4 py-1 text-center">
                    <span className="text-sm font-semibold">{data.quantity}</span>
                </div>
                <Button type="button" size={'sm'} onClick={handlePlus}>
                    +
                </Button>
            </div>
            {/* TODO: If server respose is error, Display error message */}
        </form>
    );
}
