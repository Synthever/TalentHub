<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Cloud Vertex AI Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Vertex AI integration including service account
    | credentials, project settings, and model parameters.
    |
    */

    'enabled' => env('VERTEX_AI_ENABLED', true),

    'auth_mode' => env('GEMINI_AUTH_MODE', 'apikey'), // 'apikey' or 'vertex'

    'api_key' => env('GEMINI_API_KEY'),

    'project_id' => env('VERTEX_AI_PROJECT_ID', 'dazzling-will-501112-e2'),

    'location' => env('VERTEX_AI_LOCATION', 'us-central1'),

    'credentials' => env('VERTEX_AI_CREDENTIALS', storage_path('app/private/dazzling-will-501112-e2-1a5560a5f5b5.json')),

    /*
    |--------------------------------------------------------------------------
    | Model Configuration
    |--------------------------------------------------------------------------
    */

    'model' => env('VERTEX_AI_MODEL', 'gemini-1.5-flash'),

    'temperature' => env('VERTEX_AI_TEMPERATURE', 0.7),

    'max_tokens' => env('VERTEX_AI_MAX_TOKENS', 2048),

    'top_p' => env('VERTEX_AI_TOP_P', 0.95),

    'top_k' => env('VERTEX_AI_TOP_K', 40),

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    */

    'features' => [
        'skill_matching' => env('VERTEX_AI_SKILL_MATCHING', true),
        'development_path' => env('VERTEX_AI_DEV_PATH', true),
        'collaboration' => env('VERTEX_AI_COLLABORATION', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    */

    'cache' => [
        'enabled' => env('VERTEX_AI_CACHE_ENABLED', true),
        'ttl' => env('VERTEX_AI_CACHE_TTL', 3600), // 1 hour
    ],
];
