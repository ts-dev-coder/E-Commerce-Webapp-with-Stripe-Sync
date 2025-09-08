import { Product } from '@/types';
import { Link } from '@inertiajs/react';

export const ProductCard = ({ product }: { product: Product }) => {
    return (
        <Link href={route('product-detail', product.id)} className="group hover:opacity-80">
            <div className="flex h-52 w-40 flex-col space-y-2 pr-4">
                {/* 商品画像 */}
                <div className="size-full">
                    <img src={'https://placehold.co/400x300?text=No+Image'} alt={product.name} className="size-full object-cover" />
                </div>

                <div className="flex h-full flex-col items-center justify-between pb-3">
                    {/* 商品名 */}
                    <span className="line-clamp-2 text-base group-hover:text-red-700 group-hover:underline">{product.name}</span>

                    {/* 商品価格 */}
                    <div className="w-full text-end">
                        <span className="font-semibold text-red-700 group-hover:underline">{product.price.toLocaleString('ja-JP')}円</span>
                    </div>
                </div>
            </div>
        </Link>
    );
};
