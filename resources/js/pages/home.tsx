import { Head } from '@inertiajs/react';

import { BannerCarousel } from '@/components/banner-carousel';
import { CategoryNavigation } from '@/components/category-navigation';
import { FakeBanner } from '@/components/fake-banner';
import { ProductCarousel } from '@/components/product-carousel';

import AppLayout from '@/layouts/app-layout';

import { type Product } from '@/types';

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
            <Head title="home" />
            <BannerCarousel />
            <div className="flex w-full flex-1 flex-col md:max-w-7xl">
                <div className="flex flex-1">
                    <CategoryNavigation />
                    <div className="flex-1 px-6">
                        <div>
                            <FakeBanner
                                className="bg-gradient-to-r from-red-400 to-pink-400 text-white"
                                word="新規会員登録で１０００円クーポンプレゼント中"
                            />

                            <FakeBanner className="bg-gradient-to-r from-sky-300 to-blue-500 text-white" word="対象アイテム毎日更新" />
                        </div>
                        <div>
                            <ProductCarousel />
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
