import { FormEventHandler } from 'react';

import { useForm } from '@inertiajs/react';

import { Card, CardContent } from '@/components/ui/card';

import { Product } from '@/types';

import { Button } from './ui/button';

import { CartItemQuantityForm } from './cart-item-quantity-form';
import InputError from './input-error';

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
        <Card key={item.id} className="shadow-md">
            <CardContent className="flex gap-6 p-6">
                <img
                    src={'https://placehold.co/400x300?text=No+Image'}
                    alt={'product-image'}
                    className="size-36 rounded-lg border border-gray-200 object-cover"
                />
                <div className="flex flex-1 flex-col justify-between">
                    <div>
                        <div className="mb-1 text-lg font-semibold">{item.product.name}</div>
                        <div className="mb-2 text-base font-bold text-primary">¥{item.product.price}</div>
                        <div className="mb-2">
                            {item.product.stock > 0 ? (
                                <span className="rounded bg-green-50 px-2 py-0.5 text-xs text-green-600">在庫あり</span>
                            ) : (
                                <span className="rounded bg-red-50 px-2 py-0.5 text-xs text-red-600">一時的に在庫切れ</span>
                            )}
                        </div>
                    </div>
                    <div className="flex items-center gap-2">
                        <CartItemQuantityForm
                            cartItemId={item.id}
                            productId={item.product_id}
                            quantity={item.quantity}
                            maxQuantity={item.product.max_quantity}
                        />
                        <form onSubmit={handleDeleteCartItem}>
                            <input type="hidden" value={item.id} />
                            <Button variant={'ghost'} className="text-xs text-muted-foreground" disabled={processing}>
                                削除
                            </Button>
                            <InputError message={errors.cart_item_id} />
                        </form>
                    </div>
                </div>
            </CardContent>
        </Card>
    );
};
