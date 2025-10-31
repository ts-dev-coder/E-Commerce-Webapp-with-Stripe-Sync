<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('admin/products');
    }
}
