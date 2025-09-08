import { Product } from '@/types';

export const ProductCard = ({ product }: { product: Product }) => {
    return (
        <div className="flex h-52 w-40 flex-col space-y-2 pr-4">
            {/* 商品画像 */}
            <div className="size-full">
                <img src={'https://placehold.co/400x300?text=No+Image'} alt={product.name} className="size-full object-cover" />
            </div>

            <div className="flex h-full flex-col items-center justify-between pb-3">
                {/* 商品名 */}
                <span className="line-clamp-2 text-base">{product.name}</span>

                {/* 商品価格 */}
                <div className="w-full text-end">
                    <span className="font-semibold text-red-600">{product.price.toLocaleString('ja-JP')}円</span>
                </div>
            </div>
        </div>
    );
};
