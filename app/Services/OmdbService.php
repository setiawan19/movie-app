<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class OmdbService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $baseUrl = 'http://www.omdbapi.com/';

    /**
     * OmdbService constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.omdb.key', '6f525d05');
    }

    /**
     * Fetch data from OMDb API.
     *
     * @param array $params
     * @return array
     */
    public function fetch(array $params): array
    {
        $params['apikey'] = $this->apiKey;

        try {
            $response = $this->client->get($this->baseUrl, [
                'query' => $params
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            return [
                'Response' => 'False',
                'Error' => $e->getMessage()
            ];
        }
    }
}
