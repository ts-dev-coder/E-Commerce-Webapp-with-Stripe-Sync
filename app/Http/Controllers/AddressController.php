<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;

use App\Models\Address;

use App\Repositories\AddressRepository;


class AddressController extends Controller
{
    public function store(StoreAddressRequest $request, AddressRepository $addressRepository) {
        // TODO:デフォルトで設定しているものがある場合はFalseに変更する

        $validatedData = $request->validated();

        $address = new Address($validatedData);

        $addressRepository->createAddresss($address);

        return response()->json([
            'message' => 'successfully.',
        ]);
    }
}
