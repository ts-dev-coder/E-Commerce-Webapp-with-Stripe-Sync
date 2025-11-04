<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Http\Controllers\Controller;

use App\Services\Admin\UserService;

class UserController extends Controller
{
    public function __invoke(UserService $userService)
    {
        $users = $userService->retrieveLatestUsers();
        return Inertia::render('admin/users', [
            'users' => $users
        ]);
    }
}
