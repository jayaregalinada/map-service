<?php

namespace App\Responses;

use GuzzleHttp\Psr7\Response;

class JsonAwareResponse extends Response
{
    /**
     * @var string
     */
    protected const CONTENT_TYPE = 'application/json';

    /**
     * Cache for performance
     *
     * @var array|mixed
     */
    private $json;

    /**
     * @return array|mixed|\Psr\Http\Message\StreamInterface
     */
    public function getBody()
    {
        if ($this->json) {
            return $this->json;
        }

        $body = parent::getBody();

        if (false !== strpos($this->getHeaderLine('Content-Type'), self::CONTENT_TYPE)) {
            return $this->json = json_decode($body, true);
        }

        return $body;
    }
}
