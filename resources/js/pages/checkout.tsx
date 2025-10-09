import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

import AppLayout from '@/layouts/app-layout';

import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';

import { CartItemCard } from '@/components/cart-item-card';
import { CreateShippingAddressModal } from '@/components/create-shipping-address-modal';

import { type CartItem } from '@/types';

type Address = {
    id: number;
    userId: number;
    recipiendName: string;
    postalCode: string;
    prefecture: string;
    city: string;
    street: string;
    building: string;
    phoneNumber: number;
    isDefault: boolean;
    full_address: string;
};

type Props = {
    cartItems: CartItem[];
    cartItemCount: number;
    defaultAddress: Address | null;
    addresses: Address[] | null;
    shippingFee: number;
    subTotal: number;
    totalPrice: number;
};

type CheckoutForm = {
    delivery_address_id: number | null;
};

export default function Checkout({ cartItems, cartItemCount, defaultAddress, shippingFee, addresses, subTotal, totalPrice }: Props) {
    const { post, setData } = useForm<CheckoutForm>({
        delivery_address_id: defaultAddress === null ? null : defaultAddress.id,
    });

    const handleCheckout: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('checkout.store'));
    };

    const handleChangeShippingAddressId = (e: string) => {
        const id = Number(e);
        if (Number.isNaN(id)) return;

        setData('delivery_address_id', id);
    };

    return (
        <AppLayout cartItemCount={cartItemCount}>
            <Head title="Checkout" />

            <div className="flex size-full p-2 md:max-w-7xl">
                <div className="flex w-[800px] flex-col gap-y-10">
                    {/* Address area */}
                    <div className="space-y-3">
                        <h2 className="text-2xl font-semibold">お届け先</h2>

                        {defaultAddress === null ? (
                            <div>登録されている住所はありません。</div>
                        ) : (
                            <RadioGroup defaultValue={String(defaultAddress.id)} onValueChange={handleChangeShippingAddressId}>
                                <div className="flex items-center gap-x-2">
                                    <RadioGroupItem value={String(defaultAddress.id)} id={String(defaultAddress.id)} />
                                    <Label htmlFor={String(defaultAddress.id)} className="font-semibold">
                                        {defaultAddress.full_address}
                                    </Label>
                                </div>

                                <hr className="my-2" />

                                <div className="flex flex-col gap-y-2">
                                    {addresses?.map((address) => (
                                        <div className="flex items-center gap-x-2">
                                            <RadioGroupItem value={String(address?.id)} id={String(address?.id)} />
                                            <Label htmlFor={String(address?.id)}>{address?.full_address}</Label>
                                        </div>
                                    ))}
                                </div>
                            </RadioGroup>
                        )}
                        <div className="flex items-center justify-end">
                            <CreateShippingAddressModal />
                        </div>
                    </div>

                    {/* Payment method area */}
                    <div className="space-y-3">
                        <h2 className="text-2xl font-semibold">お支払方法</h2>
                        <RadioGroup defaultValue="stripe">
                            <div className="flex items-center gap-x-2">
                                <RadioGroupItem value="stripe" id="stripe" />
                                <Label htmlFor="stripe" className="font-semibold">
                                    Stripe
                                </Label>
                            </div>
                        </RadioGroup>
                    </div>

                    {/* Cart item area */}
                    <div className="space-y-3">
                        <h2 className="text-2xl font-semibold">カート内商品</h2>
                        <div className="h-[900px] overflow-y-scroll">
                            {cartItems.map((item) => (
                                <CartItemCard key={item.id} item={item} />
                            ))}
                        </div>
                    </div>
                </div>

                {/* Summary area */}
                <div className="flex w-60 flex-col gap-y-3 p-8">
                    <div className="flex items-center justify-between">
                        <span>小計</span>
                        <span className="text-lg font-semibold">￥{subTotal.toLocaleString('ja-JP')}</span>
                    </div>
                    <div className="flex items-center justify-between">
                        <span>配送料</span>
                        <span className="text-lg font-semibold">￥{shippingFee.toLocaleString('ja-JP')}</span>
                    </div>
                    <div className="flex items-center justify-between">
                        <span>合計</span>
                        <span className="text-lg font-semibold">￥{totalPrice.toLocaleString('ja-JP')}</span>
                    </div>
                    <hr className="border-black" />
                    <div className="flex items-center justify-between">
                        <span className="text-lg font-semibold">ご請求額</span>
                        <span className="text-lg font-semibold">￥{totalPrice.toLocaleString('ja-JP')}</span>
                    </div>

                    <div className="mt-3 flex items-center justify-end">
                        <form onSubmit={handleCheckout}>
                            <Button type="submit">購入する</Button>
                        </form>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
