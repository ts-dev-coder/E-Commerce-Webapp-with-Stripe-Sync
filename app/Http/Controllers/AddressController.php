<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;

use App\Models\Address;

use App\Repositories\AddressRepository;

use App\Services\AddressService;

use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(StoreAddressRequest $request, AddressRepository $addressRepository, AddressService $addressService) {
        
        if($request->validated('is_default')) {
            $addressService->toggleDefault(Auth::user());
        }

        $validatedData = $request->validated();

        $address = new Address($validatedData);

        $addressRepository->createAddresss($address);

        return response()->json([
            'message' => 'successfully.',
        ]);
    }
}
