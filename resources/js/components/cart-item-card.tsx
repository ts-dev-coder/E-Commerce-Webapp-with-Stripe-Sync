import { LoaderCircle } from 'lucide-react';

import { Link, useForm } from '@inertiajs/react';

import { FormEventHandler } from 'react';

import { Button } from './ui/button';

import { CartItemQuantityForm } from './cart-item-quantity-form';
import InputError from './input-error';

import { Product } from '@/types';

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
        <div className="mx-auto flex py-2">
            <div className="h-40 w-52">
                {/* 商品画像 */}
                <img src={'https://placehold.co/400x300?text=No+Image'} alt={'product-image'} className="size-full object-contain" />
            </div>

            <div className="flex-1 space-y-2 px-4">
                {/* 商品名 */}
                <div className="flex items-center justify-between">
                    <Link href={route('product-detail', item.id)} className="w-full">
                        <div className="line-clamp-2 min-h-10 w-10/12 text-lg hover:text-red-700 hover:underline">{item.product.name}</div>
                    </Link>

                    {/* 商品価格 */}
                    <div className="text-xl font-semibold">{item.product.price.toLocaleString('ja-JP')}円</div>
                </div>

                {/* 在庫状況 */}
                {item.product.stock > 0 ? (
                    <p className="inline-flex rounded bg-green-50 px-2 py-0.5 text-green-600">在庫あり</p>
                ) : (
                    <p className="lllllrounded inline-flex bg-red-50 px-2 py-0.5 text-red-600">一時的に在庫切れ</p>
                )}

                <div className="flex items-center space-x-4">
                    {/* 購入個数 */}
                    <CartItemQuantityForm
                        cartItemId={item.id}
                        productId={item.product_id}
                        quantity={item.quantity}
                        maxQuantity={item.product.max_quantity}
                    />

                    {/* 削除フォーム */}
                    <form onSubmit={handleDeleteCartItem}>
                        <input type="hidden" value={item.id} />
                        <Button type="submit" variant={'ghost'} className="cursor-pointer text-xs text-muted-foreground" disabled={processing}>
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
