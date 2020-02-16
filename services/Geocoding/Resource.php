<?php

namespace Services\Geocoding;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    public function toArray($request) : array
    {
        return $this->resource->toArray();
    }
}
