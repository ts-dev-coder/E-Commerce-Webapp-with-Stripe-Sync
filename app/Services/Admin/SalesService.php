<?php

namespace App\Services\Admin;

use App\Repositories\Admin\SalesRepository;
use Carbon\Carbon;

class SalesService
{
    protected SalesRepository $repository;

    public function __construct()
    {
        $this->repository = new SalesRepository();
    }

    public function getSalesByDateRange(Carbon $start, Carbon $end)
    {
        return $this->repository->fetchSalesByDateRange($start, $end);
    }
}
