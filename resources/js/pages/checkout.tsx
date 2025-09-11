import { Head, useForm } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';

import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';

import { CartItemCard } from '@/components/cart-item-card';

import { type BreadcrumbItem, type CartItem } from '@/types';
import { FormEventHandler } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];

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
};

type Props = {
    cartItems: CartItem[];
    cartItemCount: number;
    defaultAddress: Address;
};

type CheckoutForm = {
    delivery_address_id: number;
};

export default function Checkout({ cartItems, cartItemCount, defaultAddress }: Props) {
    const mainAddress = defaultAddress.prefecture + defaultAddress.city + defaultAddress.street + defaultAddress.building;

    const SHIPPING_FEE = 500;
    const subTotal = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
    const totalPrice = subTotal + SHIPPING_FEE;

    const { post } = useForm<CheckoutForm>({
        delivery_address_id: defaultAddress.id,
    });

    const handleCheckout: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('checkout.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={cartItemCount}>
            <Head title="Checkout" />
            <div className="grid grid-cols-12 py-5">
                <div className="col-span-7 space-y-5">
                    <div className="w-full max-w-xl">
                        {/* Address */}
                        <Card>
                            <CardHeader>
                                <CardTitle>お届け先</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <RadioGroup defaultValue="default">
                                    <div className="flex items-center space-x-2">
                                        <RadioGroupItem value="default" id="default" />
                                        <Label htmlFor="default">{mainAddress}</Label>
                                    </div>
                                </RadioGroup>
                            </CardContent>
                        </Card>
                        <div className="mt-4 flex items-center justify-end">
                            <Button>新しい住所を登録する</Button>
                        </div>
                    </div>

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
                    <div className="w-full space-y-5">
                        {cartItems.length > 0 ? (
                            cartItems.map((item) => <CartItemCard item={item} />)
                        ) : (
                            <span className="text-lg font-semibold">カート内に商品はありません</span>
                        )}
                    </div>
                </div>

                <div className="col-span-5">
                    <Card>
                        <CardContent>
                            <form onSubmit={handleCheckout}>
                                <Button type="submit" variant={'addCart'}>購入する</Button>
                            </form>
                            <hr className="my-6" />
                            <div className="flex flex-col space-y-3">
                                <span className="flex w-full items-center justify-between text-sm">
                                    商品の小計 : <span>￥{subTotal.toLocaleString()}</span>
                                </span>
                                <span className="flex w-full items-center justify-between text-sm">
                                    配送料 : <span>￥{SHIPPING_FEE}</span>
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
