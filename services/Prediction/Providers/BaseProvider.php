<?php

namespace Services\Prediction\Providers;

use App\Contracts\AdapterContract;
use Services\Prediction\Contracts\ProviderContract;

abstract class BaseProvider implements ProviderContract
{
    /**
     * @var \App\Contracts\AdapterContract
     */
    protected $adapter;

    /**
     * BaseProvider constructor.
     *
     * @param \App\Contracts\AdapterContract $adapter
     */
    public function __construct(AdapterContract $adapter)
    {
        $this->adapter = $adapter;
    }
}
