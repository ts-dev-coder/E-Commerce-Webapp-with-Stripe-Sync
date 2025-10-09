import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

import AppLayout from '@/layouts/app-layout';

import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
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
            <div className="grid grid-cols-12 py-5">
                <div className="col-span-7 space-y-5">
                    <div className="w-full max-w-xl">
                        <Card>
                            <CardHeader>
                                <CardTitle>お届け先</CardTitle>
                            </CardHeader>
                            {defaultAddress === null ? (
                                <div className="text-center font-semibold">登録している住所はありません</div>
                            ) : (
                                <CardContent>
                                    <RadioGroup defaultValue={String(defaultAddress.id)} onValueChange={handleChangeShippingAddressId}>
                                        <div className="flex items-center space-x-2">
                                            <RadioGroupItem value={String(defaultAddress.id)} id={String(defaultAddress.id)} />
                                            <Label htmlFor={String(defaultAddress.id)}>{defaultAddress.full_address}</Label>
                                        </div>

                                        {addresses?.map((address) => (
                                            <div className="flex items-center space-x-2" key={address.id}>
                                                <RadioGroupItem value={String(address.id)} id={String(address.id)} />
                                                <Label htmlFor={String(address.id)}>{address.full_address}</Label>
                                            </div>
                                        ))}
                                    </RadioGroup>
                                </CardContent>
                            )}
                        </Card>
                    </div>

                    <CreateShippingAddressModal />

                    {/* Payment method */}
                    <div className="w-full max-w-xl">
                        <Card>
                            <CardHeader>
                                <CardTitle>お支払方法</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <RadioGroup defaultValue="stripe">
                                    <div className="flex items-center space-x-2">
                                        <RadioGroupItem value="stripe" id="stripe" />
                                        <Label htmlFor="stripe">Stripe</Label>
                                    </div>
                                </RadioGroup>
                            </CardContent>
                        </Card>
                    </div>

                    <hr className="w-full max-w-xl" />

                    {/* CartItems */}
                    <h2 className="text-2xl font-semibold">カート内商品</h2>
                    <div>
                        {cartItems.length > 0 ? (
                            cartItems.map((item) => <CartItemCard key={item.id} item={item} />)
                        ) : (
                            <span className="text-lg font-semibold">カート内に商品はありません</span>
                        )}
                    </div>
                </div>

                <div className="col-span-5">
                    <Card>
                        <CardContent>
                            <form onSubmit={handleCheckout}>
                                <Button type="submit" variant={'addCart'}>
                                    購入する
                                </Button>
                            </form>
                            <hr className="my-6" />
                            <div className="flex flex-col space-y-3">
                                <span className="flex w-full items-center justify-between text-sm">
                                    商品の小計 : <span>￥{subTotal.toLocaleString()}</span>
                                </span>
                                <span className="flex w-full items-center justify-between text-sm">
                                    配送料 : <span>￥{shippingFee.toLocaleString()}</span>
                                </span>
                                <span className="flex w-full items-center justify-between text-sm">
                                    合計 : <span>￥{totalPrice.toLocaleString()}</span>
                                </span>
                                <div className="flex w-full items-center justify-between text-lg font-semibold">
                                    ご請求額 : <span>￥{totalPrice.toLocaleString()}</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
