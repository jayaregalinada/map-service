<?php

return [
    'default' => env('PREDICTION_DRIVER', 'google'),

    'providers' => [
        'google' => [
            'provider' => 'google',
            'url' => env('PREDICTION_GOOGLE_URL', 'https://maps.googleapis.com/maps/api/place/autocomplete/json'),
            'api' => env('PREDICTION_GOOGLE_API', ''),
            'parameters' => [
                'radius' => 1000,
                'language' => 'en',
                'country' => [
                    'PH'
                ]
            ]
        ],
        'here' => [
            'provider' => 'here',
            'url' => env('PREDICTION_HERE_URL', 'https://places.sit.ls.hereapi.com/places/v1/autosuggest'),
            'api' => env('PREDICTION_HERE_API', ''),
            'parameters' => [
                'max_results' => 5,
                'country' => [
                    'PHL'
                ],
                'radius' => 1000,
                'types' => [
                    'address',
                    'place'
                ],
                'language' => 'en'
            ]
        ]
    ]
];
