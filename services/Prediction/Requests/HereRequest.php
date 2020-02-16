<?php

namespace Services\Prediction\Requests;

use App\GeographicalCoordinates;
use App\Contracts\RequestableContract;

class HereRequest implements RequestableContract
{

    /**
     * @var string
     */
    protected $query;

    /**
     * @var \App\GeographicalCoordinates
     */
    protected $coordinates;

    /**
     * @var array
     */
    protected $parameters;

    private $config;

    public function __construct(string $query, GeographicalCoordinates $coordinates, array $parameters = [])
    {
        $this->query = $query;
        $this->coordinates = $coordinates;
        $this->parameters = $parameters;
        $this->config = config('prediction.providers.here.parameters');
    }
    /**
     * @inheritDoc
     */
    public function toRequest() : array
    {
        return [
            'q' => $this->query,
            'in' => $this->createAreaRestrictions(),
            'addressFilter' => $this->createAddressFilter(),
            'result_types' => $this->getResultType(),
            'language' => $this->getLanguage(),
            'size' => $this->getMaxResults(),
            'tf' => 'plain',
        ];
    }

    protected function createAreaRestrictions() : string
    {
        return implode(';', [
            (string) $this->coordinates,
            'r=' . $this->getRadius(),
        ]);
    }

    protected function getRadius() : int
    {
        return $this->parameters['radius'] ?? $this->config['radius'];
    }

    protected function getLanguage() : string
    {
        return $this->parameters['language'] ?? $this->config['language'];
    }

    protected function getMaxResults() : int
    {
        return $this->config['max_results'];
    }

    protected function getResultType() : ?string
    {
        return implode(',', $this->config['types']);
    }

    protected function createAddressFilter() : string
    {
        return 'country=' . implode(',', $this->getCountry());
    }

    protected function getCountry() : array
    {
        return $this->parameters['country'] ?? $this->config['country'];
    }
}
