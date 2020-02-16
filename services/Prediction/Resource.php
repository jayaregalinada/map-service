<?php

namespace Services\Prediction;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Services\Prediction\Prediction
 */
class Resource extends JsonResource
{
    public function toArray($request) : array
    {
        return $this->resource->toArray();
    }
}
