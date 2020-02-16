<?php

namespace Services\Geocoding\Providers;

use App\Contracts\AdapterContract;
use Services\Geocoding\Contracts\ProviderContract;

abstract class BaseProvider implements ProviderContract
{
    /**
     * @var \App\Contracts\AdapterContract
     */
    protected $adapter;

    public function __construct(AdapterContract $adapter)
    {
        $this->adapter = $adapter;
    }
}
