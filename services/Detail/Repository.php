<?php

namespace Services\Detail;

use Illuminate\Http\Request;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Events\Dispatcher;
use Services\Detail\Providers\BaseProvider;

class Repository
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * @var \Services\Prediction\Providers\BaseProvider
     */
    protected $provider;

    /**
     * @var Dispatcher
     */
    protected $events;

    public function __construct(BaseProvider $provider)
    {
        $this->provider = $provider;
    }

    public function request($id, Request $request) : Detail
    {
        return $this->provider->detail(
            $id,
            $request->only([
                'language',
                'region',
                'session',
                'fields'
            ])
        );
    }

    public function setEventDispatcher(Dispatcher $events) : void
    {
        $this->events = $events;
    }

    public function getEventDispatcher() : Dispatcher
    {
        return $this->events;
    }

    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->provider->$method(...$parameters);
    }
}
