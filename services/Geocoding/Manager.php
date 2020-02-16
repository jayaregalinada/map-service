<?php

namespace Services\Geocoding;

use Illuminate\Http\Request;
use InvalidArgumentException;
use Laravel\Lumen\Application;
use Illuminate\Contracts\Events\Dispatcher;
use Services\Geocoding\Providers\BaseProvider;
use Services\Geocoding\Providers\GoogleProvider;

class Manager
{
    /**
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    protected $providers;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function __call($method, $parameters)
    {
        return $this->provider()->$method(...$parameters);
    }

    public function provider($provider = null)
    {
        $provider = $provider ?: $this->getDefaultProvider();

        return $this->providers[$provider] = $this->get($provider);
    }

    public function getDefaultProvider()
    {
        return $this->app['config']['geocoding.default'];
    }

    protected function get($provider)
    {
        return $this->providers[$provider] ?? $this->resolve($provider);
    }

    protected function resolve($provider)
    {
        $config = $this->getConfig($provider);
        if ($config === null) {
            throw new InvalidArgumentException("Geocoding provider [{$provider}] is not defined");
        }

        $providerMethod = 'create' . ucfirst($config['provider']) . 'Provider';
        if (!method_exists($this, $providerMethod)) {
            throw new InvalidArgumentException("Geocoding [{$config['provider']}] is not supported");
        }

        return $this->{$providerMethod}($config);
    }

    protected function getConfig($provider)
    {
        return $this->app['config']["geocoding.providers.{$provider}"];
    }

    protected function createGoogleProvider(array $config)
    {
        return $this->repository(new GoogleProvider($config['url'], $config['api']));
    }

    public function repository(BaseProvider $provider)
    {
        return tap(new Repository($provider), function ($repository) {
            $this->setEventDispatcher($repository);
        });
    }

    protected function setEventDispatcher(Repository $repository)
    {
        if (!$this->app->bound(Dispatcher::class)) {
            return;
        }

        $repository->setEventDispatcher($this->app[Dispatcher::class]);
    }
}
