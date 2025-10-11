import { LoaderCircle } from 'lucide-react';

import { useForm } from '@inertiajs/react';

import { FormEventHandler } from 'react';

import { Button } from './ui/button';

import { CartItemQuantityForm } from './cart-item-quantity-form';
import InputError from './input-error';

import { CartItem, Product } from '@/types';
import { StockStatus } from './stock-status';

type Response = CartItem & {
    product: Product;
};

type DeleteCartItemForm = {
    cart_item_id: number;
};

export const CartItemCard = ({ item }: { item: Response }) => {
    const {
        delete: cartItemDelete,
        processing,
        errors,
    } = useForm<Required<DeleteCartItemForm>>({
        cart_item_id: item.id,
    });

    const handleDeleteCartItem: FormEventHandler = (e) => {
        e.preventDefault();

        cartItemDelete(route('cart.destroy'));
    };

    return (
        <div className="flex py-2">
            <div className="size-40 flex-shrink-0 overflow-hidden">
                <img src="https://picsum.photos/id/163/200/200" alt={item.product.name} className="size-full object-contain" />
            </div>
            <div className="flex flex-col gap-y-2 px-3">
                <span className="line-clamp-1 text-xl font-semibold">{item.product.name}</span>
                <span className="text-xl font-semibold">￥{item.product.price.toLocaleString('ja-JP')}</span>
                <div className="w-fit">
                    <StockStatus status="in-stock" />
                </div>
                <div className="flex space-x-2">
                    <CartItemQuantityForm
                        cartItemId={item.id}
                        productId={item.product_id}
                        quantity={item.quantity}
                        maxQuantity={item.product.max_quantity}
                    />

                    {/* 削除フォーム */}
                    <form onSubmit={handleDeleteCartItem}>
                        <input type="hidden" value={item.id} />
                        <Button type="submit" variant={'ghost'} className="cursor-pointer text-xs text-muted-foreground">
                            {processing && <LoaderCircle className="size-4" />}
                            削除
                        </Button>
                        <InputError message={errors.cart_item_id} />
                    </form>
                </div>
            </div>
        </div>
    );
};
