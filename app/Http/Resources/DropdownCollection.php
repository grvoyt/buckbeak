<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DropdownCollection extends ResourceCollection
{
    public $resource = DropdownResource::class;
}
