<?php

namespace Services\Geocoding\Contracts;

use App\GeographicalCoordinates;
use Services\Geocoding\Geocoding;
use Illuminate\Support\Collection;

interface ProviderContract
{
    public function geocode(GeographicalCoordinates $coordinates, array $parameters = []) : Collection;

    public function best(GeographicalCoordinates $coordinates) : Geocoding;
}
