<?php

namespace App\Contracts;

use Psr\Http\Message\RequestInterface;

interface RequestMiddleware
{
    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return mixed
     */
    public function __invoke(RequestInterface $request);
}
