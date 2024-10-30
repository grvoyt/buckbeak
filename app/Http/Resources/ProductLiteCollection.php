<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductLiteCollection extends ResourceCollection
{
    public $resource = ProductLiteResource::class;
}
