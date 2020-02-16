<?php

namespace Services\Geocoding;

use JsonSerializable;
use Services\Detail\Detail;
use App\GeographicalCoordinates;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Services\Detail\Contracts\ToDetailContract;

class Geocoding implements Arrayable, Jsonable, JsonSerializable, ToDetailContract
{
    /**
     * @var string|mixed
     */
    protected $id;

    protected string $name;

    /**
     * @var mixed
     */
    protected $locationType;

    protected array $attributes;

    /**
     * @var \App\GeographicalCoordinates
     */
    protected GeographicalCoordinates $coordinates;

    /**
     * Geocoding constructor.
     *
     * @param                              $id
     * @param string                       $name
     * @param string|mixed                 $locationType
     * @param \App\GeographicalCoordinates $coordinates
     * @param array                        $attributes
     */
    public function __construct(
        $id,
        string $name,
        $locationType,
        GeographicalCoordinates $coordinates,
        array $attributes = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->locationType = $locationType;
        $this->coordinates = $coordinates;
        $this->attributes = $attributes;
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | $options, 512);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->toDetail()->toArray();
    }

    public function toDetail() : Detail
    {
        return new Detail($this->id, $this->name, $this->coordinates, $this->name, $this->attributes);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string|mixed
     */
    public function getLocationType()
    {
        return $this->locationType;
    }

    /**
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
