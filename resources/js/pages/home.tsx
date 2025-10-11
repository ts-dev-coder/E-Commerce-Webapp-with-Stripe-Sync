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
            <BannerCarousel />
            <div className="flex w-full flex-1 flex-col md:max-w-7xl">
                <div className="flex flex-1">
                    <CategoryNavigation categories={categories} />
                    <div className="flex-1 px-6">
                        <div>
                            <ProductCarousel categoryProducts={categoryProducts}/>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
