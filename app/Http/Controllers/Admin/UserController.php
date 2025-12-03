<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Http\Controllers\Controller;

use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke(Request $request, UserService $userService)
    {
        $users = $userService->retrieveLatestUsers($request->query());
        return Inertia::render('admin/users', [
            'users' => $users
        ]);
    }
}
