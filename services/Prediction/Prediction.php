<?php

namespace Services\Prediction;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class Prediction implements Arrayable, JsonSerializable, Jsonable
{
    /**
     * @var string|mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $distance;

    /**
     * @var array
     */
    protected $attributes;

    public function __construct($id, string $name, string $description, int $distance = null, array $attributes = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->distance = $distance;
        $this->attributes = $attributes;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id' => (string) $this->id,
            'name' => (string) $this->name,
            'description' => (string) $this->description,
            'distance' => $this->distance,
//            'attributes' => $this->attributes
        ];
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @return mixed|string
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
        return (string) $this->name;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return (string) $this->description;
    }

    /**
     * @return int
     */
    public function getDistance() : ?int
    {
        return $this->distance;
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
