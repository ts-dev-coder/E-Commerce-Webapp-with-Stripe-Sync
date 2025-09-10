import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import { FormEventHandler } from 'react';

import AppLayout from '@/layouts/app-layout';

import InputError from '@/components/input-error';

import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import { type BreadcrumbItem, type Product } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];

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
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={cartItemCount}>
            <Head title="Dashboard" />

            <div className="grid grid-cols-12 pt-4">
                <div className="col-span-5">
                    {/* 商品画像 */}
                    <img src={'https://placehold.co/400x300?text=No+Image'} alt={product.name} className='size-11/12'/>
                </div>

                <div className="col-span-4 flex flex-col space-y-5">
                    {/* 商品名 */}
                    <span className="text-2xl">{product.name}</span>

                    {/* 商品説明 */}
                    <div className="flex flex-col">
                        <p className="mb-2 text-xl font-semibold">この商品について</p>
                        {product.description}
                    </div>

                    {/* 商品価格 */}
                    <span className="text-2xl font-semibold">{product.price.toLocaleString('ja-JP')}円</span>
                </div>

                <div className="col-span-3">
                    <div className="space-y-3 rounded-lg border p-3">
                        {/* 商品価格 */}
                        <p className="text-2xl font-semibold">{product.price.toLocaleString('ja-JP')}円</p>

                        {/* 在庫状況 */}
                        {/* TODO: 在庫状況のUIをコンポーネント化する */}
                        {product.stock > 0 ? (
                            <p className="inline-flex rounded bg-green-50 px-2 py-0.5 text-green-600">在庫あり</p>
                        ) : (
                            <p className="inline-flex rounded bg-red-50 px-2 py-0.5 text-red-600">一時的に在庫切れ</p>
                        )}

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
                                {/* 各ボタン専用のVariantを追加する */}
                                <div className="flex flex-col space-y-2">
                                    {/* カート追加ボタン */}
                                    <form onSubmit={submit}>
                                        <Button type="submit" className="w-full">
                                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                            カートに入れる
                                        </Button>
                                        <InputError message={errors.quantity} />
                                    </form>

                                    <form onSubmit={() => console.log('Now buy.')}>
                                        {/* 今すぐ買うボタン */}
                                        <Button type="submit" className="w-full">
                                            今すぐ買う
                                        </Button>
                                    </form>
                                </div>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
