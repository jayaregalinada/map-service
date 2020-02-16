<?php

namespace Services\Prediction;

use Illuminate\Http\Request;
use Spatie\Fractalistic\Fractal;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\Traits\Macroable;
use Services\Prediction\Providers\BaseProvider;

class Repository
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @var \Services\Prediction\Providers\BaseProvider
     */
    protected $provider;

    public function __construct(BaseProvider $provider)
    {
        $this->provider = $provider;
    }

    public function fractal(Request $request, TransformerAbstract $transformer = null) : Fractal
    {
        return Fractal::create($this->request($request), $transformer ?? new Transformer());
    }

    public function request(Request $request) : Collection
    {
        return $this->provider->predictions(
            $request->get('query'),
            $request->only([
                'location',
                'country',
                'radius',
                'language',
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
