<?php

namespace App\Http\Controllers;

use App\Models\Address;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request) {
        // TODO:StoreAddressRequest classでのバリデーション
        // TODO:デフォルトで設定しているものがある場合はFalseに変更する

        Address::create([
            'user_id'        => Auth::id(),
            'recipient_name' => $request->input('recipient_name'),
            'postal_code'    => $request->input('postal_code'),
            'prefecture'     => $request->input('prefecture'),
            'city'           => $request->input('city'),
            'street'         => $request->input('street'),
            'building'       => $request->input('building'),
            'phone_number'   => $request->input('phone_number'),
            'is_default'     => $request->input('is_default', false),
        ]);

        return response()->json([
            'message' => 'successfully.',
        ]);
    }
}
