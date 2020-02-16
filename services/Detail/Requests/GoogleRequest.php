<?php

namespace Services\Detail\Requests;

use App\Contracts\RequestableContract;

class GoogleRequest implements RequestableContract
{
    protected const FIELD_SEPARATOR = ',';

    /**
     * @var string
     */
    protected $query;

    /**
     * @var array
     */
    protected $parameters;

    private $config;

    public function __construct(string $query, array $parameters = [])
    {
        $this->query = $query;
        $this->parameters = $parameters;
        $this->config = config('detail.providers.google.parameters');
    }

    /**
     * @inheritDoc
     */
    public function toRequest() : array
    {
        $response = [
            'place_id' => $this->query,
            'language' => $this->getLanguage(),
            'fields' => $this->getFields(),
        ];
        if (isset($this->parameters['region'])) {
            $response['region'] = $this->getRegion();
        }
        if (isset($this->parameters['session'])) {
            $response['sessiontoken'] = $this->getSession();
        }

        return $response;
    }

    protected function getLanguage() : string
    {
        return $this->parameters['language'] ?? $this->config['language'];
    }

    protected function getFields() : string
    {
        $fields = $this->parameters['fields'] ?? $this->config['fields'];

        return implode(self::FIELD_SEPARATOR, $fields);
    }

    protected function getRegion()
    {
        return $this->parameters['region'];
    }

    protected function getSession()
    {
        return $this->parameters['session'];
    }
}
