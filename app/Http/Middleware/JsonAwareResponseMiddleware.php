<?php

namespace App\Http\Middleware;

use App\Responses\JsonAwareResponse;
use App\Contracts\ResponseMiddleware;
use Psr\Http\Message\ResponseInterface;

class JsonAwareResponseMiddleware implements ResponseMiddleware
{
    /**
     * @inheritDoc
     */
    public function __invoke(ResponseInterface $response)
    {
        return new JsonAwareResponse($response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );
    }
}
