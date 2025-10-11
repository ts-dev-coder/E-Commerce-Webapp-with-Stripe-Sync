import React from 'react';

import Autoplay from 'embla-carousel-autoplay';

import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from './ui/carousel';

export const BannerCarousel = () => {
    const plugin = React.useRef(Autoplay({ delay: 5000, stopOnInteraction: true }));

    const banners = [
        { id: 1, src: 'https://picsum.photos/id/1011/600/400', alt: 'Banner 1' },
        { id: 2, src: 'https://picsum.photos/id/1015/600/400', alt: 'Banner 2' },
        { id: 3, src: 'https://picsum.photos/id/1016/600/400', alt: 'Banner 3' },
        { id: 4, src: 'https://picsum.photos/id/1021/600/400', alt: 'Banner 4' },
        { id: 5, src: 'https://picsum.photos/id/1024/600/400', alt: 'Banner 5' },
        { id: 6, src: 'https://picsum.photos/id/1044/600/400', alt: 'Banner 6' },
        { id: 7, src: 'https://picsum.photos/id/1023/600/400', alt: 'Banner 7' },
        { id: 8, src: 'https://picsum.photos/id/1033/600/400', alt: 'Banner 8' },
        { id: 9, src: 'https://picsum.photos/id/1035/600/400', alt: 'Banner 9' },
        { id: 10, src: 'https://picsum.photos/id/1011/600/400', alt: 'Banner 10' },
    ];

    return (
        <Carousel
            plugins={[plugin.current]}
            onMouseEnter={plugin.current.stop}
            // TODO:カーソルを外しても動かない
            onMouseLeave={plugin.current.reset}
        >
            <CarouselContent>
                {banners.map((banner) => (
                    <CarouselItem key={banner.id} className="basis-1/2 sm:basis-1/2 md:basis-1/3 lg:basis-1/4 xl:basis-1/5">
                        <img src={banner.src} alt={`Slide ${banner.id}`} className="size-full rounded-lg object-contain" loading="lazy" />
                    </CarouselItem>
                ))}
            </CarouselContent>
            <CarouselPrevious className="left-2" />
            <CarouselNext className="right-2" />
        </Carousel>
    );
};
