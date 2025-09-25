<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressRepository {
  public function createAddresss(Address $address) {
    Address::create([
        'user_id'        => Auth::id(),
        'recipient_name' => $address->recipient_name,
        'postal_code'    => $address->postal_code,
        'prefecture'     => $address->prefecture,
        'city'           => $address->city,
        'street'         => $address->street,
        'building'       => $address->building,
        'phone_number'   => $address->phone_number,
        'is_default'     => $address->is_default,
      ]);
  }
}