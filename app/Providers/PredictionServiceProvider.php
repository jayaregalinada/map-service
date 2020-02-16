<?php

namespace App\Providers;

use Services\Prediction\Manager;
use Illuminate\Support\ServiceProvider;
use Services\Prediction\Contracts\ProviderContract;

class PredictionServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->singleton('prediction', function ($app) {
            return new Manager($app);
        });
        $this->app->singleton('prediction.provider', function ($app) {
            return $app['prediction']->provider();
        });
        $this->app->bind(ProviderContract::class, 'prediction.provider');
    }

    public function provides() : array
    {
        return [
            'prediction',
            'prediction.provider',
        ];
    }
}
