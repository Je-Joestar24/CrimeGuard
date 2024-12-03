<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */
    /* 
    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'host' => env('PUSHER_HOST') ?: 'api-'.env('PUSHER_APP_CLUSTER', 'mt1').'.pusher.com',
                'port' => env('PUSHER_PORT', 443),
                'scheme' => env('PUSHER_SCHEME', 'https'),
                'encrypted' => true,
                'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
            ],
            'client_options' => [
                // Guzzle client options: https://docs.guzzlephp.org/en/stable/request-options.html
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ], */

    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),        // Your Pusher application key
        'secret' => env('PUSHER_APP_SECRET'),  // Your Pusher secret
        'app_id' => env('PUSHER_APP_ID'),      // Your Pusher app ID
        'options' => [
            'cluster' => /* env('PUSHER_APP_CLUSTER') */'ap1',  // Pusher cluster (e.g., 'mt1')
            'host' => env('PUSHER_HOST') ?: 'api-' . env('PUSHER_APP_CLUSTER', 'mt1') . '.pusher.com',  // Pusher API host
            'port' => env('PUSHER_PORT', 443),  // Port to connect to Pusher (default is 443 for secure HTTPS connection)
            'scheme' => env('PUSHER_SCHEME', 'https'),  // Scheme (usually HTTPS)
            'encrypted' => true,  // Whether encryption is enabled (true for HTTPS)
            'useTLS' => /* env('PUSHER_SCHEME', 'https') === 'https' */true,  // Use TLS if the scheme is HTTPS
        ],
        'client_options' => [
            // Guzzle client options for customizing HTTP requests (optional)
        ],
    ],

];
