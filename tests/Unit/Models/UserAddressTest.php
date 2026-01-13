<?php

namespace Tests\Unit\Models;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sets_default_if_user_has_no_addresses()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $address = $user->addAddress([
            'recipient_name' => '山田 太郎',
            'postal_code'    => '1000001',
            'prefecture'     => '東京都',
            'city'           => '千代田区',
            'street'         => '千代田1-1',
            'building'       => null,
            'phone_number'   => '09012345678',
        ]);

        $this->assertTrue($address->is_default);
    }    
}
