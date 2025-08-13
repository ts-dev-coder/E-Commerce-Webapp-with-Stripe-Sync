import { Head } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';

import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];

export default function Checkout() {
    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={0}>
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
                                        <Label htmlFor="default">東京都新宿区西新宿1-1-1-101</Label>
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
                    <h2 className="text-xl font-semibold">カート内商品</h2>
                    <div className="w-full max-w-xl">
                        <Card className="shadow-md">
                            <CardContent className="flex gap-6 p-6">
                                <img
                                    src={'https://placehold.co/400x300?text=No+Image'}
                                    alt={'product-image'}
                                    className="size-36 rounded-lg border border-gray-200 object-cover"
                                />
                                <div className="flex flex-1 flex-col justify-between">
                                    <div>
                                        <div className="mb-1 text-lg font-semibold">Hello world</div>
                                        <div className="mb-2 text-base font-bold text-primary">¥1000</div>
                                        <div className="mb-2">
                                            {/* {item.product.stock > 0 ? (
                                <span className="rounded bg-green-50 px-2 py-0.5 text-xs text-green-600">在庫あり</span>
                            ) : (
                                <span className="rounded bg-red-50 px-2 py-0.5 text-xs text-red-600">一時的に在庫切れ</span>
                            )} */}
                                            <span className="rounded bg-green-50 px-2 py-0.5 text-xs text-green-600">在庫あり</span>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-2">
                                        {/* <CartItemQuantityForm
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
                        </form> */}
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div className="col-span-5">
                    <Card>
                        <CardContent>
                            <Button>購入する</Button>
                            <hr className="my-6" />
                            <div className="flex flex-col space-y-3">
                                <span className="flex w-full items-center justify-between text-sm">
                                    商品の小計 : <span>￥1000</span>
                                </span>
                                <span className="flex w-full items-center justify-between text-sm">
                                    配送料 : <span>￥500</span>
                                </span>
                                <span className="flex w-full items-center justify-between text-sm">
                                    合計 : <span>￥1500</span>
                                </span>
                                <div className="flex w-full items-center justify-between text-lg font-semibold">
                                    ご請求額  : <span>￥1500</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
