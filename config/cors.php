<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sb-json', '/images/*'], // Allow specific paths

    'allowed_methods' => ['GET', 'POST', 'OPTIONS'], // Allow GET and POST methods

    'allowed_origins' => ['https://fab4-110-227-248-205.ngrok-free.app', 'https://fab4-110-227-248-205.ngrok-free.app'], // Add your frontend URL or use '*' for all

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
