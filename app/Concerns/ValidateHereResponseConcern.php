<?php

namespace App\Concerns;

use Illuminate\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait ValidateHereResponseConcern
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function validateResponse(ResponseInterface $response)
    {
        switch ($response->getStatusCode()) {
            case Response::HTTP_UNAUTHORIZED:
                throw new UnauthorizedException($response->getBody()['error'] . ': ' . $response->getBody()['error_description']);

            case Response::HTTP_BAD_REQUEST:
                throw new BadRequestHttpException($response->getBody()['error'] . ': ' . $response->getBody()['error_description']);
        }
    }
}
