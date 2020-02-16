<?php

namespace App\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ResponseMiddleware
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    public function __invoke(ResponseInterface $response);
}
