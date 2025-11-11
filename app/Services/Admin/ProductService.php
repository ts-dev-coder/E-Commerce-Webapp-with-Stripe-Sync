<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductService
{
    public function retrieveLatestProducts(int $limit = 10): Collection
    {
        return Product::latest()->take($limit)->get();
    }

    public function updateProduct(Product $product, array $updatedProduct): bool
    {
        return $product->update($updatedProduct);
    }

    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }
}
