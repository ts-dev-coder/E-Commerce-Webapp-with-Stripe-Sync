import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Product } from '@/types';
import { Link } from '@inertiajs/react';

export const ProductCard = ({ product }: { product: Product }) => {
    return (
        <Card className="flex h-full w-full max-w-xs flex-col justify-between shadow-lg">
            <CardHeader>
                <CardTitle className="text-lg font-semibold">{product.name}</CardTitle>
            </CardHeader>
            <CardContent className="flex flex-1 flex-col">
                {/* TODO: Add product image */}
                <img src={'https://placehold.co/400x300?text=No+Image'} alt={product.name} className="mb-4 h-40 w-full rounded object-cover" />
                <p className="mb-2 text-sm text-muted-foreground">{product.description}</p>
                <div className="flex-1" />
                <div className="mb-2 flex items-baseline justify-center">
                    <span className="mr-1 text-base text-primary">¥</span>
                    <span className="text-xl font-bold">{product.price}</span>
                </div>
            </CardContent>
            <CardFooter>
                <Link href={`/products/${product.id}`} className="w-full">
                    <Button className="w-full" variant="outline">
                        詳細を見る
                    </Button>
                </Link>
            </CardFooter>
        </Card>
    );
};
