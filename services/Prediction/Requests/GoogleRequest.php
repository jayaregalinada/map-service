<?php

namespace Services\Prediction\Requests;

use App\GeographicalCoordinates;
use App\Contracts\RequestableContract;

class GoogleRequest implements RequestableContract
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

    /**
     * @var array
     */
    private $config;

    /**
     * GoogleRequest constructor.
     *
     * @param string                       $query
     * @param \App\GeographicalCoordinates $coordinates
     * @param array                        $parameters
     */
    public function __construct(string $query, GeographicalCoordinates $coordinates, array $parameters = [])
    {
        $this->query = $query;
        $this->coordinates = $coordinates;
        $this->parameters = $parameters;
        $this->config = config('prediction.providers.google.parameters');
    }
    /**
     * @inheritDoc
     */
    public function toRequest() : array
    {
        return [
            'input' => $this->query,
            'origin' => (string) $this->coordinates,
            'location' => (string) $this->coordinates,
            'radius' => $this->getRadius(),
            'language' => $this->getLanguage(),
            'components' => $this->getCountry(),
        ];
    }

    protected function getRadius() : int
    {
        return $this->parameters['radius'] ?? $this->config['radius'];
    }

    protected function getLanguage() : string
    {
        return $this->parameters['language'] ?? $this->config['language'];
    }

    protected function getCountry() : string
    {
        $countries = $this->parameters['country'] ?? $this->config['country'];
        $countries = array_map(function ($country) {
            return 'country:' . $country;
        }, $countries); // TODO: Update arrow function on PHP 7.4

        return implode('|', $countries);
    }
}
