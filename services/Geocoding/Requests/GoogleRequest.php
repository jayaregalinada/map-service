<?php

namespace Services\Geocoding\Requests;

use App\GeographicalCoordinates;
use App\Contracts\RequestableContract;

class GoogleRequest implements RequestableContract
{
    /**
     * @var \App\GeographicalCoordinates
     */
    protected GeographicalCoordinates $coordinates;

    /**
     * @var array
     */
    protected array $locationTypes;

    /**
     * @var array
     */
    protected array $resultTypes;

    /**
     * GoogleRequest constructor.
     *
     * @param \App\GeographicalCoordinates $coordinates
     * @param array                        $locationTypes
     * @param array                        $resultTypes
     */
    public function __construct(GeographicalCoordinates $coordinates, array $locationTypes = [], array $resultTypes = [])
    {
        $this->coordinates = $coordinates;
        $this->locationTypes = $locationTypes;
        $this->resultTypes = $resultTypes;
    }

    /**
     * @inheritDoc
     */
    public function toRequest() : array
    {
        return collect([
            'latlng' => (string) $this->coordinates,
            'location_type' => $this->getLocationType(),
            'result_type' => $this->getResultType(),
        ])
            ->filter(fn($value) => $value !== null)
            ->toArray();
    }

    protected function getLocationType() : ?string
    {
        return !empty($this->locationTypes) ? implode('|', $this->locationTypes) : null;
    }

    protected function getResultType() : ?string
    {
        return !empty($this->resultTypes) ? implode('|', $this->resultTypes) : null;
    }
}
