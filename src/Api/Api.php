<?php

declare(strict_types=1);

namespace Nemo\Etherscan\Api;

use GuzzleHttp\Exception\GuzzleException;
use Nemo\Etherscan\Etherscan;
use Nemo\Etherscan\Exceptions\TransformResponseException;
use Nemo\Etherscan\Support\ResponseTransformer;

class Api
{
    protected Etherscan $client;

    protected ResponseTransformer $transformer;

    public function __construct(Etherscan $client)
    {
        $this->client = $client;
        $this->transformer = new ResponseTransformer();
    }

    /**
     * @throws GuzzleException
     * @throws TransformResponseException
     */
    public function get(string $module, array $query = []): array
    {
        $merged = array_merge(['module' => $module], $query, ['apikey' => $this->client->apiKey]);
        $response = $this->client->getHttpClient()->request('GET', '/api', ['query' => $merged]);

        return $this->transformer->transform($response);
    }
}
