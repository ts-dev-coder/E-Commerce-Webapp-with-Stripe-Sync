<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{    
    public function retrieveLatestUsers(int $limit = 10): Collection
    {
        return User::latest()->take($limit)->get();
    }
}
