<?php

namespace Services\Prediction;

use InvalidArgumentException;
use Laravel\Lumen\Application;
use Illuminate\Events\Dispatcher;
use Services\Prediction\Providers\BaseProvider;
use Services\Prediction\Providers\HereProvider;
use Services\Prediction\Providers\GoogleProvider;

class Manager
{
    /**
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $providers;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function provider($provider = null)
    {
        $provider = $provider ?: $this->getDefaultProvider();

        return $this->providers[$provider] = $this->get($provider);
    }

    /**
     * @return mixed
     */
    public function getProviders()
    {
        return $this->providers;
    }

    public function getDefaultProvider()
    {
        return $this->app['config']['prediction.default'];
    }

    protected function get($provider)
    {
        return $this->providers[$provider] ?? $this->resolve($provider);
    }

    protected function resolve($provider)
    {
        $config = $this->getConfig($provider);
        if ($config === null) {
            throw new InvalidArgumentException("Prediction provider [{$provider}] is not defined");
        }

        $providerMethod = 'create' . ucfirst($config['provider']) . 'Provider';
        if (!method_exists($this, $providerMethod)) {
            throw new InvalidArgumentException("Provider [{$config['provider']}] is not supported.");
        }

        return $this->{$providerMethod}($config);
    }

    protected function getConfig($provider)
    {
        return $this->app['config']["prediction.providers.{$provider}"];
    }

    protected function createGoogleProvider(array $config)
    {
        return $this->repository(new GoogleProvider($config['url'], $config['api']));
    }

    protected function createHereProvider(array $config)
    {
        return $this->repository(new HereProvider($config['url'], $config['api']));
    }

    public function repository(BaseProvider $provider)
    {
        return tap(new Repository($provider), function ($repository) {
            $this->setEventDispatcher($repository);
        });
    }

    protected function setEventDispatcher(Repository $repository)
    {
        if (! $this->app->bound(Dispatcher::class)) {
            return;
        }

        $repository->setEventDispatcher($this->app[Dispatcher::class]);
    }

    public function __call($method, $parameters)
    {
        return $this->provider()->$method(...$parameters);
    }
}
