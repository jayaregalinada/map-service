<?php

namespace Services\Detail;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Services\Detail\Detail
 */
class Resource extends JsonResource
{
    public function toArray($request) : array
    {
        return $this->resource->toArray();
    }
}
