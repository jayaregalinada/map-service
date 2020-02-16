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
use Services\Prediction\Requests\HereRequest;
use App\Concerns\ValidateHereResponseConcern;

class HereProvider extends BaseProvider
{
    use ValidateHereResponseConcern;

    protected $resultsKey = 'results';

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
            'handler' => ApiHandlerStack::make($this->apiKey, 'apiKey'),
        ]));
    }

    /**
     * @inheritDoc
     */
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

        return $this->requestRaw(new HereRequest($query, $coordinates, $parameters));
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
        return $collection->transform(function ($prediction) {
            return new Prediction(
                $prediction['id'],
                $prediction['title'],
                $this->cleanDescription($prediction['vicinity']),
                $prediction['distance'],
                $prediction
            );
        });
    }

    private function cleanDescription($description)
    {
        return str_replace(["\n", "\r"], '', $description);
    }
}
