<?php

namespace App\Handlers;

use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\JsonAwareResponseMiddleware;

class ApiHandlerStack extends BaseHandlerStack
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $key;

    /**
     * ApiHandlerStack constructor.
     *
     * @param string                   $apiKey
     * @param \GuzzleHttp\HandlerStack $stack
     * @param callable|null            $handler
     * @param string                   $key
     */
    public function __construct(string $apiKey, HandlerStack $stack, callable $handler = null, string $key = 'key')
    {
        $this->apiKey = $apiKey;
        $this->key = $key;
        parent::__construct($stack, $handler);
        $this->pushMiddleware();
    }

    /**
     * @return void
     */
    protected function pushMiddleware() : void
    {
        $this->pushRequestMiddleware();
        $this->pushResponseMiddleware();
    }

    /**
     * @return void
     */
    protected function pushRequestMiddleware() : void
    {
        $this->stack->push(Middleware::mapRequest(new ApiKeyMiddleware($this->apiKey, $this->key)));
    }

    /**
     * @return void
     */
    protected function pushResponseMiddleware() : void
    {
        $this->stack->push(Middleware::mapResponse(new JsonAwareResponseMiddleware()));
    }

    /**
     * @param string $apiKey
     * @param string $key
     *
     * @return \GuzzleHttp\HandlerStack
     */
    public static function make(string $apiKey, string $key = 'key') : HandlerStack
    {
        return (new self($apiKey, new HandlerStack(), null, $key))->getStack();
    }
}
