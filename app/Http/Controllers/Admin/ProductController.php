<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
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

    public function update(UpdateProductRequest $request, Product $product, ProductService $productService)
    {
        $productService->updateProduct($product, $request->validated());

        redirect()->route('admin.products');
    }

    public function destroy(Product $product, ProductService $productService)
    {
        $productService->deleteProduct($product);

        redirect()->route('admin.products');
    }
}
