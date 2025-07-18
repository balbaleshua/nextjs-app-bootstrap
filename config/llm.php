<?php

return [
    'api_key' => env('LLM_API_KEY', 'your-api-key-here'),
    'api_endpoint' => env('LLM_API_ENDPOINT', 'https://api.llm.example.com/generate'),
    'timeout' => env('LLM_TIMEOUT', 30),
    'default_model' => env('LLM_DEFAULT_MODEL', 'gpt-3.5-turbo'),
];