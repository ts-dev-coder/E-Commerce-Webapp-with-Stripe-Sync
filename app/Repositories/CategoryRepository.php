<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
  public function getCategoryWithProducts() {

    return Category::with(['products' => function ($q) {
        $q->where('is_published', true)
          ->where('stock', '>', 0)
          ->limit(5)
          ->select(['id', 'name', 'description', 'price', 'max_quantity']);
    }])->get();
  }
}