<?php

return [
    'token' => env('SPARROWSMS_TOKEN'), 
    'from' => env('SPARROWSMS_FROM'),
    'api_endpoint' => env('SPARROWSMS_API_ENDPOINT', 'http://api.sparrowsms.com/v2/'),
    'sanndbox' =>  env('SPARROWSMS_SANDBOX', false),
    
    'methods' => [
        'send' => 'sms/',
        'credit' => 'credit/'
    ],

    'debug' =>  env('APP_DEBUG', false),
]