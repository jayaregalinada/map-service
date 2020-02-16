<?php

namespace App\Providers;

use Services\Geocoding\Manager;
use Illuminate\Support\ServiceProvider;
use Services\Geocoding\Contracts\ProviderContract;

class GeocodingServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->singleton('geocoding', function ($app) {
            return new Manager($app);
        });
        $this->app->singleton('geocoding.provider', function ($app) {
            return $app['geocoding']->provider();
        });
        $this->app->bind(ProviderContract::class, 'geocoding.provider');
    }

    public function provides() : array
    {
        return [
            'geocoding',
            'geocoding.provider',
        ];
    }
}
