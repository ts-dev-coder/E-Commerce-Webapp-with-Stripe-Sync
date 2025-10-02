import React from 'react';

import Autoplay from 'embla-carousel-autoplay';

import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from './ui/carousel';

export const BannerCarousel = () => {
    const plugin = React.useRef(Autoplay({ delay: 5000, stopOnInteraction: true }));

    return (
        <div className="flex items-center justify-center bg-amber-500 px-3 py-4">
            <Carousel
                className="relative size-full"
                plugins={[plugin.current]}
                onMouseEnter={plugin.current.stop}
                // TODO:カーソルを外しても動かない
                onMouseLeave={plugin.current.reset}
            >
                <CarouselContent>
                    {[
                        'https://picsum.photos/id/1011/600/400',
                        'https://picsum.photos/id/1015/600/400',
                        'https://picsum.photos/id/1016/600/400',
                        'https://picsum.photos/id/1021/600/400',
                        'https://picsum.photos/id/1024/600/400',
                    ].map((src, i) => (
                        <CarouselItem key={i} className="basis-1/2 pl-4 md:basis-1/3 lg:basis-1/4">
                            <img src={src} alt={`Slide ${i + 1}`} className="h-full w-full rounded-xl object-cover" />
                        </CarouselItem>
                    ))}
                </CarouselContent>
                <CarouselPrevious className="left-2" />
                <CarouselNext className="right-2" />
            </Carousel>
        </div>
    );
};
