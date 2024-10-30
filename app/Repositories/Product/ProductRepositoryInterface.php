<?php

namespace App\Repositories\Product;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

interface ProductRepositoryInterface
{
    public function listByUser(User $user, int $perPage, int $page): Paginator;

    public function dropdown(User $user, int $perPage, int $page): Paginator;
}
