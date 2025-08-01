import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Product } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
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
    const { data, setData, post, processing, errors, reset } = useForm<Required<AddCartForm>>({
        product_id: product.id,
        quantity: 1,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('cart.store'), {
            onFinish: () => reset('quantity'),
        });
    };

    const handleQuantityChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const value = Math.max(1, Math.min(product.stock, Number(e.target.value)));
        setData('quantity', value);
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
                                    <img src={'https://placehold.co/400x300?text=No+Image'} alt={product.name} className="h-56 w-full rounded object-cover" />
                                </div>
                                <p className="mb-4 text-center text-sm text-muted-foreground">{product.description}</p>
                                <div className="mb-4 flex items-baseline justify-center">
                                    <span className="mr-1 text-base text-primary">¥</span>
                                    <span className="text-2xl font-bold">{product.price}</span>
                                </div>
                                <div className="mb-4 flex justify-center">
                                    <span className="text-xs text-gray-500">在庫: {product.stock}</span>
                                </div>
                                <form onSubmit={submit}>
                                    <div className="mb-4 flex items-center justify-center gap-2">
                                        <input type="hidden" value={product.id} />
                                        <span className="text-sm">個数</span>
                                        <input
                                            type="number"
                                            min={1}
                                            max={product.stock}
                                            value={data.quantity}
                                            onChange={handleQuantityChange}
                                            className="w-16 rounded border px-2 py-1 text-center"
                                        />
                                    </div>
                                    <Button type="submit" className="w-full" variant="default" disabled={processing}>
                                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                        カートに追加
                                    </Button>
                                    <InputError message={errors.product_id} />
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
