<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;

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

    public function search(Request $request, ProductService $productService)
    {
        // queryの中身が空の場合は'/admin/products'へリダイレクトさせる
        $query = $request->query();
        if(empty($query)) {
           return redirect()->route('admin.products');
        }

        // 検索を行う
        $result = $productService->search($query);

        // 検索結果画面をレンダリングする
        return Inertia::render('admin/search', ['result' => $result]);
    }
}
