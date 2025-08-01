import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Product } from '@/types';
import { Head } from '@inertiajs/react';

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

export default function ProductDetail({ product, cartItemCount }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={cartItemCount}>
            <Head title="Dashboard" />
            <div>
                {/* Product detail information */}
                <div className="mt-8 flex justify-center">
                    <div className="w-full max-w-md">
                        <Card className="rounded-xl shadow-lg">
                            <CardHeader>
                                <CardTitle className="text-center text-2xl font-bold">{product.name}</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="mb-4 flex justify-center">
                                    <img src={''} alt={product.name} className="h-56 w-full rounded object-cover" />
                                </div>
                                <p className="mb-4 text-center text-sm text-muted-foreground">{product.description}</p>
                                <div className="mb-4 flex items-baseline justify-center">
                                    <span className="mr-1 text-base text-primary">¥</span>
                                    <span className="text-2xl font-bold">{product.price}</span>
                                </div>
                                <div className="mb-4 flex justify-center">
                                    <span className="text-xs text-gray-500">在庫: {product.stock}</span>
                                </div>
                            </CardContent>
                            <CardFooter>
                                <Button className="w-full" variant="default">
                                    カートに追加
                                </Button>
                            </CardFooter>
                        </Card>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
