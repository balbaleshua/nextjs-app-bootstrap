<?php

namespace App\Services;

use GuzzleHttp\Client;

class LLMService
{
    protected $client;
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('llm.api_key');
        $this->apiUrl = config('llm.api_url');
    }

    public function generateSlug($title)
    {
        $response = $this->client->post($this->apiUrl . '/generate-slug', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'title' => $title,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['slug'];
    }

    public function generateSummary($content)
    {
        $response = $this->client->post($this->apiUrl . '/generate-summary', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'content' => $content,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['summary'];
    }
}