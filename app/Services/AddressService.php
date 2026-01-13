<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;

class AddressService {

  public function storeAddress(User $user, array $data): Address
  {
      return $user->addAddress($data);
  }
}