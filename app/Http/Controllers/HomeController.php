<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Services\HomeService;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function __invoke()
    {
        $user = Auth::user();

        $categoryProducts = $this->homeService->getHomeData();
        $cartItemCount = $user?->cartItemCount() ?? 0;
        
        return Inertia::render('home', [
            'categoryProducts' => $categoryProducts,
            'cartItemCount' => $cartItemCount
        ]);        
    }
}
