<?php

namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    public function findByFilters(array $filters, int $limit = 30): Collection
    {
        $query = User::query();

        $filterMap = [
            'name' => fn($query, $value) =>
                $query->where('name', 'like', "%{$value}%"),

            'email' => fn($query, $value) =>
                $query->where('email', 'like', "%{$value}%"),
        ];

        foreach ($filters as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (isset($filterMap[$key])) {
                $filterMap[$key]($query, $value);
            }
        }

        return $query->latest()->take($limit)->get();
    }
}
