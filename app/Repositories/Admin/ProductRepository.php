<?php

namespace App\Repositories\Admin;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function findByFilters(array $filters): Collection
    {
        $query = Product::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->get();
    }
}
