<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Support\Collection;

class ProductService
{
    protected ProductRepository $repository;

    public function __construct(?ProductRepository $repository = null)
    {
        $this->repository = $repository ?? new ProductRepository;
    }

    public function retrieveLatestProducts(array $filters, int $limit = 30): Collection
    {
        return $this->repository->findByFilters($filters, $limit);
    }

    public function updateProduct(Product $product, array $updatedProduct): bool
    {
        return $product->update($updatedProduct);
    }

    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }

    public function search(array $filters): Collection
    {
        return $this->repository->findByFilters($filters);
    }
}
