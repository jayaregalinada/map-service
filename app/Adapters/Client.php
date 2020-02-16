<?php

namespace App\Adapters;

use GuzzleHttp\Client as Guzzle;
use App\Constants\RequestMethods;
use App\Contracts\AdapterContract;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client extends Guzzle implements AdapterContract
{
    /**
     * @inheritDoc
     */
    public function getBody($methodOrRequest, $uri, array $options = [])
    {
        return $this->createRequest($methodOrRequest, $uri, $options)->getBody();
    }

    /**
     * @inheritDoc
     */
    public function createRequest($methodOrRequest, $uri, array $options = []) : ResponseInterface
    {
        if ($methodOrRequest instanceof RequestInterface) {
            return $this->send($methodOrRequest, $uri);
        }
        if ($methodOrRequest instanceof RequestMethods) {
            return $this->request($methodOrRequest->getValue(),
                is_array($uri) ? '' : $uri,
                is_array($uri) ? $uri : $options);
        }

        return $this->request(
            $methodOrRequest,
            is_array($uri) ? '' : $uri,
            is_array($uri) ? $uri : $options);
    }
}
