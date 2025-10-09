import { Link } from '@inertiajs/react';

export const ProductCarousel = () => {
    return (
        <div className="py-4">
            <div className="mb-3 flex items-center justify-between">
                <h1 className="text-lg font-semibold">人気ショップのおすすめアイテム</h1>
                <Link href="#">
                    <span className="text-xs font-semibold text-blue-500 hover:underline">すべて見る</span>
                </Link>
            </div>

            <div className="flex items-center">
                {Array.from({ length: 5 }).map(() => (
                    <Link href="#">
                        <div className="w-40 cursor-pointer hover:bg-gray-200/60">
                            <img src={'https://placehold.co/400x300?text=No+Image'} alt={''} />
                            <div className="flex flex-col gap-y-4 p-2">
                                <span className="text-xs font-semibold">AMERY</span>
                                <span className="font-semibold text-red-600">￥4,980</span>
                            </div>
                        </div>
                    </Link>
                ))}
            </div>
        </div>
    );
};
