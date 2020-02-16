<?php

namespace Services\Detail\Providers;

use App\Adapters\Client;
use Services\Detail\Detail;
use GuzzleHttp\RequestOptions;
use App\GeographicalCoordinates;
use App\Handlers\ApiHandlerStack;
use App\Constants\RequestMethods;
use App\Contracts\RequestableContract;
use Services\Detail\Requests\GoogleRequest;
use App\Concerns\ValidateGoogleResponseConcern;

class GoogleProvider extends BaseProvider
{
    use ValidateGoogleResponseConcern;

    protected $resultsKey = 'result';

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $apiKey;

    public function __construct(string $baseUri, string $apiKey)
    {
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        parent::__construct(new Client([
            'base_uri' => $this->baseUri,
            'handler' => ApiHandlerStack::make($this->apiKey),
        ]));
    }

    public function detail($id, array $parameters = []) : Detail
    {
        $response = $this->request($id, $parameters);

        return $this->transformToDetail($response[$this->resultsKey]);
    }

    protected function request($query, array $parameters = [])
    {
        if ($query instanceof RequestableContract) {
            return $this->requestRaw($query);
        }

        return $this->requestRaw(new GoogleRequest($query, $parameters));
    }

    /**
     * @param \App\Contracts\RequestableContract $request
     *
     * @return \Psr\Http\Message\StreamInterface|array
     */
    private function requestRaw(RequestableContract $request)
    {
        $response = $this->adapter->createRequest(RequestMethods::GET(), [
            RequestOptions::QUERY => $request->toRequest(),
        ]);
        $this->validateResponse($response);

        return $response->getBody();
    }

    protected function transformToDetail(array $detail) : Detail
    {
        return new Detail(
            $detail['place_id'],
            $detail['name'],
            new GeographicalCoordinates($detail['geometry']['location']['lat'], $detail['geometry']['location']['lng']),
            $detail['formatted_address'],
            $detail
        );
    }
}
