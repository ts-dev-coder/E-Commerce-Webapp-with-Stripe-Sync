<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class OrderCompleteController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        // TODO: If the user is logged in, retrieve the count of cart items
        //       from the database
        $cartItemCount = 0;

        // TODO: Change response data to thanks page component
        return response()->json([
            'message' => 'hello world',
            'cartItemCount' => $cartItemCount
        ]);
    }
}
