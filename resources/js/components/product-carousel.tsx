import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from './ui/carousel';

import { type Product } from '@/types';
import { Link } from '@inertiajs/react';
import Autoplay from 'embla-carousel-autoplay';
import React from 'react';

type Props = {
    category: string;
    products: Product[];
};

export const ProductCarousel = ({ category, products }: Props) => {
    const plugin = React.useRef(Autoplay({ delay: 5000, stopOnInteraction: true }));

    return (
        <div>
            <span className="mb-3 inline-block text-lg font-semibold">{category}</span>

            <Carousel
                className="rounded-lg bg-white"
                plugins={[plugin.current]}
                onMouseEnter={plugin.current.stop}
                // TODO:カーソルを外しても動かない
                onMouseLeave={plugin.current.reset}
            >
                <CarouselContent className="">
                    {products.map((product) => (
                        <CarouselItem
                            key={product.id}
                            className="flex basis-1/2 flex-col gap-y-2 sm:basis-1/2 md:basis-1/3 lg:basis-1/4 xl:basis-1/5"
                        >
                            <div className="h-36 w-full">
                                <img
                                    src={'https://picsum.photos/id/1011/600/400'}
                                    alt={product.name}
                                    className="size-full rounded-lg object-cover"
                                    loading="lazy"
                                />
                            </div>
                            <div className="flex flex-1 flex-col justify-between gap-y-3 p-2">
                                <Link href={`/products/${product.id}`} key={product.id}>
                                    <span className="line-clamp-1 hover:underline">{product.name}</span>
                                </Link>
                                <span className="line-clamp-1 text-lg font-semibold">￥{product.price.toLocaleString('ja-JP')}</span>
                            </div>
                        </CarouselItem>
                    ))}
                </CarouselContent>
                <CarouselPrevious className="left-2" />
                <CarouselNext className="right-2" />
            </Carousel>
        </div>
    );
};
