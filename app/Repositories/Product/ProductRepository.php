<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function listByUser(User $user, int $perPage, int $page): Paginator
    {
        return Product::query()
            ->select(
                ['id','name','category_id','created_at']
            )
            ->where('user_id',$user->id)
            ->with('category')
            ->paginate(
                perPage: $perPage,
                page: $page
            );
    }

    public function dropdown(User $user, int $perPage, int $page): Paginator
    {
        return Product::query()
            ->select([
                'id','name'
            ])
            ->where('user_id',$user->id)
            ->paginate(
                perPage: $perPage,
                page: $page
            );
    }
}
