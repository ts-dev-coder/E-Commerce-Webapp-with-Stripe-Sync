import { Link } from '@inertiajs/react';

import { type CategoryProducts } from '@/types';

type Props = {
    categoryProducts: CategoryProducts;
};

export const ProductCarousel = ({ categoryProducts }: Props) => {
    return (
        <div className="py-4">
            <div className="flex flex-col gap-y-2">
                {Object.keys(categoryProducts).map((category) => {
                    const products = categoryProducts[category];

                    return (
                        <div className="flex flex-col justify-center gap-y-2">
                            <h2 className="text-2xl font-semibold">{category}</h2>
                            <div className="flex items-start gap-x-2">
                                {products.map((product) => (
                                    <Link href={`/products/${product.id}`}>
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
