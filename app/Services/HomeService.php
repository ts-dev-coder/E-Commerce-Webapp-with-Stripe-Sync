<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class HomeService
{
    protected $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function getHomeData()
    {
        $categories = $this->categories->getCategoryWithProducts();
        
        $categoryProducts = [];

        foreach ($categories as $category) {
            $categoryProducts[$category->name] = $category->products;
        }

        return $categoryProducts;
    }
}
