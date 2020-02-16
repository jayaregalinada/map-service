<?php

namespace App;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class GeographicalCoordinates implements Arrayable, Jsonable, JsonSerializable
{
    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    /**
     * GeographicalCoordinates constructor.
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude = 0.0, float $longitude = 0.0)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(',', [$this->latitude, $this->longitude]);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }

    /**
     * @return float
     */
    public function getLatitude() : float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude() : float
    {
        return $this->longitude;
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param string $location
     *
     * @return \App\GeographicalCoordinates
     */
    public static function makeFromString(string $location) : GeographicalCoordinates
    {
        $coordinates = explode(',', $location);

        return new self($coordinates[0], $coordinates[1]);
    }
}
