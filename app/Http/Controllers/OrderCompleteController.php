<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OrderCompleteController extends Model
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
