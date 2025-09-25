<?php

namespace App\Services;

use App\Models\User;

class AddressService {
  public function toggleDefault(User $user) {
    $defaultAddress = $user->defaultAddress();

    if($defaultAddress === null) {
      return;
    }

    $defaultAddress->update(['is_default' => false]);
  }
}