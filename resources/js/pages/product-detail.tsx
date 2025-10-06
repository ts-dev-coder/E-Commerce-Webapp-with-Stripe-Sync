import { FormEventHandler } from 'react';

import { LoaderCircle } from 'lucide-react';
import { Head, useForm } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';

import InputError from '@/components/input-error';
import { StockStatus } from '@/components/stock-status';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import { type Product } from '@/types';

type Props = {
    product: Product;
    cartItemCount: number;
};

type AddCartForm = {
    product_id: number;
    quantity: number;
};

export default function ProductDetail({ product, cartItemCount }: Props) {
    const { data, setData, post, processing, errors, setError, reset } = useForm<Required<AddCartForm>>({
        product_id: product.id,
        quantity: 1,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        if (product.stock < data.quantity) {
            setError('quantity', 'Sorry, you cannot order more than the available stock.');
            return;
        }

        post(route('cart.store'), {
            onFinish: () => reset('quantity'),
        });
    };

    const handleQuantityChange = (value: string) => {
        setData('quantity', Number(value));
    };

    return (
        <AppLayout cartItemCount={cartItemCount}>
            <Head title={product.name} />

            <div className="mx-auto flex w-full rounded-lg bg-white px-4 py-8 md:max-w-6xl">
                <div className="h-[600px] w-[500px] flex-shrink-0 overflow-hidden">
                    <img src="https://picsum.photos/id/163/500/600" alt={product.name} className="size-full object-contain" />
                </div>

                <div className="flex flex-1 flex-col gap-4 p-6">
                    <h1 className="text-2xl font-semibold break-all">{product.name}</h1>
                    <span className="text-xl font-bold">￥{product.price.toLocaleString('ja-JP')}</span>

                    {/* Backend側で在庫状況を示すデータを作成して受け取るようにする */}
                    <StockStatus status="low-stock" />

                    {product.stock > 0 && (
                        <>
                            <div className="flex items-center">
                                <Label className="mr-2 text-muted-foreground">数量:</Label>
                                <Select onValueChange={handleQuantityChange} defaultValue="1">
                                    <SelectTrigger className="w-50">
                                        <SelectValue placeholder="個数" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {Array.from({ length: product.max_quantity }).map((_, i) => {
                                            const num = String(i + 1);
                                            return (
                                                <SelectItem key={num} value={num}>
                                                    {num}
                                                </SelectItem>
                                            );
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>

                            <div className="flex flex-col gap-y-2 py-2">
                                <InputError message={errors.quantity} />

                                <div className="flex gap-x-4">
                                    <form onSubmit={submit}>
                                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                        <Button type="submit">カートに入れる</Button>
                                    </form>

                                    <Button variant={'outline'}>今すぐ購入する</Button>
                                </div>
                            </div>
                        </>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
