import { Head } from '@inertiajs/react';

import { BannerCarousel } from '@/components/banner-carousel';
import { CategoryNavigation } from '@/components/category-navigation';
import { ProductCarousel } from '@/components/product-carousel';

import AppLayout from '@/layouts/app-layout';

import { type CategoryProducts } from '@/types';

type Props = {
    categoryProducts: CategoryProducts;
    cartItemCount: number;
};

export default function Dashboard({ categoryProducts, cartItemCount }: Props) {
    const categories = Object.keys(categoryProducts);

    return (
        <AppLayout cartItemCount={cartItemCount}>
            <Head title="home" />
            <div className="w-full px-2 2xl:max-w-[2000px]">
                <BannerCarousel />
            </div>

            {/* Main Content */}
            <div className="flex size-full min-h-0 justify-center py-5">
                <div className="flex w-full md:max-w-5xl">
                    {/* Navigation area */}
                    <div className="w-fit overflow-y-auto">
                        <CategoryNavigation categories={categories} />
                    </div>

                    {/* Product Section area */}
                    <div className="flex flex-1 flex-col gap-y-4 overflow-y-auto pr-3">
                        {Object.keys(categoryProducts).map((category) => {
                            const products = categoryProducts[category];

                            return <ProductCarousel category={category} products={products} />;
                        })}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
