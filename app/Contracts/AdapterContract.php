<?php

namespace App\Contracts;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

interface AdapterContract extends ClientInterface
{
    /**
     * @param \Psr\Http\Message\RequestInterface|string|\App\Constants\RequestMethods|mixed $methodOrRequest
     * @param string|array                                                                  $uri
     * @param array                                                                         $options
     *
     * @return array|\Psr\Http\Message\StreamInterface
     */
    public function getBody($methodOrRequest, $uri, array $options = []);

    /**
     * @param \Psr\Http\Message\RequestInterface|string|\App\Constants\RequestMethods|mixed $methodOrRequest
     * @param string|array                                                                  $uri
     * @param array                                                                         $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createRequest($methodOrRequest, $uri, array $options = []) : ResponseInterface;
}
