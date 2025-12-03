<?php

namespace App\Services\Admin;

use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Collection;

class UserService
{    
    protected UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();    
    }

    public function retrieveLatestUsers(array $filters, int $limit = 30): Collection
    {
        return $this->repository->findByFilters($filters, $limit);
    }
}
