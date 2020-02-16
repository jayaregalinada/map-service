<?php

namespace Services\Geocoding;

use Illuminate\Http\Request;
use App\GeographicalCoordinates;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Events\Dispatcher;
use Services\Geocoding\Providers\BaseProvider;

class Repository
{
    use Macroable {
        __call as macroCall;
    }

    protected $events;

    protected $provider;

    public function __construct(BaseProvider $provider)
    {
        $this->provider = $provider;
    }

    public function requestBest(Request $request) : Geocoding
    {
        return $this->provider->best(
            GeographicalCoordinates::makeFromString($request->get('coordinates'))
        );
    }

    public function request(Request $request) : Collection
    {
        return $this->provider->geocode(
            GeographicalCoordinates::makeFromString($request->get('coordinates')),
            $request->only([
                'type',
            ])
        );
    }

    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->provider->$method(...$parameters);
    }

    public function setEventDispatcher(Dispatcher $events) : void
    {
        $this->events = $events;
    }

    public function getEventDispatcher() : Dispatcher
    {
        return $this->events;
    }
}
