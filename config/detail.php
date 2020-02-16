<?php

return [
    'default' => env('DETAIL_DRIVER', 'google'),

    'providers' => [
        'google' => [
            'provider' => 'google',
            'url' => env('DETAIL_GOOGLE_URL', 'https://maps.googleapis.com/maps/api/place/details/json'),
            'api' => env('DETAIL_GOOGLE_API', ''),
            'parameters' => [
                'language' => 'en',
                'fields' => [
                    'address_component',
                    'formatted_address',
                    'geometry',
                    'name',
                    'place_id',
                    'type',
                ],
            ],
        ],
    ],
];
