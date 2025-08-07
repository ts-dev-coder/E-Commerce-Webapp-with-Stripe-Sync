import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import { FormEventHandler } from 'react';

import AppLayout from '@/layouts/app-layout';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import { Label } from '@/components/ui/label';
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
            <div>
                <div className="mt-8 flex justify-center">
                    <div className="w-full max-w-md">
                        <Card className="rounded-xl shadow-lg">
                            <CardHeader>
                                <CardTitle className="text-center text-2xl font-bold">{product.name}</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="mb-4 flex justify-center">
                                    <img
                                        src={'https://placehold.co/400x300?text=No+Image'}
                                        alt={product.name}
                                        className="h-56 w-full rounded object-cover"
                                    />
                                </div>
                                <p className="mb-4 text-center text-sm text-muted-foreground">{product.description}</p>
                                <div className="mb-4 flex items-baseline justify-center">
                                    <span className="mr-1 text-base text-primary">¥</span>
                                    <span className="text-2xl font-bold">{product.price}</span>
                                </div>
                                <div className="mb-4 flex justify-center">
                                    {product.stock > 0 ? (
                                        <span className="rounded bg-green-50 px-2 py-0.5 text-xs text-green-600">在庫あり</span>
                                    ) : (
                                        <span className="rounded bg-red-50 px-2 py-0.5 text-xs text-red-600">一時的に在庫切れ</span>
                                    )}
                                </div>
                                <form onSubmit={submit}>
                                    <div className="mb-4 flex items-center justify-center gap-2">
                                        <input type="hidden" value={product.id} />
                                        <Label className="text-muted-foreground">数量:</Label>
                                        <Select onValueChange={handleQuantityChange} defaultValue="1">
                                            <SelectTrigger className="w-50">
                                                <SelectValue placeholder="個数" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {Array.from({ length: product.max_quantity }).map((_, i) => {
                                                    const num = String(i + 1);
                                                    return <SelectItem value={num}>{num}</SelectItem>;
                                                })}
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <Button type="submit" className="w-full" variant="default" disabled={processing}>
                                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                        カートに追加
                                    </Button>
                                    <InputError message={errors.quantity} />
                                </form>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
