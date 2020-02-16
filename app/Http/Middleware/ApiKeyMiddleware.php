<?php

namespace App\Http\Middleware;

use GuzzleHttp\Psr7\Uri;
use App\Contracts\RequestMiddleware;
use Psr\Http\Message\RequestInterface;

class ApiKeyMiddleware implements RequestMiddleware
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
     * AddApiKeyMiddleware constructor.
     *
     * @param string $apiKey
     * @param string $key
     */
    public function __construct(string $apiKey, string $key = 'key')
    {
        $this->apiKey = $apiKey;
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(RequestInterface $request)
    {
        return $request->withUri(Uri::withQueryValue($request->getUri(), $this->key, $this->apiKey));
    }
}
