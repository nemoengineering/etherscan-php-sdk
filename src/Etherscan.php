<?php

namespace Nemo\Etherscan;

use GuzzleHttp\Client;
use Nemo\Etherscan\Api\Accounts;
use Nemo\Etherscan\Support\Chain;

class Etherscan
{
    private Client $httpClient;

    public string $apiKey;

    public function __construct(Chain $chain, string $apiKey, ?Client $client = null)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $client ?: new Client(['base_uri' => self::getBaseUrlForChain($chain)]);
    }

    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    public function accounts(): Accounts
    {
        return new Accounts($this);
    }

    private static function getBaseUrlForChain(Chain $chain): string
    {
        return match ($chain) {
            Chain::Ethereum => 'https://api.etherscan.io',
            Chain::Optimism => 'https://api-optimistic.etherscan.io',
            Chain::Arbitrum => 'https://api.arbiscan.io',
            Chain::Polygon => 'https://api.polygonscan.com',
            Chain::GnosisChain => 'https://api.gnosisscan.io',
            Chain::Fantom => 'https://api.ftmscan.com',
            Chain::Avalanche => 'https://api.snowtrace.io',
        };
    }
}
