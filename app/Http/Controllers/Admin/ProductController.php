<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;

class ProductController extends Controller
{
    public function index(ProductService $productService)
    {
        // 最新の商品データを１０件取得する
        $products = $productService->retrieveLatestProducts();
        return Inertia::render('admin/products', [
            'products' => $products
        ]);
    }

    public function update(ProductService $productService)
    {
        $productService->updateProduct($product, $updatedData);

        redirect()->route('admin.products');
    }
}
