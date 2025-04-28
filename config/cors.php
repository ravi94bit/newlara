<?php

return [

    'paths' => ['api/*'], // Apply CORS only to the API routes

    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)

    'allowed_origins' => ['http://localhost:3000'], // Allow requests from localhost:3000 (React)

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
