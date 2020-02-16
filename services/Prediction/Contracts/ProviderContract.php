<?php

namespace Services\Prediction\Contracts;

use Illuminate\Support\Collection;

interface ProviderContract
{
    /**
     * @param string|mixed $query
     * @param array        $parameters
     *
     * @return \Illuminate\Support\Collection
     */
    public function predictions($query, array $parameters = []) : Collection;
}
