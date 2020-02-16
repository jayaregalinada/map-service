<?php

return [
    'default' => env('GEOCODING_DRIVER', 'google'),

    'providers' => [
        'google' => [
            'provider' => 'google',
            'url' => env('GEOCODING_GOOGLE_URL', 'https://maps.googleapis.com/maps/api/geocode/json'),
            'api' => env('GEOCODING_GOOGLE_API', ''),
        ]
    ]
];
