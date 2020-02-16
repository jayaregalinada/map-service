<?php

namespace Services\Prediction\Providers;

use App\Adapters\Client;
use GuzzleHttp\RequestOptions;
use App\GeographicalCoordinates;
use App\Handlers\ApiHandlerStack;
use App\Constants\RequestMethods;
use Illuminate\Support\Collection;
use Services\Prediction\Prediction;
use App\Contracts\RequestableContract;
use App\Concerns\ValidateGoogleResponseConcern;
use Services\Prediction\Requests\GoogleRequest;

class GoogleProvider extends BaseProvider
{
    use ValidateGoogleResponseConcern;

    protected $resultsKey = 'predictions';

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

    public function predictions($query, array $parameters = []) : Collection
    {
        $response = $this->request($query, GeographicalCoordinates::makeFromString($parameters['location']),
            $parameters);

        return $this->transformCollection(new Collection($response[$this->resultsKey]));
    }

    protected function request($query, GeographicalCoordinates $coordinates = null, array $parameters = [])
    {
        if ($query instanceof RequestableContract) {
            return $this->requestRaw($query);
        }

        return $this->requestRaw(new GoogleRequest($query, $coordinates, $parameters));
    }

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
        return $this->rejectCountries($collection)
            ->transform(function ($prediction) {
                return new Prediction(
                    $prediction['place_id'],
                    $prediction['structured_formatting']['main_text'],
                    $prediction['structured_formatting']['secondary_text'],
                    $prediction['distance_meters'] ?? null,
                    $prediction
                );
            });
    }

    protected function rejectCountries(Collection $collection) : Collection
    {
        return $collection->reject(function ($prediction) {
            return in_array('country', $prediction['types'], true);
        });
    }
}
