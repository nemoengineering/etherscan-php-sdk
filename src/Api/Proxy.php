<?php

declare(strict_types=1);

namespace Nemo\Etherscan\Api;

use Brick\Math\Exception\MathException;
use GuzzleHttp\Exception\GuzzleException;
use Nemo\Etherscan\Exceptions\ApiException;
use Nemo\Etherscan\Exceptions\TransformResponseException;
use Nemo\Etherscan\ValueObjects\ProxyTransaction;

class Proxy extends Api
{
    private const MODULE = 'proxy';

    /**
     * Returns the information about a transaction requested by transaction hash.
     *
     * @param  string  $hash the string representing the hash of the transaction
     *
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getTransactionByHash(string $hash): ProxyTransaction
    {
        $params['action'] = 'eth_getTransactionByHash';
        $params['txhash'] = $hash;
        $res = $this->get(self::MODULE, $params);

        if ($res['id'] != 1) {
            throw new ApiException("{$res['message']}\nURI: {$this->client->getHttpClient()->getConfig('base_uri')}\nAction: {$params['action']}");
        }

        return ProxyTransaction::fromResponse($res['result']);
    }
}
