<?php

namespace App\Http\Controllers\Geocode;

use App\Facades\Detail;
use App\Facades\Geocoding;
use Illuminate\Http\Request;
use App\Http\Rules\Coordinates;
use Illuminate\Validation\Rule;
use Services\Geocoding\Resource;
use Services\Detail\Resource as DetailResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Services\Geocoding\Geocoding as GeocodingModel;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    private const BEST_TYPE = 'BEST';

    private const GOOGLE_TYPES = [
        'ROOFTOP', 'RANGE_INTERPOLATED', 'GEOMETRIC_CENTER', 'APPROXIMATE'
    ];

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function coordinates(Request $request) : JsonResource
    {
        $this->validate($request, [
            'coordinates' => ['required', new Coordinates()],
            'type' => [
                Rule::in(array_merge([self::BEST_TYPE], self::GOOGLE_TYPES)),
            ],
            'region' => 'string',
            'session' => 'string',
        ]);
        if ($request->has('type') && $request->get('type') === self::BEST_TYPE) {
            return $this->getBestResult($request, Geocoding::requestBest($request));
        }

        return new Resource(Geocoding::request($request));
    }

    protected function getBestResult(Request $request, GeocodingModel $geocoding) : DetailResource
    {
        return new DetailResource(Detail::request($geocoding->getId(), $request));
    }
}
