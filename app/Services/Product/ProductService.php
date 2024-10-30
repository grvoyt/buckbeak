<?php

namespace App\Services\Product;

use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Models\Product;
use App\Models\User;

class ProductService
{
    protected Product $product;
    public function __construct()
    {

    }

    public function createByUser(User $user,array $data): Product
    {
        $this->product = $user->products()->create($data);
        event(new ProductCreated($this->product));
        return $this->product;
    }

    public function update(Product $product,array $data): Product
    {
        $this->product = $product;
        $this->product->fill($data);
        $this->product->save();

        event(new ProductUpdated($this->product));

        return $this->product;
    }
}
