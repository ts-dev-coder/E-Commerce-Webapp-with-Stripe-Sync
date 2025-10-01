import { Head } from '@inertiajs/react';

import { BannerCarousel } from '@/components/banner-carousel';
import { ProductCard } from '@/components/product-card';

import AppLayout from '@/layouts/app-layout';

import { Product } from '@/types';

type CategoryProducts = {
    [categoryName: string]: Product[];
};

type Props = {
    categoryProducts: CategoryProducts;
    cartItemCount: number;
};

export default function Dashboard({ categoryProducts, cartItemCount }: Props) {
    return (
        <AppLayout cartItemCount={cartItemCount}>
            <Head title="Dashboard" />
            <BannerCarousel />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div>
                    {Object.keys(categoryProducts).map((categoryName) => {
                        const products = categoryProducts[categoryName];
                        return (
                            <section key={categoryName} className="mb-6 flex min-h-[9rem] flex-col">
                                <header className="mb-3 w-full">
                                    <h2 className="text-2xl font-semibold underline decoration-slate-300 underline-offset-8">{categoryName}</h2>
                                </header>

                                {products && products.length > 0 ? (
                                    <div className="relative">
                                        {/* 横スクロール可能エリア */}
                                        <div className="scrollbar-thin scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400 flex overflow-x-auto pb-2">
                                            {products.map((product) => (
                                                <ProductCard product={product} key={product.id} />
                                            ))}
                                        </div>

                                        <div className="pointer-events-none absolute top-0 right-0 h-full w-12 bg-gradient-to-l from-white to-transparent" />
                                    </div>
                                ) : (
                                    <p className="text-gray-500 italic">No products available.</p>
                                )}
                            </section>
                        );
                    })}
                </div>
            </div>
        </AppLayout>
    );
}
