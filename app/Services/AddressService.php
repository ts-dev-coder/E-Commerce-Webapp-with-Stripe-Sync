<?php

namespace App\Services;

use App\Models\User;

class AddressService {
  public function toggleDefault(User $user) {
    $defaultAddress = $user->defaultAddress;

    if($defaultAddress) {
      $defaultAddress->update(['is_default' => false]);
    }
  }

  public function storeAddress(User $user, array $data) {
    if($user->addresses->isEmpty()) {
      $data['is_default'] = true;
    }

    $user->addresses()->create($data);

    if($data['is_default']) {
        $this->toggleDefault($user);
    }
  }
}