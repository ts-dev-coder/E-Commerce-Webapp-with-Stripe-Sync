<?php

namespace App\Repositories\Admin;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function findByFilters(array $filters, int $limit = 30): Collection
    {
        $query = Product::query();

        $filterMap = [
            'name' => fn($query, $value) =>
                $query->where('name', 'like', "%{$value}%"),

            'price' => fn($query, $value) =>
                $query->where('price', $value),

            'is_published' => fn($query, $value) =>
                $query->where('is_published', (bool) $value),
        ];

        foreach ($filters as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (isset($filterMap[$key])) {
                $filterMap[$key]($query, $value);
            }
        }

        return $query->latest()->take($limit)->get();
    }
}
