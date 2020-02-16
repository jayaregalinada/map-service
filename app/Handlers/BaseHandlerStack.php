<?php

namespace App\Handlers;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

abstract class BaseHandlerStack
{
    /**
     * @var \GuzzleHttp\HandlerStack
     */
    protected $stack;

    /**
     * @var callable
     */
    protected $handler;

    /**
     * BasicHandlerStack constructor.
     *
     * @param \GuzzleHttp\HandlerStack $stack
     * @param callable|null            $handler
     */
    public function __construct(HandlerStack $stack, callable $handler = null)
    {
        $this->stack = $stack;
        $this->handler = $handler;
        $this->stack->setHandler($handler ?? new CurlHandler());
    }

    /**
     * @return \GuzzleHttp\HandlerStack
     */
    public function getStack() : HandlerStack
    {
        return $this->stack;
    }
}
