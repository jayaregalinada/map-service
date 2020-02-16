<?php

namespace App\Providers;

use Services\Detail\Manager;
use Illuminate\Support\ServiceProvider;
use Services\Detail\Contracts\ProviderContract;

class DetailServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->singleton('detail', function ($app) {
            return new Manager($app);
        });
        $this->app->singleton('detail.provider', function ($app) {
            return $app['detail']->provider();
        });
        $this->app->bind(ProviderContract::class, 'detail.provider');
    }

    public function provides() : array
    {
        return [
            'detail',
            'detail.provider'
        ];
    }
}
