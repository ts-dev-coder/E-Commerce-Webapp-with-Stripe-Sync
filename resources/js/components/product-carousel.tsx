import { Link } from '@inertiajs/react';

import { type CategoryProducts } from '@/types';

type Props = {
    categoryProducts: CategoryProducts;
};

export const ProductCarousel = ({ categoryProducts }: Props) => {
    return (
        <div className="py-4">
            <div className="mb-3 flex items-center justify-between">
                <h1 className="text-lg font-semibold">人気ショップのおすすめアイテム</h1>
                <Link href="#">
                    <span className="text-xs font-semibold text-blue-500 hover:underline">すべて見る</span>
                </Link>
            </div>

            <div className="flex flex-col gap-y-2">
                {Object.keys(categoryProducts).map((category) => {
                    const products = categoryProducts[category];

                    return (
                        <div className="flex flex-col justify-center gap-y-2">
                            <h2 className="text-2xl font-semibold">{category}</h2>
                            <div className="flex items-start gap-x-2">
                                {products.map((product) => (
                                    <Link href="#">
                                        <div className="w-40 cursor-pointer hover:bg-gray-200/60">
                                            <img src={'https://placehold.co/400x300?text=No+Image'} alt={product.name} />
                                            <div className="flex flex-col gap-y-4 p-2">
                                                <span className="text-sm font-semibold">{product.name}</span>
                                                <span className="font-semibold text-red-600">￥{product.price.toLocaleString('ja-JP')}</span>
                                            </div>
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        </div>
                    );
                })}
            </div>
        </div>
    );
};
