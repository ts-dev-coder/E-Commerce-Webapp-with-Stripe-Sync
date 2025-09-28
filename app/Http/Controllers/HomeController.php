<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Services\HomeService;

class HomeController extends Controller
{
    public function __invoke(HomeService $homeService)
    {
        $user = Auth::user();

        $categoryProducts = $homeService->getHomeData();
        $cartItemCount = $user?->cartItemCount() ?? 0;
        
        return Inertia::render('home', [
            'categoryProducts' => $categoryProducts,
            'cartItemCount' => $cartItemCount
        ]);        
    }
}
