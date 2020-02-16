<?php

namespace Services\Detail;

use JsonSerializable;
use App\GeographicalCoordinates;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class Detail implements Arrayable, JsonSerializable, Jsonable
{
    /**
     * @var string|int|mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \App\GeographicalCoordinates
     */
    protected $coordinates;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $attributes;

    public function __construct(
        $id,
        string $name,
        GeographicalCoordinates $coordinates,
        string $description = null,
        array $attributes = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->description = $description;
        $this->attributes = $attributes;
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
     * @return \App\GeographicalCoordinates
     */
    public function getCoordinates() : GeographicalCoordinates
    {
        return $this->coordinates;
    }

    public function getLatitude() : float
    {
        return $this->coordinates->getLatitude();
    }

    public function getLongitude() : float
    {
        return $this->coordinates->getLongitude();
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
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
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | $options, 512);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => (string) $this->name,
            'description' => (string) $this->description,
            'coordinates' => $this->coordinates->toArray(),
            'attributes' => $this->attributes,
        ];
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
