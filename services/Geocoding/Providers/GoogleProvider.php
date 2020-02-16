<?php

namespace Services\Geocoding\Providers;

use App\Adapters\Client;
use GuzzleHttp\RequestOptions;
use App\GeographicalCoordinates;
use App\Handlers\ApiHandlerStack;
use App\Constants\RequestMethods;
use Services\Geocoding\Geocoding;
use Illuminate\Support\Collection;
use App\Contracts\RequestableContract;
use Services\Geocoding\Requests\GoogleRequest;
use App\Concerns\ValidateGoogleResponseConcern;
use Services\Geocoding\Types\GoogleLocationType;

class GoogleProvider extends BaseProvider
{
    use ValidateGoogleResponseConcern;

    protected string $resultsKey = 'results';

    protected string $baseUri;

    protected string $apiKey;

    public function __construct(string $baseUri, string $apiKey)
    {
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        parent::__construct(new Client([
            'base_uri' => $this->baseUri,
            'handler' => ApiHandlerStack::make($this->apiKey),
        ]));
    }

    public function geocode(GeographicalCoordinates $coordinates, array $parameters = []) : Collection
    {
        return $this->getResults($coordinates, $parameters);
    }

    protected function getResults(GeographicalCoordinates $coordinates, array $parameters = []) : Collection
    {
        $response = $this->request($coordinates, $parameters);

        return $this->transformCollection(new Collection($response[$this->resultsKey]));
    }

    /**
     * @param       $query
     * @param array $parameters
     *
     * @return array|\Psr\Http\Message\StreamInterface
     */
    protected function request($query, array $parameters = [])
    {
        if ($query instanceof RequestableContract) {
            return $this->requestRaw($query);
        }

        return $this->requestRaw(new GoogleRequest(
            $query,
            isset($parameters['type']) ? explode('|', $parameters['type']) : [],
            isset($parameters['result']) ? explode('|', $parameters['result']) : []
        ));
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

    protected function transformCollection(Collection $collection) : Collection
    {
        return $collection->transform(fn($result) => $this->transformToGeocoding($result));
    }

    protected function transformToGeocoding(array $result) : Geocoding
    {
        return new Geocoding(
            $result['place_id'],
            $result['formatted_address'],
            $result['geometry']['location_type'],
            new GeographicalCoordinates(
                $result['geometry']['location']['lat'],
                $result['geometry']['location']['lng']
            ),
            $result
        );
    }

    public function best(GeographicalCoordinates $coordinates) : Geocoding
    {
        return $this->getBestResult($coordinates, GoogleLocationType::CENTER());
    }

    protected function getBestResult(GeographicalCoordinates $coordinates, GoogleLocationType $type)
    {
        $results = $this->getResults($coordinates);
        $first = $results
            ->filter(static function (Geocoding $result) use ($type) {
                return $result->getLocationType() === $type->getValue();
            })
            ->first();

        return $first ?? $results->first();
    }
}
