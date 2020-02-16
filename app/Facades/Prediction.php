<?php

namespace App\Facades;

use Illuminate\Http\Request;
use Spatie\Fractalistic\Fractal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use App\Contracts\RequestableContract;
use League\Fractal\TransformerAbstract;
use Services\Prediction\Providers\BaseProvider;

/**
 * @method static Collection predictions(string|RequestableContract $query, array $parameters = [])
 * @method static Fractal fractal(Request $request, TransformerAbstract $transformer = null)
 * @method static Collection request(Request $request)
 * @method static BaseProvider provider(string|null $provider = null)
 *
 * @see \Services\Prediction\Manager
 * @see \Services\Prediction\Repository
 */
class Prediction extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return 'prediction';
    }
}
