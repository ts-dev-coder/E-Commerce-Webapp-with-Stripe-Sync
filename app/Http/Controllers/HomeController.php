<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Services\HomeService;
use App\Services\CartService;

class HomeController extends Controller
{
    public function __invoke(HomeService $homeService, CartService $cartService)
    {
        return Inertia::render('home', [
            'categoryProducts' => $homeService->getHomeData(),
            'cartItemCount' => $cartService->getCartItemCount(Auth::user())
        ]);        
    }
}
