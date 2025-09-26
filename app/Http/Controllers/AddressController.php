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

        /**
         * 現状は、チェックアウト画面からのみ住所登録を行える設計なので
         * chekcout.indexにリダイレクトさせる。
         * 今後マイページなどで住所登録を行う場合は、以下のように変更する可能性あり
         * redirect()->back();
         */
        return redirect()->route('checkout.index');
    }
}
