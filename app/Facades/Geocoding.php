<?php

namespace App\Facades;

use Illuminate\Http\Request;
use App\GeographicalCoordinates;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Services\Geocoding\Geocoding requestBest(Request $request)
 * @method static Collection request(Request $request)
 * @method static Collection geocode(GeographicalCoordinates $coordinates, array $parameters = [])
 * @method static \Services\Geocoding\Geocoding best(GeographicalCoordinates $coordinates);
 *
 * @see \Services\Geocoding\Manager
 * @see \Services\Geocoding\Repository
 */
class Geocoding extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return 'geocoding';
    }
}
