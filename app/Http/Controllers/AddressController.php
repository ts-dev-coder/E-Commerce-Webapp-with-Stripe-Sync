<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;

use App\Models\Address;

use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(StoreAddressRequest $request) {
        // TODO:デフォルトで設定しているものがある場合はFalseに変更する

        Address::create([
            'user_id'        => Auth::id(),
            'recipient_name' => $request->validated('recipient_name'),
            'postal_code'    => $request->validated('postal_code'),
            'prefecture'     => $request->validated('prefecture'),
            'city'           => $request->validated('city'),
            'street'         => $request->validated('street'),
            'building'       => $request->validated('building'),
            'phone_number'   => $request->validated('phone_number'),
            'is_default'     => $request->validated('is_default', false),
        ]);

        return response()->json([
            'message' => 'successfully.',
        ]);
    }
}
