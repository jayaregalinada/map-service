<?php

namespace App\Http\Controllers;

use App\Facades\Detail;
use App\Facades\Prediction;
use Illuminate\Http\Request;
use App\Http\Rules\Coordinates;
use Services\Detail\Resource as DetailResource;
use Services\Prediction\Resource as PredictionResource;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return \Services\Prediction\Resource
     */
    public function search(Request $request) : PredictionResource
    {
        $this->validate($request, [
            'query' => 'required|string|min:2',
            'location' => ['required', new Coordinates()],
        ]);

        return new PredictionResource(Prediction::request($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return \Services\Detail\Resource
     */
    public function detail(Request $request, $id) : DetailResource
    {
        $this->validate($request, [
            'region' => 'string',
            'session' => 'string',
        ]);

        return new DetailResource(Detail::request($id, $request));
    }
}
