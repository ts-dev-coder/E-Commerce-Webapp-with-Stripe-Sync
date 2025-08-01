import { ProductCard } from '@/components/product-card';
import AppLayout from '@/layouts/app-layout';
import { Product, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

type Props = {
    products: Product[];
    cartItemCount: number;
};

export default function Dashboard({ products, cartItemCount }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={cartItemCount}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    {products && products.length > 0 ? (
                        products.map((product: Product) => <ProductCard key={product.id} product={product} />)
                    ) : (
                        <p className="text-gray-600">No products available.</p>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
